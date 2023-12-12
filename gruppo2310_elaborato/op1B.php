<!DOCTYPE html>
<html>
<head>
    <title>Acquisto Biglietto</title>
    <style>
        /* Stili CSS per il layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        .concerts-list {
            padding: 20px;
            flex-grow: 1;
        }
        .concert {
            margin-bottom: 10px;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        .back-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        footer {
            margin-top: auto; 
        }
        .concerts-list {
            padding-bottom: 0; 
        }
    </style>
</head>
<body>
    <h1>Acquisto Biglietto</h1>

    <?php
require_once 'connection.php';

// Gestione dell'invio del modulo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dal modulo
    $cf = $_POST['cf'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $numero_telefono = $_POST['numero_telefono'];
    $email = $_POST['email'];
    $eta = $_POST['eta'];
    $codice_biglietto = $_POST['codice_biglietto'];
    $zona = $_POST['zona'];
    $costo = $_POST['costo'];
    $codOrchestra = $_POST['codOrchestra'];
    $giornoConcerto = $_POST['giornoConcerto'];
    $metodo_pagamento = $_POST['metodo_pagamento'];
    $codice_sconto = $_POST['codice_sconto'];
    $descrizione_sconto = $_POST['descrizione_sconto'];
    $percentuale_sconto = $_POST['percentuale_sconto'];

    // Query di inserimento per il Cliente
    $queryCliente = "INSERT INTO Cliente (cf, nome, cognome, numero_telefono, email, eta) 
                     VALUES (?, ?, ?, ?, ?, ?)";

    // Query di inserimento per il Biglietto
    $queryBiglietto = "INSERT INTO Biglietto (codice_biglietto, zona, costo, codiceOrchestra, giornoConcerto) 
                       VALUES (?, ?, ?, ?, ?)";

    // Query di inserimento per l'Acquista
    $queryAcquista = "INSERT INTO Acquista (cf, data_acquisto, ora_acquisto, metodo_pagamento, codice_sconto, descrizione_sconto, percentuale_sconto, codice_biglietto) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Generazione della data e dell'ora correnti per l'Acquista
    $data_acquisto = date("Y-m-d");
    $ora_acquisto = date("H:i:s");

    // Preparazione delle query
    $stmtCliente = $conn->prepare($queryCliente);
    $stmtBiglietto = $conn->prepare($queryBiglietto);
    $stmtAcquista = $conn->prepare($queryAcquista);

    // Associazione dei valori ai parametri segnaposto per il Cliente
    $stmtCliente->bind_param("sssssi", $cf, $nome, $cognome, $numero_telefono, $email, $eta);

    // Associazione dei valori ai parametri segnaposto per il Biglietto
    $stmtBiglietto->bind_param("ssdis", $codice_biglietto, $zona, $costo, $codOrchestra, $giornoConcerto);

    // Associazione dei valori ai parametri segnaposto per l'Acquista
    $stmtAcquista->bind_param("ssssssss", $cf, $data_acquisto, $ora_acquisto, $metodo_pagamento, $codice_sconto, $descrizione_sconto, $percentuale_sconto, $codice_biglietto);

    // Esecuzione delle query
    $successoCliente = $stmtCliente->execute();

    // Ottieni l'ID del cliente appena inserito
    $idCliente = $stmtCliente->insert_id;

    if ($successoCliente) {
        // Esecuzione dell'inserimento nel Biglietto
        $successoBiglietto = $stmtBiglietto->execute();

        if ($successoBiglietto) {
            // Esecuzione dell'inserimento nell'Acquista
            $successoAcquista = $stmtAcquista->execute();

            if ($successoAcquista) {
                echo "<p>Acquisto effettuato con successo!</p>";
            } else {
                echo "<p>Errore durante l'acquisto. Riprova.</p>";
            }
        } else {
            echo "<p>Errore durante l'acquisto. Riprova.</p>";
        }
    } else {
        echo "<p>Errore durante l'acquisto. Riprova.</p>";
    }

    // Chiudi gli statement
    $stmtCliente->close();
    $stmtBiglietto->close();
    $stmtAcquista->close();
    $conn->close();
}
?>

    <!-- Modulo per l'acquisto del biglietto -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="cf">Codice Fiscale:</label>
        <input type="text" id="cf" name="cf" required><br>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome" required><br>

        <label for="numero_telefono">Numero di Telefono:</label>
        <input type="text" id="numero_telefono" name="numero_telefono" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="eta">Età:</label>
        <input type="number" id="eta" name="eta" required><br>

        <label for="codice_biglietto">Codice Biglietto:</label>
        <input type="text" id="codice_biglietto" name="codice_biglietto" required><br>

        <label for="zona">Zona del Biglietto:</label>
        <input type="text" id="zona" name="zona" required><br>

        <label for="costo">Costo del Biglietto:</label>
        <input type="number" step="0.01" id="costo" name="costo" required><br>

        <label for="codOrchestra">Codice Orchestra:</label>
        <input type="text" id="codOrchestra" name="codOrchestra" required><br>

        <label for="giornoConcerto">Data del Concerto (YYYY-MM-DD):</label>
        <input type="text" id="giornoConcerto" name="giornoConcerto" required><br>

        <label for="metodo_pagamento">Metodo di Pagamento:</label>
        <input type="text" id="metodo_pagamento" name="metodo_pagamento" required><br>

        <label for="codice_sconto">Codice Sconto:</label>
        <input type="text" id="codice_sconto" name="codice_sconto"><br>

        <label for="descrizione_sconto">Descrizione Sconto:</label>
        <input type="text" id="descrizione_sconto" name="descrizione_sconto"><br>

        <label for="percentuale_sconto">Percentuale Sconto:</label>
        <input type="number" step="0.01" id="percentuale_sconto" name="percentuale_sconto"><br>

        <input type="submit" value="Acquista">
    </form>

    
    <footer>
        <!-- Bottone per tornare alla home page -->
        <a href="biglietti.php" class="back-button">Torna alla pagina precedente</a>
    </footer>
</body>
</html>