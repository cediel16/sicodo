<?php
require_once '../config.php';
sesiones::logged_in();
$usr = usuarios::obtener_fila(sesiones::userdata('id'));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo tag_title() ?></title>

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
                        Mi cuenta
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <form class="form-horizontal row-fluid" method="post" action="/control/usuarios/add.php">
                    <div class="control-group">
                        <label class="control-label">Cédula</label>
                        <div class="controls">
                            <input type="text" class="span6" readonly value="<?php echo $usr['cedula'] ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls">
                            <input type="text" class="span6" readonly value="<?php echo $usr['nombre'] ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Correo electrónico</label>
                        <div class="controls">
                            <input type="text" class="span6" readonly value="<?php echo $usr['email'] ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Rol</label>
                        <div class="controls">
                            <input type="text" class="span6" readonly value="<?php echo $usr['rol'] ?>">
                        </div>
                    </div>
                    <div class="form-actions">
                        <?php if (sesiones::is_has_permission('usuarios.perfil.editar')) { ?>
                            <a class="btn" href="<?php echo site_url() ?>/usuarios/perfil_edit.php">Editar</a>
                            <?php if (sesiones::is_has_permission('usuarios.perfil.cambiar.clave')) { ?>
                                <a class="btn" href="<?php echo site_url() ?>/usuarios/perfil_clave.php">Cambiar contraseña</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </section>
        <?php include_once base_url() . '/tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/usuarios.js"></script>
    </body>
</html>
