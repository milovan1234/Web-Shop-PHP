<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
    if(!isset($_GET["naziv-grupe"]) || !isset($_GET["broj-strane"])){ //Provera da li su potrebni elementi setovani za ovaj fajl
        header("Location: ./");
    }    

    require_once "rad-sa-bazom.php"; //Dodavanja svih potrebnih elemenata za rad sa bazom
    require_once "klase.php"; //Dodavanje fajla u kome se nalaze klase preko kojih kreiramo objekte
    require_once "funkcije.php"; //Dodavanje fajla u kome se nalaze potrebne funkcije

    $nazivGrupe = $_GET["naziv-grupe"];
    $brojStrane = $_GET["broj-strane"];

    $query = "SELECT * FROM Grupa";
    $check = false;
    if($result = mysqli_query($connection,$query)){
        while($object = mysqli_fetch_object($result)){
            if($object->Naziv == $nazivGrupe){
                $check = true;
            }
        }
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }

    $naziviArtikala = []; //U ovom nizu bice smesteni nazivi svih postojecih artikala za odabranu grupu   
    
    $query = "SELECT * FROM Artikal WHERE Aktivan=1 AND IdGrupe IN(SELECT Id FROM Grupa WHERE Naziv='$nazivGrupe')"; //Upit koji uzima sve artikle za trazenu grupu
    $trazeniArtikli = [];
    if($result = mysqli_query($connection,$query)){
        while($object = mysqli_fetch_object($result)){
            $a = new Artikal();
            $a->id = $object->Id;
            $a->idGrupe = $object->IdGrupe;
            $a->naziv = $object->Naziv;
            $a->marka = $object->Marka;
            $a->brojStanja = $object->BrojStanja;
            $a->cena = $object->Cena;
            $a->popust = $object->Popust;
            $a->cenaSaPopustom = ($object->Cena - ($object->Cena*($object->Popust/100)));
            $a->opis = $object->Opis;
            $a->slika = $object->Slika;

            $trazeniArtikli[] = $a;
            $naziviArtikala[] = $object->Naziv;
        }
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
    $naziviArtikala = array_unique($naziviArtikala);

    $checkNazivArt = false;
    $checkSort = false;
    if(isset($_GET["naziv-artikla"]) && in_array($_GET["naziv-artikla"],$naziviArtikala) == true){
        $pretraga = array_values(array_filter($trazeniArtikli, function ($item) {
            return $item->naziv == $_GET["naziv-artikla"];
        }));  
        $trazeniArtikli = $pretraga;
        
        $checkNazivArt = true;     
    }
    if(isset($_GET["sort"])){
        if($_GET["sort"] == "Rastuće"){                   
            usort($trazeniArtikli, "rastuce");
            $checkSort = true;
        }
        else if($_GET["sort"] == "Opadajuće") {         
            usort($trazeniArtikli, "opadajuce");
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
    <title>Svi Artikli - Administrator</title>
    <?php
        require_once "bootstrap-head.php";
        if(count($trazeniArtikli) > 0)
        {
            $nizPodataka = rasporedPaginacije($trazeniArtikli,$brojStrane); //Pozivanje funkcije za proracun promenljivih potrebnih za prikaz
        }
    ?>
</head>

<body>
    <?php
        require_once "navigacija-admin.php";
        echo '
            <div class="main prikaz-deo">
        ';
        //Slanje upita u bazu da dobijemo sve detalje o grupama
        $query = "SELECT * FROM Grupa WHERE Aktivna=1";
        $sveGrupa = [];
        if($result = mysqli_query($connection,$query)){
            while($object = mysqli_fetch_object($result)){
                $g = new Grupa();
                $g->id = $object->Id;
                $g->naziv = $object->Naziv;
                $g->putanjaSlike = $object->Slika;
                $sveGrupa[] = $g;
            }
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }
        //Dva inputa tipa HIDDEN u koje se smestaju vrednosti koji cuvaju naziv grupe i broj strane od GET metode
        echo '           
            <input type="hidden" id="naziv-grupe-skriveno" value="' . $nazivGrupe . '"/>
            <input type="hidden" id="broj-strane-skriveno" value="' . $brojStrane . '"/>
            <div class="container mb-3 pt-3">
        ';
        if(isset($_SESSION["Brisanje-Artikal"])) {
            echo '
                <!-- Polje u kome ce se prikazivate informacije pri brisanju željenog artikla -->
                <div class="alert-information alert  alert-success alert-dismissible fade show text-center mt-3"
                    role="alert">
                    <strong>Uspešno ste obrisali željeni artikal!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            ';
            unset($_SESSION["Brisanje-Artikal"]);
        }
        echo '
            <div class="row">
        ';
        //Prikaz svake od grupa sa odgovarajucom slikom i linkom
        for($i = 0;$i < count($sveGrupa); $i++){
            echo '
                <div class="col-6 mb-2 col-sm-6 col-md-3 text-center tooltip-bottom">
                    <span class="tooltiptext">' . $sveGrupa[$i]->naziv  . '</span>                    
                    <a href="svi-artikli.php?naziv-grupe=' . $sveGrupa[$i]->naziv . '&broj-strane=1">
                        <img class="img-grupe contain grupe" alt="' . $sveGrupa[$i]->naziv . '" src="'. $sveGrupa[$i]->putanjaSlike .'" >
                    </a>
                </div>
            ';
        }
        echo '
                </div>
            </div>
        ';
        echo '
            <div class="container">
                <h2 class="text-center my-4 font-weight-normal">' . $nazivGrupe . ' </h2>                
        ';
        if(count($naziviArtikala) > 0){
            echo '
            <div class="row"><div class="col-12 col-sm-3 mb-2">
                <select class="form-control" id="naziv-artikla" name="naziv-artikla">
                    <option value="">Odaberite naziv artikla</option>
            ';
            foreach($naziviArtikala as $artikal){
                echo '
                    <option value="' . $artikal . '">' . $artikal . '</option>
                ';
            }
            echo '
                </select>
            </div>
            <div class="col-12 col-sm-3 mb-2">
                <select class="form-control" id="sort" name="sort">
                    <option value="">Sortiranje po ceni</option>
                    <option value="Opadajuće">Opadajuće</option>
                    <option value="Rastuće">Rastuće</option>
                </select>
            </div>
            <div class="col-4 col-sm-2 mb-2">
                <a href="dodaj-artikal.php" class="btn btn-success px-4 font-weight-bold">Dodaj Novi&nbsp;&nbsp;<i class="fas fa-plus"></i></a>
            </div>
            </div>
            ';            
        }
        echo '
            <hr />
        ';
        if(count($trazeniArtikli) > 0) {
            echo '<div class="row">';
            for($i = $nizPodataka["start"]; $i < $nizPodataka["end"]; $i++){
                echo '
                <div class="col-12 col-sm-6  col-lg-3 my-3">
                    <div class="card border h-100 artikal-senka">
                        <img class="card-img-top border-bottom img-trazeni-artikal" src="' . $trazeniArtikli[$i]->slika .'" alt="Slika u Card-u">
                        <div class="card-body p-0 d-flex flex-column">';
                        if($trazeniArtikli[$i]->popust > 0) {
                            echo'
                                <div class="mojdiv w-25 bg-info text-warning font-weight-bold mt-2"> -' . $trazeniArtikli[$i]->popust . '%</div>
                            ';
                        }
                        echo '
                            <h5 class="font-weight-normal mx-2 text-justify mt-2">' . $trazeniArtikli[$i]->opis .'</h5>                            
                            ';
                        if($trazeniArtikli[$i]->brojStanja > 0){
                            echo '
                                <small class="d-block mx-2 mb-3 text-success"><i class="fas fa-circle artikal-stanje"></i> Na stanju</small>
                                <div class="mt-auto">
                                <div class="text-right mr-2">
                            ';
                        }
                        else {
                            echo '
                                <small class="d-block mx-2 mb-3 text-danger"><i class="fas fa-circle artikal-stanje"></i> Nije na stanju</small>
                                <div class="mt-auto">
                                <div class="text-right mr-2">
                            ';
                        }
                        if($trazeniArtikli[$i]->popust > 0) {
                            echo'
                                <h6 class="font-weight-normal mb-0"><s>' . number_format($trazeniArtikli[$i]->cena, 0, ",", ".") .' RSD</s></h6>
                                <span class="text-danger"><small>Ušteda ' . number_format($trazeniArtikli[$i]->cena * ($trazeniArtikli[$i]->popust / 100), 0, ",", ".") . ' RSD</small></span>
                            ';
                        }
                            echo'
                                <h4>' . number_format($trazeniArtikli[$i]->cenaSaPopustom, 0, ",", ".") . ' RSD</h4>
                            </div>
                            <div class="text-center mt-4 mb-2">
                                <a href="izmeni-artikal.php?id-artikla=' . $trazeniArtikli[$i]->id . '" class="btn btn-info text-dark font-weight-bold px-3 d-inline-block mt-3 py-1"><i class="fas fa-edit"></i> Izmeni</a>
                                <button data-id="'. $trazeniArtikli[$i]->id .'" onclick="brisanjeArtikla(this)" class="btn btn-danger text-dark font-weight-bold px-3 mt-3 py-1"><i class="fas fa-trash-alt"></i> Izbriši</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
            echo '</div>';

            echo '
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
        else if($check) {
            echo '                
                <div class="alert alert-danger alert-dismissible fade show text-center py-4" role="alert">
                    <strong>Trenutno nema ni jednog proizvoda za grupu - <em>' . $nazivGrupe . '</em></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <hr />
            ';
        }
        else if(!$check){
            echo '                
                <div class="alert alert-danger alert-dismissible fade show text-center py-4" role="alert">
                    <strong>U sistemu ne postoji Grupa sa unetim nazivom!</em></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <hr />
            ';
        }
        echo '</div>';
    ?>
    <?php 
        require_once "bootstrap-body.php";
        echo '
            <script>
                $(document).ready(function () {
        ';
                if($checkNazivArt == true){
                    echo '
                        $("#naziv-artikla option").each(function() {
                            if($(this).val() == "' . $_GET["naziv-artikla"] .'") {
                                $(this).prop("selected", true);
                            }
                        });
                    ';
                }
                if($checkSort == true){
                    echo '
                        $("#sort option").each(function() {
                            if($(this).val() == "' . $_GET["sort"].'") {
                                $(this).prop("selected", true);
                            }
                        });
                    ';
                }
        echo '                    
                });
            </script>
        ';   
    ?>
    <script> 
        $(document).ready(function() {
            $(".futer").addClass("d-block");
            $(".futer").addClass("d-lg-none");
        });
    </script>
    <script src="js/js-sviartikli.js"></script>
    <script src="js/js-navigacija-admin.js"></script>
    <?php
        echo '</div>';
        require_once "footer.php";
    ?>


</body>

</html>