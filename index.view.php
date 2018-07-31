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
		<ul>
            <?php foreach($tarefa as $info => $value): ?>
                <li>
					<strong><?= $info; ?></strong>: <?= $value; ?>
                </li>
            <?php endforeach; ?>
        </ul>
	</body>
</html>