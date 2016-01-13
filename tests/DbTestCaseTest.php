<?php

namespace KoineTest\Repository\Test;

use Koine\Repository\Test\DbTestCase;

class DbTestCaseTest extends DbTestCase
{
    /**
     * @test
     */
    public function staticSetConnectionCanChangeConnection()
    {
        $pdo = $this->getConnection();
        $newPdo = clone $pdo;
        self::setConnection($newPdo);
        $this->assertSame($newPdo, $this->getConnection());
        self::setConnection($pdo);
        $this->assertSame($pdo, $this->getConnection());
    }
}
