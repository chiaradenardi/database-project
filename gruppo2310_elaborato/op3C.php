<!DOCTYPE html>
<html>
<head>
    <title>Serate Sold Out</title>
    <!-- Stili CSS -->
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
        .content {
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
    <!-- Header -->
    <header>
        <h1>Serate Sold Out</h1>
    </header>

    <!-- Contenuto principale -->
    <div class="content">
        <h2>Serate con Sold Out e numero dei biglietti venduti:</h2>

        <?php
        // Esegui la query per mostrare le serate sold out e il numero dei biglietti venduti

        require_once 'connection.php';

        $query = "SELECT c.giorno, c.ora, c.titolo, COUNT(a.codice_biglietto) AS Biglietti_venduti
                  FROM Concerto c
                  JOIN Biglietto b ON c.codiceOrchestra = b.codiceOrchestra AND c.giorno = b.giornoConcerto
                  JOIN Acquista a ON b.codice_biglietto = a.codice_biglietto
                  WHERE c.sold_out = 'si'
                  GROUP BY c.giorno, c.ora, c.titolo";

        $result = $conn->query($query);

        // Mostra i risultati della query
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Giorno</th><th>Ora</th><th>Titolo</th><th>Biglietti Venduti</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['giorno']}</td><td>{$row['ora']}</td><td>{$row['titolo']}</td><td>{$row['Biglietti_venduti']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nessuna serata sold out trovata.</p>";
        }

        // Chiudi la connessione
        $conn->close();
        ?>
    </div>

    <!-- Footer con il pulsante per tornare indietro -->
    <footer>
        <!-- Bottone per tornare alla home page -->
        <a href="concerti.php" class="back-button">Torna alla pagina precedente</a>
    </footer>
</body>
</html>
