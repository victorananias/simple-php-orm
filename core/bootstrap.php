<?php

$config = require 'config.php';

require 'core/database/Conexao.php';
require 'core/database/QueryBuilder.php';

$qb = new QueryBuilder(
  Conexao::iniciar($config['database'])
);

require 'core/Request.php';
require 'core/Router.php';
