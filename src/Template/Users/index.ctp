<div class="row">
    <div class="col-sm-11">
        <br />
        <h3>Usuários</h3>
    </div>
    <div class="col-sm-1 text-right">
        <br />
        <?php echo $this->Html->link('Novo', [
            'action' => 'add'
        ], ['class' => 'btn btn-success', 'title' => 'Criar novo usuário']); ?>
    </div>
</div>
<?php echo $this->Flash->render('users'); ?>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('username', 'Usuário') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nome', 'Nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email', 'E-mail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id', 'Grupo') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->nome) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= $user->has('group') ? $user->group->descricao : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $user->id], ['escape' => false, 'title' => 'Editar registro']) ?>
                    <?= $this->Form->postLink('<i class="fas fa-trash-alt text-danger"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Deseja excluir o usuário {0}?', $user->nome), 'escape' => false]) ?>
                </td>
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
