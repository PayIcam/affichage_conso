<?php 

session_start(); 

$_SESSION['datetime'] = $_POST['date'] . " " . $_POST['time'];

$_SESSION['val0'] = 0;
$_SESSION['val1'] = 0;
$_SESSION['val2'] = 0;
$_SESSION['val3'] = 0;
$_SESSION['val4'] = 0;
$_SESSION['val5'] = 0;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/animation.css" />
        <title>Compteur bar ICAM</title>
    </head>

    <body>
        <h3>Consommés ce soir</h3>
        <ul>
            <li id="item0"><h1 id="name0">i0</h1><h2 id="price0">p0</h2></li>
            <li id="item1"><h1 id="name1">i1</h1><h2 id="price1">p1</h2></li>
            <li id="item2"><h1 id="name2">i2</h1><h2 id="price2">p2</h2></li>
            <li id="item3"><h1 id="name3">i3</h1><h2 id="price3">p3</h2></li>
            <li id="item4"><h1 id="name4">i4</h1><h2 id="price4">p4</h2></li>
        </ul>

        <img src="img/payicam.png">

        <script type="text/javascript" src="js/oXHR.js"></script>
        <script type="text/javascript" src="js/counter.js"></script>
    </body>
</html>