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
			<li>
				<strong>Título: </strong>: <?= $tarefa['titulo']; ?>
			</li>
			<li>
				<strong>Descrição: </strong>: <?= $tarefa['descricao']; ?>
			</li>
			<li>
				<strong>Responsável: </strong>: <?= ucfirst($tarefa['responsavel']); ?>
			</li>
			<li>
				<strong>Status: </strong>
				<?php if($tarefa['completa']): ?>
					<span>&#9745;</span>
				<?php else: ?>
					<span>&#9746;</span>
				<?php endif; ?>
			</li>
        </ul>
	</body>
</html>