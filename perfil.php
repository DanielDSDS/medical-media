<!-- CUERPO PHP -->
<?php include_once 'includes/templates/header.php'; ?>
<?php 
    session_start();
    $id = $_SESSION['id'];
    if($_SESSION['loggedin']){
        try{
            require_once('includes/funciones/bd_conexion.php');
            $sql = "SELECT * FROM dbusuario where `id` = '$id' ";
            $resultado = $conn->query($sql);
            $datos = $resultado->fetch_assoc();

            $tipo_citas = explode(';',$datos['tipo_cita']);
            $horarios = explode(';',$datos['horario']);
            $ubicacion = explode(';',$datos['ubicacion']);
        }catch(Exception $e){
            $error1 = $e->getMessage();
        }   
    }else{
        header('Location: index.php');
    }
?>
<html>
<!-- SRCS -->
<link href="css/perfil-esp.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="datepickk-master/dist/datepickk.min.css">

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
            <?php if($datos['allowed'] !== '1') { ?>
            <div class="aviso">
                <h3>Tu perfil no estara disponible al publico hasta que su solicitud de registro sea confirmada</h3>
            </div>
            <? } ?>
            <div class="topdiv">
                <section class="basic-profiledata">
                    <?php if($datos['img_link'] != '' ) { ?>
                    <img class="pfp" src="uploads/profilepics/user<? echo $datos['id']; ?>/profilepic.jpg">
                    <? }else{ ?>
                    <img class="pfp" src="uploads/profilepics/pfp.png">
                    <? } ?>
                    <h3>
                        <? echo $datos['nombre'] .' '. $datos['apellido']; ?>
                    </h3>
                </section>
                <section class="personal-profiledata">
                    <h5><i class="fas fa-phone-square mobile"></i>
                        <?php echo ' '.$datos['telefono']; ?>
                    </h5>
                    <h5><i class="fab fa-twitter twitter"></i>
                        <?php echo ' '.' '.$datos['twitter']; ?>
                    </h5>
                    <h5><i class="fab fa-instagram instagram"></i>
                        <?php echo ' '.$datos['instagram']; ?>
                    </h5>
                    <h5><i class="fas fa-at"></i>
                        <?php echo ' '.$datos['email']; ?>
                    </h5>
                </section>
                <section class="descripcion-profiledata">
                    <h1>Descripcion Personal</h1>
                    <p class="descripcion-personal">
                        <?php echo $datos['descripcion']; ?>
                    </p>
                </section>
            </div>
            <!-- SECCION CALENDARIO -->
            <div class="sidebar">

            </div>
            <h1 class="subtitle">Selecciona los campos junto con los dias que corresponderan a tu disponibilidad </h1>
            <div class="calendar-container">
                <aside class="options">
                    <ul>
                        <a class="disponibilidad">
                            <li>Disponibilidad</li>
                        </a>
                        <a class="configurar">
                            <li>Configurar</li>
                        </a>
                        <a>
                            <li>Editar Perfil</li>
                        </a>
                        <a>
                            <li>Estadisticas</li>
                        </a>
                    </ul>
                </aside>
                <div id="calendario">
                </div>
                <div class="appointment-fields">
                    <section>
                        <h1 id="horarios">                            
                            <i class="fas fa-angle-down "></i>
                            <i class="fas fa-angle-up "></i>
                            <a> Horarios</a>
                        </h1>
                        <div class="horarios">
                            <?php  $i = 0;
                                while($horarios[$i] != '') { ?>
                            <? echo $horarios[$i]; ?><input type="checkbox" value="<? echo $horarios[$i]; ?>"><br>
                            <?      $i++;
                                } ?>
                        </div>
                    </section>

                    <section>
                        <h1 id="tipo-citas">                            
                            <i class="fas fa-angle-down "></i>
                            <i class="fas fa-angle-up "></i>
                            <a> Tipos de Citas</a>                           
                        </h1>
                        <div class="tipo-citas">
                            <?php  $i = 0;
                                while($tipo_citas[$i] != '') { ?>
                            <? echo $tipo_citas[$i]; ?><input type="checkbox" value="<? echo $tipo_citas[$i]; ?>"><br>
                            <?      $i++;
                                } ?>
                        </div>
                    </section>

                    <section>
                        <h1 id="ubicacion">                            
                            <i class="fas fa-angle-down "></i>
                            <i class="fas fa-angle-up "></i>
                            <a> Ubicacion</a>
                        </h1>
                        <div class="ubicacion">
                            <?php  $i = 0;
                                while($ubicacion[$i] != '') { ?>
                            <? echo $ubicacion[$i]; ?><input type="checkbox" value="<? echo $ubicacion[$i]; ?>"><br>
                            <?      $i++;
                                } ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <!-- SCRIPTS -->
    <script src =  
    "https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"> 
    </script> 
    <script src="js/scripts-perfil-esp.js"></script>
    <script src="datepickk-master/dist/datepickk.min.js"></script>
    <script>
        /* INICIALIZAR VARIABLES Y ESTADOS */

        // VARIABLES
        var id = <?php echo json_encode($datos['id']); ?>;
        var fecha = new Date();
        var delayTimer;
        var checkedHorarios = [];
        var checkedCitas = [];
        var checkedUbicaciones = [];
        var datepicker = new Datepickk();
        datepicker.weekStart = 1;
        datepicker.container = document.querySelector('#calendario');
        datepicker.disabledDays = [6, 0];
        datepicker.minDate = datepicker.currentDate;
        datepicker.locked = true;
        datepicker.button = '';
        datepicker.show();
        
        $('.perfil').addClass('active');
        
        /* FUNCIONES Y EVENTOS */
        $('#horarios').on('click', toggleField);
        $('#tipo-citas').on('click', toggleField);
        $('#ubicacion').on('click', toggleField);

        //eventos principales
        $('.configurar').on('click', abrirConfigurar);
        
        $('.disponibilidad').on('click', abrirDisponibilidad);
        
        datepicker.onConfirm = function() {            
            var it = 0;
            var fechasUsFormat = [];
            var dia = [];
            var mes = [];
            var year = [];
            var selectedDates = datepicker.selectedDates;

            $(".horarios input:checkbox:checked").each(function() {
                checkedHorarios.push($(this).val());
            });
            $(".tipo-citas input:checkbox:checked").each(function() {
                checkedCitas.push($(this).val());
            });
            $(".ubicacion input:checkbox:checked").each(function() {
                checkedUbicaciones.push($(this).val());
            });

            //como las fechas ingresadas se procesan en el formato local, son transformadas al formato US
            //para poder ser utilizadas por el calendario
            while (selectedDates[it]) {
                selectedDates[it] = selectedDates[it].toLocaleString('en-GB').slice(0, 10);

                fechasUsFormat[it] = selectedDates[it].toString();
                dia[0] = selectedDates[it][0];
                dia[1] = selectedDates[it][1];

                mes[0] = selectedDates[it][3];
                mes[1] = selectedDates[it][4];

                year[0] = selectedDates[it][6];
                year[1] = selectedDates[it][7];
                year[2] = selectedDates[it][8];
                year[3] = selectedDates[it][9];

                fechasUsFormat[it] = mes[0] + mes[1] + '/' + dia[0] + dia[1] + '/' + year[0] + year[1] + year[2] + year[3];

                it++;
            }

            delayTimer = setTimeout(function() {
                $.ajax({
                    url: "includes/funciones/config-ajax.php",
                    method: "POST",
                    data: {
                        id: id,
                        checkedHorarios: checkedHorarios,
                        checkedCitas: checkedCitas,
                        checkedUbicaciones: checkedUbicaciones,
                        selectedDates: fechasUsFormat
                    },
                    success: function() {
                        datepicker = new Datepickk();
                        datepicker.weekStart = 1;
                        datepicker.container = document.querySelector('#calendario');
                        datepicker.disabledDays = [6, 0];
                        datepicker.minDate = datepicker.currentDate;
                        datepicker.locked = true;
                        datepicker.button = '';
                        datepicker.show();
                        $('.appointment-fields').hide();
                        $('.subtitle').hide();
                        $('#calendario').width() = '75%';
                    },
                    async: false
                });
            });
        }        
 
        function abrirConfigurar() {
            datepicker.unselectAll();
            datepicker.locked = false;   
            var toggleWidth = $('#calendario').width() == '75%' ? '40%' : '75%';
            $('.appointment-fields').slideToggle();
            $('.subtitle').toggle();
            
            $('.horarios input').on('change',function(){
                datepicker.button = 'Guardar Cambios';         
            });         
            $('.tipo-citas input').on('change',function(){
                datepicker.button = 'Guardar Cambios';         
            });   
            $('.ubicacion input').on('change',function(){
                datepicker.button = 'Guardar Cambios';         
            });
            
            datepicker.onSelect = function(checked) {
                var state = (checked) ? 'selected' : 'unselected';
                if ((this.getTime() > fecha.getTime())) {              
                } else {
                    datepicker.button = '';
                    datepicker.unselectAll();
                }
            };
        }
        
        function abrirDisponibilidad() {
            $('.appointment-fields').hide();
            $('.subtitle').hide();
            
            $.ajax({
                url: "includes/funciones/disp-ajax.php",
                method: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    var parsedData = JSON.parse(response);
                    var fechasDisponibles = [];

                    $.each(parsedData.items, function(index, item) {
                        fechasDisponibles.push(item.fechas_guardadas);
                    });

                    fechasDisponibles = $.trim(fechasDisponibles);
                    fechasDisponibles = fechasDisponibles.split(',');

                    displayFechasDisponibles(fechasDisponibles);
                    datepicker.button = '';
                },
                async: false
            });
        }        
        
        var displayFechasDisponibles = fechas => {
            for (var i = 0; i < fechas.length; i++) {
                datepicker.selectDate(fechas[i]);
            }
            datepicker.locked = true;
        }

        function toggleField() {
            $(this).next().slideToggle();
            $(this).find('.fa-angle-down').toggle();
            $(this).find('.fa-angle-up').toggle();            
        };
        
    </script>

    <? $resultado->close(); ?>
    <? $conn->close(); ?>
</body>

</html>
