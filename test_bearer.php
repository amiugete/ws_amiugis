<?php
require_once("read_token.php");
require_once("conn.php");


//echo "Programma di test per vedere cosa leggo\n";


// chiamo la funzione per recuperare il token
//echo "TOKEN=".getBearerToken();
//echo "\n";

// chiamo la funzione per verificare il token 
if (verifyToken($conn_api,getBearerToken())[0]==200){
    //$user=verifyToken($conn_api,getBearerToken())[1];
    //echo $user;
} else {
    die("il token ".verifyToken($conn_api,getBearerToken())[1]." non esiste o è scaduto\n\n");
}

//echo "\nPosso proseguire\n";




?>