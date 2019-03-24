<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Regra $regra
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $regra->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $regra->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Regras'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="regras form large-9 medium-8 columns content">
    <?= $this->Form->create($regra) ?>
    <fieldset>
        <legend><?= __('Edit Regra') ?></legend>
        <?php
            echo $this->Form->control('descricao');
            echo $this->Form->control('pontos');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
