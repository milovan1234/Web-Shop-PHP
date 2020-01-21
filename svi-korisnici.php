<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
    if(!isset($_GET["broj-strane"])){ //Provera da li je setovan broj strane na ovoj stranici
        header("Location: ./");
    } 

    require_once "rad-sa-bazom.php"; //Dodavanja svih potrebnih elemenata za rad sa bazom
    require_once "klase.php"; //Dodavanje fajla u kome se nalaze klase preko kojih kreiramo objekte
    require_once "funkcije.php"; //Dodavanje fajla u kome se nalaze potrebne funkcije

    $brojStrane = $_GET["broj-strane"];
    $sviKorisnici = []; //Kreiranje praznog niza u koji cemo smestiti sve korisnike
    $query = "SELECT * FROM Korisnik WHERE Id!=" . $_SESSION["Id"]; //Slanje upita bazi za dobijenje svih osoba
    if($resulat = mysqli_query($connection,$query)){
        while($object = mysqli_fetch_object($resulat)){
            $k = new Korisnik();
            $k->id = $object->Id;
            $k->ime = $object->Ime;
            $k->prezime = $object->Prezime;
            $k->email = $object->Email;
            $k->status = $object->Status;
            $k->putanjaSlike = $object->Slika;
            $k->datumPrijave = $object->Prijava;
            $k->aktivan = $object->Aktivan;
            
            $sviKorisnici[] = $k;
        }
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }

    $checkPretraga = false;
    if(isset($_GET["pretraga"])){
        $pretraga = array_values(array_filter($sviKorisnici, function ($item) {
            return strstr(strtolower($item->ime),strtolower($_GET["pretraga"])) || strstr(strtolower($item->prezime),strtolower($_GET["pretraga"]));
        }));  
        $sviKorisnici = $pretraga;
        
        $checkPretraga = true;     
    }
    $checkSort = false;
    if(isset($_GET["sort"])){
        if($_GET["sort"] == "Rastuće"){                   
            usort($sviKorisnici, "rastuceKor");
            $checkSort = true;
        }
        else if($_GET["sort"] == "Opadajuće") {         
            usort($sviKorisnici, "opadajuceKor");
            $checkSort = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Svi korisnici - Administrator</title>
    <?php 
        require_once "bootstrap-head.php";
        if(count($sviKorisnici) > 0)
        {
            $nizPodataka = rasporedPaginacije($sviKorisnici,$brojStrane,8); //Pozivanje funkcije za proracun promenljivih potrebnih za prikaz
        }
    ?>
</head>

<body>
    <?php
        require_once "navigacija-admin.php";
        echo '
            <input type="hidden" id="broj-strane-skriveno" value="' . $brojStrane . '"/>
        ';
    ?>
    <div class="main prikaz-deo">

    <div class="container">
        <h2 class="text-center py-4 font-weight-normal">Svi Korisnici</h2>
        <?php 
            if(count($sviKorisnici) > 0){
                echo '
                    <div class="row">                        
                        <div class="col-12 col-sm-3 mb-2">
                            <select class="form-control" id="sort" name="sort">
                                <option value="">Sortiranje po imenu</option>
                                <option value="Opadajuće">Opadajuće</option>
                                <option value="Rastuće">Rastuće</option>
                            </select>
                        </div>
                        <div class="col-4 col-sm-2 mb-2">
                            <a href="dodaj-korisnika.php" class="btn btn-success px-4 font-weight-bold">Dodaj Korisnika&nbsp;&nbsp;<i class="fas fa-plus"></i></a>
                        </div>
                        <div class="col-12 col-sm-4 offset-sm-3 mb-2">
                            <div class="input-group">
                                <input class="form-control" type="search" name="pretraga" id="pretraga" placeholder="Pretraga po imenu ili prezimenu">
                                <span class="input-group-btn ml-2">
                                    <input type="button" id="btn-pretraga" class="btn btn-info font-weight-bold text-light" value="Pretraži">
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                ';

                for($i = $nizPodataka["start"]; $i < $nizPodataka["end"]; $i++){
                    echo '
                        <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="card mb-3">
                            <div class="row no-gutters korisnik-senka">
                                <div class="col-md-4">
                                    <img src="'. $sviKorisnici[$i]->putanjaSlike .'" class="card-img slika-korisnik">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                    <h5 class="card-title">' . $sviKorisnici[$i]->ime . ' ' . $sviKorisnici[$i]->prezime;
                    if($sviKorisnici[$i]->aktivan==1){
                        echo '
                            <sup><small class="mx-1 mb-3 aktivan text-success"><i class="fas fa-circle korisnik-stanje"></i></small></sup></h5>
                        ';
                    } else {
                        echo '
                            <sup><small class="mx-1 mb-3 aktivan text-danger"><i class="fas fa-circle korisnik-stanje"></i></small></sup></h5>
                        ';
                    } 
                    echo '
                                        <p class="card-text text-dark"><span class="font-weight-bold">Status: </span> ' . $sviKorisnici[$i]->status . '</p>
                                        <p class="card-text text-dark"><span class="font-weight-bold">Prijavljen: </span><small class="text-muted">' . date("d.m.Y H:i",strtotime($sviKorisnici[$i]->datumPrijave)) . '</small></p>
                                        <a href="izmeni-korisnika.php?id-korisnika=' . $sviKorisnici[$i]->id . '" class="btn btn-info text-dark font-weight-bold py-1"><i class="fas fa-edit"></i> Izmeni</a>
                                        <button data-id="' . $sviKorisnici[$i]->id . '" onclick="brisanjeKorisnika(this)" class="btn btn-danger text-dark font-weight-bold py-1""><i class="fas fa-trash-alt"></i> Izbriši</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    ';
                }

                echo '
                </div>
                <hr />
                <div class="row mt-4 mb-5">
                    <div class="w-100 text-center">
                        <button type="button" class="btn btn-sm btn-dark text-light mx-1 btn-page-prev pr-2"><i class="fas fa-caret-left"></i></button>
                ';
                for($i = 0; $i < $nizPodataka["count"]; $i++){
                        echo '<button type="button" btn-id="'. ($i+1) .'" class="btn btn-sm text-dark font-weight-bold mx-1 btn-page">' . ($i+1) . '</button>';
                }
                echo '  
                            <button type="button" class="btn btn-sm btn-dark text-light mx-1 btn-page-next pl-2"><i class="fas fa-caret-right"></i></button>    
                        </div>
                    </div>
                ';
            }
            else if(count($sviKorisnici) == 0 && $checkPretraga == false) {
                echo '
                    <hr />
                    <div class="alert alert-danger alert-dismissible fade show text-center py-4" role="alert">
                        <strong>Trenutno nema ni jednog registrovanog korisnika u sistemu!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <hr />
                ';
            }
            else {
                echo '
                    <div class="row">                        
                        <div class="col-12 col-sm-3 mb-2">
                            <select class="form-control" id="sort" name="sort">
                                <option value="">Sortiranje po imenu</option>
                                <option value="Opadajuće">Opadajuće</option>
                                <option value="Rastuće">Rastuće</option>
                            </select>
                        </div>
                        <div class="col-4 col-sm-2 mb-2">
                            <a href="./dodaj-artikal.php" class="btn btn-success px-4 font-weight-bold">Dodaj Korisnika&nbsp;&nbsp;<i class="fas fa-plus"></i></a>
                        </div>
                        <div class="col-12 col-sm-4 offset-sm-3 mb-2">
                            <div class="input-group">
                                <input class="form-control" type="search" name="pretraga" id="pretraga" placeholder="Pretraga po imenu ili prezimenu">
                                <span class="input-group-btn ml-2">
                                    <input type="button" id="btn-pretraga" class="btn btn-info font-weight-bold text-light" value="Pretraži">
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr />
                        <div class="alert alert-danger alert-dismissible fade show text-center py-4" role="alert">
                            <strong>Nije pronađen ni jedan korisnik prilikom pretrage!</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <hr />
                ';
            }
        ?>

    <?php 
        require_once "bootstrap-body.php";
        if($checkSort == true){
            //Postavljanjem svojstva selektovano na padajucu listu za sortiranje u zavisnosti od izbora korisnika Opadajuce/Rastuce
            echo '
                <script>
                    $(document).ready(function(){
                        $("#sort option").each(function() {
                            if($(this).val() == "' . $_GET["sort"].'") {
                                $(this).prop("selected", true);
                            }
                        });                        
                    });
                </script>
            ';
        }
        if($checkPretraga == true) {
            echo '
                <script>
                    $(document).ready(function(){
                        $("#pretraga").val("' . $_GET["pretraga"] . '");
                    });
                </script>
            ';
        }
    ?>
    <script src="js/js-svikorisnici.js"></script>
    <script src="js/js-navigacija-admin.js"></script>
    <script>
        $(document).ready(function() {
            $(".futer").addClass("d-block");
            $(".futer").addClass("d-lg-none");
        });
    </script>
    </div>
    
    <?php
        require_once "footer.php";
    ?>
</body>

</html>