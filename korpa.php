<?php
    session_start();
    if(isset($_SESSION["Prijavljen"]) && $_SESSION["Status"] == "Administrator"){
        header("Location: index.php");
    }
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
    <title>Veb Prodavnica - Korpa</title>
    <?php 
        /*Dodavanje elemenata bootstrapa i css fajla*/
        require_once "bootstrap-head.php";        
    ?>
</head>

<body>
    <?php 
        require_once "navigacija.php";
    ?>
    <h2 class="text-dark text-center font-weight-normal my-4">Vaša korpa</h2>
    <div class="container">
        <?php
            if(isset($_SESSION["Artikli-Korpa"]) && count($_SESSION["Artikli-Korpa"]) > 0){
                for($i = 0; $i < count($_SESSION["Artikli-Korpa"]);$i++){
                    $query = "SELECT * FROM Artikal WHERE Id=" . $_SESSION["Artikli-Korpa"][$i]["id"];
                    $artikal = new Artikal();
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
                    echo '
                        <div class="row mb-3 artikli-kupovina">
                            <input type="hidden" id="id-artikla" value="' . $artikal->id . '">
                            <input type="hidden" id="cena-artikla" value="' . $artikal->cenaSaPopustom . '">
                            <input type="hidden" id="naziv-artikla" value="' . $artikal->naziv . '">
                            <input type="hidden" id="marka-artikla" value="' . $artikal->marka . '">
                            <input type="hidden" id="opis-artikla" value="' . $artikal->opis . '">
                            <div class="col-md-3 border text-center">
                                <img src="' . $artikal->slika . '" class="img-fluid korpa-slika">
                            </div>
                            <div class="col-md-9 border">
                                <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <h6 class="font-weight-normal text-secondary my-2">PROIZVOD</h6>
                                        <p>
                                            ' . $artikal->opis  . '
                                        </p>
                    ';
                    if($artikal->brojStanja > 0){
                        echo '
                            <div>
                                <small class="d-block mb-3 text-success text-left"><i class="fas fa-circle artikal-stanje"></i> Na stanju</small>
                            </div>
                        ';
                    }
                    else {
                        echo '
                            <div>
                                <small class="d-block mb-3 text-danger text-left"><i class="fas fa-circle artikal-stanje"></i> Nije na stanju</small>
                            </div>
                        ';
                    }
                    echo '
                                    </div>
                                    <div class="col-sm-3 text-right">
                                        <h6 class="font-weight-normal text-secondary my-2">CENA</h6>
                    ';
                    if($artikal->popust > 0) {
                        echo '
                            <h6 class="font-weight-normal mb-0"><s>' . number_format($artikal->cena, 0, ",", ".") .' RSD</s></h6>
                            <span class="text-danger"><small>Ušteda ' . number_format($artikal->cena * ($artikal->popust / 100), 0, ",", ".") . ' RSD</small></span>
                        ';
                    }
                    
                    echo '
                            <h4>' . number_format($artikal->cenaSaPopustom, 0, ",", ".") . ' RSD</h4>
                    ';
                    echo '
                                    </div>
                                    <div class="col-sm-3 text-center">
                                        <h6 class="font-weight-normal text-secondary mt-2 mb-4">KOLIČINA</h6>
                                        <input type="number" id="kolicina-artikla" data-price="' . $artikal->cenaSaPopustom . '" onchange="ukupnaCenaZaUplatu()" class="form-control broj-artikala" value="1" min="1" max="' . $artikal->brojStanja . '" id="broj-odabranih">
                                    </div>
                                    <div class="col-sm-2 text-center">
                                    <h6 class="font-weight-normal text-secondary mt-2 mb-4">
                                        <i class="fas fa-times fa-2x" onclick="brisanjeArtiklaKorpa(this)" data-id="' . $artikal->id. '"></i>
                                    </h6>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                }
            }
            else {
                echo '
                        <div class="alert-information alert text-left alert-info alert-dismissible fade show my-3 text-center" role="alert">
                            <strong>Vaša korpa je trenutno prazna.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                ';
            }
            echo '
                        <div class="alert-korpa alert text-left alert-info alert-dismissible fade show my-3 text-center d-none" role="alert">
                            <strong>Vaša korpa je trenutno prazna.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
            ';
        ?>
        <div class="row">
            <div class="offset-md-8 col-md-4 border p-2">
                <h5 class="font-weight-normal">
                    Ukupan iznos za uplatu:
                    <span id="ukupno-cena-korpa" class="font-weight-bold"></span>
                    <input type="hidden" id="ukupno-cena-racun">
                </h5>
            </div>
        </div>
        <div class="row">
            <?php
                if(!isset($_SESSION["Prijavljen"])){
                    echo '
                        <div class="offset-md-8 col-md-4 border my-4">
                            <a href="login.php" id="kupi-proizvod" onclick="alert(`Da bi ste mogli da vršite kupovinu nekog proizvoda morate da se prijavite!`)"  class="btn btn-dark btn-block text-light dugme-korpa text-center px-4 py-2 my-3"><span class="font-weight-normal">KUPI PROIZVOD/E</span> <i class="fas fa-shopping-cart"></i></a>
                        </div>
                    ';
                }
                else {
                    echo '
                        <div class="offset-md-8 col-md-4 border my-4">
                            <button id="kupi-proizvod" onclick="kupiProizvod()"  class="btn btn-dark btn-block text-light dugme-korpa text-center px-4 py-2 my-3"><span class="font-weight-normal">KUPI PROIZVOD/E</span> <i class="fas fa-shopping-cart"></i></button>
                        </div>
                    ';
                }
            ?>
        </div>
        <div class="alert-racun alert alert-secondary alert-dismissible fade show my-3 text-center d-none" role="alert">
            <h3 class="font-weight-normal">Vaš račun</h3>
            <div class="mx-4 my-3">
                <h5 class="text-left font-weight-normal">
                    Broj transakcije:
                    <span class="font-weight-bold" id="racun-broj-transakcije"></span>
                </h5>
            </div>
            <div class="mx-4 my-3">
                <h5 class="text-left font-weight-normal">
                    Ime i Prezime:
                    <span class="font-weight-bold" id="racun-ime-prezime"></span>
                </h5>
            </div>
            <div class="mx-4 my-3">
                <h5 class="text-left font-weight-normal">
                    Broj kupljeih Artikala:
                    <span class="font-weight-bold" id="racun-broj-kupljenih"></span>
                </h5>
            </div>
            <div class="mx-4 mb-3 mt-5">
                <h5 class="text-right font-weight-normal">
                    Ukupno za uplatu:
                    <span class="font-weight-bold" id="racun-ukupno-cena"></span>
                </h5>
            </div>
        </div>
    </div>
    <?php
        /*Dodavanje elemanata boostrapa vezanih za body kao i javascript i jquery fajlova*/
        require_once "bootstrap-body.php";
    ?>
    <script src="js/js-korpa.js"></script>
    <script>
    function ukupnaCenaZaUplatu() {
        let artikliUkupnaCena = $(".broj-artikala");
        let ukupnaCena = 0;
        let ukupnoArtikala = 0;
        for (let i = 0; i < artikliUkupnaCena.length; i++) {
            ukupnaCena += parseInt($(artikliUkupnaCena[i]).attr("data-price")) * parseInt($(artikliUkupnaCena[i])
        .val());
            ukupnoArtikala += parseInt($(artikliUkupnaCena[i]).val());
        }
        if (parseInt(ukupnaCena) > 0) {
            $("#ukupno-cena-korpa").html(Math.round(parseFloat(ukupnaCena), 0) + " RSD");
            $("#cena-korpa-ukupno").html(Math.round(parseFloat(ukupnaCena), 0) + " RSD");
            $("#ukupno-cena-racun").val(Math.round(parseFloat(ukupnaCena), 0));
        } else {
            $("#ukupno-cena-korpa").html("0.00 RSD");
            $("#cena-korpa-ukupno").html("0.00 RSD");
            $("#ukupno-cena-racun").val(0);
        }
        $("#korpa-ukupno-artikala").html(parseInt(ukupnoArtikala));
    }
    $(document).ready(function() {
        ukupnaCenaZaUplatu();
    });
    </script>
    <?php
        require_once "footer-klijent.php";
    ?>
</body>

</html>