<?php

use function PHPSTORM_META\map;

if (PHP_SAPI != 'cli') {
    exit("RODAR VIA CLI");
}

require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

$dependencies = require __DIR__ . '/src/dependencies.php';
$dependencies($app);

$db = $app->getContainer()->get('db');

$schema = $db->schema();
$tabela = 'produtos';

$schema->dropIfExists($tabela);

//Criar tabela
$schema->create($tabela, function($table){
    $table->increments('id');
    $table->string('titulo', 100);
    $table->text('descricao');
    $table->decimal('preco', 11,2);
    $table->string('fabricante', 60);
    $table->date("dt_criacao");
});

$db->table($tabela)->insert([
    'titulo' => 'Smartphone Motorola Moto G6 32GB Dual Chip',
    'descricao' => 'Android Oreo - 8.0 Tela 5.7" Octa-Core 1.8 Ghz 4G Câmera 12 + 5Mp (Dual Traseira) - índigo',
    'preco' => 899.00,
    'fabricante' => 'Motorola',
    'dt_criacao' => '2019-10-22'
]);

$db->table($tabela)->insert([
    'titulo' => 'Iphone X Cinza Especial 64GB',
    'descricao' => 'Tela 5.8" IOS 12 4G Wi-fi Câmera 12MP - Apple',
    'preco' => 4999.99,
    'fabricante' => 'Apple',
    'dt_criacao' => '2020-01-10'
]);