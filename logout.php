<?php
    session_start();
    if(!isset($_SESSION["Prijavljen"])){
        header("Location: ./");
    }
    else {
        require_once "rad-sa-bazom.php";
        $query = "UPDATE Korisnik SET Aktivan=0 WHERE Id=" . $_SESSION["Id"];
        if(mysqli_query($connection,$query)){
            echo "Uspesno ste se odjavili!";
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }
        setcookie("Email","", time() - 1);
        header("Location: ./");
        session_destroy();
    }
?>