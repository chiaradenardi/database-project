<!DOCTYPE html>
<html>
<head>
    <title>Scaletta dei Brani</title>
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
        <h1>Scaletta dei Brani</h1>
    </header>

    <!-- Contenuto principale -->
    <div class="content">
        <h2>Elenco della scaletta dei brani di un concerto con un certo direttore musicale:</h2>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="nome">Nome Direttore:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="cognome">Cognome Direttore:</label>
            <input type="text" id="cognome" name="cognome" required>
            <input type="submit" value="Cerca Scaletta">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recupera i dati dal modulo
            $nomeDirettore = $_POST['nome'];
            $cognomeDirettore = $_POST['cognome'];

            // Esegui la query per mostrare l'elenco della scaletta dei brani
            require_once 'connection.php'; 

            $query = "SELECT rb.ordine_Brani, br.titolo, br.durata, co.titolo AS titolo_concerto, co.giorno, co.citta, orr.nome, orr.cognome 
                      FROM rappresentati rb
                      JOIN Concerto co ON rb.codiceOrchestra = co.codiceOrchestra AND rb.giornoConcerto = co.giorno
                      JOIN Brano br ON rb.codiceBrano = br.codiceBrano
                      JOIN Orchestra orc ON co.codiceOrchestra = orc.codiceOrchestra
                      JOIN Inclusione inc ON orc.codiceOrchestra = inc.codiceOrchestra
                      JOIN Orchestrali orr ON inc.matricolaOrchestrali = orr.matricola
                      WHERE orr.nome = ? AND orr.cognome = ?
                      ORDER BY rb.ordine_Brani";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $nomeDirettore, $cognomeDirettore);
            $stmt->execute();
            $result = $stmt->get_result();

            // Mostra i risultati della query
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Ordine Brani</th><th>Titolo Brano</th><th>Durata</th><th>Titolo Concerto</th><th>Giorno</th><th>Città</th><th>Nome Direttore</th><th>Cognome Direttore</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['ordine_Brani']}</td><td>{$row['titolo']}</td><td>{$row['durata']}</td><td>{$row['titolo_concerto']}</td><td>{$row['giorno']}</td><td>{$row['citta']}</td><td>{$row['nome']}</td><td>{$row['cognome']}</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Nessun risultato trovato per il direttore musicale specificato.</p>";
            }

            // Chiudi lo statement e la connessione
            $stmt->close();
            $conn->close();
        }
        ?>
    </div>

    <!-- Footer con il pulsante per tornare indietro -->
    <footer>
        <!-- Bottone per tornare alla home page -->
        <a href="concerti.php" class="back-button">Torna alla pagina precedente</a>
    </footer>
</body>
</html>
