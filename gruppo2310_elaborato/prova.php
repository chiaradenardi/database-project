<?php
require_once 'connection.php';

// Chiudi la connessione al database
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Stagione concertistica 2023</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        .container {
            display: flex;
            height: 100vh;
        }
        .section {
            flex: 1;
            padding: 20px;
            text-align: center;
            background-color: #f2f2f2;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .section:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1>Stagione concertistica 2023</h1>
    </header>
    <div class="container">
        <div class="section" onclick="window.location.href='concerti.php'">
            <h2>Concerto</h2>
        </div>
        <div class="section" onclick="window.location.href='biglietti.php'">
            <h2>Biglietti</h2>
        </div>
        <div class="section" onclick="window.location.href='musicisti.php'">
            <h2>Musicisti</h2>
        </div>
    </div>
</body>
</html>
