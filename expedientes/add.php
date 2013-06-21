<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('expedientes.insertar');
$rutas = rutas::obtener_filas();

$band = 1;
if (count(var_post()) > 0) {
    if (!is_numeric(var_post('ruta'))) {
        $msj_ruta = text('error', 'Seleccione la ruta.');
        $band = 0;
    }

    if (var_post('codigo') == '') {
        $msj_codigo = text('error', 'Escriba el código identificador del expediente.');
        $band = 0;
    } elseif (!expedientes::esta_codigo_disponible(var_post('id'), var_post('codigo'))) {
        $msj_codigo = text('error', 'El codigo identificador no está disponible.');
        $band = 0;
    }

    if (var_post('titulo') == '') {
        $msj_titulo = text('error', 'Escriba el titulo del expediente.');
        $band = 0;
    }

    if (var_post('descripcion') == '') {
        $msj_descripcion = text('error', 'Escriba una descripción breve del expediente.');
        $band = 0;
    }

    if ($band) {
        if (expedientes::add(var_post())) {
            set_flashdata('info', 'Se ha añadido un nuevo expediente con éxito.');
            redirect('expedientes');
        } else {
            set_flashdata('error', 'Error al intentar añadir un nuevo expediente.');
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
                        Añadir expediente
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <?php echo flashdata() ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form-horizontal row-fluid" >
                    <div class="control-group">
                        <label class="control-label">Ruta</label>
                        <div class="controls">
                            <select class="span6" id="ruta" name="ruta">
                                <option></option>
                                <?php
                                for ($i = 0; $i < count($rutas); $i++) {
                                    if ($rutas[$i]['id'] == var_post('ruta')) {
                                        $sltd = 'selected';
                                    } else {
                                        $sltd = '';
                                    }
                                    echo '<option value="' . $rutas[$i]['id'] . '" ' . $sltd . '>' . $rutas[$i]['ruta'] . '</option>';
                                }
                                ?>
                            </select>
                            <?php echo $msj_ruta ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Código identificador</label>
                        <div class="controls">
                            <input class="span6" type="text" id="codigo" name="codigo" value="<?php echo var_post('codigo') ?>" />
                            <?php echo $msj_codigo ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Título</label>
                        <div class="controls">
                            <input class="span6" type="text" id="titulo" name="titulo" value="<?php echo var_post('titulo') ?>" />
                            <?php echo $msj_titulo ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Descripción breve</label>
                        <div class="controls">
                            <textarea class="span6" id="descripcion" name="descripcion"><?php echo var_post('descripcion') ?></textarea>
                            <?php echo $msj_descripcion ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <div class="alert alert-block span6">
                                <h4>Atención!</h4> Verifica una o otra vez que la la información a suministrar es la correcta, una vez registrada esta no podrá ser modificada.
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="<?php echo site_url() ?>/expedientes" class="btn">Cancelar</a>
                        <input type="submit" class="btn btn-primary" value="Aceptar" />
                    </div>
                </form>
            </div>
        </section>
        <?php include_once base_url() . '/tpl/script.php'; ?>
    </body>
</html>
