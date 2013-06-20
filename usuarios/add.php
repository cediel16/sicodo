<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('usuarios.insertar');
$roles = roles::obtener_filas();

$band = 1;
if (count(var_post()) > 0) {
    if (!es_cedula(var_post('cedula'))) {
        $msj_cedula = text('error', 'La cédula es inválida.');
        $band = 0;
    } elseif (!usuarios::esta_cedula_disponible(var_post('cedula'))) {
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
    } elseif (!usuarios::esta_email_disponible(var_post('email'))) {
        $msj_email = text('error', 'El correo electrónico no está disponible.');
        $band = 0;
    }

    if (var_post('clave1') == '' || var_post('clave2') == '') {
        $msj_clave1 = text('error', 'Ingrese una contraseña y su confirmación.');
        $band = 0;
    } elseif (var_post('clave1') != var_post('clave2')) {
        $msj_clave1 = text('error', 'La contraseña y su confirmación no coinciden.');
        $band = 0;
    }

    if (!is_numeric(var_post('rol'))) {
        $msj_rol = text('error', 'Seleccione rol.');
        $band = 0;
    }

    if ($band) {
        if (usuarios::add(var_post())) {
            set_flashdata('info', 'Se ha añadido un nuevo usuario con éxito.');
            redirect('usuarios');
        } else {
            set_flashdata('error', 'Error al intentar añadir un nuevo usuario.');
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
                        <label class="control-label">Cédula</label>
                        <div class="controls">
                            <input class="span6" type="text" id="cedula" name="cedula" maxlength="8" value="<?php echo var_post('cedula') ?>" />
                            <?php echo $msj_cedula ?>
<!--                            <p class="text-error">Donec ullamcorper nulla non metus auctor fringilla.</p>-->
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls">
                            <input class="span6" type="text" id="nombre" name="nombre" value="<?php echo var_post('nombre') ?>" />
                            <?php echo $msj_nombre ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Correo electrónico</label>
                        <div class="controls">
                            <input class="span6" type="text" id="email" name="email" value="<?php echo var_post('email') ?>" />
                            <?php echo $msj_email ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Contraseña</label>
                        <div class="controls">
                            <input class="span6" type="password" id="clave1" name="clave1" />
                            <?php echo $msj_clave1 ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Confirmar contraseña</label>
                        <div class="controls">
                            <input class="span6" type="password" id="clave2" name="clave2" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Rol</label>
                        <div class="controls">
                            <select class="span6" id="rol" name="rol">
                                <option></option>
                                <?php
                                for ($i = 0; $i < count($roles); $i++) {
                                    if ($roles[$i]['status'] == 'activo') {

                                        if ($roles[$i]['id'] == var_post('rol')) {
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
