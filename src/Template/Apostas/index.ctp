<div class="row">
    <div class="col-sm-3">
        <br />
        <h3>
            Apostas
            <?php
            if (!empty($jogo)) {
                echo ' para';
                echo $this->Html->image($jogo->mandante->brasao, [
                    'class' => 'img-fluid', 'alt' => $jogo->mandante->descricao,
                    'title' => $jogo->mandante->descricao
                ]) . ' X ';
                echo $this->Html->image($jogo->fora->brasao, [
                    'class' => 'img-fluid', 'alt' => $jogo->fora->descricao,
                    'title' => $jogo->fora->descricao
                ]);
            }
            ?>
        </h3>
    </div>
    <div class="col-sm-6">
        <?= $this->Form->create('', ['method' => 'get']); ?>
        <div class="row">
            <div class="col-sm-4">
                <?= $this->Form->control('users_id', ['label' => 'Usuários:', 'class' => 'form-control', 'empty' => true, 'default' => ($this->request->getQuery('users_id')) ? $this->request->getQuery('users_id') : '']); ?>
            </div>
            <div class="col-sm-4">
                <?= $this->Form->control('rodadas', ['label' => 'Rodadas:', 'class' => 'form-control', 'empty' => true, 'default' => ($this->request->getQuery('rodadas')) ? $this->request->getQuery('rodadas') : '']); ?>
            </div>
            <div class="col-sm-4">
                <br />
                <?= $this->Form->button('<i class="fas fa-search"></i>', ['escape' => false, 'title' => 'Pesquisar', 'class' => 'btn btn-sm btn-info']); ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>
    <div class="col-sm-2 text-right">
        <br />
        <?php
        if (!empty($jogo)) {
            if ((strtotime(date('Y-m-d')) <= strtotime($jogo->data->format('Y-m-d'))) && (strtotime(date('Y-m-d H:i')) < strtotime($prazoHora))) {
                echo $this->Html->link('Novo', ['action' => 'add', $jogo->id], ['class' => 'btn btn-primary', 'title' => 'Nova aposta']);
            } elseif ((strtotime(date('Y-m-d')) >= strtotime($jogo->data->format('Y-m-d'))) && (strtotime(date('Y-m-d H:i')) >= strtotime($horaPosJogo)) && $pontos === 0) {
                echo $this->Form->postLink('Contabilizar pontos', [
                    'controller' => 'Pontos',
                    'action' => 'contabilizarPontos', $jogo->id], [
                    'confirm' => 'Contabilizar pontos das apostas?',
                    'title' => 'Contabilizar pontos' , 'escape' => false,
                    'class' => 'btn btn-info'
                ]);
            } elseif ($pontos > 0) {
                echo $this->Html->link('Ver pontos do jogo', ['controller' => 'Pontos', 'action' => 'index', $jogo->id], [
                    'class' => 'btn btn-info', 'title' => 'Ver pontos do jogo'
                ]);
            }
        }
        ?>
    </div>
</div>
<?php echo $this->Flash->render('apostas'); ?>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('Users.username', 'Apostador') ?></th>
                <th scope="col">Aposta</th>
                <th scope="col">Resultado real</th>
                <th scope="col"><?= $this->Paginator->sort('Jogos.rodadas_id', 'Rodada') ?></th>
                <th scope="col">Pontos</th>
                <!-- <th scope="col" class="actions">Ações</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apostas as $aposta): ?>
            <tr>
                <td><?= $aposta->has('user') ? $aposta->user->nome : '' ?></td>
                <td>
                    <?= $this->Html->image($aposta->jogo->mandante->brasao, [
                        'class' => 'img-fluid', 'title' => $aposta->jogo->mandante->brasao
                    ]) ?>
                    <?= $aposta->placar1 ?>
                    X
                    <?= $aposta->placar2 ?>
                    <?= $this->Html->image($aposta->jogo->fora->brasao, [
                        'class' => 'img-fluid', 'title' => $aposta->jogo->fora->brasao
                    ]) ?>
                </td>
                <td>
                    <?= $this->Html->image($aposta->jogo->mandante->brasao, [
                        'class' => 'img-fluid', 'title' => $aposta->jogo->mandante->brasao
                    ]) ?>
                    <?= $aposta->jogo->placar1 ?>
                    X
                    <?= $aposta->jogo->placar2 ?>
                    <?= $this->Html->image($aposta->jogo->fora->brasao, [
                        'class' => 'img-fluid', 'title' => $aposta->jogo->fora->brasao
                    ]) ?>
                </td>
                <td>
                    <?= $aposta->jogo->rodada->numero_rodada; ?>
                </td>
                <td>
                    <?= $aposta->ponto->pontos; ?>
                </td>
                <!-- <td class="actions">
                    <?php if (!empty($jogo)) : ?>
                        <?php if ((strtotime(date('Y-m-d')) <= strtotime($jogo->data->format('Y-m-d'))) && (strtotime(date('Y-m-d H:i')) < strtotime($prazoHora))) : ?>
                            <?= $this->Html->link('<i class="fas fa-edit"></i>', [
                                'action' => 'edit', $aposta->id], [
                                    'title' => 'Editar registro' , 'escape' => false
                            ]) ?>
                            <?= $this->Form->postLink('<i class="fas fa-trash-alt text-danger"></i>', [
                                'action' => 'delete', $aposta->id], [
                                    'confirm' => __('Deseja excluir este registro # {0}?', $aposta->id),
                                    'title' => 'Excluir registro' , 'escape' => false
                            ]) ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td> -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<<') ?>
            <?= $this->Paginator->prev('<') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('>') ?>
            <?= $this->Paginator->last('>>') ?>
        </ul>
    </div>
</div>
