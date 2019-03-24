<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ponto $ponto
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $ponto->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $ponto->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Pontos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Apostas'), ['controller' => 'Apostas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Aposta'), ['controller' => 'Apostas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pontos form large-9 medium-8 columns content">
    <?= $this->Form->create($ponto) ?>
    <fieldset>
        <legend><?= __('Edit Ponto') ?></legend>
        <?php
            echo $this->Form->control('pontos');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
