$(document).ready(function(e) {
    $("#form_add").submit(function() {
        $.ajax({
            type: "POST",
            url: 'ajax.php',
            dataType: 'json',
            data: $("#form_add").serialize() + '&band=add',
            success: function(data) {
                if (data.resp === 1) {
                    flash_type = 'info';
                    $("#unidad").val('');
                    $("#lista").html(data.lista);
                } else if (data.resp === 2) {
                    flash_type = 'block';
                } else {
                    flash_type = 'error';
                }
                flashdata(flash_type, data.msj);
            },
            error: function(xhr, textStatus, errorThrown) {
                flashdata('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            }
        });
        return false;
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
                flashdata('error', textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
                alert(textStatus.toUpperCase() + ' ' + xhr.status + ' - ' + errorThrown);
            }
        });
        $(".cargando").css('display', 'none');
        $("#unidad").removeAttr("readonly");
        $("#btn_volver").removeAttr("disabled");
        $("#btn_editar").removeAttr("disabled"  );
        return false;
    });

    $("#btn_volver").click(function() {
        window.location = '.';
    });


});