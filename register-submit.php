<?php
    session_start();
    /*U slučaju da je korisnik ulogovan ne može pristupiti ovoj stranici*/
    if(isset($_SESSION["Prijavljen"])){
        header("Location: ./");
    }
    else if(!isset($_POST["btn-register"])){
        header("Location: ./");
    }
    else {
        require_once "rad-sa-bazom.php"; /*Inkludovanje datoteke i funkcije za rad sa bazom podataka.*/

        $ime = $_POST["ime"];
        $prezime = $_POST["prezime"];
        $email = $_POST["email"];
        $lozinka = hash("sha256",$_POST["lozinka"]);
        $status = "Kupac";
        $putanja_slike = "";

        $query = "SELECT * FROM Korisnik";
        $check_email = false;
        $poruka_greske = "";
        if($result = mysqli_query($connection,$query)){
            while($object = mysqli_fetch_object($result)){
                if($object->Email == $email){
                    $check_email = true;
                    break;
                }
            }
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }
        if($check_email){
            $poruka_greske .= "Korisnik sa unesenom e-mail adresom već postoji. Pokušajte sa izmenom!<br>";
        }        
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
                    move_uploaded_file($file_tmp,"slike-korisnika/".$file_name);
                    $putanja_slike = "slike-korisnika/".$file_name;
                }    
        } else {
            $putanja_slike = "slike-korisnika/customer.jpg";
        }
        if($poruka_greske != ""){
            $_SESSION["Greska-Regsitracija"] = $poruka_greske;
            header("Location: register.php");
        }
        else {            
            $query = "INSERT INTO Korisnik VALUES(null,'$ime','$prezime','$email','$lozinka','$status','$putanja_slike',0,null,null)";
            if(mysqli_query($connection,$query)){
                echo "Uspešno ste se registrovali. Pređite na stranu za prijavu!";
            }
            else {
                die("Poruka o grešci: " . mysqli_error($connection));
            }
            $_SESSION["Uspesno-Registracija"] = "Uspešno ste se registrovali. Pređite na stranu za prijavu!";
            header("Location: register.php");
        }
    }
?>