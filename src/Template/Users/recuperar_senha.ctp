<?php echo $this->Form->create('', ['class' => 'form-signin']); ?>
    <?php echo $this->Flash->render('login'); ?>
    <?php echo $this->Html->image('logo.png', ['alt' => 'Medeiros Cervejaria', 'class' => 'img-fluid mb-4']); ?>
    <h1 class="h3 mb-3 font-weight-normal">Bolão Medeiros</h1>
    <h4>Recuperar senha</h4>
    <label for="email" class="sr-only">E-mail</label>
    <input type="text" id="email" class="form-control" name="email" placeholder="E-mail" required autofocus>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Recuperar</button>
    <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y'); ?></p>
<?php echo $this->Form->end(); ?>
