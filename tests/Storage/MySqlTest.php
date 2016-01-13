<?php

namespace KoineTest\Repository;

use Koine\Repository\Storage\MySql;
use Koine\Repository\Test\DbTestCase;

class MySqlTest extends DbTestCase
{
    /** @var MySql */
    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new MySql($this->getConnection(), 'test_table');
    }

    /**
     * @test
     */
    public function canGetConnection()
    {
        $this->assertSame($this->getConnection(), $this->object->getConnection());
    }

    /**
     * @test
     */
    public function canGetTableName()
    {
        $this->assertSame('test_table', $this->object->getTableName());
    }

    /**
     * @test
     */
    public function canGetIdColumn()
    {
        $this->assertEquals('id', $this->object->getIdColumn());
    }

    /**
     * @test
     */
    public function canCountTableName()
    {
        $this->assertEquals(0, $this->object->getNumberOfRows());
        $this->insertQuery("INSERT INTO test_table values (0, 'foo', 'bar')");
        $this->assertEquals(1, $this->object->getNumberOfRows());
    }

    /**
     * @test
     */
    public function saveCanInsertRecord()
    {
        $id = $this->object->insert(array(
            'name'  => 'someName',
            'value' => 'someValue',
        ));

        $this->assertTableCount(1, 'test_table');

        $expected = array(
            array(
                'name'  => 'someName',
                'value' => 'someValue',
            ),
        );

        $this->assertEquals($expected, $this->getRecords());
        $this->assertGreaterThan(0, $id);
    }

    /**
     * @test
     */
    public function canFindRecordsBiId()
    {
        $this->object->insert(array(
            'name'  => 'someName',
            'value' => 'someValue',
        ));

        $records = $this->getRecords(array());
        $id = $records[0]['id'];

        $expected = array(
            'id'    => $id,
            'name'  => 'someName',
            'value' => 'someValue',
        );

        $record = $this->object->find($id);

        $this->assertEquals($expected, $record);
    }

    /**
     * @test
     */
    public function canFindRecordsByMultipleConditions()
    {
        $this->object->insert(array(
            'name'  => 'foo',
            'value' => 'bar',
        ));

        $this->object->insert(array(
            'name'  => 'foo',
            'value' => 'baz',
        ));

        $this->object->insert(array(
            'name'  => 'baz',
            'value' => 'foo',
        ));

        $records = $this->object->findAllBy(array(
            'name'  => 'foo',
            'value' => 'bar',
        ));

        $this->assertCount(1, $records);
    }

    /**
     * @test
     */
    public function canFindAllWithLimit()
    {
        $this->object->insert(array(
            'name'  => 'foo',
            'value' => 'bar',
        ));

        $this->object->insert(array(
            'name'  => 'foo',
            'value' => 'baz',
        ));

        $this->object->insert(array(
            'name'  => 'baz',
            'value' => 'foo',
        ));

        $records = $this->object->findAllBy(array('name' => 'foo'), 1);

        $this->assertCount(1, $records);
    }

    /**
     * @test
     * @expectedException \Koine\Repository\Exception\RecordNotFoundException
     * @expectedExceptionMessage test_table record not found by id 0
     */
    public function findThrowsExceptionOnNotFound()
    {
        $this->object->find(0);
    }

    /**
     * @return array
     */
    private function getRecords($columns = array('name', 'value'))
    {
        $resultSet = $this->selectQuery('SELECT * FROM test_table');

        if ($columns) {
            return $this->filterResultSet($resultSet, $columns);
        }

        return $resultSet;
    }

    /**
     * @test
     */
    public function canUpdateRecord()
    {
        $this->object->insert(array(
            'name'  => 'someName',
            'value' => 'someValue',
        ));

        $records = $this->getRecords(array());
        $id = $records[0]['id'];

        $this->object->updateWhere(
            array('id' => $id),
            array(
                'name'  => 'updated name',
                'value' => 'updated value',
            )
        );

        $expected = array(
            'id'    => $id,
            'name'  => 'updated name',
            'value' => 'updated value',
        );

        $record = $this->object->find($id);

        $this->assertEquals($expected, $record);
    }

    /**
     * @test
     */
    public function canUpdateByConditions()
    {
        $originalValues = array(
            'name'  => 'someName',
            'value' => 'someValue',
        );

        $newValues = array('value' => 'newValue');

        $this->object->insert($originalValues);
        $this->object->updateWhere($originalValues, $newValues);

        $records = $this->object->findAllBy(array());
        $this->assertCount(1, $records);
        $record = $records[0];
        unset($record['id']);
        $this->assertEquals($record, array('name' => 'someName', 'value' => 'newValue'));
    }

    /**
     * @test
     */
    public function findOneByWillReturnOneRecord()
    {
        $params = array(
            'name'  => 'someName',
            'value' => 'someValue',
        );

        $this->object->insert($params);
        $this->object->insert($params);

        $record = $this->object->findOneBy($params);
        unset($record['id']);
        $this->assertEquals($params, $record);
    }

    /**
     * @test
     * @expectedException \Koine\Repository\Exception\RecordNotFoundException
     * @expectedExceptionMessage Record not found
     */
    public function findOneThrowsExceptionWhenRecordIsNotFound()
    {
        $this->object->findOneBy(array('name' => 'foo'));
    }

    /**
     * @test
     */
    public function canVeryfyIfCertainRecordExists()
    {
        $this->object->insert(array(
            'name'  => 'someName',
            'value' => 'someValue',
        ));

        $this->assertTrue($this->object->exists(array('name' => 'someName')));
        $this->assertFalse($this->object->exists(array('name' => 'non existing')));
    }

    /**
     * @test
     */
    public function canDelete()
    {
        $id = $this->object->insert(array(
            'name'  => 'someName',
            'value' => 'someValue',
        ));

        $id = $this->object->insert(array(
            'name'  => 'someName',
            'value' => 'someValue',
        ));

        $this->object->deleteWhere(array('id' => $id));
        $this->assertTableCount(1, 'test_table');
    }
}
