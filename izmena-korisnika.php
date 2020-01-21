<?php
    session_start();
    /*U slučaju da je korisnik ulogovan ne može pristupiti ovoj stranici*/
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Administrator
        header("Location: ./");
    }
    else if(!isset($_POST["btn-izmeni-korisnika"])){
        header("Location: ./");
    }
    else {
        require_once "rad-sa-bazom.php";
        $id = $_POST["id-korisnika"];
        $ime = $_POST["ime"];
        $prezime = $_POST["prezime"];
        $email = $_POST["email"];
        $lozinka = ($_POST["lozinka"] != "") ? hash("sha256",$_POST["lozinka"]) : $_POST["stara-lozinka"];
        $status = $_POST["status"];
        $staraSlika = $_POST["putanja-stare-slike"];
        $poruka_greske = "";
        $putanja_slike = "";
        if(isset($_FILES['slika']) && $_FILES['slika']['name'] != ""){
            $file_name = $_FILES['slika']['name'];
            $file_size = $_FILES['slika']['size'];
            $file_tmp = $_FILES['slika']['tmp_name'];
            $file_type = $_FILES['slika']['type'];
            $file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));            
            $expensions= array("jpeg","jpg","png","gif");
            if(!in_array($file_ext,$expensions)){
                $poruka_greske .= "Ekstenzija slike mora biti JPG, JPEG, GIF ili PNG format.<br>";
            }
            else {
                move_uploaded_file($file_tmp,"slike-korisnika/".$file_name);
                $putanja_slike = "slike-korisnika/".$file_name;
            }    
        } else {
            $putanja_slike = $staraSlika;
        }      
        if($poruka_greske != ""){
            $_SESSION["Greska-Izmena-Korisnika"] = $poruka_greske;
        }
        else {            
            $query = "UPDATE Korisnik SET Ime='$ime', Prezime='$prezime', Lozinka='$lozinka', Status='$status',
            Slika='$putanja_slike', Izmena=null WHERE Id=" . $id;
            if(mysqli_query($connection,$query)){
                $_SESSION["Uspesno-Izmena-Korisnika"] = "Uspešno ste izmenili podatke o  Korisniku!";
            }
            else {
                die("Poruka o grešci: " . mysqli_error($connection));
            }           
        }
        header("Location: izmeni-korisnika.php?id-korisnika=" . $id);
    }
?>