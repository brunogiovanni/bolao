<div class="row">
    <div class="col-sm-2">
        <br />
        <h3>Rodadas</h3>
    </div>
    <div class="col-sm-9">
        <?php echo $this->Form->create('', ['method' => 'get']); ?>
        <div class="row">
            <div class="col-sm-3">
                <?php echo $this->Form->input('data', [
                    'label' => 'Data:', 'class' => 'form-control',
                    'placeholder' => date('d/m/Y'),
                    'val' => (!empty($this->request->getQuery('data'))) ? $this->request->getQuery('data') : ''
                ]); ?>
            </div>
            <div class="col-sm-2">
                <?php echo $this->Form->input('rodada', [
                    'label' => 'Rodada:', 'class' => 'form-control',
                    'options' => $rodadas, 'empty' => true,
                    'val' => (!empty($this->request->getQuery('rodada'))) ? $this->request->getQuery('rodada') : ''
                ]); ?>
            </div>
            <div class="col-sm-1">
                <label>  </label>
                <?php echo $this->Form->button('<i class="fas fa-search"></i>', ['class' => 'btn btn-info', 'escape' => false, 'title' => 'Pesquisar']); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<div id="mensagem-sucesso" style="display: none;">
    <div class="alert alert-success">Apostas salvas com sucesso!</div>
</div>
<div id="mensagem-erro" style="display: none;">
    <div class="alert alert-danger">Erro ao salvar as apostas! Tente novamente ou entre em contato com a administração!</div>
</div>
<?php echo $this->Flash->render('jogos'); ?>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('data') ?></th>
                <th scope="col"><?= $this->Paginator->sort('horario', 'Horário') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rodadas_id', 'Rodada') ?></th>
                <th scope="col"><?= $this->Paginator->sort('casa', 'Mandante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('visitante') ?></th>
                <?php if (in_array($usuario['group_id'], [1])) : ?>
                    <th scope="col">Id</th>
                    <th scope="col" class="actions">Ações</th>
                <?php endif; ?>
                <!-- <th scope="col" class="actions"></th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jogos as $key => $jogo) : ?>
            <?php $disabled = ((strtotime(date('Y-m-d')) <= strtotime($jogo->data->format('Y-m-d'))) && (strtotime(date('H:i')) < strtotime($prazoHora[$jogo->id]))) ? '' : 'disabled'; ?>
                <tr>
                    <td><?= h($jogo->data->format('d/m/Y')) ?></td>
                    <td><?= h($jogo->horario->format('H:i')) ?></td>
                    <td><?= $jogo->rodada->numero_rodada ?></td>
                    <td>
                        <div class="row">
                            <?= $this->Html->image($jogo->mandante->brasao, ['class' => 'img-fluid col-3', 'alt' => $jogo->mandante->descricao, 'title' => $jogo->mandante->descricao]) ?>
                            <input type="number" <?= $disabled ?> onBlur="salvarLance(this.value, null, <?= $key ?>, <?= $jogo->id ?>);" min="0" id="placar-mandante-<?= $key ?>" class="form-control col-3" />
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <input type="number" <?= $disabled ?> onBlur="salvarLance(null, this.value, <?= $key ?>, <?= $jogo->id ?>);" min="0" id="placar-visitante-<?= $key ?>" class="form-control col-3" />
                            <?= $this->Html->image($jogo->fora->brasao, ['class' => 'img-fluid col-3', 'alt' => $jogo->fora->descricao, 'title' => $jogo->fora->descricao]) ?>
                        </div>
                    </td>
                    <?php if (in_array($usuario['group_id'], [1])) : ?>
                        <td><?php echo $jogo->id; ?></td>
                        <td class="actions">
                            <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $jogo->id], ['escape' => false, 'title' => 'Editar registro']) ?>
                            <?= $this->Form->postLink('<i class="fas fa-trash-alt text-danger"></i>', ['action' => 'delete', $jogo->id], ['confirm' => __('Deseja excluir o registro # {0}?', $jogo->id), 'escape' => false, 'title' => 'Excluir registro']) ?>
                        </td>
                    <?php endif; ?>
                    <!-- <td>
                        <?php echo $this->Html->link('Apostas', ['controller' => 'Apostas', 'action' => 'index', $jogo->id], ['title' => 'Apostas']); ?>
                    </td> -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="container text-right">
        <button type="button" onClick="salvarApostas();" class="btn btn-success" title="Salvar apostas" <?= (!empty($disabled)) ? 'style="display: none"' : '' ?>>Salvar apostas</button>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?= $this->Paginator->first('<<') ?>
            <?= $this->Paginator->prev('<') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('>') ?>
            <?= $this->Paginator->last('>>') ?>
        </ul>
    </nav>
</div>
<?php
echo $this->Html->scriptBlock('let quantidadeApostas = parseInt(' . $key . ');', ['block' => 'scriptEnd']);
echo $this->Html->script('partidas/index.js', ['block' => 'scriptEnd']);
?>
