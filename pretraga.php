<?php
    session_start();
    if(!isset($_GET["pretraga"])){
        header("Location: index.php");
    }
    $brojStrane = $_GET["broj-strane"];
    $filtriraniArtikli = array();
    require_once "rad-sa-bazom.php";
    require_once "klase.php";
    require_once "funkcije.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veb Prodavnica - Pretraga</title>
    <?php
        require_once "bootstrap-head.php";
    ?>
</head>
<body>
    <?php 
        require_once "navigacija.php";
    ?>
    <div class="container">
        <form method="GET" action="pretraga.php" class="d-block d-lg-none mt-5">
            <div class="row">
                <div class="col-8">
                    <input class="form-control pretraga" type="search" id="pretraga" name="pretraga" placeholder="Pretraga..." aria-label="Search">
                    <input type="hidden" name="broj-strane" value="1">
                </div>
                <div class="col-2">
                    <button class="btn btn-info px-4" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>       
        </form> 
        <h2 class="text-dark text-center font-weight-normal my-4">Rezultati pretrage</h2>
        <hr>
        <?php
            if($_GET["pretraga"] == ""){
                echo '
                    <div class="alert alert-danger alert-dismissible fade show text-center py-4" role="alert">
                        <strong>Morate popuniti polje za pretragu!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <hr>
                ';
            }
            else {
                $pretraga = $_GET["pretraga"];
                $query = "SELECT * FROM Artikal WHERE Aktivan=1";                
                if($result = mysqli_query($connection,$query)){
                    while($object = mysqli_fetch_object($result)){
                        if(strstr(mb_strtolower($object->Naziv),mb_strtolower($pretraga)) ||
                        strstr(mb_strtolower($object->Marka),mb_strtolower($pretraga)) ||
                        strstr(mb_strtolower($object->Opis),mb_strtolower($pretraga))){
                                $artikal = new Artikal();
                                $artikal->id = $object->Id;
                                $artikal->idGrupe = $object->IdGrupe;
                                $artikal->naziv = $object->Naziv;
                                $artikal->marka = $object->Marka;
                                $artikal->brojStanja = $object->BrojStanja;
                                $artikal->cena = $object->Cena;
                                $artikal->popust = $object->Popust;
                                $artikal->cenaSaPopustom = ($object->Cena - ($object->Cena*($object->Popust/100)));
                                $artikal->opis = $object->Opis;
                                $artikal->slika = $object->Slika;
                                $filtriraniArtikli[] = $artikal;                                
                        }               
                    }
                }
                else {
                    die("Poruka o grešci: " . mysqli_error($connection));
                }
            }
            if(count($filtriraniArtikli) > 0)
            {  $nizPodataka = rasporedPaginacije($filtriraniArtikli,$brojStrane);
                echo '
                    <div class="row">
                ';
                for($i = $nizPodataka["start"]; $i < $nizPodataka["end"]; $i++){
                    echo '
                    <div class="col-12 col-sm-6  col-lg-3 my-3">
                        <a href="artikal.php?id-artikla=' . $filtriraniArtikli[$i]->id . '" class="text-dark artikal-link">
                            ' . prikaziArtikal($filtriraniArtikli[$i]) . ' 
                        </a>
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
                            <button type="button"  class="btn btn-sm btn-dark text-light mx-1 btn-page-next pl-2"><i class="fas fa-caret-right"></i></button>    
                        </div>
                    </div>
                ';
            }
            else if(count($filtriraniArtikli) == 0 && $_GET["pretraga"] != ""){
                echo '
                <div class="alert alert-info alert-dismissible fade show text-center py-4" role="alert">
                    <strong>Nema pronađenih artikala za traženu pretragu!</strong>
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
            <input type="hidden" id="broj-strane-skriveno" value="' . $_GET["broj-strane"] . '">
        ';
        echo '<script src="js/js-pretraga.js"></script>';
        if($_GET["pretraga"] != ""){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".pretraga").val("' . $_GET["pretraga"] . '");
                    });
                </script>
            ';
        }
    ?>
    <script src="js/js-korpa.js"></script>
    <?php
        require_once "footer-klijent.php";
    ?>
</body>
</html>