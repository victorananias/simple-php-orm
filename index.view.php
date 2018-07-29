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
            <?php foreach($animais as $animal): ?>
                <li>
                    <?= $animal; ?>
                </li>
            <?php endforeach; ?>
        </ul>
	</body>
</html>