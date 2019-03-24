<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rodada $rodada
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Rodadas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="rodadas form large-9 medium-8 columns content">
    <?= $this->Form->create($rodada) ?>
    <fieldset>
        <legend><?= __('Add Rodada') ?></legend>
        <?php
            echo $this->Form->control('numero_rodada');
            echo $this->Form->control('data_inicio');
            echo $this->Form->control('data_final');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
