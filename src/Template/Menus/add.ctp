<div class="row">
    <div class="col-sm-6">
        <br />
        <h3>Cadastro de menu</h3>
    </div>
    <div class="col-sm-6">
        <br />
        <?php echo $this->Flash->render('menus'); ?>
    </div>
</div>
<?= $this->Form->create($menu) ?>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('nome', ['label' => 'Nome:', 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('icone', ['label' => 'Ícone:', 'class' => 'form-control']); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('parent_id', ['label' => 'Menu principal:', 'class' => 'form-control', 'empty' => true, 'options' => $parentMenus]); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('acos_id', ['label' => 'Aco:', 'class' => 'form-control', 'empty' => true, 'default' => 0]); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('tipo', ['label' => 'Tipo:', 'class' => 'form-control', 'options' => $tiposMenu]); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="container">
        <?= $this->Form->button('Salvar', ['class' => 'btn btn-success']) ?>
        <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'btn btn-warning']) ?>
    </div>
</div>
<?= $this->Form->end() ?>
