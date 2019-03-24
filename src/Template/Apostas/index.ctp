<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aposta[]|\Cake\Collection\CollectionInterface $apostas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Aposta'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jogos'), ['controller' => 'Jogos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Jogo'), ['controller' => 'Jogos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="apostas index large-9 medium-8 columns content">
    <h3><?= __('Apostas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('users_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('jogos_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('aposta') ?></th>
                <th scope="col"><?= $this->Paginator->sort('equipes_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apostas as $aposta): ?>
            <tr>
                <td><?= $this->Number->format($aposta->id) ?></td>
                <td><?= $aposta->has('user') ? $this->Html->link($aposta->user->id, ['controller' => 'Users', 'action' => 'view', $aposta->user->id]) : '' ?></td>
                <td><?= $aposta->has('jogo') ? $this->Html->link($aposta->jogo->id, ['controller' => 'Jogos', 'action' => 'view', $aposta->jogo->id]) : '' ?></td>
                <td><?= h($aposta->aposta) ?></td>
                <td><?= $aposta->has('equipe') ? $this->Html->link($aposta->equipe->id, ['controller' => 'Equipes', 'action' => 'view', $aposta->equipe->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $aposta->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $aposta->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $aposta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $aposta->id)]) ?>
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
