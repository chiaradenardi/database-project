<!DOCTYPE html>
<html>
<head>
    <title>Variazione Costo Biglietti</title>
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
    </style>
</head>
<body>
    <div class="concerts-list">
    <h1>Variazione Costo Biglietti</h1>
    <p>Di quanto vuoi aumentare o diminuire il prezzo dei biglietti?</p>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="azione">Azione:</label>
        <select id="azione" name="azione">
            <option value="aumenta">Aumenta</option>
            <option value="diminuisci">Diminuisci</option>
        </select>
        <br>

        <label for="importo">Importo:</label>
        <input type="number" step="0.01" id="importo" name="importo" required>
        <br>

        <input type="submit" value="Applica">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recupera l'azione e l'importo dal modulo
        $azione = $_POST['azione'];
        $importo = $_POST['importo'];

        // Connessione al database
        require_once 'connection.php';

        if ($azione === 'aumenta') {
            // Query per aumentare il costo dei biglietti
            $query = "UPDATE Biglietto SET costo = costo + ?";
        } elseif ($azione === 'diminuisci') {
            // Query per diminuire il costo dei biglietti (assicurandoti che non diventi negativo)
            $query = "UPDATE Biglietto SET costo = CASE WHEN costo - ? >= 0 THEN costo - ? ELSE costo END";
        }

        // Preparazione della query
        $stmt = $conn->prepare($query);

        // Associazione del valore al parametro segnaposto
        $stmt->bind_param("dd", $importo, $importo);

        // Esecuzione della query di aggiornamento
        $successo = $stmt->execute();

        // Chiudi lo statement e la connessione
        $stmt->close();
        $conn->close();

        if ($successo) {
            echo "<p>Il costo dei biglietti è stato modificato con successo!</p>";
        } else {
            echo "<p>Si è verificato un errore nella modifica del costo dei biglietti. Riprova.</p>";
        }
    }
    ?>
    
    </div>

        <footer>
            <!-- Bottone per tornare alla pagina precedente -->
            <a href="biglietti.php" class="back-button">Torna alla pagina precedente</a>
        </footer></body>
</html>
