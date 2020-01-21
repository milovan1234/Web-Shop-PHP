<?php
    session_start();
    /*U slučaju da je korisnik ulogovan ne može pristupiti ovoj stranici*/
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Administrator
        header("Location: ./");
    }
    if(!isset($_GET["id-korisnika"])){
        header("Location: ./");
    }
    require_once "rad-sa-bazom.php";
    $query = "DELETE FROM Korisnik WHERE Id=" . $_GET["id-korisnika"];
    if(mysqli_query($connection,$query)){
        echo "Uspešno ste obrisali izabranog Korisnika!";
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
    header("Location: svi-korisnici.php?broj-strane=1");
?>