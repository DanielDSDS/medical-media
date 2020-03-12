<!-- CUERPO PHP -->
<?php include_once 'includes/templates/header.php'; ?>

<?php 

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
        
        try{
            require_once('includes/funciones/bd_conexion.php');
            $sql = "SELECT * FROM dbusuario where `id` = '$id' ";
            $resultado = $conn->query($sql);
            $datos = $resultado->fetch_assoc();
        }catch(Exception $e){
            $error1 = $e->getMessage();
        }
    }
?>    

<!-- SRCS -->
<link rel="stylesheet" href="datepickk-master/dist/datepickk.min.css">
<link href="css/perfil.css" rel="stylesheet" type="text/css" />

<!-- CUERPO HTML -->
<head>
    <title>
        <?php echo htmlspecialchars($datos['nombre']); ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
</head>

<body>
    <main>

        <div class="top-container">
            <!-- SECCION DE DATOS DEL PERFIL -->
            <div class="personal-dashboard">
                <nav>
                    <!-- navegacion basica del perfil -->
                    <?php if($datos['img_link']) { ?>
                        <img src="uploads/profilepics/user<? echo htmlspecialchars($datos['id']) . '/' . htmlspecialchars($datos['img_link']); ?>">
                    <? }else{ ?>
                        <img src="uploads/profilepics/pfp.png">
                    <? } ?>
                    <section>
                        <h2 class="section-subtitle">
                            <?php echo htmlspecialchars($datos['nombre']) . ' ' . htmlspecialchars($datos['apellido']);  ?>
                        </h2>
                        <p class="plain-text">
                            <?php echo htmlspecialchars($datos['descripcion']); ?>
                        </p>
                    </section>
                    <div class="social-media">
                        <a class="section-subtitle" id="telefono">
                            <i class="fas fa-phone-square mobile icon"></i>
                            <?php echo htmlspecialchars($datos['telefono']); ?>
                        </a>
                        <?php if($datos['twitter'].trim()) { ?>
                            <a class="section-subtitle" id="twitter">    
                                <i class="fab fa-twitter twitter icon" ></i>
                                <?php echo htmlspecialchars($datos['twitter']); ?>        
                            </a>
                        <? } ?>
                        <?php if($datos['instagram'].trim()) { ?>
                            <a class="section-subtitle" id="instagram">
                                <i class="fab fa-instagram instagram icon" ></i>
                                <?php echo htmlspecialchars($datos['instagram']); ?>        
                            </a>
                        <? } ?>
                        <a href="mailto: <?php echo htmlspecialchars($datos['email']); ?>" class="section-subtitle" id="email">
                            <i class="fas fa-at google icon"></i>
                            <?php echo htmlspecialchars($datos['email']); ?>    
                        </a>
                    </div>
                </nav>
            </div>

            <!-- SECCION CALENDARIO -->
            <div id="calendario">
                <div id="options">
                    <span>Horario</span>
                    <select id="horario">
                        <option value=""></option>
                        <option value="manana">Diurno</option>
                        <option value="tarde">Nocturno</option>
                    </select><br>
                    Tipo de Cita
                    <select id="tipo-cita">
                        <option value=""></option>
                        <option value="consulta">Consulta</option>
                        <option value="ecografia">Ecografia</option>
                        <option value="odontologia">Chequeo Odontologico</option>
                        <option value="ex_laboratorio">Examenes de Laboratorio</option>
                        <option value="ex_radiograficos">Examenes Radiograficos</option>
                        <option value="ex_patologia">Examenes de Patologia-Citologia</option>
                    </select><br>
                    Localizacion
                    <select id="localizacion">
                        <option value=""></option>
                        <option value="poz">Clinica Puerto Ordaz</option>
                        <option value="chilemex">Clinica Chilemex</option>
                        <option value="san">Clinica San Antonio</option>
                        <option value="san">Clinica Caroni</option>
                        <option value="san">Hospital Medico Uyapar</option>
                        <option value="san">Clinica La Familia</option>
                    </select>
                </div>
                <div id="errorCalendario">Introdujo una fecha no valida, refresque la pagina</div>
            </div>

            <!-- SECCION DE CONFIRMACION DE CITA -->
            <div id="confirm">
                <h1>CONFIRMAR CITA</h1>
                <section class="confirmar-cita">
                    <div class="campo">Fecha de cita:
                        <span id="fecha"></span>
                    </div>
                    <div class="campo">Horario:
                        <span id="hora"></span>
                    </div>
                    <div class="campo">Tipo de Cita:
                        <span id="tipo"></span>
                    </div>
                    <div class="campo">Localizacion:
                        <span id="ubicacion"></span>
                    </div>
                </section>
                <button id="paymentButton" class="boton-submit">Confirmar</button>
            </div>
        </div>

        <div class="bot-containter">
            <!-- CURRICULUM -->
            <div class="curriculum" id="curriculum">
                <ul class="data-list">
                    <h3>Información Profesional</h3>
                    <div class="data-list-item">
                        <ul>
                            <li>Ocupación Actual</li>
                            <li>Ubicación de Consultorio</li>
                            <li>Especialidad</li>
                        </ul>
                        <ul class="response">
                            <li id="ocupacion">
                                <?php echo htmlspecialchars($datos['ocupacion']); ?>
                            </li>
                            <li>
                                <?php echo htmlspecialchars($datos['localizacion']);?>
                            </li>
                            <li>
                                <?php echo htmlspecialchars($datos['especialidad']);?>
                            </li>
                        </ul>
                    </div><br>
                    <h3>Educación</h3>
                    <div class="data-list-item">
                        <ul>
                            <li>Fecha de Graduación</li>
                            <li>Universidad/Institución</li>
                            <li>Fecha de Residencia</li>
                            <li>Ubicación</li>
                        </ul>
                        <ul class="response">
                            <li>
                                <?php echo htmlspecialchars($datos['fecha_graduacion']);?>
                            </li>
                            <li>
                                <?php echo htmlspecialchars($datos['universidad']);?>
                            </li>
                            <li>
                                <?php echo htmlspecialchars($datos['fecha_postgrado']);?>
                            </li>
                            <li>
                                <?php echo htmlspecialchars($datos['local_postgrado']);?>
                            </li>
                        </ul>
                    </div>
                    <?php if($datos['certificado1_link'] != '' && $datos['certificado2_link'] != '' && $datos['certificado3_link'] != '') { ?>
                        <h3 id="c-title">Certificación</h3>
                        <div class="data-list-item">
                            <?php if($datos['certificado1_link'] != '') { ?>
                                <embed id="cert1" src="uploads/certificados/user<? echo htmlspecialchars($datos['id']) . '/' . htmlspecialchars($datos['certificado1_link']);?>" width="200px" height="100px" />
                            <? } ?>
                            <?php if($datos['certificado2_link'] != '') { ?>
                                <embed id="cert2" src="uploads/certificados/user<? echo htmlspecialchars($datos['id']) . '/' . htmlspecialchars($datos['certificado2_link']);?>" width="200px" height="100px" />
                            <? } ?>
                            <?php if($datos['certificado3_link'] != '') { ?>
                                <embed id="cert3" src="uploads/certificados/user<? echo htmlspecialchars($datos['id']) . '/' . htmlspecialchars($datos['certificado3_link']);?>" width="200px" height="100px" />
                            <? } ?>
                        </div>
                    <? } ?>
                </ul>
            </div>

            <div id="map"></div>
        </div>
    </main>

<!--SCRIPTS-->
    <script src="js/scripts-perfil.js"></script>
    <script src="datepickk-master/dist/datepickk.min.js"></script>
    
    <?php $resultado->close(); ?>
    <?php $conn->close(); ?>
</body>

</html>
