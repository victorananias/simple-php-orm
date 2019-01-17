<?php require "partials/head.php"; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3>Edição</h3>
                </div>
                <div class="card-body">

                    <form action="/produtos/edit" method="POST">
                      <input type="text" hidden value="<?= $produto->id?>" name="id">
                      <div class="form-group">

                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" placeholder="Insira o nome do produto."
                            value="<?= $produto->nome; ?>" required>
                      </div>

                      <div class="form-group">
                        <label for="segmento">Segmento</label>
                        <select class="form-control" id="segmento" name="segmento_id">
                        <?php foreach ($segmentos as $segmento): ?>
                            <option value="<?= $segmento->id; ?>" <?= $produto->segmento_id == $segmento->id ? 'selected' : '' ?>>
                                <?= $segmento->nome; ?>
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
