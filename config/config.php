<?php
// session_start();

    // //use this in config file to ensure that this file is restrict from access in 

    // if(!isset($_SERVER['HTTP_REFERER'])){
    //     //redirect them to desired location
    //     header('location: http://localhost/Noshi/index.php');
    //     exit;
    // }


try{
    


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

    // if($conn == true){
    //     echo "Connected Successfully";
    // } else{
    //     echo "Erro Connection";
    // }

} catch(PDOException $e){
    echo $e-> getMessage();
}