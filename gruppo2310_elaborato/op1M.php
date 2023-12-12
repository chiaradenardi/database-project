<!DOCTYPE html>
<html>
<head>
    <title>Concerti</title>
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
    </style>
</head>
<body>
    <header>
        <h1>Concerti Info</h1>
    </header>
    <div class="concerts-list">
    <!-- Titolo della sezione degli elenchi dei concerti -->
    <h2>Elenco Musicisti</h2>
    <h4>Puoi selezionare i musicisti/direttori presenti in una certa orchestra</h4>

    <!-- Form per selezionare l'orchestra -->
    <form id="filterForm" method="post">
        <label for="codiceOrchestra">Codice Orchestra:</label>
        <input type="text" id="codiceOrchestra" name="codiceOrchestra" required>
        <input type="submit" value="Filtra">
    </form>

    <table>
        <tr>
            <th>Ospite</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Matricola</th>
            <th>Ruolo</th>
            <th>Azioni</th>
        </tr>

        <!-- Elenco dei concerti tramite query al database -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recupera il codice orchestra dal form
        $codiceOrchestra = $_POST['codiceOrchestra'];

        // Connessione al database
        require_once 'connection.php';

        // Query di selezione dei musicisti presenti nella determinata orchestra
        $sql = "SELECT o.*
        FROM Orchestrali o
        JOIN Inclusione i ON o.matricola = i.matricolaOrchestrali
        WHERE i.codiceOrchestra = ?";

        // Preparazione della query
        $stmt = mysqli_prepare($conn, $sql);

        // Associazione del valore ai parametri segnaposto
        mysqli_stmt_bind_param($stmt, "s", $codiceOrchestra);

        // Esecuzione della query
        mysqli_stmt_execute($stmt);

        // Ottieni i risultati della query
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['ospite']}</td>";
                echo "<td>{$row['nome']}</td>";
                echo "<td>{$row['cognome']}</td>";
                echo "<td>{$row['matricola']}</td>";
                echo "<td>{$row['ruolo']}</td>";
                echo "<td><a href='elimina.php?matricola={$row['matricola']}'>Elimina</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nessun musicista trovato</td></tr>";
        }

        // Chiusura della connessione
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
?>
    </table>

         <script>
        function filterMusicisti() {
            const codiceOrchestra = document.getElementById("codiceOrchestra").value;

            // Esegui una richiesta AJAX al server per ottenere i musicisti filtrati
            // e aggiorna la tabella
            fetch(`/api/musicisti?codiceOrchestra=${codiceOrchestra}`)
                .then(response => response.json())
                .then(data => updateTable(data))
                .catch(error => console.error('Errore nella richiesta AJAX:', error));
        }

        function updateTable(musicisti) {
            // Svuota la tabella
            const table = document.getElementById("musicistiTable");
            table.innerHTML = "";

            // Aggiungi i musicisti filtrati alla tabella
            musicisti.forEach(musicista => {
                const row = table.insertRow();
                row.insertCell().innerText = musicista.ospite;
                row.insertCell().innerText = musicista.nome;
                row.insertCell().innerText = musicista.cognome;
                row.insertCell().innerText = musicista.matricola;
                row.insertCell().innerText = musicista.ruolo;
            });
        }
        </script>

         <h2>Inserisci nuovo musicista</h2>
        <form action="inserisci.php" method="post">
        <label for="opsite">Opsite:</label>
            <input type="text" id="opsite" name="ospite" required>
            <br>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <br>
            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome" required>
            <br>
            <label for="matricola">Matricola:</label>
            <input type="text" id="matricola" name="matricola" required>
            <br>
            <label for="ruolo">Ruolo:</label>
            <input type="text" id="ruolo" name="ruolo" required>
            <br>
            <input type="submit" value="Inserisci">
        </form>

    </div>
    <footer>
        <!-- Bottone per tornare alla home page -->
        <a href="musicisti.php" class="back-button">Torna alla pagina precedente</a>
    </footer>
</body>
</html>