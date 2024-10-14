<?php
declare(strict_types=1);

require_once("autoloader.php");


use App\DTO\ShopDTO;
use PHPUnit\Framework\TestCase;
final class ShopDTOTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        echo "\n---- Ceci est le test le plus simple du monde, nul besoin de MOCKER object object injecté ----\n";
    }
    public function testShopDTOPropertiesAreSetCorrectly()
    {
        // Données d'exemple
        $id = 1;
        $name = 'My Shop';
        $city = 'Paris';

        // Création de l'instance de ShopDTO
        $shopDTO = new ShopDTO($id, $name, $city);

        // Asserts pour vérifier que les propriétés sont initialisées correctement
        $this->assertSame($id, $shopDTO->id, 'id incorrect.');
        $this->assertSame($name, $shopDTO->name, 'name incorrect.');
        $this->assertSame($city, $shopDTO->city, 'city incorrect.');
    }

}