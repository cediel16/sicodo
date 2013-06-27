<?php
require_once '../config.php';
sesiones::logged_in();
//sesiones::has_permission('unidades.acceso');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo tag_title() ?></title>
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
                        Solicitud de Ayuda en linea
                    </li>
                    <li class="search">
                        <span class="">
                            <i class="icon-remove-sign"></i>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail"></label>
                        <div class="controls">
                            <h4>Solicite ayuda</h4>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Nombre</label>
                        <div class="controls">
                            <input class="span6" type="text" id="inputEmail" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Correo electrónico</label>
                        <div class="controls">
                            <input class="span6" type="password" id="inputPassword" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Asunto</label>
                        <div class="controls">
                            <input class="span6" type="password" id="inputPassword" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Mensaje</label>
                        <div class="controls">
                            <textarea class="span6" rows="10"></textarea>
                        </div>
                    </div>
                </form>
                <!--
                <div id="flashdata"></div>
                <?php if (sesiones::is_has_permission('unidades.insertar')) { ?>
                                    <form id="form_add" action="ajax.php" class="form-inline" method="post">
                                        <input type="text" class="span4" placeholder="Añadir unidad" name="unidad" id="unidad">
                                    </form>
                <?php } ?>
                <div id="lista" class="tabbable basic-grid">
                <?php echo unidades::lista() ?>
                </div>
                -->
            </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/unidades.js"></script>
    </body>
</html>
