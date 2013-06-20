function flashdata(op, msj) {
    $("#flashdata #alert").remove();
    $('<div><strong>' + msj + '</strong></div>').addClass("span12 alert alert-" + op).attr("id", "alert").appendTo("#flashdata");
    $("#flashdata").delay(5000).slideUp(1000);
}

function notificacion(tipo, mensaje) {
    $(".top-center").notify({
        message: {html: '<strong>' + mensaje + '</strong>'},
        type: tipo
    }).show();

}

function cargando_lista(id) {
    $(id).html('<div class="cargando_lista"><img src="../img/cargando_lista.gif" /></div>');
}

function is_numeric(input) {
    var number = /^[0-9]$/i;
    var regex = RegExp(number);
    return regex.test(input) && input.length > 0;
}