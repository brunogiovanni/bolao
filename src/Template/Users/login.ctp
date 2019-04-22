<?php echo $this->Form->create('', ['class' => 'form-signin']); ?>
    <?php echo $this->Flash->render('login'); ?>
    <?php echo $this->Html->image('logo.png', ['alt' => 'Medeiros Cervejaria', 'class' => 'img-fluid mb-4']); ?>
    <h1 class="h3 mb-3 font-weight-normal">Bolão Medeiros</h1>
    <label for="username" class="sr-only">Usuário</label>
    <input type="text" id="username" class="form-control" name="username" placeholder="Usuário" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" class="form-control" name="password" placeholder="Senha" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
    <div class="checkbox mb-3">
        <label>
            <?php
            echo $this->Html->link('Esqueci minha senha', ['action' => 'recuperarSenha']);
            ?>
        </label>
    </div>
    <div class="mb-3">
        <label>
            <a href="#" data-toggle="modal" data-target="#sobreBolao">Leia sobre o bolão aqui</a>
        </label>
    </div>
    <!-- <div class="mb-3">
        <label>
            Ainda não participa?
            <?php
            echo $this->Html->link('Cadastre-se', ['action' => 'add_public']);
            ?>
        </label>
    </div> -->
    <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y'); ?></p>
<?php echo $this->Form->end(); ?>

<!-- Modal -->
<div class="modal fade" id="sobreBolao" tabindex="-1" role="dialog" aria-labelledby="sobreBolaoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sobreBolaoLabel">Sobre o Bolão</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-justify">
        O Bolão Medeiros do Brasileirão 2019 tem o custo de R$250,00 (duzentos e cinquenta reais).<br>
        Ligue para os telefones 31 9501-5991 ou 31 9127-8386 para informações sobre métodos de pagamento ou nos visite no endereço abaixo.<br>
        Rua Tabaiares, 26, Floresta, Belo Horizonte.<br/>
        Seu cadastro ficará inativo até que seja confirmado o pagamento.
      </div>
    </div>
  </div>
</div>
