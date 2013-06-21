<?php
require_once '../config.php';
sesiones::logged_in();
$rutas = rutas::obtener_filas();
$unidades = unidades::obtener_filas();
$cargos = cargos::obtener_filas();
$usuarios = usuarios::obtener_filas();
$estaciones = estaciones::obtener_filas();

sesiones::has_permission('estaciones.acceso');
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
                        Estaciones
                    </li>
                    <li class="search">
                        <form class="form-horizontal">
                            <div class="control-group">
                                <div class="controls">
                                    <select class="span5" id="ruta">
                                        <option value="">Seleccione ruta...</option>
                                        <?php for ($i = 0; $i < count($rutas); $i++) { ?>
                                            <option value="<?php echo $rutas[$i]['id'] ?>"><?php echo $rutas[$i]['ruta'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div id="flashdata" class="row-fluid"></div>
                <div class='notifications top-center'></div>
                <div class="row-fluid">
                    <div class="span12">
                        <form id="form_estaciones">
                            <div class="span1">
                                <div class="control-group">
                                    <label class="control-label"><strong>Orden</strong></label>
                                    <div class="controls">
                                        <input type="hidden" id="estacion_id" name="estacion_id" />
                                        <input class="span12" type="text" id="orden" name="orden" />
                                    </div>
                                </div>
                            </div>
                            <div class="span1">
                                <div class="control-group">
                                    <label class="control-label"><strong>Horas</strong></label>
                                    <div class="controls">
                                        <input class="span12" type="text" id="horas" name="horas"/>
                                    </div>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="control-group">
                                    <label class="control-label"><strong>Unidad</strong></label>
                                    <div class="controls">
                                        <select class="span12" id="unidad" name="unidad">
                                            <option value="">Seleccione...</option>
                                            <?php for ($i = 0; $i < count($unidades); $i++) { ?>
                                                <option value="<?php echo $unidades[$i]['id'] ?>"><?php echo $unidades[$i]['unidad'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="control-group">
                                    <label class="control-label"><strong>Cargo</strong></label>
                                    <div class="controls">
                                        <select class="span12" id="cargo" name="cargo">
                                            <option value="">Seleccione...</option>
                                            <?php for ($i = 0; $i < count($cargos); $i++) { ?>
                                                <option value="<?php echo $cargos[$i]['id'] ?>"><?php echo $cargos[$i]['cargo'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="control-group">
                                    <label class="control-label"><strong>Usuario responsable</strong></label>
                                    <div class="controls">
                                        <select class="span12" id="usuario" name="usuario">
                                            <option value="">Seleccione...</option>
                                            <?php for ($i = 0; $i < count($usuarios); $i++) { ?>
                                                <option value="<?php echo $usuarios[$i]['id'] ?>"><?php echo $usuarios[$i]['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="span3">
                                <div class="control-group">
                                    <label class="control-label"><strong>Descripción del paso</strong></label>
                                    <div class="controls">
                                        <input class="span12" type="text" id="descripcion" name="descripcion" />
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="span1">
                            <div class="control-group">
                                <label class="control-label">&nbsp;</label>
                                <div class="controls" id="ctrl_add">
                                    <button class="btn span12" id="btn_add">Añadir</button>
                                </div>
                                <div class="controls hide" id="ctrl_edit">
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn dropdown-toggle span12">Acción <span class="caret"></span></button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="javascript:void(0);" id="anch_save">Guardar</a></li>
                                            <li><a href="javascript:void(0);" id="anch_cancel">Cancelar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="lista" class="tabbable basic-grid">
                </div>
            </div>
            <div id="dialog-confirm" title="Eliminar estación">
                <h5>¿Estás seguro que deseas eliminar esta estación?</h5>
            </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/estaciones.js"></script>
    </body>
</html>
