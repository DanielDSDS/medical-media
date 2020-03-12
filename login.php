<?php include_once 'includes/templates/header.php'; ?>
<?php 
    //Valida si viene enviado por un formulario
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

            
            try {
                //Se ABRE una conexion a la base de datos
                require_once('includes/funciones/bd_conexion.php');

                $errorValidation = false;
                
                //Se valida si los datos vienen vacios y se protege de una inyeccion SQL
                if(isset($_POST['email']) || trim($_POST['email']) != '') {
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    echo $email;
                }else{
                    $errorValidation = true;   
                }

                if(isset($_POST['password']) || trim($_POST['password']) != '') {
                    $password = mysqli_real_escape_string($conn, $_POST['password']);
                    echo $password;
                }else{
                    $errorValidation = true;   
                }                

                //codigo SQL para obtener los datos del usuario insertado
                if(!$errorValidation){
                    $sql = "SELECT * FROM dbusuario WHERE email ='$email' AND password = '$password' " ;
                }
                //se envia el query a la base de datos y se guarda la respuesta del servidor
                $resultado = $conn->query($sql);
                $datos = $resultado->fetch_assoc();
                
                //Se valida si se pudo registrar o iniciar sesion para enviarlo a distintas paginas
                if($datos != '') { 
                    //Se envian estos datos mediante el request $_SESSION hacia el header
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['nombre'] = $datos['nombre'];
                    $_SESSION['id'] = $datos['id'];
                    header("Location: perfil.php");//enviar a perfil.php?id=datos['id']
                    exit;
                }else{ 
                    header("Location: sign-up.php?error=1");
                    exit;
                }
            } catch(Exception $e) {
                $error1 = $e->getMessage();    
            }     
            
    }
  
?>

<head>
    <title>
        Login
    </title>
</head>
<body>
    <?php $resultado->close(); ?>
    <?php $conn->close(); ?>
</body>