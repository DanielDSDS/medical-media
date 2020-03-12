<?php
    require_once("bd_conexion.php");

    $id = $_POST['id'];
    $sql = "SELECT nombre_campo, categoria_campo, fechas_guardadas FROM config_disponibilidad where id_user = '$id' ";
    $result = $conn->query($sql);
    
    $i= 0;
    $arr = ["items" => []] ;
    while($rows = $result->fetch_assoc()){
        $arr["items"][$i] = $rows;
        $i++;
    }
    echo json_encode($arr, JSON_UNESCAPED_SLASHES);
?>
