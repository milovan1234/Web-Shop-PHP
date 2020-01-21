<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
    if(!isset($_POST["btn-izmeni-artikal"])){
        header("Location: ./");
    }
    require_once "rad-sa-bazom.php"; //Inkludovana konekcija na bazu podataka
    $id = $_POST["id-artikla"];
    $idGrupe = $_POST["grupa"];
    $naziv = $_POST["naziv-artikla"];
    $marka = $_POST["marka-artikla"];
    $brojStanja = $_POST["broj-artikala"];
    $cena = $_POST["cena-artikla"];
    $popust = $_POST["snizenje"];
    $opis = $_POST["opis-artikla"];
    $staraSlika = $_POST["putanja-stare-slike"];
    $query = "SELECT * FROM Artikal WHERE Id!=". $id;
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
    if(!$check) {
        $porukaGreske .= "Ne možete izmeniti podatke o artiklu tako da nastanu duplikati artikala.<br>";
    }
    $putanjaSlike = "";
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
            move_uploaded_file($file_tmp,"slike-artikala/" . $file_name);
            $putanjaSlike = "slike-artikala/" . $file_name;
        } 
    }
    else {
        $putanjaSlike = $staraSlika;
    }

    if($porukaGreske != ""){
        $_SESSION["Greska-Izmena-Artikla"] .= $porukaGreske;
    }
    else {
        $query = "UPDATE Artikal SET Naziv='$naziv', Marka='$marka',
        BrojStanja=$brojStanja, Cena=$cena, Popust=$popust, Opis='$opis', Slika='$putanjaSlike', Izmena=null WHERE Id=" . $id;
        if(mysqli_query($connection,$query)){
            $_SESSION["Uspesna-Izmena-Artikla"] = "Uspešno ste izmenili traženi Artikal!";
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }        
    }

    header("Location: izmeni-artikal.php?id-artikla=" . $id);
?>