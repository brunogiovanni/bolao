<div class="row">
    <div class="col-sm-4">
        <br />
        <h3>
            Placar geral
        </h3>
    </div>
</div>
<?php echo $this->Flash->render('pontos'); ?>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col">Usuário</th>
                <th scope="col">Pontos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($totalPontos as $ponto): ?>
            <tr>
                <td><?= $ponto['usuario'] ?></td>
                <td><?= $this->Number->format($ponto['pontos']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
