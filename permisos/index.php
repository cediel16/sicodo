<?php
require_once '../config.php';
sesiones::logged_in();
//sesiones::has_permission('usuarios.permisos.acceso');
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
                        Permisos
                    </li>
                    <li class="search">
                        <a class="btn" href="<?php echo site_url() ?>/permisos/add.php">Añadir permiso</a>
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div id="flashdata"></div>
                <div id="lista" class="tabbable basic-grid">
                    <?php echo permisos::lista() ?>
                </div>
            </div>
        </section>
        <?php include_once base_url() . '/tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/permisos.js"></script>
    </body>
</html>