<!-- CUERPO PHP -->
<?php include_once 'includes/templates/header.php'; ?>
<?php 
    
    session_start();
    if(!$_SESSION['loggedin']){
        $membership = -1;
        //Enviado desde login.php en caso de entrada de dato invalido
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $error = $_GET['error'];
            $login = $_GET['login'];
            $membership = $_GET['membership'];
        }
    }else{
        header('Location: index.php');
    }
?>

<!-- SRCS  -->
<link href="css/sign-up.css" rel="stylesheet" type="text/css" />

<!-- CUERPO HTML -->
<head>
    <title>
        Registro
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
</head>

<body>
    <main>
        <!-- FORMAS PARA EL MANEJO DE CUENTAS -->
        <h1>EMPIEZA YA!</h1>
        <h3>Aplica para obtener tu perfil de especialista</h3>
        <div class="login">
            <!-- forma de registro -->
            <form class="signup-form" action="registrar.php" method="post" enctype="multipart/form-data">
                <fieldset class="user-fieldset">
                    <h2>Registrarse</h2>
                    <!--DATOS BASICOS-->
                    <section class="form-1">
                        <h4>Datos Basicos</h4>
                        <br>
                        <input name="nombre" type="text" class="input-text" id="nombre" value="" maxlength="50" size="50" placeholder="Nombre Completo" autocomplete="off" spellcheck="false" onClick="$('#apellido').show();$('#telefono').show();">
                        <input name="apellido" type="text" class="input-text" id="apellido" value="" maxlength="50" size="50" placeholder="Apellido Completo" autocomplete="off" spellcheck="false">
                        <input name="telefono" type="text" class="input-text" id="telefono" maxlength="16" value="" autocomplete="off" placeholder="Numero Telefonico">
                        <input name="email" type="email" class="input-text" id="email" maxlength="50" size="50" value="" placeholder="Correo Electronico" spellcheck="false">
                        <input name="password" type="password" class="input-text" id="password" maxlength="16" size="16" value="" placeholder="Tu Password" autocomplete="off" onClick="$('#confirmPass').show();">
                        <input name="password2" type="password" class="input-text" maxlength="16" size="16" id="confirmPass" name="registro" value="" placeholder="Confirmar Password" onClick="$('#profilepic').show();$('#especialidad').show();$('#universidad').show();$('#certificado').show();$('#membresia').show();">
                        <div id="membresia">
                            Suscripcion<br>
                            <select name="membresia" id="memSelector">
                                <?php if($membership == -1) { ?>
                                    <option value=''>Selecciona tu Suscripcion</option>
                                    <option value='standard'>Standard</option>
                                    <option value='premium'>Premium</option>
                                    <option value='free'>Free</option>
                                <?php }else if($membership == 0){ ?>
                                    <option value=''>Selecciona tu Suscripcion</option>
                                    <option value='standard'>Standard</option>
                                    <option value='premium'>Premium</option>
                                    <option value='free' selected>Free</option>
                                <?php }else if($membership == 1){ ?>
                                    <option value=''>Selecciona tu Suscripcion</option>
                                    <option value='standard' selected>Standard</option>
                                    <option value='premium'>Premium</option>
                                    <option value='free'>Free</option>
                                <?php }else if($membership == 2){ ?>
                                    <option value=''>Selecciona tu Suscripcion</option>
                                    <option value='standard'>Standard</option>
                                    <option value='premium' selected>Premium</option>
                                    <option value='free'>Free</option>
                                <?php } ?>
                            </select>
                        </div>
                        <h2 id="total">COSTO SUSCRIPCION: <span id="monto"></span></h2>
                        <input id="continuar" class="boton-submit" type="button" value="Continuar">
                    </section>

                    <!--DATOS PROFESIONALES-->
                    <section class="form-2">
                        <h4>Datos Profesionales</h4><br>
                        <div id="especialidad">
                            Epecialidad<br>
                            <select id="especialidadSelect" name="especialidad" selected="">
                                <option value="">Selecciona tu especialidad</option>
                                <option value="Reumatologia">Reumatologia</option>
                                <option value="Cardiologia">Cardiologia</option>
                                <option value="Oftalmologia">Oftalmologia</option>
                                <option value="Neurologia">Neurologia</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>
                        <div id="wrapper">
                            Ocupacion Actual<br>
                            <select id="ocupacion" name="ocupacion" selected="">
                                <option value="">Selecciona tu ocupacion</option>
                                <option value="Consultor en Clinica">Consultor en Clinica</option>
                                <option value="Consultor en Hospital">Consultor en Hospital</option>
                                <option value="Consultor en Clinica y Hospital">Consultor en Clinica y Hospital</option>
                                <option value="Propietario de Consultorio">Propietario de Consultorio</option>
                                <option value="Propietario de Clinica">Propietario de Clinica</option>
                                <option value="N/A">Otra</option>
                            </select>
                        </div>
                        <input name="localizacion" type="text" id="localizacion" value="" maxlength="50" size="50" class="input-text" placeholder="Ubicacion de Consultorio" spellcheck="false"> 
                        Graduacion
                        <div class="graduacion">
                            <select name="fecha_graduacion" type="number" selected="" class="fecha-graduacion input-text yearselect"></select>
                            <input name="universidad" type="text" id="universidad" value="" maxlength="50" size="50" class="input-text" placeholder="Universidad de Egreso" spellcheck="false"> 
                        </div><br>
                        Residencia/Post-Grado
                        <div class="post-grado">
                            <select name="fecha_postgrado" type="number" selected="" class="fecha-graduacion input-text yearselect"></select>
                            <input name="local_postgrado" type="text" id="local_postgrado" value="" maxlength="50" size="50" class="input-text" placeholder="Localizacion" spellcheck="false"> 
                        </div>
                        <div class="wrapper">
                            Certificacion
                            <h6>El tamaño maximo por archivo debe ser de 10mb</h6>
                            <input type="file" id="certificado1_link" name="certificado[]" multiple>
                            <input type="file" id="certificado2_link" name="certificado[]" multiple>
                            <input type="file" id="certificado3_link" name="certificado[]" multiple>
                            <i id="add" class="fas fa-plus-circle"><span> adjuntar mas</span></i>
                        </div>
                        <input id="continuar1" class="boton-submit" type="button" value="Continuar">
                        <input id="regresar" class="boton-submit" type="button" value="Regresar">
                    </section>

                    <!--DATOS PERSONALES-->
                    <section class="form-3">
                        <h4>Datos Personales</h4><br>
                        <div class="wrapper">
                            Foto de Perfil
                            <h6>El tamaño maximo por imagen debe ser de 10mb</h6>
                            <input type="file" id="profilepic" name="profilepic" value="">
                        </div>
                        <textarea rows="20" maxlength="250" size="250" type="text" name="descripcion" id="comment_text" cols="40" autocomplete="off" placeholder="Introduzca una pequeña introduccion a su perfil" aria-autocomplete="list" aria-haspopup="true"></textarea>
                        <input type="text" maxlength="18" placeholder="Instagram" name="instagram" class="input-text" id="instagram">
                        <input type="text" maxlength="18" placeholder="Twitter" name="twitter" class="input-text" id="twitter">
                        <input id="regresar1" class="boton-submit" type="button" value="Regresar">
                        <input name="submit-signup" type="submit" class="solicitar boton-submit" value="Registrarse" id="registrarse">
                    </section>

                        <div id="errorEmail">Introduzca un correo valido</div>
                        <div id="error">Falta un elemento obligatorio</div>
                        <div id="passValidation">Las contraseñas no coinciden</div>
                        <div id="phoneValidation">Numero de telefono invalido</div>
                        <div id="shortPass">Las contraseña debe tener 6 caracteres o mas</div>
                        <div id="errorArchivo">El archivo subido no puede exceder el tamaño de 10MB</div>
                        <?php if($error == 2) { ?>
                            <div id="signupresponse">Ha ocurrido un error con el servidor</div>
                        <? } ?>
                        <?php if($error == 3) { ?>
                            <div id="signupresponse">Ha ingresado un correo existente</div>
                        <? } ?>
                        <?php if($error == 4) { ?>
                            <div id="signupresponse">Ha ingresado un numero de telefono existente</div>
                        <? } ?>                        
                        <?php if($error == 5) { ?>
                            <div id="signupresponse">Ha ingresado un tipo de archivo no valido para la foto de perfil, solo .jpg y .png son aceptados</div>
                        <? } ?>                        
                        <?php if($error == 6) { ?>
                            <div id="signupresponse">Ha ingresado un tipo de archivo no valido para los certificados, solo .jpg, .jpeg y .png son aceptados</div>
                        <? } ?>                        
                        <?php if($error == 7) { ?>
                            <div id="signupresponse">El tamaño maximo de archivo de certificado aceptado es de 10mb</div>
                        <? } ?>
                </fieldset>
            </form>

            <!-- forma de inicio de sesion -->
            <form class="login-form" action="login.php" method="post">
                <fieldset class="user-fieldset">
                    <h2>Ya estas registrado?</h2>
                    <h4>Inicia Sesion</h4>
                    <section>
                        <br>
                        <input name="email" id="emailLogin" type="email" value="" maxlength="50" size="50" class="input-text" placeholder="Correo Electronico" spellcheck="false" id="correo">
                        <input name="password" id="passwordLogin" type="password" value="" maxlength="16" size="16" class="input-text" placeholder="Password"><br>

                        <div id="errorDiv">Falta un campo obligatorio</div>
                        <!-- validacion de entrada de dato invalido previo -->
                        <?php if($error == 1) { ?>
                        <div id="signupresponse">Ha ingresado un dato invalido</div>
                        <? } ?>
                        <input name="submit-login" type="submit" value="Iniciar Sesion" class="boton-submit" id="logearse">
                    </section>
                </fieldset>
            </form>

        </div>
    </main>
    
    <!--SCRIPTS-->
    <script src="js/scripts-signup.js"></script>
    <script src="yearselect-master/lib/year-select.js"></script>
    <script src="maskPhone-master/dist/jquery-input-mask-phone-number.js"></script>
    <script>
        $(function(){
            $('#telefono').usPhoneFormat({
                format: '(xxx) xxx-xxxx'    
            }); 
        });
        var login = <?php echo json_encode($login); ?>;
        if(login){
            $('#emailLogin').focus();
        }
        $('.yearselect').yearselect();
        $('.yearselect').yearselect({
            start: 2018,
            end: 1960
        });          
        $('.yearselect').yearselect({
            step:1
        });            
        $('.yearselect').yearselect({
            order:'asc'
        });         
        $('.yearselect').yearselect({
            formatDisplay: function(yr) { return yr }
        });        
        $('.yearselect').yearselect({
            displayAsValue:true
        });    
    </script>
</body>

</html>
