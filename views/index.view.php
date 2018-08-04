<?php require "views/partials/head.php"; ?>

	<form action="/nomes" method="POST">
		<label for="nome">Nome:</label>
		<input type="text" name="nome" id="nome">
		<button type="submit">Submit</button>
	</form>

	<ul>
		<?php foreach($usuarios as $usuario): ?>
			<li><?= $usuario->nome; ?></li>
		<?php endforeach; ?>
	</ul>

<?php require "views/partials/footer.php"; ?>