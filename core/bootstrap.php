<?php
$app = [];
$app['config'] = require 'config.php';

$app['db']  = new QueryBuilder(
  Conexao::iniciar($app['config']['database'])
);
