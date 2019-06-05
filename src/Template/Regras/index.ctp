<div class="row">
    <div class="col-sm-6">
        <br />
        <h1>Regras</h1>
    </div>
    <div class="col-sm-6">
        <br />
        <?php echo $this->Flash->render('regras'); ?>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('descricao', 'Descrição') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pontos') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($regras as $regra): ?>
            <tr>
                <td><?= h($regra->descricao) ?></td>
                <td><?= $this->Number->format($regra->pontos) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
