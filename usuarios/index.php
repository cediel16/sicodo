<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('usuarios.acceso');
$roles = usuarios::obtener_lista_roles_para_filtrar();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Control de documentos</title>

        <?php include_once base_url() . '/tpl/link.php'; ?>
    </head>
    <body>
        <header>
            <?php include_once base_url() . '/tpl/header.php'; ?>
        </header>
        <section class="container-fluid contenedor-principal">
            <div class="titlebar">
                <ul>
                    <li class="title">
                        Administrador de usuarios
                    </li>
                    <li class="search">
                        <?php if (sesiones::is_has_permission('usuarios.insertar')) { ?>
                            <a class="btn" href="<?php echo site_url() ?>/usuarios/add.php">Añadir usuario</a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <?php echo flashdata() ?>
                <div class='notifications top-center'></div>
                <div class="row-fluid">
                    <div class="span3 pull-right">
                        <div class="pull-right">
                            <div class="btn-group pull-right">
                                <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown">Filtrar por <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li class="nav-header">Status</li>
                                    <li><a href="javascript:void(0);" class="filtrar_usuarios" rel="activos"><?php echo status('info', 'Activos') ?></a></li>
                                    <li><a href="javascript:void(0);" class="filtrar_usuarios" rel="inactivos"><?php echo status('important', 'Inactivos') ?></a></li>
                                    <li><a href="javascript:void(0);" class="filtrar_usuarios" rel="bloqueados"><?php echo status('warning', 'Bloqueados') ?></a></li>
                                    <li class="divider"></li>
                                    <li class="nav-header">Roles</li>
                                    <?php for ($i = 0; $i < count($roles); $i++) { ?>
                                        <li><a href="javascript:void(0);" class="filtrar_usuarios" rel="<?php echo $roles[$i]['id'] ?>"><?php echo $roles[$i]['rol'] ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="lista" class="tabbable basic-grid">
                    <?php echo usuarios::lista(var_get('filtro')) ?>
                </div>
            </div>
        </section>
        <?php include_once base_url() . '/tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/usuarios.js"></script>
    </body>
</html>
