<?php require "views/partials/head.php"; ?>
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
<?php require "views/partials/footer.php"; ?>