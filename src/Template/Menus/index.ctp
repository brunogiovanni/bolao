<div class="row">
    <div class="col-sm-2">
        <br />
        <h3>Menus</h3>
    </div>
    <div class="col-sm-9">
    </div>
    <div class="col-sm-1 text-right">
        <br />
        <?php
        echo $this->Html->link('Novo', ['action' => 'add'], ['class' => 'btn btn-success', 'title' => 'Cadastrar novo menu']);
        ?>
    </div>
</div>
<?php echo $this->Flash->render('menus'); ?>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nome') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('icone') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menus as $menu): ?>
            <tr>
                <td><?= h($menu->nome) ?></td>
                <td><?= h($tipo) ?></td>
                <td><?= h($menu->icone) ?></td>
                <td class="actions">
                    <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $menu->id], ['escape' => false, 'title' => 'Editar registro']) ?>
                    <?= $this->Form->postLink('<i class="fas fa-trash-alt text-danger"></i>', ['action' => 'delete', $menu->id], ['confirm' => __('Deseja excluir o menu {0}?', $menu->nome), 'escape' => false, 'title' => 'Excluir registro']) ?>
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
