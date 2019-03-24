<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ponto $ponto
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ponto'), ['action' => 'edit', $ponto->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ponto'), ['action' => 'delete', $ponto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ponto->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pontos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ponto'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Apostas'), ['controller' => 'Apostas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Aposta'), ['controller' => 'Apostas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pontos view large-9 medium-8 columns content">
    <h3><?= h($ponto->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $ponto->has('user') ? $this->Html->link($ponto->user->id, ['controller' => 'Users', 'action' => 'view', $ponto->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Aposta') ?></th>
            <td><?= $ponto->has('aposta') ? $this->Html->link($ponto->aposta->id, ['controller' => 'Apostas', 'action' => 'view', $ponto->aposta->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ponto->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pontos') ?></th>
            <td><?= $this->Number->format($ponto->pontos) ?></td>
        </tr>
    </table>
</div>
