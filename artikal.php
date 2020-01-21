<?php
    session_start(); 
    if(!isset($_GET["id-artikla"])){
        header("Location: index.php");
    }    
    require_once "rad-sa-bazom.php";
    require_once "klase.php";
    require_once "funkcije.php";
    $artikal = new Artikal();
    $query = "SELECT * FROM Artikal WHERE Id=" . $_GET["id-artikla"];
    if($result = mysqli_query($connection,$query)){
        $object = mysqli_fetch_object($result);
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
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=	, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veb Prodavnica - Prikaz artikla</title>
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
        <h2 class="text-dark text-center font-weight-normal my-4">Prikaz Artikla</h2>
        <?php
            echo '
                <div class="row px-2">
                    <div class="col-sm-12 col-md-6 border mb-2">
                        <img data-toggle="modal" data-target="#modal-slika" src="'. $artikal->slika . '" class="w-100  slika-artikla">
                    </div>
                    <div class="col-sm-12 col-md-6">
            ';
            if($artikal->popust > 0) {
                echo '
                            <div class="div-artikal bg-info text-warning font-weight-bold text-center mb-5"> -' . $artikal->popust . '%</div>
                ';
            }
            if($artikal->brojStanja > 0){
                echo '
                    <small class="d-block mb-3 text-success"><i class="fas fa-circle artikal-stanje"></i> Na stanju</small>
                ';
            }
            else {
                echo '
                    <small class="d-block mb-3 text-danger"><i class="fas fa-circle artikal-stanje"></i> Nije na stanju</small>
                ';
            }                        
            echo '
                <h4>' . $artikal->opis . '</h4>
                <h6 class="font-weight-normal">Naziv: ' . $artikal->naziv . '</h6>
                <h6 class="font-weight-normal">Marka: ' . $artikal->marka . '</h6>
                <div class="mt-4">
            ';
            if($artikal->popust > 0) {
                echo '
                    <h5 class="font-weight-normal mb-0"><s>' . number_format($artikal->cena, 0, ",", ".") .' RSD</s></h5>
                    <span class="text-danger"><small>Ušteda ' . number_format($artikal->cena * ($artikal->popust / 100), 0, ",", ".") . ' RSD</small></span>
                ';
            }
            
            echo '
                    <h3>' . number_format($artikal->cenaSaPopustom, 0, ",", ".") . ' RSD</h3>
            ';
            if(!isset($_SESSION["Prijavljen"]) || $_SESSION["Status"] == "Kupac"){
                echo '
                    <button id="dodaj-u-korpu" data-id="' . $artikal->id . '" onclick="dodajUKorpu(this)"  class="btn btn-dark text-light dugme-korpa text-center px-4 my-3"><span class="font-weight-normal">DODAJ U KORPU</span> <i class="fas fa-shopping-cart"></i></button>
                ';
            } 
            echo '
                        </div>
                    </div>
                </div>
            ';
        ?>
    </div>




    
    <?php 
        echo '
            <div class="modal fade" id="modal-slika" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <img data-toggle="modal" data-target="#modal-slika" class="img-fluid mx-auto" src="' . $artikal->slika . '">
                </div>
            </div>
        ';
        /*Dodavanje elemanata boostrapa vezanih za body kao i javascript i jquery fajlova*/
        require_once "bootstrap-body.php";
    ?>
    <script src="js/js-korpa.js"></script>
    <?php
        require_once "footer-klijent.php";
    ?>
</body>
</html>