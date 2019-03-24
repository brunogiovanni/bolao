<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Regra $regra
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Regra'), ['action' => 'edit', $regra->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Regra'), ['action' => 'delete', $regra->id], ['confirm' => __('Are you sure you want to delete # {0}?', $regra->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Regras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Regra'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="regras view large-9 medium-8 columns content">
    <h3><?= h($regra->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descricao') ?></th>
            <td><?= h($regra->descricao) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($regra->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pontos') ?></th>
            <td><?= $this->Number->format($regra->pontos) ?></td>
        </tr>
    </table>
</div>
