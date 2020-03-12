<html>
<body>
<link href="../../css/busqueda.css" rel="stylesheet" type="text/css" />
<script src="../../js/scripts-index.js"></script>
<?

    require_once("bd_conexion.php");
    
    if(isset($_POST['search_input'])) {
        
        $search_input = $_POST['search_input'];
        
        $sql = "SELECT * FROM dbusuario WHERE
        nombre LIKE '%$search_input%' OR 
        apellido LIKE '%$search_input%' OR 
        especialidad LIKE '%$search_input%' OR 
        localizacion LIKE '%$search_input%' 
        ORDER BY 
        (nombre LIKE '$search_input%') DESC,(apellido LIKE '%$search_input%') DESC,(especialidad LIKE '%$search_input%') DESC,(localizacion LIKE '%$search_input%') DESC LIMIT 25";
        
        $respuesta = $conn->query($sql);
        
        echo 
        '<ul>';
            while($result = $respuesta->fetch_assoc()) { ?>
                <li id="item">
                    <section class="c1"> 
                        <?php if($result['img_link']!='') { ?>
                            <img class="pfp" src="uploads/profilepics/user<? echo htmlspecialchars($result['id']) . '/' . htmlspecialchars($result['img_link']); ?>">
                        <? }else{ ?>
                            <img class="pfp" src="uploads/profilepics/pfp.png">
                        <? } ?>
                        <h4 class="nombre"><?php echo htmlspecialchars($result['nombre']).' '.htmlspecialchars($result['apellido']); ?></h4>
                    </section>
                    <section class="c2">
                        <div class="data">
                            <h4><i class="fas fa-book-medical icon"></i><?php echo htmlspecialchars($result['especialidad']); ?></h4>
                            <h4><i class="fas fa-map-marker-alt icon"></i><?php echo htmlspecialchars($result['localizacion']); ?></h4>
                            <h4><i class="fas fa-graduation-cap icon"></i><?php echo htmlspecialchars($result['universidad']).' ('.htmlspecialchars($result['fecha_graduacion']).')'; ?></h4>
                        </div>
                        <p class="descripcion"> <?php echo ' '.htmlspecialchars($result['descripcion']); ?></p>
                        <section class="c4">
                            <div class="c4-data">
                                <a target="_blank" href="perfil-guest-pov.php?id=<?php echo htmlspecialchars($result['id']);?>"><button class="boton-submit">Ver perfil completo</button></a>
                                <a href=""><button class="boton-submit">Crear cita</button></a>
                            </div>
                        </section>
                    </section>
                    <section class="c3">
                        <div class="c3-data">
                            <h4><i class="fas fa-phone-square icon"></i><?php echo htmlspecialchars($result['telefono']); ?></h4>
                            <h4><i class="fab fa-twitter icon"></i><?php echo htmlspecialchars($result['twitter']); ?></h4>
                            <h4><i class="fab fa-instagram icon"></i><?php echo htmlspecialchars($result['instagram']); ?></h4>
                            <h4><i class="fas fa-at google icon"></i><?php echo htmlspecialchars($result['email']); ?></h4>
                        </div>                        
                    </section>
                </li>

        <?php
            }
    }

?>
