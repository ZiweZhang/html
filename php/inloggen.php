<?php
/*
 * Code zonder hash

include "var.php";

$pasnummer= $_SESSION['pasnummer'];
$pincode  = $_SESSION["pin"];

$_SESSION["error"] = NULL;

// Check connection
if (mysqli_connect_error()) {
    die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
} else {
    //connectie goed
    $sql = "SELECT Pincode FROM rekeningen WHERE Pasnummer = '$pasnummer' AND Pincode = '$pincode'";
    $sql_fout = "SELECT fout_pogingen FROM rekeningen WHERE Pasnummer = '$pasnummer'";
    $sql_update = "UPDATE rekeningen SET fout_pogingen = fout_pogingen + 1 WHERE rekeningen.Pasnummer = '$pasnummer'";
    $sql_reset = "UPDATE rekeningen SET fout_pogingen = 0 WHERE rekeningen.Pasnummer = '$pasnummer'";

    $result = mysqli_query($conn, $sql);
    $result_fout = mysqli_query($conn, $sql_fout);

    $fout_pogingen = mysqli_fetch_assoc($result_fout)["fout_pogingen"];

    if ($fout_pogingen < 3) {
        if (mysqli_num_rows($result) == 1) {
            echo "Gebruiker gevonden";
            mysqli_query($conn, $sql_reset);
            header("location: ../html/menu.php");
        } else {
            mysqli_query($conn, $sql_update);

            $result_fout = mysqli_query($conn, $sql_fout);
            $fout_pogingen = mysqli_fetch_assoc($result_fout)["fout_pogingen"];

            switch ($_SESSION["taal"]) {
                case "Nederlands":
                    $_SESSION["error"] = "Verkeerde pincode, aantal fout pogingen: " . $fout_pogingen;
                    break;
                case "Engels":
                    $_SESSION["error"] = "Wrong PIN, number of wrong attempts: " . $fout_pogingen;
                    break;
                case "Duits":
                    $_SESSION["error"] = "Falsche PIN, aantal fout pogingen: " . $fout_pogingen;
                    break;
            }
            $_SESSION["pin"] = NULL;
            header("location: ../html/pin_invoeren.php");
        }
    } else {
        switch ($_SESSION["taal"]) {
            case "Nederlands":
                $_SESSION["error"] = "Pas geblokkeerd, neem contact op met je bank!";
                break;
            case "Engels":
                $_SESSION["error"] = "Card blocked, contact your bank!";
                break;
            case "Duits":
                $_SESSION["error"] = "Karte gesperrt, kontaktieren Sie Ihre Bank!";
                break;
        }
        $_SESSION["pin"] =NULL;
        header("location: ../html/pin_invoeren.php");
    }
}

*/

include "var.php";

$pasnummer = $_SESSION['pasnummer'];
$pincode = $_SESSION["pin"];

$_SESSION["error"] = NULL;

// Check connection
if (mysqli_connect_error()) {
    die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
} else {
//connectie goed
    echo "connectie goed";

    // alle queries
    $sql = "SELECT Pincode FROM rekeningen WHERE Pasnummer = '$pasnummer'";
    $sql_fout = "SELECT fout_pogingen FROM rekeningen WHERE Pasnummer = '$pasnummer'";

    $sql_update = "UPDATE rekeningen SET fout_pogingen = fout_pogingen + 1 WHERE rekeningen.Pasnummer = '$pasnummer'";
    $sql_reset = "UPDATE rekeningen SET fout_pogingen = 0 WHERE rekeningen.Pasnummer = '$pasnummer'";

    // queries uitvoeren
    $result = mysqli_query($conn, $sql);
    $result_fout = mysqli_query($conn, $sql_fout);

    $fout_pogingen = mysqli_fetch_assoc($result_fout)["fout_pogingen"];

    //als aantal foutpogingen lager zijn dan 3
    if ($fout_pogingen < 3) {
        if (mysqli_num_rows($result) == 1) {
            // Er is 1 resultaat bij de pas
            $row = mysqli_fetch_assoc($result);
            $hashed_pincode = $row["Pincode"];

            echo "1 result gevonden";

            // checkt of pincode goed is
            if (password_verify($pincode, $hashed_pincode)) {
                //als die goed is wordt je doorgestuurd naar menu
                echo "Gebruiker gevonden";
                mysqli_query($conn, $sql_reset);
                header("location: ../html/menu.php");
            } else {
                // pincode is fout, aantal foutpogingen wordt verhoogd met 1
                mysqli_query($conn, $sql_update);

                $result_fout = mysqli_query($conn, $sql_fout);
                $fout_pogingen = mysqli_fetch_assoc($result_fout)["fout_pogingen"];

                switch ($_SESSION["taal"]) {
                    case "Nederlands":
                        $_SESSION["error"] = "Verkeerde pincode, aantal fout pogingen: " . $fout_pogingen;
                        break;
                    case "Engels":
                        $_SESSION["error"] = "Wrong PIN, number of wrong attempts: " . $fout_pogingen;
                        break;
                    case "Duits":
                        $_SESSION["error"] = "Falsche PIN, aantal fout pogingen: " . $fout_pogingen;
                        break;
                }
                $_SESSION["pin"] = NULL;

                echo "Verkeerde pincode";
                 header("location: ../html/pin_invoeren.php");
            }
        }
    } else {
        switch ($_SESSION["taal"]) {
            case "Nederlands":
                $_SESSION["error"] = "Pas geblokkeerd, neem contact op met je bank!";
                break;
            case "Engels":
                $_SESSION["error"] = "Card blocked, contact your bank!";
                break;
            case "Duits":
                $_SESSION["error"] = "Karte gesperrt, kontaktieren Sie Ihre Bank!";
                break;
        }
        $_SESSION["pin"] = NULL;
        header("location: ../html/pin_invoeren.php");
    }
}

?>

