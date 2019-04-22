<fieldset>
    <legend>Dados do usuário</legend>
    <div class="row">
        <div class="col-sm-6">
            <label>
                <?php echo $user->nome; ?>
            </label>
        </div>
        <div class="col-sm-6">
            <label>
                <?php echo $user->email; ?>
            </label>
        </div>
    </div>
</fieldset>
<hr />
<fieldset>
    <legend>Pontos acumulados</legend>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped table-hovered">
                <thead>
                    <th>Jogo</th>
                    <th>Pontos</th>
                </thead>
                <tbody>
                    <?php foreach ($users->pontos as $ponto) : ?>
                        <tr>
                            <td>
                                <?php
                                echo $this->Html->image($ponto->jogo->mandante->brasao, [
                                    'class' => 'img-fluid mb-2', 'alt' => $ponto->jogo->mandante->descricao,
                                    'title' => $ponto->jogo->mandante->descricao
                                ]) . ' x ';
                                echo $this->Html->image($ponto->jogo->fora->brasao, [
                                    'class' => 'img-fluid mb-2', 'alt' => $ponto->jogo->fora->descricao,
                                    'title' => $ponto->jogo->fora->descricao
                                ]);
                                ?>
                            </td>
                            <td>
                                <?php echo $ponto->pontos; $totalPontos += $ponto->pontos; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td><strong>Total de pontos</strong></td>
                        <td><?php echo $totalPontos; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</fieldset>
