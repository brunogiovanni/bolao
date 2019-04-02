<div class="row">
    <div class="col-sm-3">
        <br />
        <h3>Editar jogo</h3>
    </div>
    <div class="col-sm-6">
        <br />
        <?php echo $this->Flash->render('jogos'); ?>
    </div>
</div>
<hr />
<?= $this->Form->create($jogo) ?>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <?php echo $this->Form->control('casa', ['label' => 'Mandante:', 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <?php echo $this->Form->control('visitante', ['label' => 'Visitante:', 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('data', ['label' => 'Data:', 'class' => 'form-control', 'type' => 'text']); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('horario', ['label' => 'Horário:', 'class' => 'form-control', 'type' => 'text']); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('estadio', ['label' => 'Estádio:', 'class' => 'form-control']); ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <?= $this->Form->button('Salvar', ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?= $this->Form->end() ?>
