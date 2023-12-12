<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati dal modulo di inserimento
    $ospite = $_POST['ospite'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $matricola = $_POST['matricola'];
    $ruolo = $_POST['ruolo'];

    // Connessione al database
    require_once 'connection.php';

    // Query di inserimento
    $sql = "INSERT INTO Orchestrali (ospite, nome, cognome, matricola, ruolo) VALUES (?, ?, ?, ?, ?)";

    // Preparazione della query
    $stmt = mysqli_prepare($conn, $sql);

    // Associazione dei valori ai parametri segnaposto
    mysqli_stmt_bind_param($stmt, "sssss", $ospite, $nome, $cognome, $matricola, $ruolo);

    // Esecuzione della query di inserimento
    if (mysqli_stmt_execute($stmt)) {
        // Redirezione alla pagina dell'elenco musicisti dopo l'inserimento
        header('Location: op1M.php');
        exit;
    } else {
        echo "Errore durante l'inserimento del musicista: " . mysqli_error($conn);
    }

    // Chiusura dello statement e della connessione al database
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
