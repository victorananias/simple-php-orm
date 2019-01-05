<?php require "partials/head.php"; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Cadastro de Produtos</h3>
                </div>
                <div class="card-body">

                    <form action="/cadastro" method="POST">
                      <div class="form-group">

                        <label for="NmProduto">Nome:</label>
                        <input type="text" name="NmProduto" id="NmProduto" class="form-control" placeholder="Insira o nome do produto." required>
                      </div>

                      <div class="form-group">
                        <label for="segmento">Segmento</label>
                        <select class="form-control" id="segmento" name="SegmentoID" required>
                        <option hidden selected>-</option>
                        <?php foreach($segmentos as $segmento): ?>
                            <option value="<?= $segmento->SegmentoID; ?>">
                                <?= $segmento->NmSegmento; ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                      </div>

                      <button type="submit" class="btn btn-primary float-right">Cadastrar</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require "partials/footer.php"; ?>
