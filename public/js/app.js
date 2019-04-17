var show_msg=function(str){
    $('#msg').show();
    $('#msg').html('<p>'+str+'</p>');
    setTimeout(function(){$('#msg').hide();}, 4000);
};

//var urlPropia = 'http://localhost:8030/';
var urlPropia = 'http://sguidobono.cesnuria.com/A4/';

$(document).ready(function(){
    // initialize elements
    $('#msg').hide();
    // validación del nombre
    $('#nombre-reg').on('change',function(){
        var nombre=$('#nombre-reg').val();
        if(nombre.length==0){
            show_msg("Debe ingresar el nombre");
            $('#nombre-reg').focus();
        }else{
            if(nombre.length<3){
                show_msg("La longitud del nombre debe ser mayor a 3");
                $('#nombre-reg').focus();
            }    
        }
    });
    // validación de apellidos
    $('#apellidos-reg').on('change',function(){
        var apellidos=$('#apellidos-reg').val();
        if(apellidos.length==0){
            show_msg("Debe ingresar los apellidos");
            $('#apellidos-reg').focus();
        }else{
            if(apellidos.length<3){
                show_msg("La longitud de los apellidos debe ser mayor a 3");
                $('#apellidos-reg').focus();
            }    
        }
    });
    // validación del correo electrónico
    $('#email-reg').on('change',function(){
        var form=$('#form-reg');
        var url=form.attr('action');
        var email=$('#email-reg').val();
        if(email.length==0){
            show_msg("Debe ingresar un correo electrónico");
            $('#email-reg').focus();
        }else{
            // valido el email no exista
            $.ajax({
                url:urlPropia+'reg/valemail',
                type:'post',
                data: {email: email},
                dataType:'json',
                error:function(out){
                    console.log(out);
                },
                success:function(out){
                    console.log(out);
                    show_msg(out.msg);
                    if(out.msg=="Email en uso"){
                        $('#email-reg').focus();
                    }
                    /*if (out.redir == 'home') {
                        window.location.href = '/home';
                    }*/
                }
            });
            //return false;
        }
    });
    // validación de la contraseña
    $('#clave-reg').on('change',function(){
        var clave=$('#clave-reg').val();
        if(clave.length==0){
            show_msg("Debe ingresar la contraseña");
            $('#clave-reg').focus();
        }else{
            if(clave.length<3){
                show_msg("La longitud de la contraseña debe ser mayor a 3");
                $('#clave-reg').focus();
            }    
        }
    });
    
});