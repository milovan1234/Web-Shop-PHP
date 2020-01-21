<?php
    session_start();
    /*U slučaju da je korisnik ulogovan ne može pristupiti ovoj stranici*/
    if(!(isset($_SESSION["Prijavljen"]))){ //Provera da li je prijavljeni korisnik Administrator
        header("Location: ./");
    }
    else if(!isset($_POST["btn-izmeni-profil"])){
        header("Location: ./");
    }
    else {
        require_once "rad-sa-bazom.php";
        echo $_POST["stara-lozinka"];
        $ime = $_POST["ime"];
        $prezime = $_POST["prezime"];
        $novaLozinka = $_POST["nova-lozinka"];
        $check = false;
        $poruka_greske = "";
        if(isset($_POST["stara-lozinka"]) && $_POST["stara-lozinka"] != ""){
            $staraLozinka = $_POST["stara-lozinka"];
            $query = "SELECT * FROM Korisnik WHERE Id=" . $_SESSION["Id"];
            if($result = mysqli_query($connection,$query)){
                $object = mysqli_fetch_object($result);
                if(hash("sha256",$staraLozinka) == $object->Lozinka){
                    $check = true;
                }
            }
            else {
                die("Poruka o grešci: " . mysqli_error($connection));
            }
        }
        if(!$check && $_POST["stara-lozinka"] != ""){
            $poruka_greske .= "Uneli ste neipsravnu staru lozinku. Pokušajte ponovo!<br>";
        }
        else if($check && $_POST["stara-lozinka"] != "") {
            if(isset($_POST["nova-lozinka"]) && $_POST["nova-lozinka"] == ""){
                $poruka_greske .= "Niste uneli novu željenu lozinku. Pokušajte ponovo!<br>";
            }
        }
        if($poruka_greske != ""){
            $_SESSION["Greska-Izmena-Profila"] = $poruka_greske;
        }
        else {
            $query = "";
            if($novaLozinka != ""){
                $novaLozinka = hash("sha256", $novaLozinka);
                $query = "UPDATE Korisnik SET Ime='$ime', Prezime='$prezime', Lozinka='$novaLozinka', Izmena=null WHERE Id=" . $_SESSION["Id"];
            }
            else {
                $query = "UPDATE Korisnik SET Ime='$ime', Prezime='$prezime', Izmena=null WHERE Id=" . $_SESSION["Id"];
            }           
            if(mysqli_query($connection,$query)){
                $_SESSION["Uspesno-Izmena-Profila"] = "Uspešno ste izmenili svoje profil podatke!";
            }
            else {
                die("Poruka o grešci: " . mysqli_error($connection));
            }            
        }
        header("Location: profil-korisnika.php");
    }
?>