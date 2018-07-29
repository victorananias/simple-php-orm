<!DOCTYPE html>
<html>
	<head>
	<style>
		header {
			background-color: #e3e3e3;
			padding: 2em;
			text-align: center
		}
	</style>
	</head>
	<body>
		<header>
			<h1>
				<?= "Hello, ".htmlspecialchars($_GET['nome']) ?>
			</h1>
		</header>
	</body>
</html>