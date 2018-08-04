<?php require "views/partials/head.php"; ?>
	<form action="/nomes" method="POST">
		<label for="nome">Nome:</label>
		<input type="text" name="nome" id="nome">
		<button type="submit">Submit</button>
	</form>
<?php require "views/partials/footer.php"; ?>