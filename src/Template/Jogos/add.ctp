<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Jogo $jogo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Jogos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Rodadas'), ['controller' => 'Rodadas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Rodada'), ['controller' => 'Rodadas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="jogos form large-9 medium-8 columns content">
    <?= $this->Form->create($jogo) ?>
    <fieldset>
        <legend><?= __('Add Jogo') ?></legend>
        <?php
            echo $this->Form->control('data');
            echo $this->Form->control('horario');
            echo $this->Form->control('estadio');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
