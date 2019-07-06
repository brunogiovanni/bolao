<div class="row">
	<div class="col-sm-6">
        <h3>Atualizar rodada</h3>
	</div>
	<div class="col-sm-6">
		<?php echo $this->Flash->render('rodadas'); ?>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-striped table-hovered">
		<thead>
			<tr>
				<th>Rodada</th>
				<th>Atual</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($rodadas as $rodada) : ?>
				<tr>
					<td>
						<?php echo $rodada->numero_rodada; ?>
					</td>
					<td>
						<?php echo ($rodada->atual === 'N') ? 'Não' : 'Sim'; ?>
					</td>
					<td>
						<?php
						if ($rodada->atual === 'N') {
    						echo $this->Form->postLink('<i class="fas fa-edit"></i>', [
    						    'action' => 'edit', $rodada->id
    						], ['escape' => false, 'title' => 'Atualizar rodada']);
						}
						?>
					</td>
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