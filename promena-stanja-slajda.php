<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
    if(!isset($_GET["id-slike"]) || !isset($_GET["status"])){
        header("Location: slajder-pocetna.php");
    }
    $id = $_GET["id-slike"];
    $status = $_GET["status"];
    require_once "rad-sa-bazom.php";
    $query = "UPDATE Slajder SET Aktivna=$status, Izmena=null WHERE Id=" . $id;
    if(mysqli_query($connection,$query)){
        echo "Uspešno izmenjeno stanje slike!";
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
?>