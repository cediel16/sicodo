function activar(usuario_id) {
    $.ajax({
        type: "POST",
        url: 'ajax.php',
        dataType: 'json',
        data: 'usuario_id=' + usuario_id + '&status=activo' + '&band=cambiar_status',
        success: function(data) {
            if (data.resp) {
                notificacion('info', data.msj);
                $("#lista").html(data.lista);
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
        }
    });
}

function desactivar(usuario_id) {
    $.ajax({
        type: "POST",
        url: 'ajax.php',
        dataType: 'json',
        data: 'usuario_id=' + usuario_id + '&status=inactivo' + '&band=cambiar_status',
        success: function(data) {
            if (data.resp) {
                notificacion('info', data.msj);
                $("#lista").html(data.lista);
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
        }
    });
}

function bloquear(usuario_id) {
    $.ajax({
        type: "POST",
        url: 'ajax.php',
        dataType: 'json',
        data: 'usuario_id=' + usuario_id + '&status=bloqueado' + '&band=cambiar_status',
        success: function(data) {
            if (data.resp) {
                notificacion('info', data.msj);
                $("#lista").html(data.lista);
            }
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

    $(".filtrar_usuarios").click(function() {
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            dataType: 'json',
            data: 'filtro=' + $(this).attr('rel') + '&band=filtrar',
            success: function(data) {
                $("#lista").html(data.lista);
            },
            error: function(xhr, textStatus, errorThrown) {
                alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                notificacion('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            }
        });

        /*
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
         */
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