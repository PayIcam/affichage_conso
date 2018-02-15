<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/style.css" />
        <title>Compteur bar ICAM</title>
    </head>

    <body>
        <form action="trader.php" method="post">
            <p>Choisissez la date de début</p>
            <input type="date" name="date" required>
            <input type="time" name="time" required>
            <button type="submit">Démarrer le compteur</button>
        </form>
    </body>
</html>