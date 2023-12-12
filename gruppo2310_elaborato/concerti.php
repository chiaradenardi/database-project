<!DOCTYPE html>
<html>
<head>
    <title>Concerti Info</title>
    <style>
        /* CSS per definire il layout */
        body {
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        .main-section {
            display: flex;
            flex: 1;
        }

        .left-section {
            flex: 1;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .concerts-list {
            flex: 2;
            padding: 20px;
        }

        /* Aggiungi altri stili a tuo piacimento */
    </style>
</head>
<body>
    <header>
        <h1>Concerti Info</h1>
    </header>
    <div class="main-section">
        <div class="left-section">
            <!-- Sezione verticale a sinistra con 4 link -->
            <h2>Links</h2>
            <ul>
                <li><a href="op1C.php">Aggiungere una nuova data alla 
                    stagione concertistica con relative informazioni</a></li>
                <li><a href="op2C.php">Cercare la città, il giorno e l’ora dei concerti che si terranno in 
                    una certa città, esplicitando anche nome e cognome degli orchestrali</a></li>
                <li><a href="op3C.php">Mostrare tutte le serate in cui 
                    c’è sold out, specificando il numero dei biglietti venduti </a></li>
                <li><a href="op4C.php">Mostrare l’elenco della scaletta dei brani di 
                    un concerto in cui è presente un certo direttore musicale </a></li>
            </ul>
            <!-- Bottone per tornare alla home page -->
            <br>
            <a href="prova.php">Torna alla Home Page</a>

        </div>
        <div class="concerts-list">
           <!-- Titolo della sezione degli elenchi dei concerti -->
           <h2>Seleziona concerti</h2>
        </div>

    </div>
</body>
</html
