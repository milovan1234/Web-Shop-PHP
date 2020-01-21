<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
    if(!isset($_POST["btn-dodaj-artikal"])){
        header("Location: ./");
    }
    require_once "rad-sa-bazom.php"; //Inkludovana konekcija na bazu podataka
    $IdGrupe = $_POST["grupa"];
    $naziv = $_POST["naziv-artikla"];
    $marka = $_POST["marka-artikla"];
    $brojStanja = $_POST["broj-artikala"];
    $cena = $_POST["cena-artikla"];
    $popust = $_POST["snizenje"];
    $opis = $_POST["opis-artikla"];

    $query = "SELECT * FROM Artikal";
    $check = true;
    if($result = mysqli_query($connection,$query)){
        while($object = mysqli_fetch_object($result)){
            if(strtolower($opis) == strtolower($object->Opis)){
                $check = false;
                break;
            }
        }
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
    $porukaGreske = "";
    $putanjaSlike = "";
    if(!$check) {
        $porukaGreske .= "Ne mozete dodati isti artikal kao što već postoji u sistemu.<br>";
    }
    if(isset($_FILES['slika']) && $_FILES['slika']['name'] != ""){
        $file_name = $_FILES['slika']['name'];
        $file_size = $_FILES['slika']['size'];
        $file_tmp = $_FILES['slika']['tmp_name'];
        $file_type = $_FILES['slika']['type'];
        $file_ext = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));            
        $expensions= array("jpeg","jpg","png","gif");
        if(in_array($file_ext,$expensions) == false){
            $porukaGreske .= "Ekstenzija slike mora biti JPG, JPEG, GIF ili PNG format.<br>";
        }
        else {
            move_uploaded_file($file_tmp,"./slike-artikala/".$file_name);
            $putanjaSlike = "./slike-artikala/".$file_name;
        } 
    }
    if($porukaGreske != ""){
        $_SESSION["Greska-Dodat-Artikal"] = $porukaGreske;
    }
    else {
        $query = "INSERT INTO Artikal VALUES(null,$IdGrupe,'$naziv','$marka',$brojStanja,0,$cena,$popust,'$opis','$putanjaSlike',1,null,null)";
        if(mysqli_query($connection,$query)){
            $_SESSION["Uspesno-Dodat-Artikal"] = "Uspešno dodat novi Artikal!";
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }
    }
    header("Location: dodaj-artikal.php");
?>