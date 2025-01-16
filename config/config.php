<?php


    //Database Setup
    //host 
    define("HOST", "localhost");

    //dbname
    define("DBNAME", "noshi");

    //user
    define("USER","root");

    //password
    define("PASS","");

    $conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME.";", USER, PASS);

    if($conn == true){
        echo "Connected Successfully";
    } else{
        echo "Erro Connection";
    }

