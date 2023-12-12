<?php
// Verifica se la matricola è stata passata tramite il parametro GET
if (isset($_GET['matricola'])) {
    // Recupera la matricola dalla query string
    $matricola = $_GET['matricola'];

    // Connessione al database
    require_once 'connection.php';

    // Query di eliminazione
    $sql = "DELETE FROM Orchestrali WHERE matricola = ?";

    // Preparazione della query
    $stmt = mysqli_prepare($conn, $sql);

    // Associazione del valore della matricola al parametro segnaposto
    mysqli_stmt_bind_param($stmt, "s", $matricola);

    // Esecuzione della query di eliminazione
    if (mysqli_stmt_execute($stmt)) {
        // Redirezione alla pagina dell'elenco musicisti dopo l'eliminazione
        header('Location: op1M.php');
        exit;
    } else {
        echo "Errore durante l'eliminazione del musicista: " . mysqli_error($conn);
    }

    // Chiusura dello statement e della connessione al database
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
