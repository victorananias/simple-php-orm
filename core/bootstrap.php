<?php
$app = [];
$app['config'] = require 'config.php';

require 'core/database/Conexao.php';
require 'core/database/QueryBuilder.php';
require 'core/Request.php';
require 'core/Router.php';

$app['db']  = new QueryBuilder(
  Conexao::iniciar($app['config']['database'])
);
