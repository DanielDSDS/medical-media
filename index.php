<!-- CUERPO PHP -->
<?php include_once 'includes/templates/header.php'; ?>
<?php 
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        $loggedOff = $_GET['logoff'];
        if($loggedOff) {
            $_SESSION['loggedin'] = false;
            session_destroy();
        }
    }   

    $to_email = 'ddimelan9no@gmail.com';
    $subject = 'Testing PHP Mail';
    $message = 'This mail is sent using the PHP mail function';
    $headers = 'From: noreply@gmail.com';
    mail($to_email,$subject,$message,$headers);
?>

<!-- SRCS -->
<link href="css/busqueda.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />

<!-- CUERPO HTML -->
<head>
    <title>
        Inicio
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
</head>

<body>
    <main>

        <!-- Barra de busqueda principal -->
        <div class="main-search">
            <section>
                <h2 class="section-title busca" >Encuentra especialistas</h2>
                <h4 class="titulo2"> los mejores especialistas de la zona estan con nosotros </h4>
            </section>

            <!-- barra de busqueda -->
            <section>
                <div class="search-bar">
                    <input type="text" id="search" placeholder="Busca un doctor" >
                    <button type="button">
                        <i class="fa fa-search">
                        </i>
                    </button>
                    <button type="button" class="boton-filtro">
                        <span> filtrar</span>
                    </button>
                </div>
            </section>
            <h4 class="subtitulo"> Empieza buscando tu medico o especialidad de preferencia </h4>
            <div class="loader"></div>
            <div id="display"></div> 
            <h3 class="empty"> Ingrese una busqueda para empezar </h3>
        </div>

        <article class="hide">
            <!-- titulo del landing -->
            <div class="main-title">
                <section>
                    <h1>MEJORAMOS</h1>
                    <h4>la <em>interactividad</em></h4>
                    <h1>MEDICO <i>-</i> <span>PACIENTE</span></h1>
                </section>
            </div>
            
            <!-- ventajas de especialistas -->
            <div class="ventajas">
                <h2>ventajas para medicos</h2>
            </div>

            <!-- pasos de pacientes -->
            <div class="pasos">
                <h2>sistema de 3 pasos</h2>
            </div>             
            
            <!-- seccion de clientes y especialistas -->
            <div class="cliente-medico">
                <section class="medicos">
                    <div class="description-left">
                        <h3>Para medicos y especialistas</h3>
                        <p>Solidificate como profesional </p>
                        <a class="boton-left" href="sign-up.php">Crea una cuenta</a>
                    </div>
                    <div>
                        <h4><span>Incrementa</span> tu indice de consultas</h4>
                        <h4><span>Aumenta</span> tus ganancias</h4>
                        <h4><span>Obten</span> experiencia laboral</h4>
                    </div>
                </section>
                <section class="clientes">
                    <div class="description-right">
                        <h3>Para clientes y pacientes</h3>
                        <p>Asegura tu salud</p>
                        <a class="boton-right" href="perfil.php">Busca especialistas</a>
                    </div>
                    <div>
                        <h4><span>Acelera</span> el proceso de consulta</h4>
                        <h4><span>Facilita</span> tu busqueda</h4>
                        <h4><span>Optimiza</span> tu salud</h4>
                    </div>
                </section>
            </div>


            <!-- tipos de membresias -->
            <div class="memberships">
                <h1 class="section-title">EMPIEZA HOY!</h1>
                <h3 class="section-subtitle">con nuestros distintos paquetes</h3>
                <section>
                    <div href="sign-up.php">
                        <a href="sign-up.php?membership=0" id="free">
                            <h3 class="section-subtitle">Free</h3>
                            <img src="img/badge.png" class="badge">
                            <ul class="list">
                                <li class="plain-text">item</li>
                                <li class="plain-text">item</li>
                                <li class="plain-text">item</li>
                            </ul>
                        </a>
                    </div>
                    <div href="sign-up.php">
                        <a href="sign-up.php?membership=1" id="standard">
                            <h3 class="section-subtitle">Standard</h3>
                            <img src="img/badge.png" class="badge">
                            <ul class="list">
                                <li class="plain-text">item</li>
                                <li class="plain-text">item</li>
                                <li class="plain-text">item</li>
                            </ul>
                        </a>
                    </div>
                    <div href="sign-up.php">
                        <a href="sign-up.php?membership=2" id="premium">
                            <h3 class="section-subtitle">Pro</h3>
                            <img src="img/badge.png" class="badge">
                            <ul class="list">
                                <li class="plain-text">item</li>
                                <li class="plain-text">item</li>
                                <li class="plain-text">item</li>
                            </ul>
                        </a>
                    </div>
                </section>
            </div>           
            
            <!-- contenedor del footer -->
            <div class="about-us">
                <h1 class="section-title">SOBRE NOSOTROS</h1>
                <p class="plain-text">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
        </article>
    </main>
    
<!--SCRIPTS-->
    <script src="js/scripts-index.js"></script>
    <script>
        var loggedOff = <?php echo json_encode($loggedOff); ?>;
        if(loggedOff){
            window.location.href = 'index.php',true; 
        }

    </script>
    <script>
        var loggedin = <?php echo json_encode($_SESSION['loggedin']); ?>;
        if(loggedin){
            $('#titulo').css({
                'margin-top':'0' 
            });
            $('.welcome').css({
                'margin-top':'190px' 
            });   
        }
    </script>
</body>

</html>
