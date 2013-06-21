function del(permiso_id) {
    alert(1);
    $.ajax({
        type: "POST",
        url: 'ajax.php',
        dataType: 'json',
        data: 'id=' + permiso_id + '&band=del',
        success: function(data) {
            if (data.resp === 1) {
                not_type = 'info';
                $("#lista").html(data.lista);
            } else if (data.resp === 2) {
                not_type = 'warning';
            } else {
                not_type = 'error';
            }
            notificacion(not_type, data.msj);
        },
        error: function(xhr, textStatus, errorThrown) {
            flashdata('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
        }
    });
}

function act(permiso_id) {
    $.ajax({
        type: "POST",
        url: 'ajax.php',
        dataType: 'json',
        data: 'id=' + permiso_id + '&band=act',
        success: function(data) {
            if (data.resp === 1) {
                not_type = 'info';
                $("#lista").html(data.lista);
            } else if (data.resp === 2) {
                not_type = 'warning';
            } else {
                not_type = 'error';
            }
            notificacion(not_type, data.msj);
        },
        error: function(xhr, textStatus, errorThrown) {
            flashdata('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
        }
    });
}

$(document).ready(function(e) {

    $("#form_edit").submit(function() {
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            dataType: 'json',
            data: $("#form_edit").serialize() + '&band=edit',
            success: function(data) {
                if (data.resp === 1) {
                    not_type = 'info';
                } else if (data.resp === 2) {
                    not_type = 'warning';
                } else {
                    not_type = 'error';
                }
                notificacion(not_type, data.msj);
            },
            error: function(xhr, textStatus, errorThrown) {
                flashdata('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            }
        });
        $(".cargando").css('display', 'none');
        $("#rol").removeAttr("readonly");
        $("#btn_volver").removeAttr("disabled");
        $("#btn_editar").removeAttr("disabled");
        return false;
    });

    $("#btn_volver").click(function() {
        window.location = '.';
    });
});

$("input:checkbox").click(function() {
    var chkd = $(this).is(':checked');
    if (chkd === true) {
        band = 'asignar_permiso';
    } else {
        band = 'quitar_permiso';
    }
    $.ajax({
        type: "POST",
        url: 'ajax.php',
        dataType: 'html',
        data: 'rol=' + $(this).attr("rel") + '&permiso=' + $(this).val() + '&band=' + band,
        success: function(data) {

        },
        error: function(xhr, textStatus, errorThrown) {
            alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
        }
    });
});