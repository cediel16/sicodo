<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('cargos.acceso')
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
                        Cargos
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div id="flashdata"></div>
                <?php if(sesiones::is_has_permission('cargos.insertar')) { ?>
                    <form id="form_add" action="ajax.php" class="form-inline" method="post">
                        <input type="text" class="span4" placeholder="Añadir cargo" name="cargo" id="cargo">
                    </form>
                <?php } ?>
                <div id="lista" class="tabbable basic-grid">
                    <?php echo cargos::lista() ?>
                </div>
            </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/cargos.js"></script>
    </body>
</html>
