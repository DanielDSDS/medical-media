<!DOCTYPE html>
<?php 
    session_start();
    $logged = $_SESSION['loggedin'];
?>

<!-- SRCS -->
<link href="https://fonts.googleapis.com/css?family=Aleo|Raleway:900|Raleway:600|Montserrat" type="text/css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link href="css/header.css" rel="stylesheet" type="text/css" />

<!-- CUERPO HTML -->
<html>
<!-- navegador superior -->
<header>
    <div class="contenedor">
        <nav class="topnav" id="top-navigator" role="navigator">
            <a class="logo" href="index.php"><!--<img src="#" height="10px">--></a>
            <? if(!$logged) { ?>
                <a class="busqueda" href="sign-up.php?login=1">Iniciar Sesion</a>
                <a class="sign-up" href="sign-up.php">Registrate</a>
            <? }else{ ?>
                <a class="perfil" href="perfil.php">Perfil</a>
                <a class="logoff" href="index.php?logoff=1">Cerrar Sesion</a>
            <? } ?>
            <a class="faqs" href="#faqs">FAQs</a>
        </nav>
        <a id="dropdown" onclick="dropDown()" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
    </div>
</header>

<!-- SCRIPTS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
    //Revisar si el usuario inicio sesion
    var logged = <? echo json_encode($_SESSION['loggedin']); ?> ;

    var logo = $('.logo');
    var signup = $('.sign-up');
    var perfil = $('.perfil');
    var logoff = $('.logoff');
    var busqueda = $('.busqueda');
    
    var containerHeight = $('.contenedor').height();
    $(window).scroll(function() {
        if (window.matchMedia("(min-width: 900px)").matches){
            var scroll = $(window).scrollTop(); 
            if(scroll > containerHeight) {
                $('header').addClass('fadein');
                $('header').css({
                    'background' : '#333'
                });
                $('.topnav a').css({
                    'color' : '#ffffff'    
                });     
            } else {
                $('header').removeClass('fadein');
                $('header').css({
                    'background' : 'none'
                });
                $('.topnav a').css({
                    'color' : 'black'    
                });
            }
        }
    });
    
    window.onresize = function() {
        if (window.matchMedia("(min-width: 900px)").matches) {
            if (logged) {
                busqueda.hide();
                signup.hide();
                perfil.show();
                logoff.show();
            } else {
                busqueda.show();
                signup.show();
                perfil.hide();             
                logoff.hide();
            }
            $('.faqs').show();
        }else{
            signup.hide();
            perfil.hide();
            logoff.hide();       
            busqueda.hide();       
            $('.faqs').hide();
            $('header').css({
                'background' : '#333'
            });
            $('.topnav a').css({
                'color' : '#ffffff'    
            });
        }
    };

    function dropDown() {
        if (logged) {
            perfil.toggle();
            logoff.toggle();
        } else {
            signup.toggle();
            busqueda.toggle();
        }
        $('.faqs').toggle();
    }

</script>
</html>
