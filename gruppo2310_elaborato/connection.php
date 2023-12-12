<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "orch_normalizz";
    $port = "3307";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);
    
    if (!$conn) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    } else {
        echo "Connessione al database avvenuta con successo!";
    }
    
?>
