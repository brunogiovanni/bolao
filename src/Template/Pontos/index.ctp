<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ponto[]|\Cake\Collection\CollectionInterface $pontos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ponto'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Apostas'), ['controller' => 'Apostas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Aposta'), ['controller' => 'Apostas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pontos index large-9 medium-8 columns content">
    <h3><?= __('Pontos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('users_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pontos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('apostas_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pontos as $ponto): ?>
            <tr>
                <td><?= $this->Number->format($ponto->id) ?></td>
                <td><?= $ponto->has('user') ? $this->Html->link($ponto->user->id, ['controller' => 'Users', 'action' => 'view', $ponto->user->id]) : '' ?></td>
                <td><?= $this->Number->format($ponto->pontos) ?></td>
                <td><?= $ponto->has('aposta') ? $this->Html->link($ponto->aposta->id, ['controller' => 'Apostas', 'action' => 'view', $ponto->aposta->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ponto->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ponto->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ponto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ponto->id)]) ?>
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
