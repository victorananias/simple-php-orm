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
			<?php foreach($tarefas as $tarefa): ?>
				<li>
					<?php if($tarefa->completa): ?>
						<strike><?= $tarefa->descricao; ?></strike>
					<?php else: ?>
						<?= $tarefa->descricao; ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
        </ul>
	</body>
</html>
