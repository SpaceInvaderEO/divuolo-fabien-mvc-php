<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Ride;
use PDO;
use PDOStatement;

/**
 * Class RideTest
 * Tests unitaires pour le modèle Ride
 */
class RideTest extends TestCase
{
    private $pdoMock;
    private $rideModel;

    protected function setUp(): void
    {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->rideModel = new Ride();
        
        $reflection = new \ReflectionClass(Ride::class);
        $pdoProp = $reflection->getParentClass()->getProperty('pdo');
        $pdoProp->setAccessible(true);
        $pdoProp->setValue($this->rideModel, $this->pdoMock);
    }

    /**
     * Test de l'insertion d'un trajet
     */
    public function testInsertRide()
    {
        $data = [
            'departure_time' => '2023-10-01 08:00:00',
            'arrival_time' => '2023-10-01 10:00:00',
            'total_seats' => 4,
            'available_seats' => 4,
            'id_departure_agency' => 1,
            'id_arrival_agency' => 2,
            'id_user' => 1
        ];

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);

        $this->pdoMock->method('prepare')->with($this->stringContains('INSERT INTO `ride`'))->willReturn($stmtMock);

        $result = $this->rideModel->insert($data);

        $this->assertTrue($result);
    }

    /**
     * Test de la suppression d'un trajet
     */
    public function testDeleteRide()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->with(['id' => 123])->willReturn(true);

        $this->pdoMock->method('prepare')->with($this->stringContains('DELETE FROM `ride`'))->willReturn($stmtMock);

        $result = $this->rideModel->delete(123);

        $this->assertTrue($result);
    }
}
