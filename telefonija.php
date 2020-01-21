<?php
    session_start();
    require_once "rad-sa-bazom.php";
    require_once "klase.php";
    require_once "funkcije.php";
    if(!isset($_GET["broj-strane"])){
        header("Location: index.php");
    }
    $brojStrane = $_GET["broj-strane"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veb Prodavnica - Bela tehnika</title>
    <?php 
        /*Dodavanje elemenata bootstrapa i css fajla*/
        require_once "bootstrap-head.php";        
    ?>
</head>
<body>
    <?php 
        require_once "navigacija.php";
    ?>
    <div class="container">
        <?php
            //Skriveni elementi
            echo '
                <input type="hidden" id="broj-strane-skriveno" value="' . $brojStrane . '"/>
            ';
        ?>      



        <?php

            $naziviArtikala = array(); //U ovom nizu bice smesteni nazivi svih postojecih artikala za odabranu grupu
            $markeArtikala = array();   
                
            $query = "SELECT * FROM Artikal WHERE Aktivan=1 AND IdGrupe IN(SELECT Id FROM Grupa WHERE Naziv='Telefonija')"; //Upit koji uzima sve artikle za trazenu grupu
            $trazeniArtikli = array();
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
                    $a->datumDodavanja = strtotime($object->DatumDodavanja);

                    $trazeniArtikli[] = $a;
                    $naziviArtikala[] = $object->Naziv;
                    $markeArtikala[] = $object->Marka;
                }
            }
            else {
                die("Poruka o grešci: " . mysqli_error($connection));
            }
            $naziviArtikala = array_unique($naziviArtikala);
            $markeArtikala = array_unique($markeArtikala);

            $checkSortCena = false;
            $checkSortVreme = false;
            $checkNazivArtikla = false;
            $checkMarkaArtikla = false;
            if(isset($_GET["sort-cena"])){
                if($_GET["sort-cena"] == "Rastuće"){                   
                    usort($trazeniArtikli, "rastuce");
                    $checkSortCena = true;
                }
                else if($_GET["sort-cena"] == "Opadajuće") {         
                    usort($trazeniArtikli, "opadajuce");
                    $checkSortCena = true;
                }
            }
            if(isset($_GET["sort-vreme"])){
                if($_GET["sort-vreme"] == "Najnoviji"){                   
                    usort($trazeniArtikli, "najnoviji");
                    $checkSortVreme = true;
                }
                else if($_GET["sort-vreme"] == "Najstariji") {         
                    usort($trazeniArtikli, "najstariji");
                    $checkSortVreme = true;
                }
            }
            if(isset($_GET["naziv-artikla"]) && in_array($_GET["naziv-artikla"],$naziviArtikala) == true){
                $pretraga = array_values(array_filter($trazeniArtikli, function ($item) {
                    return $item->naziv == $_GET["naziv-artikla"];
                }));                
                $trazeniArtikli = $pretraga;
                $checkNazivArtikla = true;     
            }
            if(isset($_GET["marka-artikla"]) && in_array($_GET["marka-artikla"],$markeArtikala) == true){
                $pretraga = array_values(array_filter($trazeniArtikli, function ($item) {
                    return $item->marka == $_GET["marka-artikla"];
                }));
                $trazeniArtikli = $pretraga;                
                $checkMarkaArtikla = true;     
            }

            echo '
                <h2 class="text-dark text-center font-weight-normal my-4">Telefonija</h2>
                <button type="button" class="btn btn-outline-info font-weight-bold px-4" data-target="#filter" data-toggle="collapse">
                    Filter
                    <i class="fas fa-filter"></i>    
                </button>
                <div id="filter" class="collapse">
                    <div class="row mt-3"">
                        <div class="col-12 col-sm-4 col-md-3 col-lg-2 mb-2">
                            <select class="form-control font-weight-bold" id="naziv-artikla">
                                <option value="">Odaberite naziv artikla</option>
            ';
            foreach($naziviArtikala as $naziv){
                echo '
                    <option value="' . $naziv . '">' . $naziv . '</option>
                ';
            }
            echo '
                            </select>
                        </div>
                        <div class="col-12 col-sm-4 col-md-3 col-lg-2  mb-2">
                            <select class="form-control font-weight-bold" id="marka-artikla">
                                <option value="">Odaberite marku artikla</option>
            ';
            foreach($markeArtikala as $marka){
                echo '
                    <option value="' . $marka . '">' . $marka . '</option>
                ';
            }
            echo '
                            </select>
                        </div>
                        <div class="col-12 col-sm-4 col-md-3 col-lg-4  mb-2">
                            <button type="button" id="btn-pretrazi" class="btn btn-info font-weight-bold px-3">Filtriraj</button>
                        </div>
                        <div class="col-12 col-sm-4 col-md-3 col-lg-2  mb-2">
                            <select class="form-control font-weight-bold" id="sort-cena">
                                <option value="">Sortiranje po ceni</option>
                                <option value="Opadajuće">Najskuplji prvo</option>
                                <option value="Rastuće">Najeftiniji prvo</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4 col-md-3 col-lg-2 mb-2">
                            <select class="form-control font-weight-bold" id="sort-vreme">
                                <option value="">Sortiranje po datumu</option>
                                <option value="Najstariji">Najstariji prvo</option>
                                <option value="Najnoviji">Najnoviji prvo</option>
                            </select>
                        </div>                        
                    </div>
                </div>
                <hr>
            ';
            if(count($trazeniArtikli) > 0)
            {
                $nizPodataka = rasporedPaginacije($trazeniArtikli,$brojStrane);
                echo '
                    <div class="row">
                ';
                for($i = $nizPodataka["start"]; $i < $nizPodataka["end"]; $i++){
                    echo '
                    <div class="col-12 col-sm-6  col-lg-3 my-3">
                         ' . prikaziArtikal($trazeniArtikli[$i]) . '
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
            else {
                echo '
                    <div class="alert alert-info alert-dismissible fade show text-center py-4" role="alert">
                    <strong>Trenutno name artikala!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <hr>
                ';
            }
        ?>
    </div>

    <?php 
        /*Dodavanje elemanata boostrapa vezanih za body kao i javascript i jquery fajlova*/
        require_once "bootstrap-body.php";        
        echo '
            <script>
                $(document).ready(function () {
        ';
                if($checkSortCena == true){
                    echo '
                        $("#sort-cena option").each(function() {
                            if($(this).val() == "' . $_GET["sort-cena"].'") {
                                $(this).prop("selected", true);
                            }
                        });
                    ';
                }
                if($checkSortVreme == true){
                    echo '
                        $("#sort-vreme option").each(function() {
                            if($(this).val() == "' . $_GET["sort-vreme"].'") {
                                $(this).prop("selected", true);
                            }
                        });
                    ';
                }
                if($checkNazivArtikla == true){
                    echo '
                        $("#naziv-artikla option").each(function() {
                            if($(this).val() == "' . $_GET["naziv-artikla"] .'") {
                                $(this).prop("selected", true);
                            }
                        });
                    ';
                }
                if($checkMarkaArtikla == true){
                    echo '
                        $("#marka-artikla option").each(function() {
                            if($(this).val() == "' . $_GET["marka-artikla"] .'") {
                                $(this).prop("selected", true);
                            }
                        });
                    ';
                }
        echo '                    
                });
            </script>
        ';
        echo '
            <script src="js/js-telefonija.js"></script>
        '; 
    ?>
    <script src="js/js-korpa.js"></script>
    <?php
        require_once "footer-klijent.php";
    ?>
</body>
</html>