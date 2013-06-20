<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('usuarios.insertar');

$band = 1;
if (count(var_post()) > 0) {

    if (var_post('permiso') == '') {
        $msj_permiso = text('error', 'Escriba el permiso.');
        $band = 0;
    }

    if (var_post('descripcion') == '') {
        $msj_descripcion = text('error', 'Escriba una descripción breve del permiso.');
        $band = 0;
    }

    if ($band) {
        if (permisos::add(var_post())) {
            set_flashdata('info', 'Se ha añadido un nuevo permiso con éxito.');
            redirect('permisos');
        } else {
            set_flashdata('error', 'Error al intentar añadir un nuevo permiso.');
        }
    }
}
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
                        Añadir usuario
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <?php echo flashdata() ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form-horizontal row-fluid" >
                    <div class="control-group">
                        <label class="control-label">Permiso</label>
                        <div class="controls">
                            <input class="span6" type="text" id="permiso" name="permiso" value="<?php echo var_post('permiso') ?>" />
                            <?php echo $msj_permiso ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Descripción</label>
                        <div class="controls">
                            <textarea class="span6" id="descripcion" name="descripcion"><?php echo var_post('descripcion') ?></textarea>
                            <?php echo $msj_descripcion ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="<?php echo site_url() ?>/permisos" class="btn">Cancelar</a>
                        <input type="submit" class="btn btn-primary" value="Aceptar" />
                    </div>
                </form>
            </div>
        </section>
        <?php include_once base_url() . '/tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/usuarios.js"></script>
    </body>
</html>
