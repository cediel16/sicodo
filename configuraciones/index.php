<?php
require_once '../config.php';
sesiones::logged_in();
//sesiones::has_permission('rutas.acceso');
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
                        Configuraciones generales
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div class="row-fluid">
                    <div class="span6">
                        <form accept-charset="UTF-8" action="." method="POST">
                            <div class="control-group">
                                <label><strong>Dias laborales</strong></label>
                                <div class="well">
                                    <div class="controls">
                                        <label class="checkbox inline">
                                            <input type="checkbox" <?php echo (configuraciones::check_dia_laborable('lun')) ? 'checked' : ''; ?> />
                                            Lun
                                        </label>
                                        <label class="checkbox inline">
                                            <input type="checkbox" <?php echo (configuraciones::check_dia_laborable('mar')) ? 'checked' : ''; ?>/>
                                            Mar
                                        </label>
                                        <label class="checkbox inline">
                                            <input type="checkbox" <?php echo (configuraciones::check_dia_laborable('mie')) ? 'checked' : ''; ?>/>
                                            Mie
                                        </label>
                                        <label class="checkbox inline">
                                            <input type="checkbox" <?php echo (configuraciones::check_dia_laborable('jue')) ? 'checked' : ''; ?>/>
                                            Jue
                                        </label>
                                        <label class="checkbox inline">
                                            <input type="checkbox" <?php echo (configuraciones::check_dia_laborable('vie')) ? 'checked' : ''; ?>/>
                                            Vie
                                        </label>
                                    </div>
                                    <div class="control-group">
                                        <label class="checkbox inline">
                                            <input type="checkbox" <?php echo (configuraciones::check_dia_laborable('sab')) ? 'checked' : ''; ?>/>
                                            Sab
                                        </label>
                                        <label class="checkbox inline">
                                            <input type="checkbox" <?php echo (configuraciones::check_dia_laborable('dom')) ? 'checked' : ''; ?>/>
                                            Dom
                                        </label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label><strong>Horas laborables por día</strong></label>
                                    <div class="controls">
                                        <input type="text" class="span12" value="<?php echo configuraciones::get('horas_laborables_por_dia') ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-info">Guardar configuración</a>
                </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/rutas.js"></script>
    </body>
</html>
