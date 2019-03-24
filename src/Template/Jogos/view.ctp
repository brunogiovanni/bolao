<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Jogo $jogo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Jogo'), ['action' => 'edit', $jogo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Jogo'), ['action' => 'delete', $jogo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jogo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Jogos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Jogo'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Rodadas'), ['controller' => 'Rodadas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rodada'), ['controller' => 'Rodadas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="jogos view large-9 medium-8 columns content">
    <h3><?= h($jogo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Estadio') ?></th>
            <td><?= h($jogo->estadio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rodada') ?></th>
            <td><?= $jogo->has('rodada') ? $this->Html->link($jogo->rodada->id, ['controller' => 'Rodadas', 'action' => 'view', $jogo->rodada->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($jogo->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Visitante') ?></th>
            <td><?= $this->Number->format($jogo->visitante) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Casa') ?></th>
            <td><?= $this->Number->format($jogo->casa) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Data') ?></th>
            <td><?= h($jogo->data) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Horario') ?></th>
            <td><?= h($jogo->horario) ?></td>
        </tr>
    </table>
</div>
