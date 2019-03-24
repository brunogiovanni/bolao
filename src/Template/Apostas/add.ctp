<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aposta $aposta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Apostas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jogos'), ['controller' => 'Jogos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Jogo'), ['controller' => 'Jogos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Equipes'), ['controller' => 'Equipes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Equipe'), ['controller' => 'Equipes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="apostas form large-9 medium-8 columns content">
    <?= $this->Form->create($aposta) ?>
    <fieldset>
        <legend><?= __('Add Aposta') ?></legend>
        <?php
            echo $this->Form->control('aposta');
            echo $this->Form->control('equipes_id', ['options' => $equipes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
