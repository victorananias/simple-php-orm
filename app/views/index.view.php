<?php require "partials/head.php"; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2>Lista de Produtos</h2>
                </div>
                
                <div class="card-body">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Segmento</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto): ?>

                                <tr scope="row" id="<?= 'produto'.$produto->ProdutoID; ?>">
                                    <td>
                                        <?= $produto->NmProduto; ?>
                                    </td>
                                    <td>
                                        <?= $produto->segmento()->NmSegmento; ?>
                                    </td>
                                    <td width="5%">
                                        <button class="btn btn-sm text-success" onclick="editar('<?= $produto->ProdutoID; ?>')">
                                            <i class="material-icons float-right">edit</i>
                                        </button>
                                    </td>
                                    <td width="5%">
                                    <button class="btn btn-sm text-danger" onclick="editar('<?= $produto->ProdutoID; ?>')">
                                        <i class="material-icons float-right clicavel" onclick="deletar('<?= $produto->ProdutoID; ?>')">delete</i>
                                    </button>
                                    
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>

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