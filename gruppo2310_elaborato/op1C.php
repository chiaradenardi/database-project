<!DOCTYPE html>
<html>
<head>
    <title>Aggiungi Data Concerto</title>
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
        .concert-form {
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
        <h1>Aggiungi Data Concerto</h1>
    </header>
    <div class="concert-form">
        <h2>Compila il form per aggiungere una nuova data alla stagione concertistica</h2>

        <!-- Form per aggiungere una nuova data -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <!-- Informazioni sul Concerto -->
            <h3>Informazioni sul Concerto</h3>

            <label for="ora">Ora del Concerto:</label>
            <input type="text" id="ora" name="ora" required>
            <br>
            <label for="giorno">Data del Concerto (YYYY-MM-DD):</label>
            <input type="text" id="giorno" name="giorno" required>
            <br>
            <label for="titolo">Titolo del Concerto:</label>
            <input type="text" id="titolo" name="titolo" required>
            <br>
            <label for="descrizione">Descrizione del Concerto:</label>
            <input type="text" id="descrizione" name="descrizione" required>
            <br>
            <label for="sold_out">Sold Out:</label>
            <select id="sold_out" name="sold_out" required>
                <option value="Si">Si</option>
                <option value="No">No</option>
            </select>
            <br>
            <label for="nomeEdifico">Nome Edifico:</label>
            <input type="text" id="nomeEdifico" name="nomeEdificio" required>
            <br>
            <label for="codiceOrchestra">Codice Orchestra:</label>
            <input type="text" id="codiceOrchestra" name="codiceOrchestra" required>
            <br>
            <label for="via">Via:</label>
            <input type="text" id="via" name="via" required>
            <br>
            <label for="nCivico">Numero Civico:</label>
            <input type="text" id="nCivico" name="nCivico" required>
            <br>
            <label for="cap">CAP:</label>
            <input type="text" id="cap" name="cap" required>
            <br>
            <label for="citta">Città:</label>
            <input type="text" id="citta" name="citta" required>

            <br>
            <input type="submit" value="Aggiungi Data">
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recupera i dati dal modulo
            $giorno = $_POST['giorno'];
            $ora = $_POST['ora'];
            $titolo = $_POST['titolo'];
            $descrizione = $_POST['descrizione'];
            $sold_out = $_POST['sold_out'];            
            $nomeEdificio = $_POST['nomeEdificio'];
            $codiceOrchestra = $_POST['codiceOrchestra'];
            $via = $_POST['via'];
            $nCivico = $_POST['nCivico'];
            $cap = $_POST['cap'];
            $citta = $_POST['citta'];            

            
            // Connessione al database
            require_once 'connection.php';

            // Query di inserimento per il Concerto
            $queryConcerto = "INSERT INTO Concerto (ora, giorno, titolo, descrizione, sold_out, nomeEdificio, codiceOrchestra, via, nCivico, cap, citta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Preparazione delle query
            $stmtConcerto = $conn->prepare($queryConcerto);

            // Associazione dei valori ai parametri segnaposto e inserimento dei dati
            $stmtConcerto->bind_param("sssssssssss", $ora, $giorno, $titolo, $descrizione, $sold_out, $nomeEdificio, $codiceOrchestra, $via, $nCivico, $cap, $citta);
            $stmtConcerto->execute();

            // Chiudi lo statement e la connessione
            $stmtConcerto->close();
            $conn->close();

            echo "<p>La nuova data del concerto è stata aggiunta con successo!</p>";
            }
        
        ?>
    </div>
    <footer>
        <!-- Bottone per tornare alla pagina precedente -->
        <a href="concerti.php" class="back-button">Torna alla pagina precedente</a>
    </footer>
</body>
</html>
