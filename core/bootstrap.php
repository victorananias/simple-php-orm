<?php

App::bind('config', require 'config.php');

App::bind('db', new QueryBuilder(
  Conexao::iniciar(App::get('config')['database'])
));
