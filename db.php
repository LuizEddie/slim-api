<?php
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