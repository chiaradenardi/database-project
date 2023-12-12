<!DOCTYPE html>
<html>
<head>
    <title>Concerti per Biglietto</title>
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
        .concert-info {
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
    <header>
        <h1>Concerti per Biglietto</h1>
    </header>
    <div class="concert-info">
        <h2>Verifica a quale concerto puoi partecipare con il tuo biglietto</h2>

        <!-- Form per inserire il codice del biglietto -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="codice_biglietto">Codice Biglietto:</label>
            <input type="text" id="codice_biglietto" name="codice_biglietto" required>
            <input type="submit" value="Verifica">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recupera il codice del biglietto dal modulo
            $codice_biglietto = $_POST['codice_biglietto'];

            // Connessione al database
            require_once 'connection.php';

            // Query per ottenere le informazioni del concerto corrispondente al biglietto
            $query = "SELECT c.giorno AS Giorno_concerto,
                             c.ora AS ora_concerto,
                             c.titolo AS titolo_concerto,
                             c.descrizione AS descrizione_concerto
                      FROM BIGLIETTO b
                      JOIN CONCERTO c ON b.codiceOrchestra = c.codiceOrchestra AND b.giornoConcerto = c.giorno
                      WHERE b.codice_biglietto = ?";

            // Preparazione della query
            $stmt = $conn->prepare($query);

            // Associazione del valore al parametro segnaposto
            $stmt->bind_param("s", $codice_biglietto);

            // Esecuzione della query
            $stmt->execute();

            // Ottieni i risultati della query
            $result = $stmt->get_result();

            // Visualizza le informazioni del concerto corrispondente
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h3>Informazioni del concerto:</h3>";
                echo "<p><strong>Giorno:</strong> {$row['Giorno_concerto']}</p>";
                echo "<p><strong>Ora:</strong> {$row['ora_concerto']}</p>";
                echo "<p><strong>Titolo:</strong> {$row['titolo_concerto']}</p>";
                echo "<p><strong>Descrizione:</strong> {$row['descrizione_concerto']}</p>";
            } else {
                echo "<p>Il biglietto inserito non corrisponde a nessun concerto.</p>";
            }

            // Chiudi lo statement e la connessione
            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
    <footer>
        <!-- Bottone per tornare alla pagina precedente -->
        <a href="biglietti.php" class="back-button">Torna alla pagina precedente</a>
    </footer>
</body>
</html>
