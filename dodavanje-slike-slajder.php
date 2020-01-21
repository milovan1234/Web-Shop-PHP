<?php
    session_start();
    /*U slučaju da je korisnik ulogovan ne može pristupiti ovoj stranici*/
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Administrator
        header("Location: ./");
    }
    else if(!isset($_POST["btn-dodaj-sliku"])){
        header("Location: ./");
    }
    else {
        require_once "rad-sa-bazom.php";
        $status = $_POST["status"];
        $poruka_greske = "";    
        $putanja_slike = "";    
        if(isset($_FILES['slika']) && $_FILES['slika']['name'] != ""){
            $file_name = $_FILES['slika']['name'];
            $file_size = $_FILES['slika']['size'];
            $file_tmp = $_FILES['slika']['tmp_name'];
            $file_type = $_FILES['slika']['type'];
            $file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));            
            $expensions= array("jpeg","jpg","png","gif");
            $check_img = true;
            if(!in_array($file_ext,$expensions)){
                $poruka_greske .= "Ekstenzija slike mora biti JPG, JPEG, GIF ili PNG format.<br>";
                $check_img = false;
            }
            if($check_img){
                move_uploaded_file($file_tmp,"slike-slajder/".$file_name);
                $putanja_slike = "slike-slajder/".$file_name;
            }    
        } 
        $query = "SELECT * FROM Slajder";
        if($result = mysqli_query($connection,$query)){
            while($object = mysqli_fetch_object($result)){
                if($putanja_slike == $object->Slika){
                    $poruka_greske .= "Slika koju ste odabrali već postoji u sistemu.<br>";
                    break;
                }
            }
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }
        if($poruka_greske != ""){
            $_SESSION["Greska-Dodata-Slika"] = $poruka_greske;
        }
        else {
            $query = "INSERT INTO Slajder VALUES(null,'$putanja_slike', $status,null,null)";
            if(mysqli_query($connection,$query)){
                $_SESSION["Uspesno-Dodata-Slika"] = "Uspešno ste dodali novu sliku za slajder!";
            }
            else {
                die("Poruka o grešci: " . mysqli_error($connection));
            }
        }
        header("Location: dodaj-sliku-slajder.php");
    }
?>