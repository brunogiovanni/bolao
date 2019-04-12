<?php echo $this->Form->create('', ['class' => 'form-signin']); ?>
    <?php echo $this->Flash->render('login'); ?>
    <?php echo $this->Html->image('logo.png', ['alt' => 'Medeiros Cervejaria', 'class' => 'img-fluid mb-4']); ?>
    <h1 class="h3 mb-3 font-weight-normal">Bolão Medeiros</h1>
    <label for="username" class="sr-only">Usuário</label>
    <input type="text" id="username" class="form-control" name="username" placeholder="Usuário" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" name="password" placeholder="Senha" required>
    <div class="checkbox mb-3">
        <label>
            <?php
            echo $this->Html->link('Esqueci minha senha', ['action' => 'recuperarSenha']);
            ?>
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
    <div class="mb-3">
        <label>
            Ainda não participa?
            <?php
            echo $this->Html->link('Cadastre-se', ['action' => 'add_public']);
            ?>
        </label>
    </div>
    <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y'); ?></p>
<?php echo $this->Form->end(); ?>
