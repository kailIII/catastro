/**
 * Script de manejo de intentos de trámite e inicios de trámite en la ventanilla de primera atención.
 */

var ventanillaApp = (function () {
    var predio = null;
    var requisitos = {};
    return {
        setPredio: function (oPredio) {
            this.predio = oPredio;
        },
        getPredio: function() {
            return this.predio;
        },
        getRequisitos: function() {
            return requisitos;
        },
        setRequisitos: function(tipotramite_id) {
            $('#requisitos-lista-'+tipotramite_id+' .botones-requisitos').each(function(){
                var rid = $(this).data('requisito');
                requisitos[rid] = null;
            });
        },
        setRequisito: function (id, val) {
            requisitos[id] = val;
        },
        reset: function() {
            requisitos = {};
            predio = null;
        },
        requisitosChecados: function () {
            var completos = false;
            var c = 0;
            var numReq = 0;
            for(var presentado in requisitos ){
                numReq++;
                if(requisitos[presentado] == 0 || requisitos[presentado] == 1){
                    c++;
                }
            }
            if(c == numReq){
                completos = true;
            }
            return completos;
        },
        requisitosCompletos: function(){
            var completos = false;
            var c = 0;
            var numReq = 0;
            for(var presentado in requisitos ){
                numReq++;
                if(requisitos[presentado] == 1){
                    c++;
                }
            }
            if(c == numReq){
                completos = true;
            }
            return completos;
        }
    }
})();

$(function () {
    //Inicializamos el campo con una máscara por clave catastral
    $('.clave-catastral').mask("00-000-000-0000-000000", {placeholder: "__-___-___-____-______"});

    //Cuando hay algún cambio en el campo entonces buscamos el valor en el servidor
    $('.clave-catastral').change(function (ev) {
        var clave = $(this).val().trim();
        var tipotramite_id = $(this).data('tipotramite');
        if (clave == '') {
            return false;
        }
        $.get(laroute.route('ventanilla.consulta-padron'), {'clave': clave.toUpperCase(), 'tipotramite_id': tipotramite_id}, function (data) {
            if (data == '') {
                //console.log('No existe el registro buscado');
                $('.alert').show();
                $('#requisitos-lista-'+tipotramite_id+' .botones-requisitos').hide();
                $('#requisitos-lista-'+tipotramite_id+' ul').removeClass('list-unstyled');
                return false;
            }

            //Asignamos el valor del predio con el registro encontrado
            ventanillaApp.setPredio(data);
            ventanillaApp.setRequisitos(tipotramite_id);
            $('#requisitos-lista-'+tipotramite_id+' .botones-requisitos').show();
            $('#requisitos-lista-'+tipotramite_id+' ul').addClass('list-unstyled');
            $('#requisitos-lista-'+tipotramite_id+' .cancelar-tramite').show();
        });
    });

    //Cuando se selecciona un valor del dropdown del buscador entonces:
    $('.dropdown-menu li a').click(function () {
        var tipo = $(this).data('tipo');
        $('.clave-catastral').val('');
        if (tipo == 'cuenta') {
            $('.clave-catastral').mask("00-S-000000", {
                placeholder: "__-_-______",
                translation: {S: {pattern: /[RUru]/}}
            });
            $('.select-busqueda .dropdown-label').text('Cuenta');
        }
        else {
            $('.clave-catastral').mask("00-000-000-0000-000000", {placeholder: "__-___-___-____-______"});
            $('.select-busqueda .dropdown-label').text('Clave');
        }
    });

    //Cuando hay cambios en los radio buttons de los requisitos
    $('.radio-requisito').change(function (ev) {
        var requisito_id = $(this).data('requisito');
        var tipotramite_id = $(this).data('tipotramite');
        var presentado = $(this).val();
        ventanillaApp.setRequisito(requisito_id, presentado);
        var completos = ventanillaApp.requisitosCompletos();

        if(completos) {
            $('#requisitos-lista-'+tipotramite_id+' .iniciar-tramite').show();
            $('#requisitos-lista-'+tipotramite_id+' .cancelar-tramite').hide();
        }
        else {
            $('#requisitos-lista-'+tipotramite_id+' .iniciar-tramite').hide();
            $('#requisitos-lista-'+tipotramite_id+' .cancelar-tramite').show();
        }
    });

    //Botón cancelar guarda los valores del intento y recarga la pág.
    $('.cancelar-tramite').click(function(ev){
        $(this).hide();
        var tipotramite_id = $(this).data('tipotramite');
        var predio = ventanillaApp.getPredio();
        var requisitos = ventanillaApp.getRequisitos();

        $('.btn').removeClass('active');
        $('#requisitos-lista-'+tipotramite_id+' .botones-requisitos').hide();
        $('#requisitos-lista-'+tipotramite_id+' ul').removeClass('list-unstyled');

        $.post(laroute.route('ventanilla.intento-tramite'), {'clave': predio.clave, 'tipotramite_id': tipotramite_id, 'cuenta': predio.cuenta, 'requisitos': requisitos}, function (data) {
            return false;
        });
    });

    //Cuando los requisitos estan completos podemos iniciar el trámite
    $('.iniciar-tramite').click(function(ev){
        $(this).hide();
        console.log(ventanillaApp.getPredio());
        var tipotramite_id = $(this).data('tipotramite');
        console.log(tipotramite_id);
        var predio = ventanillaApp.getPredio();
        $('#iniciar .clave').val(predio.clave);
        $('#iniciar .cuenta').val(predio.cuenta);
        $('#iniciar .tipotramite_id').val(tipotramite_id);
        $('#iniciar').submit();
    });

    $(document).on("submit", "#lista-tipotramites", function(e){
        e.preventDefault();
    });

});

//Spinners de cargando.
$(document).bind("ajaxSend", function(){
    $('.alert').hide();
    $('.botones-requisitos').hide();
    $('.cancelar-tramite').hide();
    $('ul').removeClass('list-unstyled');

    $(".boton-buscador").removeClass('glyphicon-search');
    $(".boton-buscador").addClass('glyphicon-refresh spin');
}).bind("ajaxComplete", function(){
    $(".boton-buscador").removeClass('glyphicon-refresh spin');
    $(".boton-buscador").addClass('glyphicon-search');
});