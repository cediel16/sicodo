<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('unidades.editar');
$data = unidades::obtener_fila(var_get('var'));
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
                        Editar expediente
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div id="flashdata"></div>
                <form id="form_edit" action="ajax.php" class="form-inline" method="post">
                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" id="id" name="id" value="<?php echo $data['id'] ?>">
                            <input type="text" class="span5" id="unidad" name="unidad" value="<?php echo $data['unidad'] ?>" />
                            <span class="cargando"><img src="../img/cargando.gif" /></span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn" id="btn_volver">Volver</button>
                        <button type="submit" class="btn btn-primary" id="btn_editar">Editar</button>
                    </div>
                </form>
            </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/unidades.js"></script>
    </body>
</html>
