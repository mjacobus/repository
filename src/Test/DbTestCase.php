<?php

namespace Koine\Repository\Test;

use PHPUnit_Framework_TestCase;
use Koine\Repository\Storage\MySql;
use PDO;

class DbTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var PDO
     */
    private static $connection;

    public function setUp()
    {
        $this->getConnection()->beginTransaction();
    }

    public function tearDown()
    {
        $this->getConnection()->rollBack();
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return self::$connection;
    }

    /**
     * @param PDO $pdo
     */
    public static function setConnection(PDO $pdo)
    {
        self::$connection = $pdo;
    }

    /**
     * @param int    $count
     * @param string $tableName
     */
    public function assertTableCount($count, $tableName)
    {
        $actual = $this->getNumberOfTableRows($tableName);
        $count = (int) $count;
        $this->assertEquals(
            $count,
            $actual,
            "Failed asserting that table '$tableName' has $count records. $actual found."
        );
    }

    /**
     * @param string tableName
     *
     * @return int
     */
    public function getNumberOfTableRows($tableName)
    {
        return $this->createTableHelper($tableName)->getNumberOfRows();
    }

    /**
     * @param string $tableName
     *
     * @return MySql
     */
    protected function createTableHelper($tableName)
    {
        return new MySql($this->getConnection(), $tableName);
    }

    /**
     * @param string $sql
     * @param array  $params
     *
     * @return array
     */
    public function selectQuery($sql, array $params = array())
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $sql
     * @param array  $params
     */
    public function insertQuery($sql, array $params = array())
    {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
    }

    /**
     * @param array $resultSet
     * @param array $columns
     *
     * @return array
     */
    protected function filterResultSet(array $resultSet, array $columns)
    {
        $filtered = array();

        foreach ($resultSet as $row) {
            $newRow = array();
            foreach ($row as $column => $value) {
                if (in_array($column, $columns)) {
                    $newRow[$column] = $value;
                }
            }
            $filtered[] = $newRow;
        }

        return $filtered;
    }
}
