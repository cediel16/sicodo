<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('expedientes.acceso');
$exp = expedientes::obtener_vista(var_get('var'));
$movimientos = expedientes::obtener_vista_movimientos($exp['id']);
if(!is_array($exp)){
    redirect('expedientes');
}
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
                        Expediente
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div id="flashdata"></div>
                <div class="row-fluid">
                    <div class="row-fluid">
                        <div class="span12">
                            <h4><strong><?php echo $exp['codigo'] . ' ' . $exp['titulo'] ?></strong></h4>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <p><?php echo $exp['descripcion'] ?></p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <span class="btn btn-mini" id="exp_fecha_inicio" data-placement="bottom" data-toggle="tooltip" data-original-title="Inicio de la ruta"><i class="icon-flag-checkered"></i> <?php echo fecha('d M Y - h:i:s a', $exp['fecha_inicio']) ?></span>
                            <span class="btn btn-mini" id="exp_fecha_fin" data-placement="bottom" data-toggle="tooltip" data-original-title="Fin estimado de la ruta"><i class="icon-flag"></i> <?php echo fecha('d M Y - h:i:s a', configuraciones::sumar_horas($exp['fecha_inicio'], $exp['horas_movimientos'])) ?></span>
                            <span class="btn btn-mini" id="exp_horas" data-placement="bottom" data-toggle="tooltip" data-original-title="Horas laborales requeridas"><i class="icon-time"></i> <?php echo $exp['dias'] ?> días (<?php echo $exp['horas'] ?> hora laborables)</span>
                            <span class="btn btn-mini" id="exp_rutas" data-placement="bottom" data-toggle="tooltip" data-original-title="Rutas ejecutadas"><i class="icon-comment"></i> <?php echo $exp['estaciones_cumplidas'] ?> de <?php echo $exp['total_estaciones'] ?></span>

                            <?php
                            if ($exp['estaciones_cumplidas'] == $exp['total_estaciones']) {
                                $btn = 'btn-success';
                                $icon = 'icon-check';
                                $status = 'Finalizado';
                            } else {
                                $btn = 'btn-info';
                                $icon = 'icon-resize-full';
                                $status = 'En curso';
                            }
                            ?>
                            <span class="btn <?php echo $btn ?> btn-mini" id="exp_status" data-placement="bottom" data-toggle="tooltip" data-original-title="Status actual del expediente">
                                <i class="<?php echo $icon ?> icon-white"></i>
                                <strong><?php echo $status ?></strong>

                            </span>
                        </div>
                    </div>
                </div>
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab"><i class="icon-map-marker"></i> Ruta: <?php echo $exp['ruta'] ?></a></li>
                        <li><a href="#tab2" data-toggle="tab"><i class="icon-list-alt"></i> Linea de respuestas</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <ul class="media-list">
                                <?php $fecha_anterior = $exp['fecha_inicio'] ?>
                                <?php for ($i = 0; $i < count($movimientos); $i++) { ?>
                                    <li class="media ">
                                        <div class="orden pull-left"><i></i><?php echo $movimientos[$i]['orden'] ?></div>
                                        <div class="media-body">
                                            <div class="row-fluid">
                                                <div class="span9">
                                                    <div class="media-heading">
                                                        <div><strong><?php echo $movimientos[$i]['unidad'] ?> - <?php echo $movimientos[$i]['cargo'] ?> - <?php echo $movimientos[$i]['responsable'] ?></strong></div>
                                                        <div><i><?php echo $movimientos[$i]['descripcion'] ?></i></div>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <div class="pull-right">
                                                        <span class="btn btn-mini exp_tiempo_estimado" data-placement="bottom" data-toggle="tooltip" data-original-title="Tiempo estimado de respuesta">
                                                            <i class="icon-bullhorn"></i> <?php echo fecha('d M Y - h:i:s a', $movimientos[$i]['timestamp']) ?>
                                                        </span>
                                                        <span class="btn btn-mini exp_horas_estacion" data-placement="bottom" data-toggle="tooltip" data-original-title="Horas requeridas">
                                                            <i class="icon-time"></i> <?php echo $movimientos[$i]['horas'] ?> horas
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row-fluid">

                                                <?php if ($movimientos[$i]['testigo'] == 'si') { ?>
                                                    <?php if ($movimientos[$i]['usuario_fkey'] == sesiones::userdata('id')) { ?>
                                                        <form id="form_respuesta">
                                                            <div class="row-fluid">
                                                                <div class="span12">
                                                                    <input class="span12" type="hidden" id="movimiento_fkey" name="movimiento_fkey" value="<?php echo $movimientos[$i]['id'] ?>" />
                                                                    <input class="span12" type="text" id="respuesta" name="respuesta" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                <div class="span6">
                                                                    <div id="msj_respuesta"></div>
                                                                </div>

                                                                <div class="span6">
                                                                    <div class="pull-right">
                                                                        <input class="btn btn-info btn-small" type="submit" value="Responder" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <?php $resp = expedientes::obtener_respuesta_por_movimiento($movimientos[$i]['id']); ?>
                                                    <?php if (is_array($resp)) { ?>
                                                        <div class = "span9">
                                                            <div style = "font-size:18px;" class = "span12">
                                                                <strong>Respuesta:</strong>
                                                                <?php echo $resp['respuesta'] ?>
                                                            </div>
                                                        </div>
                                                        <div class="span3">
                                                            <div class="pull-right">
                                                                <span class="btn btn-mini exp_fecha_respuesta" data-placement="bottom" data-toggle="tooltip" data-original-title="Tiempo de respuesta">
                                                                    <i class="icon-bullhorn"></i> <?php echo fecha('d M Y - h:i:s a', $resp['timestamp']) ?>
                                                                </span>
                                                                <?php echo btn_diferencia_respuesta(configuraciones::diferencia_en_responder($resp['timestamp'], $movimientos[$i]['timestamp'])) ?>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                    <?php $fecha_anterior = configuraciones::sumar_horas($fecha_anterior, $movimientos[$i]['horas']); ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <p>En construcción</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/expedientes.js"></script>
    </body>
</html>