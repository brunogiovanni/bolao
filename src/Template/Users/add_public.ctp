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
        <div class="col-sm-12">
            <a href="#" data-toggle="modal" data-target="#sobreBolao">Leia sobre o bolão aqui</a>
        </div>
        <div id="btnPaypal" class="col-sm-12">
        </div>
    </div>
<?= $this->Form->button('Cadastrar e pagar no bar', ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>

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
        Caso opte por pagar via internet, é acrescida a taxa de R$10,00 (dez reais) para transferência. <br>
        Outros métodos de pagamento, ligue para os telefones 31 9501-5991 ou 31 9127-8386.<br>
        Seu cadastro ficará inativo até que seja confirmado o pagamento.
      </div>
    </div>
  </div>
</div>

<script src="https://www.paypal.com/sdk/js?currency=BRL&locale=pt_BR&client-id=AZGqVjGWGneqLmCAMiE1UYLcnK6ipwaTlGptfech7sMunbOmiXnxzQNlfLg3aPcnNWdgTDPRxXCeVA8u"></script>
<script>
    let nome, usuario, senha, email = '';
    $().ready(function () {
        $("#btnPaypal").hide();
        $('#nome').keyup(function() {
            nome = $('#nome').val();
            verificarCampos();
        });
        $('#email').keyup(function() {
            email = $('#email').val();
            verificarCampos();
        });
        $('#username').keyup(function() {
            usuario = $('#username').val();
            verificarCampos();
        });
        $('#password').keyup(function() {
            senha = $('#password').val();
            verificarCampos();
        });
    });

    function verificarCampos() {
        if (nome !== '' && usuario !== '' && senha !== '' && email !== '') {
            $("#btnPaypal").show();
        }
    }

    paypal.Buttons({
        createOrder: function(data, actions) {
            // Set up the transaction
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '270.00'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            // Capture the funds from the transaction
            return actions.order.capture().then(function(details) {
                // Show a success message to your buyer
                alert('Transação completa ' + details.payer.name.given_name);
                salvarDados();
            });
        }
    }).render('#btnPaypal');

    function salvarDados() {
        $.ajax({
            url: '/users/add_public',
            method: 'post',
            data: {nome: nome, email: email, password: senha, username: usuario, confirmado: 1},
            success: function () {
                window.href = '/login';
            },
            error: function (error) {
                alert('Ocorreu um erro! Entre em contato com o suporte em sistema@cervejamedeiros.com.br');
                console.error(error);
            }
        });
    }
</script>
