$(document).ready(function () {
    //alert('Si funciona');
    cargarListeners();
    cargarTablaRegisters();
    console.log($('#inName').val());
    console.log($('#inLastName').val());
    funcionModal('modalQr', 'hide');

});

function cargarListeners()
{
    listenerRegisterForm();
    listenerBotonNuevoRegister();
    listenerBotonDelete();
}

function cargarTablaRegisters()
//llena la tabla de carros con los datos de la BD
{
    $.ajax({
        url: "../Server.php",
        type: "POST",
        data: {
            req: "getRegisters"
        },
        success: function (result) {
            var json = JSON.parse(result);
            $("#contenedorTabla").html('<table id="tb_register"></table>');
            console.log(json);
            $('#tb_register').DataTable({
                "data": json.registers,
                "columns": [
                    {"title": "Name"},
                    {"title": "LastName"},
                    {"title": "ID"},
                    {"title": "Email"},
                    {"title": "UniqueCode"}
                ]
                
            });

        }});
}

function OcultarMostrar(id, action)
{
    $('#' + id).action + '()';
}
//inserta un nuevo carro
function listenerRegisterForm()
{
    $('#formRegister').on("submit", function (ev)
    {
        ev.preventDefault();

        $.ajax({
            url: "../Server.php",
            type: "POST",
            data: {
                req: "insertRegister",
                name: $('#inName').val(),
                lastName: $('#inLastName').val(),
                ID: $('#inID').val(),
                email: $('#inEmail').val()
            },
            success: function (result) {
                console.log(result);
                
                var json = JSON.parse(result);
                console.log(json.success);
                if (json.success == false)
                {
                    alert('No se logro insertar el Register');
                }
                
                funcionModal('modalRegister', 'hide');
                $("#div_Qr").html('<img src="'+json.image+'">');
                funcionModal('modalQr','show');
                cargarTablaRegisters();
            }
        });
    }
    );
}
//accion del boton nuevoRegister para que presente el modal
function listenerBotonNuevoRegister()
{
    $('#bt_agregaRegister').on("click", function () {
        $('#bt_delete').attr('type', 'hidden');
        $('#bt_insert').attr('value', 'Insert');
        $('.inputModal').val('');
        funcionModal('modalRegister', 'show');
    });

}

//Agrega Option al select de las marcas
function AgregaOptionSelect(idSelect, val, text)
{
    var select = $("#" + idSelect + "");
    select.append('<option value="' + val + '">' + text + '</option>');
}
function listenerBotonDelete()
{
    $('#bt_delete').on("click", function () {
        EliminarRegister($('#inPlaca').val());
    });
}
//funcion para mostrar o esconder el modal
function funcionModal(id, action)
{
    $('#' + id).modal(action);
}


String.format = function () {
    // The string containing the format items (e.g. "{0}")
    // will and always has to be the first argument.
    var theString = arguments[0];

    // start with the second argument (i = 1)
    for (var i = 1; i < arguments.length; i++) {
        // "gm" = RegEx options for Global search (more than one instance)
        // and for Multiline search
        var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
        theString = theString.replace(regEx, arguments[i]);
    }

    return theString;
}

