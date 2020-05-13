<?php
include "../php/var.php";

if (ctype_alnum($_SESSION["key"])) {
    switch ($_SESSION["key"]) {
        case '1':
        case '2':
            header("location: ../php/arduino_get.php");
            break;
    }
}


switch ($_SESSION["taal"]) {
    case "Nederlands":
        $keuze = "Wilt u de transactiebon?";
        $ja = "../Pictures/nederlands/ja.png";
        $nee = "../Pictures/nederlands/nee.png";
        break;
    case "Engels":
        $keuze = "Would you like the transaction receipt?";
        $ja = "../Pictures/engels/yes.png";
        $nee = "../Pictures/engels/no.png";
        break;
    case "Duits":
        $keuze = "Möchten Sie den Transaktionsbeleg?";
        $ja = "../Pictures/duits/ja.png";
        $nee = "../Pictures/duits/nein.png";
        break;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>pin invoeren</title>
    <link href="../CSS/bonprinten.css" rel="stylesheet" type="text/css"/>
    <meta http-equiv="refresh" content="0.2">
</head>
<body>

<div class="main">
    <section class="background"></section>
    <section>
        <h1>Batbank</h1>
        <br>
        <h2><?php echo $keuze ?></h2>
        <a href="menu.php"><img src="../Pictures/algemeen/bon.png" style="width: 40%"></a>
        <br>

        <button class="keuze">
            <a href="../php/arduino_get.php"> <img src="<?php echo $ja ?>"
                                                   class="keuze_button"> </a>
            <h3>1</h3>
        </button>

        <button class="keuze">
            <a href="../php/arduino_get.php"> <img src="<?php echo $nee ?>"
                                                   class="keuze_button"> </a>

            <h3>2</h3>
        </button>

    </section>
</div>
</body>
</html>