<div class="row">
    <div class="col-sm-10">
        <br />
        <h3>Nova aposta para <b>"<?php echo $jogo->mandante->descricao . ' x ' . $jogo->fora->descricao; ?>"</b></h3>
    </div>
</div>
<?php echo $this->Flash->render('apostas'); ?>
<hr />
<?= $this->Form->create($aposta) ?>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <?php
            echo $this->Form->control('aposta', [
                'label' => 'Aposta:', 'class' => 'form-control'
            ]);
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <?php
            echo $this->Form->control('equipes_id', [
                'label' => 'Vencedor:', 'class' => 'form-control',
                'options' => $equipes
            ]);
            ?>
        </div>
    </div>
</div>
<div class="container row">
    <?= $this->Form->button('Salvar', ['class' => 'btn btn-success']) ?>
</div>
<?= $this->Form->end() ?>
