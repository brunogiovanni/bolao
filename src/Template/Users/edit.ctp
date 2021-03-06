<div class="row">
    <div class="col-sm-4">
        <br />
        <h3>Cadastro de usuário</h3>
    </div>
    <div class="col-sm-6">
        <br />
        <?php echo $this->Flash->render('users'); ?>
    </div>
</div>
<hr />
<?= $this->Form->create($user) ?>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('username', ['label' => 'Usuário:', 'class' => 'form-control', 'readonly' => true]); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('nova_senha', ['label' => 'Nova senha:', 'class' => 'form-control', 'type' => 'password']); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('nome', ['label' => 'Nome:', 'class' => 'form-control', 'readonly' => true]); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <?php echo $this->Form->control('email', ['label' => 'E-mail:', 'class' => 'form-control', 'readonly' => true]); ?>
        </div>
    </div>
    <?php if ($usuario['group_id'] !== 3) : ?>
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $this->Form->control('group_id', ['label' => 'Grupo:', 'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <?php echo $this->Form->control('ativo', ['label' => 'Ativo:', 'class' => 'form-control', 'options' => ['S' => 'Sim', 'N' => 'Não']]); ?>
            </div>
        </div>
    <?php endif ?>
</div>
<div class="row">
    <div class="container">
        <?= $this->Form->button('Salvar', ['class' => 'btn btn-success']) ?>
        <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'btn btn-warning']) ?>
    </div>
</div>
<?= $this->Form->end() ?>
