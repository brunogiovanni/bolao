<div class="row">
    <div class="col-sm-4">
        <br />
        <h3>
            Pontos
            <?php if (!empty($jogo)) : ?>
                do jogo
                <?php echo $this->Html->image($jogo->mandante->brasao, [
                    'class' => 'img-fluid', 'alt' => $jogo->mandante->descricao,
                    'title' => $jogo->mandante->descricao
                ]); ?>
                X
                <?php echo $this->Html->image($jogo->fora->brasao, [
                    'class' => 'img-fluid', 'alt' => $jogo->fora->descricao,
                    'title' => $jogo->fora->descricao
                ]); ?>
            <?php endif; ?>
        </h3>
    </div>
    <div class="col">
        <?php
        if ($usuario['group_id'] === 1) {
            echo $this->Form->create('', ['action' => 'contabilizarPontos']);
            for ($i = 0; $i < count($jogosId); $i++) {
                echo $this->Form->hidden('jogosId[]', ['value' => $jogosId[$i]]);
            }
            echo $this->Form->submit('Contabilizar Pontos', ['class' => 'btn btn-primary']);
            echo $this->Form->end();
        }
        ?>
    </div>
</div>
<?php echo $this->Flash->render('pontos'); ?>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('users_id', 'Usuário') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pontos') ?></th>
                <?php if (empty($jogo)) : ?>
                    <th scope="col"><?= $this->Paginator->sort('Apostas.jogos_id', 'Jogo') ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pontos as $ponto): ?>
            <tr>
                <td><?= $ponto->user->nome ?></td>
                <td><?= $this->Number->format($ponto->pontos) ?></td>
                <?php if (empty($jogo)) : ?>
                    <td>
                        <?php
                        echo $this->Html->image($ponto->aposta->jogo->mandante->brasao, [
                            'class' => 'img-fluid', 'alt' => $ponto->aposta->jogo->mandante->descricao,
                            'title' => $ponto->aposta->jogo->mandante->descricao
                        ]);
                        echo 'x';
                        echo $this->Html->image($ponto->aposta->jogo->fora->brasao, [
                            'class' => 'img-fluid', 'alt' => $ponto->aposta->jogo->fora->descricao,
                            'title' => $ponto->aposta->jogo->fora->descricao
                        ]);
                        ?>
                    </td>
                <?php endif; ?>
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
