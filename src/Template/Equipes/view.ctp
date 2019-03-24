<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipe $equipe
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Equipe'), ['action' => 'edit', $equipe->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Equipe'), ['action' => 'delete', $equipe->id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipe->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Equipes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipe'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="equipes view large-9 medium-8 columns content">
    <h3><?= h($equipe->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descricao') ?></th>
            <td><?= h($equipe->descricao) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($equipe->id) ?></td>
        </tr>
    </table>
</div>
