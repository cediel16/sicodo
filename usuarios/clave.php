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

    if (var_post('clave1') == '' || var_post('clave2') == '') {
        $msj_clave1 = text('error', 'Ingrese una contraseña y su confirmación.');
        $band = 0;
    } elseif (var_post('clave1') != var_post('clave2')) {
        $msj_clave1 = text('error', 'La contraseña y su confirmación no coinciden.');
        $band = 0;
    }


    if ($band) {
        if (usuarios::cambiar_clave(var_post('id'),var_post('clave1'))) {
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
                        Editar usuario - Cambiar contraseña
                    </li>
                    <li class="search">
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
                            <input class="span6" type="text" id="cedula" name="cedula" maxlength="8" value="<?php echo $usuario['cedula'] ?>" readonly />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nombre</label>
                        <div class="controls">
                            <input class="span6 " type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre'] ?>" readonly />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Correo electrónico</label>
                        <div class="controls">
                            <input class="span6" type="text" id="email" name="email" value="<?php echo $usuario['email'] ?>" readonly />
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
                            <select class="span6" id="rol" name="rol" disabled>
                                <option></option>
                                <?php
                                for ($i = 0; $i < count($roles); $i++) {
                                    if ($roles[$i]['id'] == $usuario['rol_fkey']) {
                                        $sltd = 'selected';
                                    } else {
                                        $sltd = '';
                                    }
                                    echo '<option value="' . $roles[$i]['id'] . '" ' . $sltd . '>' . $roles[$i]['rol'] . '</option>';
                                }
                                ?>
                            </select>
                            <?php echo $msj_rol ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="<?php echo site_url() ?>/usuarios/edit.php?var=<?php echo $usuario['id'] ?>" class="btn">Cancelar</a>
                        <input type="submit" class="btn btn-primary" value="Aceptar" />
                    </div>
                </form>
            </div>
        </section>
        <?php include_once base_url() . '/tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/usuarios.js"></script>
    </body>
</html>
