<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('permisos.editar');
$data = permisos::obtener_fila(var_get('var'));
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
                        Editar permiso
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div class="notifications top-center"></div>
                <form id="form_edit" action="ajax.php" class="form-inline" method="post">
                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" id="id" name="id" value="<?php echo $data['id'] ?>">
                            <input type="text" class="span6" id="permiso" name="permiso" value="<?php echo $data['permiso'] ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Descripción</label>
                        <div class="controls">
                            <textarea class="span6" id="descripcion" name="descripcion"><?php echo $data['descripcion'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="<?php echo site_url() ?>/permisos" class="btn">Cancelar</a>
                        <button type="submit" class="btn btn-primary" id="btn_editar">Editar</button>
                        <span class="cargando"><img src="../img/cargando.gif" /></span>
                    </div>
            </div>
        </form>
    </div>
</section>
<?php include_once '../tpl/script.php'; ?>
<script src="<?php echo site_url() ?>/js/permisos.js"></script>
</body>
</html>
