<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Jogo[]|\Cake\Collection\CollectionInterface $jogos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Jogo'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Rodadas'), ['controller' => 'Rodadas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rodada'), ['controller' => 'Rodadas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="jogos index large-9 medium-8 columns content">
    <h3><?= __('Jogos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('data') ?></th>
                <th scope="col"><?= $this->Paginator->sort('horario') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estadio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rodadas_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('casa') ?></th>
                <th scope="col"><?= $this->Paginator->sort('visitante') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jogos as $jogo): ?>
            <tr>
                <td><?= h($jogo->data->format('d/m/Y')) ?></td>
                <td><?= h($jogo->horario->format('H:i')) ?></td>
                <td><?= h($jogo->estadio) ?></td>
                <td><?= $jogo->has('rodada') ? $this->Html->link($jogo->rodada->id, ['controller' => 'Rodadas', 'action' => 'view', $jogo->rodada->id]) : '' ?></td>
                <td><?= $jogo->mandante->descricao ?></td>
                <td><?= $jogo->fora->descricao ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $jogo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $jogo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $jogo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jogo->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
