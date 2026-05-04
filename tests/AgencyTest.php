<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\Agency;
use PDO;
use PDOStatement;

/**
 * Class AgencyTest
 * Tests unitaires pour le modèle Agency
 */
class AgencyTest extends TestCase
{
    private $pdoMock;
    private $agencyModel;

    protected function setUp(): void
    {
        // Création d'un mock pour PDO
        $this->pdoMock = $this->createMock(PDO::class);
        
        // On va injecter ce mock dans le modèle
        // Note: Le constructeur de Model tente de se connecter. 
        // Pour un vrai test unitaire, on pourrait modifier Model pour accepter un PDO en paramètre
        // ou mocker le constructeur. Ici on va utiliser une approche simple.
        
        $this->agencyModel = $this->getMockBuilder(Agency::class)
                                  ->disableOriginalConstructor()
                                  ->getMock();
                                  
        // On simule manuellement la propriété pdo
        $reflection = new \ReflectionClass(Agency::class);
        $pdoProp = $reflection->getParentClass()->getProperty('pdo');
        $pdoProp->setAccessible(true);
        
        $this->agencyModel = new Agency();
        $pdoProp->setValue($this->agencyModel, $this->pdoMock);
    }

    /**
     * Test de la récupération de toutes les agences
     */
    public function testGetAllAgencies()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetchAll')->willReturn([
            ['id_agency' => 1, 'name' => 'Paris'],
            ['id_agency' => 2, 'name' => 'Lyon']
        ]);

        $this->pdoMock->method('query')->willReturn($stmtMock);

        $agencies = $this->agencyModel->getAll();

        $this->assertCount(2, $agencies);
        $this->assertEquals('Paris', $agencies[0]['name']);
    }

    /**
     * Test de la création d'une agence
     */
    public function testCreateAgency()
    {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->with(['name' => 'Marseille'])->willReturn(true);

        $this->pdoMock->method('prepare')->with($this->stringContains('INSERT INTO `agency`'))->willReturn($stmtMock);

        $result = $this->agencyModel->create('Marseille');

        $this->assertTrue($result);
    }
}
