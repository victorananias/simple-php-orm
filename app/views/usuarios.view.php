<?php require "partials/head.php"; ?>

<h3>Cadastrar Usuário</h3>
<form action="/usuarios" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome">
    <button type="submit">Submit</button>
</form>

<h3>Lista de Usuários</h3>
<ul>
    <?php foreach($usuarios as $usuario): ?>
        <li><?= $usuario->nome; ?></li>
    <?php endforeach; ?>
</ul>

<?php require "partials/footer.php"; ?>
