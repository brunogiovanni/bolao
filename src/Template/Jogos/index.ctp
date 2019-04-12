<div class="row">
    <div class="col-sm-2">
        <br />
        <h3>Jogos</h3>
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
                <br />
                <?php echo $this->Form->button('<i class="fas fa-search"></i>', ['class' => 'btn btn-default', 'escape' => false]); ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="col-sm-1 text-right">
        <br />
        <?php echo $this->Html->link('Nova', ['action' => 'add'], ['class' => 'btn btn-primary']); ?>
    </div>
</div>
<?php echo $this->Flash->render('jogos'); ?>
<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('data') ?></th>
                <th scope="col"><?= $this->Paginator->sort('horario', 'Horário') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estadio', 'Estádio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rodadas_id', 'Rodada') ?></th>
                <th scope="col"><?= $this->Paginator->sort('casa', 'Mandante') ?></th>
                <th scope="col"><?= $this->Paginator->sort('visitante') ?></th>
                <?php if (in_array($usuario['group_id'], [1, 2])) : ?>
                    <th scope="col">Id</th>
                    <th scope="col" class="actions">Ações</th>
                <?php endif; ?>
                <th scope="col" class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jogos as $jogo): ?>
            <tr>
                <td><?= h($jogo->data->format('d/m/Y')) ?></td>
                <td><?= h($jogo->horario->format('H:i')) ?></td>
                <td><?= h($jogo->estadio) ?></td>
                <td class="text-center">
                    <?= $jogo->has('rodada') ? $jogo->rodada->numero_rodada : '' ?>
                </td>
                <td><?= $jogo->mandante->descricao ?></td>
                <td><?= $jogo->fora->descricao ?></td>
                <?php if (in_array($usuario['group_id'], [1, 2])) : ?>
                    <td><?php echo $jogo->id; ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $jogo->id], ['escape' => false, 'title' => 'Editar registro']) ?>
                        <?= $this->Form->postLink('<i class="fas fa-trash-alt text-danger"></i>', ['action' => 'delete', $jogo->id], ['confirm' => __('Deseja excluir o registro # {0}?', $jogo->id), 'escape' => false, 'title' => 'Excluir registro']) ?>
                    </td>
                <?php endif; ?>
                <td>
                    <?php echo $this->Html->link('Apostas', ['controller' => 'Apostas', 'action' => 'index', $jogo->id], ['title' => 'Apostas']); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
