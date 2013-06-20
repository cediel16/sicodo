function form_estaciones(value) {
    switch (value) {
        case true:
            {
                $("#orden").removeAttr("readonly");
                $("#horas").removeAttr("readonly");
                $("#unidad").removeAttr("disabled");
                $("#cargo").removeAttr("disabled");
                $("#usuario").removeAttr("disabled");
                $("#descripcion").removeAttr("readonly");
                $("#btn_add").removeAttr("disabled");
                break;
            }
        default:
            {
                $("#estacion_id").val("");
                $("#orden").attr("readonly", "true").val("");
                $("#horas").attr("readonly", "true").val("");
                $("#unidad").attr("disabled", "true").val("");
                $("#cargo").attr("disabled", "true").val("");
                $("#usuario").attr("disabled", "true").val("");
                $("#descripcion").attr("readonly", "true").val("");
                $("#btn_add").attr("disabled", "true");
                break;
            }
    }
}

function edit(estacion_id) {
    $.ajax({
        type: "POST",
        url: 'ajax.php',
        dataType: 'json',
        data: 'estacion_id=' + estacion_id + '&band=obtener_fila',
        success: function(data) {
            $("#estacion_id").val(data.fila.id);
            $("#orden").val(data.fila.orden);
            $("#horas").val(data.fila.horas);
            $("#unidad").val(data.fila.unidad_fkey);
            $("#cargo").val(data.fila.cargo_fkey);
            $("#usuario").val(data.fila.usuario_fkey);
            $("#descripcion").val(data.fila.descripcion);
            $("#ctrl_add").hide();
            $("#ctrl_edit").show();
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
        }
    });
}
function del(estacion_id) {
    $("#dialog-confirm").data({"id": estacion_id, "ruta": $("#ruta").val()}).dialog("open");
}

$(document).ready(function(e) {

    form_estaciones(false);
    $("#btn_add").click(function() {
        var msj = '';
        var band = true;
        var ruta = $("#ruta").val();
        var orden = $("#orden").val();
        var horas = $("#horas").val();
        var unidad = $("#unidad").val();
        var cargo = $("#cargo").val();
        var usuario = $("#usuario").val();
        var descripcion = $("#descripcion").val();
        if (!$.isNumeric(orden)) {
            band = false;
            msj += 'El orden de la estación es inválido.';
        } else if (!$.isNumeric(horas)) {
            band = false;
            msj += 'Las horas para la estación son inválidas.';
        } else if (!$.isNumeric(unidad)) {
            band = false;
            msj += 'Seleccione una unidad para la estación.';
        } else if (!$.isNumeric(cargo)) {
            band = false;
            msj += 'Seleccione el cargo para la estación.';
        } else if (!$.isNumeric(usuario)) {
            band = false;
            msj += 'Seleccione el usuario responsable para la estación.';
        } else if (descripcion === '') {
            band = false;
            msj += 'Escriba la descripción del paso a realizar en esta estación.';
        }

        if (band === false) {
            notificacion('error', '<i class="icon-warning-sign"></i> ' + msj);
        } else {
            form_estaciones(false);
            var alldata = 'ruta=' + ruta;
            alldata += '&orden=' + orden;
            alldata += '&horas=' + horas;
            alldata += '&unidad=' + unidad;
            alldata += '&cargo=' + cargo;
            alldata += '&usuario=' + usuario;
            alldata += '&descripcion=' + descripcion;
            $.ajax({
                type: "POST",
                url: 'ajax.php',
                dataType: 'json',
                data: alldata + '&band=add',
                success: function(data) {
                    if (data.resp === 1) {
                        notificacion('info', data.msj);
                        $("#lista").html(data.lista);
                    } else {
                        notificacion('error', data.msj);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                    notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                }
            });
            form_estaciones(true);
        }
    });

    $("#anch_save").click(function() {
        var msj = '';
        var band = true;
        var estacion_id = $("#estacion_id").val();
        var ruta = $("#ruta").val();
        var orden = $("#orden").val();
        var horas = $("#horas").val();
        var unidad = $("#unidad").val();
        var cargo = $("#cargo").val();
        var usuario = $("#usuario").val();
        var descripcion = $("#descripcion").val();
        if (!$.isNumeric(orden)) {
            band = false;
            msj += 'El orden de la estación es inválido.';
        } else if (!$.isNumeric(horas)) {
            band = false;
            msj += 'Las horas para la estación son inválidas.';
        } else if (!$.isNumeric(unidad)) {
            band = false;
            msj += 'Seleccione una unidad para la estación.';
        } else if (!$.isNumeric(cargo)) {
            band = false;
            msj += 'Seleccione el cargo para la estación.';
        } else if (!$.isNumeric(usuario)) {
            band = false;
            msj += 'Seleccione el usuario responsable para la estación.';
        } else if (descripcion === '') {
            band = false;
            msj += 'Escriba la descripción del paso a realizar en esta estación.';
        } else if (!$.isNumeric(estacion_id)) {
            band = false;
            msj += 'Error en la referencia única de la estacion a editar, intentelo de nuevo o consulte al administrador del Sistema.';
        }

        if (band === false) {
            notificacion('error', '<i class="icon-warning-sign"></i> ' + msj);
        } else {
            form_estaciones(false);
            var alldata = 'estacion_id=' + estacion_id;
            alldata += '&ruta=' + ruta;
            alldata += '&orden=' + orden;
            alldata += '&horas=' + horas;
            alldata += '&unidad=' + unidad;
            alldata += '&cargo=' + cargo;
            alldata += '&usuario=' + usuario;
            alldata += '&descripcion=' + descripcion;
            $.ajax({
                type: "POST",
                url: 'ajax.php',
                dataType: 'json',
                data: alldata + '&band=edit',
                success: function(data) {
                    if (data.resp === 1) {
                        notificacion('info', data.msj);
                        $("#lista").html(data.lista);
                    } else {
                        notificacion('error', data.msj);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                    notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                }
            });
            form_estaciones(true);
        }
    });

    $("#anch_cancel").click(function() {
        form_estaciones(false);
        $("#ctrl_add").show();
        $("#ctrl_edit").hide();
    });
    $("#form_edit").submit(function() {
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            dataType: 'json',
            data: $("#form_edit").serialize() + '&band=edit',
            success: function(data) {
                if (data.resp === 1) {
                    flash_type = 'info';
                } else if (data.resp === 2) {
                    flash_type = 'block';
                } else {
                    flash_type = 'error';
                }
                flashdata(flash_type, data.msj);
            },
            error: function(xhr, textStatus, errorThrown) {
                alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            }
        });
        $(".cargando").css('display', 'none');
        $("#ruta").removeAttr("readonly");
        $("#btn_volver").removeAttr("disabled");
        $("#btn_editar").removeAttr("disabled");
        return false;
    });
    $("#btn_volver").click(function() {
        window.location = '.';
    });
    $("#ruta").change(function() {
        if ($(this).val() === '') {
            form_estaciones(false);
            $("#ctrl_add").show();
            $("#ctrl_edit").hide();
        } else {
            $("#ctrl_add").show();
            $("#ctrl_edit").hide();
            form_estaciones(false);
            form_estaciones(true);
        }
        cargando_lista("#lista");
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            dataType: 'json',
            data: 'ruta=' + $(this).val() + '&band=lista',
            success: function(data) {
                $("#lista").html(data.lista);
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#lista").html('');
                alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            }
        });
    });

    $("#dialog-confirm").dialog({
        autoOpen: false,
        modal: true,
        width: 450,
        buttons: {
            "No": function() {
                $(this).dialog("close");
            },
            "Sí": function() {
                $.ajax({
                    type: "POST",
                    url: 'ajax.php',
                    dataType: 'json',
                    data: 'estacion_id=' + $(this).data().id + '&ruta=' + $(this).data().ruta + '&band=del',
                    success: function(data) {
                        if (data.resp === 1) {
                            notificacion('info', data.msj);
                            $("#lista").html(data.lista);
                        } else {
                            notificacion('error', data.msj);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                        notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                    }
                });
                $(this).dialog("close");
            }
        }
    });
});