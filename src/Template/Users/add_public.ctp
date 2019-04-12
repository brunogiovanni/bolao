<?php echo $this->Html->css('cake.css', ['block' => 'cssHead']); ?>
<?= $this->Form->create($user, ['class' => 'form-cadastro']) ?>
    <?php echo $this->Flash->render('login'); ?>
    <?php echo $this->Html->image('logo.png', ['alt' => 'Medeiros Cervejaria', 'class' => 'img-fluid mb-4']); ?>
    <h1 class="h3 mb-3 font-weight-normal">Bolão Medeiros</h1>
    <div class="row text-left">
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $this->Form->control('username', ['label' => 'Usuário:', 'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $this->Form->control('password', ['label' => 'Senha:', 'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $this->Form->control('nome', ['label' => 'Nome:', 'class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php echo $this->Form->control('email', ['label' => 'E-mail:', 'class' => 'form-control']); ?>
            </div>
        </div>
    </div>
    <?= $this->Form->button('Cadastrar', ['class' => 'btn btn-success btn-lg']) ?>
<?= $this->Form->end() ?>
