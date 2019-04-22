<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
        - Bolão Medeiros
    </title>
    <?= $this->Html->meta('icon') ?>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <?php
    echo $this->Html->css([
        'stickyfooter.css',
        'cake.css'
    ]);
    ?>

    <style>
        .corpo {
            margin-top: 1rem;
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <?php echo $this->Html->image('logo-menu.png', ['alt' => 'Bolão Medeiros', 'title' => 'Bolão Medeiros', 'class' => 'img-fluid']); ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Início</a>
                    </li>
                    <?php foreach ($menuPai as $pai) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $pai->nome; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php foreach ($menuLateral as $menu) : ?>
                                    <?php if ($menu->parent_id === $pai->id) : ?>
                                        <?php
                                        if ($menu->tipo === 'A') {
                                            echo $this->Html->link($menu->nome, [
                                                'controller' => $parentMenu[$menu->id]['alias'],
                                                'action' => $menu->aco->alias
                                            ], ['class' => 'dropdown-item']);
                                        } else {
                                            echo $this->Html->link($menu->nome, [
                                                'controller' => $menu->aco->alias,
                                                'action' => 'index'
                                            ], ['class' => 'dropdown-item']);
                                        }
                                        ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <?php if (in_array($usuario['group_id'], [1])) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Desenvolvedores
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php
                                echo $this->Html->link('Menus', ['controller' => 'Menus', 'action' => 'index'], ['class' => 'dropdown-item']);
                                echo $this->Html->link('Grupos', ['controller' => 'Groups', 'action' => 'index'], ['class' => 'dropdown-item']);
                                echo $this->Html->link('Permissões', '/AclManager', ['class' => 'dropdown-item', 'target' => '_blank']);
                                ?>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i> <?php echo $usuario['nome']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            echo $this->Html->link('Perfil', ['controller' => 'Users', 'action' => 'view', $usuario['id']], [
                                'class' => 'dropdown-item']);
                            echo $this->Html->link('Sair', [
                                'controller' => 'Users', 'action' => 'logout'], [
                                'class' => 'dropdown-item']);
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="corpo container">
        <?= $this->fetch('content') ?>
    </div>

    <footer class="footer">
        <div class="container">
            &copy;<?php echo date('Y'); ?> - <a href="#">Medeiros Cervejaria</a>
            <div class="text-right small">
                Desenvolvido por
                <a href="https://bgbo.com.br/" target="_blank">
                    <img src="https://i1.wp.com/bgbo.com.br/wp-content/uploads/2019/03/cropped-icone.png?fit=32%2C32&ssl=1" class="mb-0" width="16">
                    Bruno Giovanni
                </a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
