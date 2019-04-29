<div class="row">
    <div class="col-sm-2">
        <br />
        <h3>Logs</h3>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('users_id', 'Usuário') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tela') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created', 'Data/Horário') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= h($log->user->username) ?></td>
                <td><?= h($log->tela) ?></td>
                <td><?= h($log->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<<') ?>
            <?= $this->Paginator->prev('<') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('>') ?>
            <?= $this->Paginator->last('>>') ?>
        </ul>
    </div>
</div>
