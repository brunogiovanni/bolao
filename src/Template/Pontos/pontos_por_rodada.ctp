<div class="row">
    <div class="col-sm-4">
        <br />
        <h3>
            Pontos da rodada <?php echo $rodada; ?>
        </h3>
    </div>
    <div class="col-sm-6">
    	<?php
    	echo $this->Form->create('', ['method' => 'get']);
    	echo $this->Form->label('rodada', 'Rodada:');
    	?>
    	<div class="input-group">
        	<?php
        	echo $this->Form->control('rodada', ['label' => false, 'class' => 'form-control', 'options' => $rodadas, 'val' => $rodada]);
        	?>
        	<div class="input-group-append">
        	<?php
        	echo $this->Form->button('<i class="fa fa-search"></i>', ['escape' => false, 'class' => 'btn btn-success']);
        	?>
        	</div>
    	</div>
    	<?php
    	echo $this->Form->end();
    	?>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hovered">
        <thead>
            <tr>
                <th scope="col">Usuário</th>
                <th scope="col">Pontos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($totalPontos as $ponto): ?>
            <tr>
                <td><?= $ponto['usuario'] ?></td>
                <td><?= $this->Number->format($ponto['pontos']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
