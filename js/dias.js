$(document).on("ready", inicio);
function evento(e) {
    e.preventDefault();
}

function scrollToBottom() {
    $('html, body').animate({
        scrollTop: $(document).height()
    }, 'slow');
}
function scrollToTop() {
    $('html, body').animate({
        scrollTop: 0
    }, 'slow');
}
$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});
function nuevo() {
    location.reload();
}
function inicio() {  


    ///////////////////        
    $("#btnGuardar").on("click", modificar_dias);
    $("#btnNuevo").on("click", nuevo);
    ////////
    cargar_dias();     
}
function cargar_dias(){
    $.ajax({
        type: "POST",
        dataType:'json',
        url: "../procesos/carga_dias.php",        
        success: function(data) {            
            if(data[1] == 0){
                $("#lunes").prop('checked',false);
            }else{
                $("#lunes").prop("checked",true);
            }
            if(data[2] == 0){
                $("#martes").prop('checked',false);
            }else{
                $("#martes").prop("checked",true);
            }
            if(data[3] == 0){
                $("#miercoles").prop('checked',false);
            }else{
                $("#miercoles").prop("checked",true);
            }
            if(data[4] == 0){
                $("#jueves").prop('checked',false);
            }else{
                $("#jueves").prop("checked",true);
            }
            if(data[5] == 0){
                $("#viernes").prop('checked',false);
            }else{
                $("#viernes").prop("checked",true);
            }
            if(data[6] == 0){
                $("#sabado").prop('checked',false);
            }else{
                $("#sabado").prop("checked",true);
            }
            if(data[7] == 0){
                $("#domingo").prop('checked',false);
            }else{
                $("#domingo").prop("checked",true);
            }

            alertify.success('Datos Cargados Correctamente');                                                  
            
        }
    });
}
function modificar_dias(){    
    if($("#lunes").is(":checked")){
        lunes = 1;
    }else{
        lunes = 0;
    }
    if($("#martes").is(":checked")){
        martes = 1;
    }else{
        martes = 0;
    }
    if($("#miercoles").is(":checked")){
        miercoles = 1;
    }else{
        miercoles = 0;
    }
    if($("#jueves").is(":checked")){
        jueves = 1;
    }else{
        jueves = 0;
    }
    if($("#viernes").is(":checked")){
        viernes = 1;
    }else{
        viernes = 0;
    }
    if($("#sabado").is(":checked")){
        sabado = 1;
    }else{
        sabado = 0;
    }
    if($("#domingo").is(":checked")){
        domingo = 1;
    }else{
        domingo = 0;
    }
     $.ajax({
        type: "POST",
        url: "../procesos/modificar_dias.php",
        data: "lunes=" + lunes + "&martes=" + martes + "&miercoles=" + miercoles + "&jueves=" + jueves + "&viernes=" + viernes + "&sabado=" + sabado + "&domingo=" + domingo,
        success: function(data) {
            var val = data;
            if (val == 1) {
                alertify.success('Datos Agregados Correctamente');                                  
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        }
    });
}
