<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rodada $rodada
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Rodada'), ['action' => 'edit', $rodada->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rodada'), ['action' => 'delete', $rodada->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rodada->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rodadas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rodada'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rodadas view large-9 medium-8 columns content">
    <h3><?= h($rodada->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($rodada->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Numero Rodada') ?></th>
            <td><?= $this->Number->format($rodada->numero_rodada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data Inicio') ?></th>
            <td><?= h($rodada->data_inicio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data Final') ?></th>
            <td><?= h($rodada->data_final) ?></td>
        </tr>
    </table>
</div>
