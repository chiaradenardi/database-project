<!DOCTYPE html>
<html>
<head>
    <title>Cerca Concerti</title>
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
        <h1>Cerca Concerti</h1>
    </header>

    <!-- Contenuto principale -->
    <div class="content">
        <h2>Seleziona una città per cercare i concerti e i musicisti presenti:</h2>
        <!-- Form per la ricerca dei concerti -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="citta">Città:</label>
            <input type="text" id="citta" name="citta" required>
            <input type="submit" value="Cerca">
        </form>

        <?php
        // Verifica se è stata inviata una richiesta di ricerca
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recupera la città inserita nel form
            $citta = $_POST['citta'];

            // Esegui la query per cercare i concerti nella città specificata
            require_once 'connection.php'; 

            $query = "SELECT c.citta, c.giorno, c.titolo, o.nome, o.cognome, o.ruolo
                      FROM Concerto c
                      JOIN Inclusione i ON c.codiceOrchestra = i.codiceOrchestra
                      JOIN Orchestrali o ON i.matricolaOrchestrali = o.matricola
                      WHERE c.citta = ?";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $citta);
            $stmt->execute();
            $result = $stmt->get_result();

            // Mostra i risultati della query
            if ($result->num_rows > 0) {
                echo "<h3>Risultati della ricerca:</h3>";
                echo "<table>";
                echo "<tr><th>Città</th><th>Giorno</th><th>Titolo</th><th>Nome</th><th>Cognome</th><th>Ruolo</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['citta']}</td><td>{$row['giorno']}</td><td>{$row['titolo']}</td><td>{$row['nome']}</td><td>{$row['cognome']}</td><td>{$row['ruolo']}</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Nessun concerto trovato per la città: $citta</p>";
            }

            // Chiudi lo statement e la connessione
            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
    <footer>
        <!-- Bottone per tornare alla home page -->
        <a href="concerti.php" class="back-button">Torna alla pagina precedente</a>
    </footer>
</body>
</html>