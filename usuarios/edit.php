<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('usuarios.editar');
$usuario = usuarios::obtener_fila(var_get('var'));
if (!is_array($usuario)) {
    redirect('usuarios');
}
$roles = roles::obtener_filas();
$band = 1;
if (count(var_post()) > 0) {
    if (!es_cedula(var_post('cedula'))) {
        $msj_cedula = text('error', 'La cédula es inválida.');
        $band = 0;
    } elseif (!usuarios::esta_cedula_disponible_al_editar(var_post('id'), var_post('cedula'))) {
        $msj_cedula = text('error', 'La cédula no está disponible.');
        $band = 0;
    }

    if (var_post('nombre') === '') {
        $msj_nombre = text('error', 'Escriba el nombre del usuario.');
        $band = 0;
    }

    if (!es_email(var_post('email'))) {
        $msj_email = text('error', 'Correo electrónico inválido.');
        $band = 0;
    } elseif (!usuarios::esta_email_disponible_al_editar(var_post('id'), var_post('email'))) {
        $msj_email = text('error', 'El correo electrónico no está disponible.');
        $band = 0;
    }

    if (!is_numeric(var_post('rol'))) {
        $msj_rol = text('error', 'Seleccione rol.');
        $band = 0;
    }

    if ($band) {
        if (usuarios::edit(var_post())) {
            set_flashdata('info', 'Los datos del usuario se han editado con éxito.');
            redirect('usuarios');
        } else {
            set_flashdata('error', 'Error al intentar editar los datos del usuario.');
        }
    }
}
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
                        Editar usuario
                    </li>
                    <li class="search">
                        <a class="btn btn-danger btn-mini" href="<?php echo site_url() ?>/usuarios/clave.php?var=<?php echo $usuario['id'] ?>">Cambiar constraseña</a>
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <?php echo flashdata() ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>?var=<?php echo $usuario['id'] ?>" method="post" class="form-horizontal row-fluid" >
                    <div class="control-group">
                        <label class="control-label">Cédula</label>
                        <div class="controls">
                            <input class="span6" type="hidden" id="id" name="id" value="<?php echo $usuario['id'] ?>" />
                            <input class="span6" type="text" id="cedula" name="cedula" maxlength="8" value="<?php echo $usuario['cedula'] ?>" />
                            <?php echo $msj_cedula ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls">
                            <input class="span6" type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre'] ?>" />
                            <?php echo $msj_nombre ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Correo electrónico</label>
                        <div class="controls">
                            <input class="span6" type="text" id="email" name="email" value="<?php echo $usuario['email'] ?>" />
                            <?php echo $msj_email ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Rol</label>
                        <div class="controls">
                            <select class="span6" id="rol" name="rol">
                                <?php
                                for ($i = 0; $i < count($roles); $i++) {
                                    if ($roles[$i]['status']=='activo') {
                                        if ($roles[$i]['id'] == $usuario['rol_fkey']) {
                                            $sltd = 'selected';
                                        } else {
                                            $sltd = '';
                                        }
                                        echo '<option value="' . $roles[$i]['id'] . '" ' . $sltd . '>' . $roles[$i]['rol'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <?php echo $msj_rol ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="<?php echo site_url() ?>/usuarios" class="btn">Cancelar</a>
                        <input type="submit" class="btn btn-primary" value="Aceptar" />
                    </div>
                </form>
            </div>
        </section>
        <?php include_once base_url() . '/tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/usuarios.js"></script>
    </body>
</html>
