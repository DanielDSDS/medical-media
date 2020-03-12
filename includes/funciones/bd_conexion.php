<?php

    //Se crea la conexion con la base de datos SQL
    $conn = mysqli_init();
    $mysql_host = 'localhost';
    $mysql_user = 'root';
    $mysql_password = 'root';
    $mysql_db = 'db_pagina';

    mysqli_real_connect($conn,$mysql_host, $mysql_user, $mysql_password, $mysql_db, '8889');

    if($conn->connect_error){
        echo $error = $conn->connect_error;
    }
?>