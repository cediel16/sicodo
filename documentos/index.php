<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('documentos.acceso');
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
                        Documentos
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div id="flashdata"></div>
                <div class="row-fluid">
                    <div class="input-append pull-left">
                        <?php if (sesiones::is_has_permission('documentos.insertar')) { ?>
                            <a class="btn" href="<?php echo site_url() ?>/documentos/add.php">Añadir documento</a>
                        <?php } ?>
                    </div>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
                        <div class="input-append pull-right">
                            <?php if (trim(var_post('buscar')) != '') { ?>
                                <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn btn-link" title="Quitar filtro"><i class="icon-remove"></i></a>
                            <?php } ?>
                            <input class="" id="appendedInputButton" type="text" placeholder="Buscar" id="buscar" name="buscar" value="<?php echo trim(var_post('buscar')) ?>">
                            <button class="btn" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab">En curso</a></li>
                        <li><a href="#tab2" data-toggle="tab">Finalizado</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div id="lista" class="tabbable basic-grid">
                                <?php echo documentos::lista('en curso',trim(var_post('buscar'))) ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div id="lista" class="tabbable basic-grid">
                                <?php echo documentos::lista('finalizado',trim(var_post('buscar'))) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/unidades.js"></script>
    </body>
</html>
