<?php require "partials/head.php"; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Edição</h3>
                </div>
                <div class="card-body">

                    <form action="/edicao" method="POST">
                      <input type="text" hidden value="<?= $produto->ProdutoID?>" name="ProdutoID">
                      <div class="form-group">

                        <label for="NmProduto">Nome:</label>
                        <input type="text" name="NmProduto" id="NmProduto" class="form-control" placeholder="Insira o nome do produto."
                            value="<?= $produto->NmProduto; ?>" required>
                      </div>

                      <div class="form-group">
                        <label for="segmento">Segmento</label>
                        <select class="form-control" id="segmento" name="SegmentoID">
                        <?php foreach($segmentos as $segmento): ?>
                            <option value="<?= $segmento->SegmentoID; ?>" <?= $produto->SegmentoID == $segmento->SegmentoID ? 'selected' : '' ?>>
                                <?= $segmento->NmSegmento; ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                      </div>

                      <button type="submit" class="btn btn-primary float-right">Salvar</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
</script>

<?php require "partials/footer.php"; ?>
