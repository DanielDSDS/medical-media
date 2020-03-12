<?php include_once 'includes/templates/header.php'; ?>
<?php      


    //Valida si viene enviado por un formulario
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Valida si el boton presionado fue el de login
        if(isset($_POST['submit-signup'])) {
            
            try {
                //Se ABRE una conexion a la base de datos
                require_once('includes/funciones/bd_conexion.php');
                
                //Validar si campos estan vacios y proteccion de inyecciones SQL
                $error = false;

                if(isset($_POST['email']) && trim($_POST['email']) != ''){
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                }else{
                    $error = true;
                }

                if(isset($_POST['nombre']) && trim($_POST['nombre']) != ''){
                    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
                }else{
                    $error = true;
                }

                if(isset($_POST['apellido']) && trim($_POST['apellido']) != ''){
                    $apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
                }else{
                    $error = true;
                }

                if(isset($_POST['telefono']) && trim($_POST['telefono']) != ''){
                    $telefono = mysqli_real_escape_string($conn, $_POST['telefono']);
                }else{
                    $error = true;
                }

                if(isset($_POST['password']) && trim($_POST['password']) != ''){
                    $password = mysqli_real_escape_string($conn, $_POST['password']);
                    if($password != $_POST['password2']){
                        $error = true;
                    }
                }else{
                    $error = true;
                }

                if(isset($_POST['especialidad']) && trim($_POST['especialidad']) != ''){
                    $especialidad = mysqli_real_escape_string($conn, $_POST['especialidad']);
                }else{
                   $error = true;
                }

                if(isset($_POST['membresia']) && trim($_POST['membresia']) != ''){
                    $membresia = mysqli_real_escape_string($conn, $_POST['membresia']);
                }else{
                    $error = true;
                }
                
                if(isset($_POST['ocupacion']) && trim($_POST['ocupacion']) != ''){
                    $ocupacion =  mysqli_real_escape_string($conn, $_POST['ocupacion']);
                }else{
                    $error = true;
                } 
                
                if(isset($_POST['localizacion']) && trim($_POST['localizacion']) != ''){
                    $localizacion =  mysqli_real_escape_string($conn, $_POST['localizacion']);
                }else{
                    $error = true;
                }

                if(isset($_POST['universidad']) && trim($_POST['universidad']) != ''){
                    $universidad =  mysqli_real_escape_string($conn, $_POST['universidad']);
                }else{
                    $error = true;
                }               
                
                if(isset($_POST['fecha_graduacion']) && trim($_POST['fecha_graduacion']) != ''){
                    $fecha_graduacion =  mysqli_real_escape_string($conn, $_POST['fecha_graduacion']);
                }else{
                    $error = true;
                }                
                
                if(isset($_POST['descripcion']) && trim($_POST['descripcion']) != ''){
                    $descripcion =  mysqli_real_escape_string($conn, $_POST['descripcion']);
                }else{
                    $error = true;
                }               
                
                if(isset($_POST['twitter']) && trim($_POST['twitter']) != ''){
                    $twitter =  mysqli_real_escape_string($conn, $_POST['twitter']);
                }else{
                    $twitter = 'N/A';
                }
                
                if(isset($_POST['instagram']) && trim($_POST['instagram']) != ''){
                    $instagram =  mysqli_real_escape_string($conn, $_POST['instagram']);
                }else{
                    $instagram = 'N/A';
                }     
                
                if(isset($_POST['fecha_postgrado']) && trim($_POST['fecha_postgrado']) != ''){
                    $fecha_postgrado =  mysqli_real_escape_string($conn, $_POST['fecha_postgrado']);
                }else{
                    $fecha_postgrado = 'N/A';
                }
                
                if(isset($_POST['local_postgrado']) && trim($_POST['local_postgrado']) != ''){
                    $local_postgrado =  mysqli_real_escape_string($conn, $_POST['local_postgrado']);
                }else{
                    $local_postgrado = 'N/A';
                }               
                
                        //Si no hay error se busca el email y el telefono para saber si estan repetidos
                if(!$error){
                    $sqlValidacion = "SELECT * FROM dbusuario where `email` = '$email' " ;
                    $sqlTelefono = "SELECT * FROM dbusuario where `telefono` = '$telefono' " ;
                }            
                
                $resultadoValidacion = $conn->query($sqlValidacion);
                $data = $resultadoValidacion->fetch_assoc();
                
                $resultadoValidacion2 = $conn->query($sqlTelefono);
                $data2 = $resultadoValidacion2->fetch_assoc();                
                
                //Si ninguno de los dos se repite inserta en la base de datos
                if($data == '' && $data2 == '') {

                    if($twitter != 'N/A'){
                        if (strpos($twitter, '@') == false) {
                            $twitter = "@".$twitter;
                        }                     
                    }
                    
                    if($instagram != 'N/A'){
                        if (strpos($instagram, '@') == false) {
                            $instagram = "@".$instagram;
                        } 
                    }
                    
                    //INSERT
                    //Codigo SQL para insertar en la tabla 'dbusuario'
                    if(!$error){
                        $sql = "INSERT INTO dbusuario (`id`,`email`,`password`,`nombre`,`apellido`, `telefono`,`especialidad` , `ocupacion`,`fecha_graduacion`,`universidad`,`fecha_postgrado`,`local_postgrado`,`membresia`,`descripcion`,`localizacion`,`instagram`,`twitter`,`img_link`,`certificado1_link`,`certificado2_link`,`certificado3_link`,`allowed`) " ;
                        $sql .= "VALUES (NULL, '$email', '$password', '$nombre', '$apellido', '$telefono', '$especialidad', '$ocupacion' ,'$fecha_graduacion', '$universidad','$fecha_postgrado','$local_postgrado', '$membresia', '$descripcion', '$localizacion','$instagram', '$twitter','','','','','0') ";
                    }
                    //Se envia el query a la base de datos y se guarda la respuesta del servidor
                    $resultado = $conn->query($sql);
                    
                    //Se busca el usuario creado para obtener su id y poder inciar la sesion correctamente
                    $sqlQuery = "SELECT * FROM dbusuario where `email` = '$email' ";
                    $result = $conn->query($sqlQuery);
                    $id = $result->fetch_assoc()['id'];
                    
                    //Si no hubo ningun problema con la base de datos inicia la sesion y lo lleva al perfil
                    if($resultado){
                        $_SESSION['loggedin'] = true;
                        $_SESSION['nombre'] = $_POST['nombre'];
                        $_SESSION['id'] = $id;
                        

                        //Subir certificados a archivos del especialista
                        $total = count($_FILES['certificado']['name']);
                        $files = $_FILES['certificado']['name'];
                        $maxsize = 10000000;
                        $certificados = array();
                        $links = array('certificado1_link','certificado2_link','certificado3_link');
                        $path = 'uploads/certificados/user' . $id; 
                        mkdir($path);
                        
                        for($i=0; $i < $total; $i++){
                            
                            $tmpFilePath = $_FILES['certificado']['tmp_name'][$i];
                            $file_name = $_FILES['certificado']['name'][$i]; 
                            $file_size = $_FILES['certificado']['size'][$i];
                            
                            if($file_name != ''){
                                
                                if($file_size <= $maxsize){
                                    $file_ext = pathinfo($file_name);
                                    switch($file_ext['extension']){
                                        case 'jpeg':{
                                            $newFileName = 'certificado' . $i . '.' . jpg;
                                            $newFilePath = $path . '/' . $newFileName;
                                            break;                                   
                                        }                                
                                        case 'jpg':{
                                            $newFileName = 'certificado' . $i . '.' . jpg;
                                            $newFilePath = $path . '/' . $newFileName;
                                            break;                                    
                                        }
                                        case 'png':{
                                            $newFileName = 'certificado' . $i . '.' . png;
                                            $newFilePath = $path . '/' . $newFileName;
                                            break;                                    
                                        }
                                        default:{
                                            header('Location: sign-up.php?error=6');
                                            exit;
                                        }

                                    }

                                    if($tmpFilePath != ""){
                                        $certificados[$i] = $newFileName;
                                        if(move_uploaded_file($tmpFilePath, $newFilePath)){
                                            $sqlCert = "UPDATE `dbusuario` SET $links[$i] = '$certificados[$i]' WHERE `dbusuario`.`id` = '$id' ";
                                            $resultCert = $conn->query($sqlCert); 
                                            echo 'Success';
                                        }
                                        echo $linkCertificado;                                      
                                    }                                    
                                }else{
                                    header("Location: sign-up.php?error=7");
                                    exit;
                                }
   
                            }
                        }

                        
                        //Subir imagen de perfil desde forma
                        if(isset($_FILES['profilepic'])){
                            $errors = array();
                            $file_name = $_FILES['profilepic']['name'];
                            $file_size = $_FILES['profilepic']['size'];
                            $file_tmp = $_FILES['profilepic']['tmp_name'];
                            $file_type = $_FILES['profilepic']['type'];
                            $file_ext = strtolower(end(explode('.',$_FILES['profilepic']['name'])));
                            
                            $file_name = 'profilepic.' . $file_ext;
                            
                            $path = 'uploads/profilepics/user' . $id . '/';
                            mkdir($path);
                            $extensions= array("jpeg","jpg","png");

                            if($file_ext != ''){                        

                                if(in_array($file_ext,$extensions) === false){
                                    $errors[]="extension not allowed, please choose a JPEG or PNG file.";
                                    header('Location: sign-up.php?error=5');
                                    exit;
                                }

                                if(empty($errors)==true) {      
                                    if(move_uploaded_file($file_tmp, $path . $file_name )){
                                        echo "Success";  
                                    }else{
                                        $file_name = '';                                      
                                    }
                                }else{
                                    print_r($errors);
                                    $file_name = '';
                                }   
                            }else{
                                $file_name = '';
                            }
                        }else{
                            $file_name = '';
                        }
                        
                        $sql2 = "UPDATE `dbusuario` SET `img_link` = '$file_name' WHERE `dbusuario`.`id` = '$id' ";
                        $resultUpdate = $conn->query($sql2);
                        
                        header("Location: perfil.php");
                        exit;
                    }else{
                        header("Location: sign-up.php?error=2");
                        exit;
                    }   
                    

                    
                
                //Si el correo se repite manda el error con un GET
                }else if($data != '') {
                    header("Location: sign-up.php?error=3");
                    exit;           
                //Si el telefono se repite manda el error con un GET
                }else{
                    header("Location: sign-up.php?error=4");
                    exit;                     
                }

            } catch(Exception $e) {
                $error1 = $e->getMessage();    
            }   
        }
    }
?>


<link href="css/registro.css" rel="stylesheet" type="text/css" />

<head>
    <title id="titulo">
        Login
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
</head>

<body>
    <!--Cerrar conexion-->
    <?php $conn->close(); ?>
</body>

