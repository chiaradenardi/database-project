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
                <li><a href="op1B.php">Registrare l’acquisto di un nuovo biglietto 
                    per una data del concerto da parte di un cliente</a></li>
                <li><a href="op2B.php">Mostrare a che concerto può andare una 
                    persona con un certo biglietto</a></li>
                <li><a href="op3B.php">Aumentare il prezzo di 
                    tutti i biglietti di 5 euro</a></li>
            </ul>
            <!-- Bottone per tornare alla home page -->
            <br>
            <a href="prova.php">Torna alla Home Page</a>
        </div>
        <div class="concerts-list">
           <!-- Titolo della sezione degli elenchi dei concerti -->
           <h2>Seleziona biglietti</h2>
        </div>
    </div>
</body>
</html
