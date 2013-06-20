<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('roles.permisos');
$data = roles::obtener_fila(var_get('var'));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Control de documentos</title>
        <?php include_once '../tpl/link.php'; ?>
    </head>
    <body>
        <header>
            <?php include_once '../tpl/header.php'; ?>
        </header>
        <section class="container-fluid contenedor-principal">
            <div class="titlebar">
                <ul>
                    <li class="title">
                        Permisos para <i><?php echo $data['rol'] ?> </i>
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div class='notifications top-center'></div>
                <div id="lista" class="tabbable basic-grid">
                    <?php echo roles::lista_permisos($data['id']) ?>
                </div>
            </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/roles.js"></script>
    </body>
</html>
