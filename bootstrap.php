<?php

require 'database/Conexao.php';
require 'database/QueryBuilder.php';

return new QueryBuilder(
  Conexao::iniciar()
);
