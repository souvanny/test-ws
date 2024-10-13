<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {

    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../../src/';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $relative_class = substr($class, strlen($prefix));

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }

});

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