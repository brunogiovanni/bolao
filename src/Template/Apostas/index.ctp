<div class="row">
    <div class="col-sm-3">
        <h3>Apostas</h3>
    </div>
</div>
<?php $this->Flash->render('apostas'); ?>
<hr />
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('users_id', 'Apostador') ?></th>
                <th scope="col"><?= $this->Paginator->sort('jogos_id', 'Jogo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('aposta', 'Aposta') ?></th>
                <?php if (in_array($usuario['group_id'], [1, 2])) : ?>
                    <th scope="col">Id</th>
                    <th scope="col" class="actions">Ações</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apostas as $aposta): ?>
            <tr>
                <td><?= $aposta->has('user') ? $aposta->user->nome : '' ?></td>
                <td><?= $aposta->has('jogo') ? $aposta->jogo->mandante->descricao . ' X ' . $aposta->jogo->fora->descricao : '' ?></td>
                <td><?= h($aposta->aposta) ?></td>
                <?php if (in_array($usuario['group_id'], [1, 2])) : ?>
                    <td><?php echo $aposta->id; ?></td>
                    <td class="actions">
                        <?= $this->Form->postLink('<i class="fas fa-trash-alt text-danger"></i>', [
                            'action' => 'delete', $aposta->id], [
                                'confirm' => __('Deseja excluir este registro # {0}?', $aposta->id),
                                'title' => 'Excluir registro' , 'escape' => false
                        ]) ?>
                    </td>
                <?php endif; ?>
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
