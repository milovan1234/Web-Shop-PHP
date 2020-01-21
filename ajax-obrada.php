<?php
    session_start();
    require_once "rad-sa-bazom.php";
    require_once "klase.php";

    if(isset($_GET["funkcija"])){
        $funkcija = $_GET["funkcija"];
        switch($funkcija){
            case "markeZaNaziv":
                $naziv = $_POST["naziv"];
                $grupa = $_POST["grupa"];
                $query = "";
                if($naziv != "")
                    $query = "SELECT * FROM Artikal WHERE Aktivan=1 AND Naziv='$naziv' AND IdGrupe IN(
                        SELECT Id FROM Grupa WHERE Naziv='$grupa')";
                else
                    $query = "SELECT * FROM Artikal WHERE Aktivan=1 AND IdGrupe IN(
                        SELECT Id FROM Grupa WHERE Naziv='$grupa')";
                $markeArtikala = array();
                if($result = mysqli_query($connection,$query)){
                    while($object = mysqli_fetch_object($result)){
                        $markeArtikala[] = $object->Marka;
                    }
                }
                else {
                    die("Poruka o grešci: " . mysqli_error($connection));
                }
                $markeArtikala = array_values(array_unique($markeArtikala));
                echo json_encode($markeArtikala);
                break;
            case "naziviZaMarku":
                $marka = $_POST["marka"];
                $grupa = $_POST["grupa"];
                $query = "";
                if($marka != "")
                    $query = "SELECT * FROM Artikal WHERE Aktivan=1 AND Marka='$marka' AND IdGrupe IN(
                        SELECT Id FROM Grupa WHERE Naziv='$grupa')";
                else
                    $query = "SELECT * FROM Artikal WHERE Aktivan=1 AND IdGrupe IN(
                        SELECT Id FROM Grupa WHERE Naziv='$grupa')";
                $naziviArtikla = array();
                if($result = mysqli_query($connection,$query)){
                    while($object = mysqli_fetch_object($result)){
                        $naziviArtikla[] = $object->Naziv;
                    }
                }
                else {
                    die("Poruka o grešci: " . mysqli_error($connection));
                }
                $naziviArtikla = array_values(array_unique($naziviArtikla));
                echo json_encode($naziviArtikla);
                break;
            case "dodajKorpa":
                $idArtikla = $_POST["id-artikla"];
                $query = "SELECT * FROM Artikal WHERE Id=" . $idArtikla;
                $artikal = new Artikal();
                if($result = mysqli_query($connection,$query)){
                    $object = mysqli_fetch_object($result);
                    if($object->BrojStanja == 0){
                        echo json_encode("Greska-BrojStanja");
                        exit();
                    }
                    $artikal->cenaSaPopustom = ($object->Cena - ($object->Cena*($object->Popust/100)));
                }
                else {
                    die("Poruka o grešci: " . mysqli_error($connection));
                }
                if(!isset($_SESSION["Artikli-Korpa"])){
                    $_SESSION["Artikli-Korpa"][0] = array("id" => $idArtikla,"cena" => $artikal->cenaSaPopustom);
                }
                else {
                    $count = count($_SESSION["Artikli-Korpa"]);
                    $check = false;
                    for($i = 0; $i < $count; $i++){
                        if($_SESSION["Artikli-Korpa"][$i]["id"] == $idArtikla){
                            $check = true;
                        }
                    }
                    if(!$check){
                        $_SESSION["Artikli-Korpa"][$count] = array("id" => $idArtikla,"cena" => $artikal->cenaSaPopustom);
                    }
                    else {
                        echo json_encode("Greska-Postoji");
                        exit();
                    }
                }  
                echo json_encode($_SESSION["Artikli-Korpa"]);
                break;
            case "brisanjeArtiklaKorpa":
                $idArtikla = $_POST["id-artikla"];
                $artikliKorpa = array();
                for($i = 0; $i < count($_SESSION["Artikli-Korpa"]); $i++){
                    if($_SESSION["Artikli-Korpa"][$i]["id"] != $idArtikla){
                        $artikliKorpa[] = $_SESSION["Artikli-Korpa"][$i];
                    }
                }
                $_SESSION["Artikli-Korpa"] = $artikliKorpa;
                echo json_encode($_SESSION["Artikli-Korpa"]);
                break;
            case "kupovinaProizvoda":
                $racun = json_decode($_POST["racun"]);
                $artikli = $racun->artikli;
                $brojKupljenih = 0;
                foreach($artikli as $a){
                    $query = "SELECT * FROM Artikal WHERE Id=" . $a->idArtikla;
                    if($result = mysqli_query($connection,$query)){
                        $object = mysqli_fetch_object($result);
                        $brojstanja = intval($object->BrojStanja) -  intval($a->kolicina);
                        $prodato = intval($object->Prodato) + intval($a->kolicina);
                        $query1 = "UPDATE Artikal SET BrojStanja=$brojstanja, Prodato=$prodato WHERE Id=" . $a->idArtikla;
                        if(!mysqli_query($connection,$query1)){
                            die("Poruka o grešci: " . mysqli_error($connection));
                        }
                        $brojKupljenih += $a->kolicina;
                    }
                    else {
                        die("Poruka o grešci: " . mysqli_error($connection));
                    }
                }
                $id = $_SESSION["Id"];
                $query = "SELECT * FROM Korisnik WHERE Id=" . $id;
                $korisnik = new Korisnik();
                if($result = mysqli_query($connection,$query)){
                    $object = mysqli_fetch_object($result);
                    $korisnik->id = $object->Id;
                    $korisnik->ime = $object->Ime;
                    $korisnik->prezime = $object->Prezime;
                    $korisnik->email = $object->Email;
                    $korisnik->status = $object->Status;
                    $korisnik->putanjaSlike = $object->Slika;
                    $korisnik->aktivan = $object->Aktivan;
                    $korisnik->datumPrijave = $object->Prijava;
                }
                else {
                    die("Poruka o grešci: " . mysqli_error($connection));
                }                
                $_SESSION["Uspesna-Kupovina"] = true;
                $transakcija = array();
                if (file_exists("racuni/racuni.json")) {
                    $racuniJson = (array)json_decode(file_get_contents("racuni/racuni.json"));
                    $transakcija = ["brojTransakcije" => count($racuniJson)+1, "datum" => date("d.m.Y H:i"),"idKupca" => $korisnik->id,"imePrezime" => $korisnik->ime . " " . $korisnik->prezime,
                            "brojKupljenih" => $brojKupljenih,"kupljeniArtikli" => $racun->artikli,"ukupnaCena" => $racun->ukupnaCena];
                    $racuniJson[] = $transakcija;
                    file_put_contents("racuni/racuni.json", json_encode($racuniJson));
                } else {
                    file_put_contents("racuni/racuni.json", json_encode(array()));
                    $racuniJson = (array)json_decode(file_get_contents("racuni/racuni.json"));
                    $transakcija = ["brojTransakcije" => count($racuniJson)+1, "datum" => date("d.m.Y H:i"),"idKupca" => $korisnik->id,"imePrezime" => $korisnik->ime . " " . $korisnik->prezime,
                            "brojKupljenih" => $brojKupljenih,"kupljeniArtikli" => $racun->artikli,"ukupnaCena" => $racun->ukupnaCena];
                    $racuniJson[] = $transakcija;
                    file_put_contents("racuni/racuni.json", json_encode($racuniJson));
                }
                unset($_SESSION["Artikli-Korpa"]);
                echo json_encode($transakcija);
                break;
            default:
                break;
        }
    }
?>