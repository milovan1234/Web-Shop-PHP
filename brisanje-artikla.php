<?php
    session_start();
    /*U slučaju da je korisnik ulogovan ne može pristupiti ovoj stranici*/
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Administrator
        header("Location: ./");
    }
    if(!isset($_GET["id-artikla"])){
        header("Location: ./");
    }
    require_once "rad-sa-bazom.php";
    $query = "UPDATE Artikal SET Aktivan=0 WHERE Id=" . $_GET["id-artikla"];
    if(mysqli_query($connection,$query)){
        echo "Uspešno ste obrisali izabrani Artikal!";
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
    header("Location: svi-artikli.php?naziv-grupe=Bela tehnika&broj-strane=1");
?>