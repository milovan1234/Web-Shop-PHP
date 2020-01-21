<?php
    session_start();
    /*U slučaju da je korisnik ulogovan ne može pristupiti ovoj stranici*/
    if(isset($_SESSION["Prijavljen"])){
        header("Location: ./");
    }
    else if(!isset($_POST["btn-login"])){
        header("Location: ./");
    }
    else {
        require_once "rad-sa-bazom.php";
        $email = $_POST["email"];
        $lozinka = hash("sha256",$_POST["lozinka"]);
        $query = "SELECT * FROM Korisnik";
        $zapamtiMe = (isset($_POST["zapamti-email"])) ? true : false;
        $check_login = false;
        if($result = mysqli_query($connection,$query)){
            while($obejct = mysqli_fetch_object($result)){
                if($obejct->Email == $email && $obejct->Lozinka == $lozinka){
                    $_SESSION["Id"] = $obejct->Id;
                    $_SESSION["Status"] = $obejct->Status;
                    $_SESSION["Email"] = $obejct->Email;
                    $_SESSION["Prijavljen"] = true;
                    $check_login = true;
                    break;
                }
            }
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }
        if($check_login){
            if($zapamtiMe){
                //Postavljanje cookie-a
                setcookie("Email",$_SESSION["Email"],time() + 86400, "./");
            }
            $query = "UPDATE Korisnik SET Aktivan=1, Prijava=null WHERE Id=" . $_SESSION["Id"];
            if(mysqli_query($connection,$query)){
                echo "Uspešna prijava!";
            }
            else {
                die("Poruka o grešci: " . mysqli_error($connection));
            }
            header("Location: ./");
        }
        else {
            echo "Uneti podaci nisu tačni. Pokušaj te ponovo da se prijavite!";
            $_SESSION["Greska-Prijava"] = "Uneti podaci nisu tačni. Pokušaj te ponovo da se prijavite!";
            header("Location: login.php");
        }
    }
?>