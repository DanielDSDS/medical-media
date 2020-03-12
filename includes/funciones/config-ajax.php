<?php
    require_once("bd_conexion.php");
    if(isset($_POST['id'])) {
        
        #PRUEBA
        function getDates($result,$selectedDates) {
            #borrar este bloque si algo falla
            if(!empty($result['fechas_guardadas'])){ 
                $idx = 0;
                $iter = 0;
                $fechasBD = explode(',',$result['fechas_guardadas']);
                $newDates = $selectedDates;
                $toInsertDates = [];
                while($fechasBD[$idx]){
                    if(!in_array($newDates[$idx],$fechasBD)){
                        $toInsertDates[$iter] = $newDates[$idx];
                        $iter++;
                    }
                    $idx++;
                }         
                $fechas = implode(',',$toInsertDates);
            }
            return $fechas;
            #borrar este bloque si algo falla 
        }
        
        $id = $_POST['id'];
        $horarios = $_POST['checkedHorarios'];
        $ubicacion = $_POST['checkedUbicaciones'];
        $tipo_citas = $_POST['checkedCitas'];
        $selectedDates = $_POST['selectedDates'];
        
        
        $stmt = $conn->prepare("INSERT INTO config_disponibilidad (id_user,nombre_campo,categoria_campo,fechas_guardadas) VALUES (?,?,?,?)");
        $stmt->bind_param("isss",$id,$nombreCampo,$categoriaCampo,$fechas);
            
        $i = 0;
        while($horarios[$i] != ''){
    
            $nombreCampo = $horarios[$i];
            $categoriaCampo = 'Horario';
            $fechas = implode(',',$selectedDates);
            
            $sql = "SELECT * FROM config_disponibilidad WHERE (id_user = '$id') AND (nombre_campo = '$nombreCampo') ";
            $respuesta = $conn->query($sql);
            $result = $respuesta->fetch_assoc();
            
            if($result == ''){
                //si no consigue coincidencias ejecuta el statement preparado
                $stmt->execute();    
            }else{
                //si hay coincidencia existente concatena con las fechas existentes
                
                #PRUEBA
                $fechas = getDates($result,$selectedDates);                
                
                $sql2 = " UPDATE config_disponibilidad SET fechas_guardadas = concat(fechas_guardadas,',','$fechas') WHERE (`config_disponibilidad`.`id_user` = '$id') AND (`config_disponibilidad`.`nombre_campo` = '$nombreCampo')";
                $conn->query($sql2);
            }
            
            $i++;      
        }        
        
        $i = 0;
        while($ubicacion[$i] != ''){
            $nombreCampo = $ubicacion[$i];
            $categoriaCampo = 'Ubicacion';
            $fechas = implode(',',$selectedDates);

            $sql = "SELECT * FROM config_disponibilidad WHERE (id_user = '$id') AND (nombre_campo = '$nombreCampo') ";
            $respuesta = $conn->query($sql);
            $result = $respuesta->fetch_assoc();
            
            if($result == ''){
                //si no consigue coincidencias ejecuta el statement
                $stmt->execute();    
            }else{
                //si hay coincidencia existente concatena con las fechas existentes
                
                #PRUEBA
                $fechas = getDates($result,$selectedDates);
                
                $sql2 = " UPDATE config_disponibilidad SET fechas_guardadas = concat(fechas_guardadas,',','$fechas') WHERE (`config_disponibilidad`.`id_user` = '$id') AND (`config_disponibilidad`.`nombre_campo` = '$nombreCampo')";
                $conn->query($sql2);
            }            
            
            $i++;      
        }        
        
        $i = 0;
        while($tipo_citas[$i] != ''){
            $nombreCampo = $tipo_citas[$i];
            $categoriaCampo = 'Tipo de Citas';
            $fechas = implode(',',$selectedDates);
            
            $sql = "SELECT * FROM config_disponibilidad WHERE (id_user = '$id') AND (nombre_campo = '$nombreCampo') ";
            $respuesta = $conn->query($sql);
            $result = $respuesta->fetch_assoc();
            
            if($result == ''){
                //si no consigue coincidencias ejecuta el statement
                $stmt->execute();    
            }else{
                //si hay coincidencia existente concatena con las fechas existentes
                
                #PRUEBA
                $fechas = getDates($result,$selectedDates);
                
                $sql2 = " UPDATE config_disponibilidad SET fechas_guardadas = concat(fechas_guardadas,',','$fechas') WHERE (`config_disponibilidad`.`id_user` = '$id') AND (`config_disponibilidad`.`nombre_campo` = '$nombreCampo')";
                $conn->query($sql2);
            }            
            
            $i++;      
        }
            
        
    }
?>
