var monto;
$(document).ready(function () {

    "use strict";

    /* Scripts para sign-up.html */

    // Seccion de registro

    //Datos de usuario
    //Forma 1
    var nombre = $('#nombre');
    var apellido = $('#apellido');
    var email = $('#email');
    var password = $('#password');
    var confirmPass = $('#confirmPass');
    var profilepic = $('#profilepic');
    var memSelector = $('#memSelector');
    var telefono = $('#telefono');

    //Forma 2
    var especialidad = $('#especialidadSelect');
    var universidad = $('#universidad');
    var certificado = $('#certificadofile');
    var fecha_grad = $('#fecha_graduacion');
    var ocupacion = $('#ocupacion');
    var localizacion = $('#localizacion');

    //Forma 3
    var descripcion = $('#comment_text');

    //Datos de login
    var emailLogin = $('#emailLogin');
    var passwordLogin = $('#passwordLogin');

    //Divs y botones
    var registrarse = $('#registrarse');
    var logearse = $('#logearse');
    var error = $('#error');
    var errorDiv = $('#errorDiv');
    var errorEmail = $('#errorEmail');

    var total = memSelector.on('blur', precioTotal);
    var total = precioTotal();


    //SCRIPTS PARA VALIDAR DATOS DE REGISTRO 

    //scripts para validacion individual de campos
    nombre.on('input', function () {
        validar(nombre);
    });
    apellido.on('input', function () {
        validar(apellido);
    });
    email.on('input', function () {
        validar(email);
        validarEmail(email);
    });
    password.on('input', function () {
        validar(password);
        validar(confirmPass);
        validarPass();
    });
    confirmPass.on('input', function () {
        validar(password);
        validar(confirmPass);
        validarPass();
    });
    telefono.on('input', function () {
        validar(telefono);
        validarTelefono(telefono)
    });
    memSelector.on('blur', function () {
        validarMembresia();
    });
    especialidad.on('blur', function () {
        validarSelect();
    });
    ocupacion.on('blur', function () {
        validarOcupacion();
    });
    universidad.on('input', function () {
        validar(universidad);
    });
    descripcion.on('input', function () {
        validar(descripcion);
    });
    localizacion.on('input', function () {
        validar(localizacion);
    });
    profilepic.on('change', function () {
        if ((((this.files[0].size) / 1024) / 1024) > 20) {
            $('#errorArchivo').show();
            profilepic.css({
                'border': '1px solid red'
            });
            return false;
        } else {
            $('#errorArchivo').hide();
            profilepic.css({
                'border': 'none'
            });
            return true;
        }
    });

    //validar al clickear en el boton de registro
    registrarse.on('click', function () {
        validAll();
    });

    //validar al enviar la forma
    $('.signup-form').on('submit', function () {
        if (validar(nombre) && validar(email) && validar(password) && validar(descripcion) && validar(confirmPass) && validar(universidad) && validar(telefono) && validarSelect() && validarEmail(email) && validarMembresia() && validarTelefono(telefono) && validarPass() && validarOcupacion() && validarPHP()) {
            return true;
        }
        return false;
    });

    //SCRIPTS PARA VALIDAR DATOS DE LOGIN

    //scripts para la validacion individual de campos de login
    emailLogin.on('input', function () {
        validarEmail(emailLogin);
        validarLogin(emailLogin);
    });
    passwordLogin.on('input', function () {
        validarLogin(passwordLogin);
    });

    //validar al clickear en el boton de login
    logearse.on('click', function () {
        validarEmail(emailLogin);
        validarLogin(emailLogin);
        validarLogin(passwordLogin);
    });

    //validar al enviar la forma
    $('.login-form').on('submit', function () {
        if (validarLogin(emailLogin) && validarLogin(passwordLogin) && validarEmail(emailLogin)) {
            return true;
        }
        return false;
    });

    //FUNCIONES DE VALIDACION 
    function validAll() {
        validar(nombre);
        validar(apellido);
        validar(email);
        validarEmail(email);
        validar(password);
        validarPass();
        validar(confirmPass);
        validar(universidad);
        validar(descripcion);
        validar(telefono);
        validarTelefono(telefono);
        validar(localizacion);
        validarSelect();
        validarMembresia();
        validarOcupacion();
        validarPFP();
    }


    function validarPass() {
        if (password.val().length >= 6 || confirmPass.val().length >= 6) {
            $('#shortPass').hide();
            password.css({
                'border': '1px solid #2d2d2d9c'
            });
            confirmPass.css({
                'border': '1px solid #2d2d2d9c'
            });
            if (password.val().length == confirmPass.val().length) {
                if (password.val() === confirmPass.val()) {
                    $('#passValidation').hide();
                    password.css({
                        'border': '1px solid #2d2d2d9c'
                    });
                    confirmPass.css({
                        'border': '1px solid #2d2d2d9c'
                    });
                    return true;
                } else {
                    $('#passValidation').show();
                    password.css({
                        'border': '1px solid red'
                    });
                    confirmPass.css({
                        'border': '1px solid red'
                    });
                    return false;
                }
            }
            $('#passValidation').show();
            password.css({
                'border': '1px solid red'
            });
            confirmPass.css({
                'border': '1px solid red'
            });
            return false;
        }
        $('#shortPass').show();
        password.css({
            'border': '1px solid red'
        });
        confirmPass.css({
            'border': '1px solid red'
        });
        return false;
    }

    function validar(elemento) {
        if (elemento.val() === '') {
            error.show();
            elemento.css({
                'border': '1px solid red'
            });
            console.log(elemento.attr('id') + ' vacio');
            return false;
        } else {
            error.hide();
            elemento.css({
                'border': '1px solid #2d2d2d9c'
            });
            return true;
        }
    }

    function validarTelefono(elemento) {
        if (elemento.val().length < 7 || elemento.val().length > 16) {
            elemento.css({
                'border': '1px solid red'
            });
            $('#phoneValidation').show();
            elemento.focus();
            return false;
        } else {
            $('#phoneValidation').hide();
        }
        return true;
    }

    function validarLogin(elemento) {
        if (elemento.val() === '') {
            errorDiv.show();
            elemento.css({
                'border': '1px solid red'
            });
            console.log(elemento.attr('id') + ' vacio');
            elemento.focus();
            return false;
        } else {
            errorDiv.hide();
            elemento.css({
                'border': '1px solid #2d2d2d9c'
            });
            return true;
        }
    }

    function validarEmail(elemento) {
        if (elemento.val().indexOf("@") > -1) {
            if (elemento.val().length < 4) {
                errorEmail.show();
                elemento.css({
                    'border': '1px solid red'
                });
                elemento.focus();
                return false;
            }else{
                errorEmail.hide();   
                elemento.css({
                    'border': '1px solid #2d2d2d9c'
                });
            }
            errorEmail.hide();
            elemento.css({
                'border': '1px solid #2d2d2d9c'
            });
            return true;
        } else {
            errorEmail.show();
            elemento.css({
                'border': '1px solid red'
            });
            return false;
        }
    }

    function validarSelect() {
        if ($('#especialidadSelect option:selected').val() === '') {
            error.show();
            especialidad.css({
                'border': '1px solid red'
            });
            console.log('especialidad vacio');
            return false;
        } else {
            error.hide();
            especialidad.css({
                'border': '1px solid #2d2d2d9c'
            });
            return true;
        }
    }

    function validarOcupacion() {
        if ($('#ocupacion option:selected').val() === '') {
            error.show();
            ocupacion.css({
                'border': '1px solid red'
            });
            console.log('ocupacion vacio');
            return false;
        } else {
            error.hide();
            ocupacion.css({
                'border': '1px solid #2d2d2d9c'
            });
            return true;
        }
    }

    function validarMembresia() {
        if ($('#memSelector option:selected').val() === '') {
            error.show();
            memSelector.css({
                'border': '1px solid red'
            });
            console.log('membresia vacio');
            memSelector.focus();
            return false;
        } else {
            error.hide();
            memSelector.css({
                'border': 'none'
            });
            return true;
        }
    }

    function validarArchivo() {
        if ($('#certificadofile').val() === '') {
            error.show();
            $('#certificadofile').css({
                'border': '1px solid red'
            });
            console.log('certificado vacio');
        } else {
            $('#certificadofile').css({
                'border': 'none'
            });
        }
    }

    //CALCULAR COSTO SEGUN LA MEMBRESIA
    function precioTotal() {
        var optionSelected = $('#memSelector option:selected').val();
        switch (optionSelected) {
            case 'standard':
                {
                    monto = 20;
                    $('#monto').text(' $' + monto);
                    $('#total').show();
                    break;
                }
            case 'premium':
                {
                    monto = 25;
                    $('#monto').text(' $' + monto);
                    $('#total').show();
                    break;
                }
            case 'free':
                {
                    monto = 0;
                    $('#monto').text(' $' + monto);
                    $('#total').show();
                    break;
                }
            default:
                {
                    break;
                }
        }
        console.log(monto);
        return monto;
    }

    $('.sign-up').addClass('active');

    //Scripts para la navegacion de formas
    $('#continuar').on('click', function () {
        $('.form-1').hide();
        $('.form-2').show();
    });

    $('#continuar1').on('click', function () {
        $('.form-2').hide();
        $('.form-3').show();
    });

    $('#regresar').on('click', function () {
        $('.form-2').hide();
        $('.form-1').show();
    });

    $('#regresar1').on('click', function () {
        $('.form-3').hide();
        $('.form-2').show();
    });

    
    $('#add').on('click', function () {
        if ($('#certificado2_link').css('display') == 'none' && $('#certificado3_link').css('display') == 'none') {
            $('#certificado2_link').show();
        } else if ($('#certificado3_link').css('display') == 'none' && $('#certificado2_link').css('display') != 'none') {
            $('#certificado3_link').show();
            $('#add').hide();
        }
    });

    function validarPFP() {
        profilepic.on('change', function () {
            if ((((this.files[0].size) / 1024) / 1024) > 20) {
                $('#errorArchivo').show();
                profilepic.css({
                    'border': '1px solid red'
                });
                return false;
            } else {
                $('#errorArchivo').hide();
                profilepic.css({
                    'border': 'none'
                });
                return true;
            }
        });
    }



});
