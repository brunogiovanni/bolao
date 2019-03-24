<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aposta $aposta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Aposta'), ['action' => 'edit', $aposta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Aposta'), ['action' => 'delete', $aposta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $aposta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Apostas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Aposta'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Jogos'), ['controller' => 'Jogos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Jogo'), ['controller' => 'Jogos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="apostas view large-9 medium-8 columns content">
    <h3><?= h($aposta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $aposta->has('user') ? $this->Html->link($aposta->user->id, ['controller' => 'Users', 'action' => 'view', $aposta->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Jogo') ?></th>
            <td><?= $aposta->has('jogo') ? $this->Html->link($aposta->jogo->id, ['controller' => 'Jogos', 'action' => 'view', $aposta->jogo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Aposta') ?></th>
            <td><?= h($aposta->aposta) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Equipe') ?></th>
            <td><?= $aposta->has('equipe') ? $this->Html->link($aposta->equipe->id, ['controller' => 'Equipes', 'action' => 'view', $aposta->equipe->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($aposta->id) ?></td>
        </tr>
    </table>
</div>
