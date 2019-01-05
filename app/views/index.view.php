<?php require "partials/head.php"; ?>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h2>Lista de Produtos</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="lista">

                        <?php foreach($produtos as $produto): ?>

                        <li class="list-group-item" id="<?= 'produto'.$produto->ProdutoID; ?>">
                            <?= $produto->NmProduto; ?>
                            <i class="material-icons text-danger float-right clicavel" onclick="deletar('<?= $produto->ProdutoID; ?>')">delete</i>
                            <i class="material-icons text-success float-right clicavel" onclick="editar('<?= $produto->ProdutoID; ?>')">edit</i>
                        </li>

                        <?php endforeach; ?>

                        
                        </ul>
                        <span id="aviso" style="<?= count($produtos) > 0 ? 'display: none' : ''; ?>">
                            Não existem produtos cadastrados.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        
        function editar(id) {
            window.open(`edicao?produto=${id}`, '_self');
        }

        function deletar(id) {
            $.ajax({
                url: `/deletar?ProdutoID=${id}`,
                type: 'delete',
                dataType: 'json',
            })
            .done(function() {
                $(`#produto${id}`).remove();
                verificarAviso();
            })
            .fail(function() {
                console.log("Erro ao deletar produto.");
            });
        }

        function verificarAviso() {
            if($('#lista').children().length == 0) {
                $('#aviso')[0].style.display = 'inherit';
            } 
        }
    </script>

<?php require "partials/footer.php"; ?>