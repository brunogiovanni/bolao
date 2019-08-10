<div class="row" id="rodadas">
    <div class="col-sm-2">
        <br />
        <h3>Rodada <?php echo $rodadaAtual; ?></h3>
    </div>
    <div class="col-sm-9">
        <?php if ($usuario['group_id'] === 1) : ?>
            <?php echo $this->Form->create('', ['method' => 'get']); ?>
            <div class="row">
                <!-- <div class="col-sm-3">
                    <?php echo $this->Form->control('data', [
                        'label' => 'Data:', 'class' => 'form-control',
                        'placeholder' => date('d/m/Y'),
                        'val' => (!empty($this->request->getQuery('data'))) ? $this->request->getQuery('data') : ''
                    ]); ?>
                </div> -->
                <div class="col-sm-2">
                    <?php echo $this->Form->control('rodada', [
                        'label' => 'Rodada:', 'class' => 'form-control',
                        'options' => $rodadas,
                        'val' => $rodadaAtual,
                        'default' => 7
                    ]); ?>
                </div>
                <div class="col-sm-1">
                    <label>  </label>
                    <?php echo $this->Form->button('<i class="fas fa-search"></i>', ['class' => 'btn btn-info', 'escape' => false, 'title' => 'Pesquisar']); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        <?php endif; ?>
    </div>
</div>
<div id="mensagem-sucesso" style="display: none;">
    <div class="alert alert-success">Apostas salvas com sucesso!</div>
</div>
<div id="mensagem-erro" style="display: none;">
    <div class="alert alert-danger">Erro ao salvar as apostas! Tente novamente ou entre em contato com a administração!</div>
</div>
<?php echo $this->Flash->render('jogos'); ?>
<?php echo $this->Flash->render('apostas'); ?>
<div class="table-responsive">
    <?= $this->Form->create('', ['action' => '/apostas/salvarApostas']); ?>
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th class="d-none d-md-table-cell" scope="col"><?= $this->Paginator->sort('data') ?></th>
                <th class="d-none d-md-table-cell" scope="col"><?= $this->Paginator->sort('horario', 'Horário') ?></th>
                <th class="d-none d-md-table-cell" scope="col"><?= $this->Paginator->sort('rodadas_id', 'Rodada') ?></th>
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
                    <td class="d-none d-md-table-cell"><?= h($jogo->data->format('d/m/Y')) ?></td>
                    <td class="d-none d-md-table-cell"><?= h($jogo->horario->format('H:i')) ?></td>
                    <td class="d-none d-md-table-cell"><?= $jogo->rodada->numero_rodada ?></td>
                    <td>
                        <div class="row">
                            <div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                <?= $this->Html->image($jogo->mandante->brasao, ['class' => 'img-fluid', 'alt' => $jogo->mandante->descricao, 'title' => $jogo->mandante->descricao]) ?>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                <input type="hidden" id="jogo-id-<?= $key; ?>" value="<?= $jogo->id; ?>" />
                                <input type="hidden" id="id-aposta-<?= $key; ?>" value="<?= $apostas[$jogo->id]['id']; ?>" />
                                <input type="hidden" id="time1-<?= $key; ?>" value="<?= $jogo->casa; ?>" />
                                <input type="number" <?= $disabled ?> onBlur="salvarLance(this.value, null, <?= $key ?>, <?= $jogo->id ?>);" min="0" id="placar-mandante-<?= $key ?>" class="form-control" value="<?= $apostas[$jogo->id]['time1'] ?>" />
                            </div>
                            <div class="col">
                                <?= $jogo->placar1; ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="row">
                            <div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                <?= $this->Html->image($jogo->fora->brasao, ['class' => 'img-fluid', 'alt' => $jogo->fora->descricao, 'title' => $jogo->fora->descricao]) ?>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                <input type="hidden" id="time2-<?= $key; ?>" value="<?= $jogo->visitante; ?>" />
                                <input type="number" <?= $disabled ?> onBlur="salvarLance(null, this.value, <?= $key ?>, <?= $jogo->id ?>);" min="0" id="placar-visitante-<?= $key ?>" class="form-control" value="<?= $apostas[$jogo->id]['time2'] ?>" />
                            </div>
                            <div class="col">
                                <?= $jogo->placar2; ?>
                            </div>
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
            <?= $this->Form->end() ?>
        </tbody>
    </table>
    
    <?php if (!empty($partidasAdiadas)) : ?>
        <h3>Jogos adiados</h3>
        <table class="table table-striped table-hovered">
            <thead>
                <tr>
                    <th class="d-none d-md-table-cell" scope="col">Data</th>
                    <th class="d-none d-md-table-cell" scope="col">Horário</th>
                    <th class="d-none d-md-table-cell" scope="col">Rodada</th>
                    <th scope="col">Mandante</th>
                    <th scope="col">Visitante</th>
                    <?php if (in_array($usuario['group_id'], [1])) : ?>
                        <th scope="col">Id</th>
                        <th scope="col" class="actions">Ações</th>
                    <?php endif; ?>
                </tr>
            </thead>
        	<tbody>
        		<?php foreach ($partidasAdiadas as $k => $adiado) : ?>
		            <?php $disabled = ((strtotime(date('Y-m-d')) <= strtotime($adiado->data->format('Y-m-d'))) && (strtotime(date('H:i')) < strtotime($prazoHora[$adiado->id]))) ? '' : 'disabled'; ?>
                	<tr>
                        <td class="d-none d-md-table-cell"><?= h($adiado->data->format('d/m/Y')) ?></td>
                        <td class="d-none d-md-table-cell"><?= h($adiado->horario->format('H:i')) ?></td>
                        <td class="d-none d-md-table-cell"><?= $adiado->rodada->numero_rodada ?></td>
                        <td>
                            <div class="row">
                                <div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?= $this->Html->image($adiado->mandante->brasao, ['class' => 'img-fluid', 'alt' => $adiado->mandante->descricao, 'title' => $adiado->mandante->descricao]) ?>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                    <input type="hidden" id="jogo-id-adiado-<?= $k; ?>" value="<?= $adiado->id; ?>" />
                                    <input type="hidden" id="id-aposta-adiado-<?= $k; ?>" value="<?= $apostasAdiadas[$adiado->id]['id']; ?>" />
                                    <input type="hidden" id="time1-adiado-<?= $k; ?>" value="<?= $adiado->casa; ?>" />
                                    <input type="number" <?= $disabled ?> onBlur="salvarLance(this.value, null, <?= $k ?>, <?= $adiado->id ?>);" min="0" id="placar-mandante-adiado-<?= $k ?>" class="form-control" value="<?= $apostasAdiadas[$adiado->id]['time1'] ?>" />
                                </div>
                                <div class="col">
                                    <?= $adiado->placar1; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                    <?= $this->Html->image($adiado->fora->brasao, ['class' => 'img-fluid', 'alt' => $adiado->fora->descricao, 'title' => $adiado->fora->descricao]) ?>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
                                    <input type="hidden" id="time2-adiado-<?= $k; ?>" value="<?= $adiado->visitante; ?>" />
                                    <input type="number" <?= $disabled ?> onBlur="salvarLance(null, this.value, <?= $k ?>, <?= $adiado->id ?>);" min="0" id="placar-visitante-adiado-<?= $k ?>" class="form-control" value="<?= $apostasAdiadas[$adiado->id]['time2'] ?>" />
                                </div>
                                <div class="col">
                                    <?= $adiado->placar2; ?>
                                </div>
                            </div>
                        </td>
                        <?php if (in_array($usuario['group_id'], [1])) : ?>
                            <td><?php echo $adiado->id; ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $adiado->id], ['escape' => false, 'title' => 'Editar registro']) ?>
                                <?= $this->Form->postLink('<i class="fas fa-trash-alt text-danger"></i>', ['action' => 'delete', $adiado->id], ['confirm' => __('Deseja excluir o registro # {0}?', $adiado->id), 'escape' => false, 'title' => 'Excluir registro']) ?>
                            </td>
                        <?php endif; ?>
                        <!-- <td>
                        <?php echo $this->Html->link('Apostas', ['controller' => 'Apostas', 'action' => 'index', $adiado->id], ['title' => 'Apostas']); ?>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
        	</tbody>
        </table>
    <?php endif; ?>
    <div class="container text-right">
        <a href="#rodadas" onClick="salvarApostas();" class="btn btn-success" title="Salvar apostas" <?= (!empty($disabled)) ? 'style="display: none"' : '' ?>>Salvar apostas</a>
    </div>
    <?= $this->Form->end(); ?>
    <!-- <nav aria-label="Page navigation">
        <ul class="pagination">
            <?= $this->Paginator->first('<<') ?>
            <?= $this->Paginator->prev('<') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('>') ?>
            <?= $this->Paginator->last('>>') ?>
        </ul>
    </nav> -->
</div>
<?php
if (empty($partidasAdiadas)) {
    echo $this->Html->scriptBlock('let quantidadeApostas = parseInt(' . $key . '); let adiados = false;', ['block' => 'scriptEnd']);
} else {
    echo $this->Html->scriptBlock('let quantidadeApostas = parseInt(' . ($key + $k) . '); let adiados = true;', ['block' => 'scriptEnd']);
}
echo $this->Html->script('partidas/index.js', ['block' => 'scriptEnd']);
?>
