<?php 
    session_start(); 
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
    <title>Veb Prodavnica - Početna strana</title>
    <?php 
        /*Dodavanje elemenata bootstrapa i css fajla*/
        require_once "bootstrap-head.php";        
    ?>
</head>
<body>  
<?php 
        require_once "navigacija.php";
        $query = "SELECT * FROM Slajder";
        $slikeSlajder = [];
        $query = "SELECT * FROM Slajder WHERE Aktivna=1";
        if($result = mysqli_query($connection,$query)){
            while($object = mysqli_fetch_object($result)){
                $s = new Slajder();
                $s->putanjaSlike = $object->Slika;
                $slikeSlajder[] = $s;
            }
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }

        if(count($slikeSlajder) > 0){
        echo '<div id="carouselExampleIndicators" class="slajder-pocetna carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">';
        for($i = 0; $i < count($slikeSlajder);$i++){
            if($i == 0){
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '" class="active"></li>';
            }
            else{
                echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i .'"></li>';
            }        
        }
        echo '</ol><div class="carousel-inner">';
        for($i = 0; $i < count($slikeSlajder);$i++){
            if($i == 0){
                echo '
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="' . $slikeSlajder[$i]->putanjaSlike . '" alt="First slide">
                    </div>
                ';
            }
            else{
                echo '
                    <div class="carousel-item">
                        <img class="d-block w-100" src="' . $slikeSlajder[$i]->putanjaSlike  . '" alt="Second slide">
                    </div>
                ';
            }        
        }
          echo '
            </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>';
        }
    ?>
    <form method="GET" action="pretraga.php" class="d-block d-lg-none px-4 mt-5">
        <div class="row">
            <div class="col-8">
                <input class="form-control" type="search" name="pretraga" placeholder="Pretraga..." aria-label="Search">
                <input type="hidden" name="broj-strane" value="1">
            </div>
            <div class="col-2">
                <button class="btn btn-info px-4" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>       
    </form>       
    <h2 class="text-dark text-center font-weight-normal mt-4 mb-4">Izdvajamo iz ponude</h2>
    <div class="px-4">    
    <?php
        $query = "SELECT * FROM Artikal WHERE Aktivan=1 AND BrojStanja>0 ORDER BY Popust DESC";
        $izdvojamoIzPonude = array();
        if($result = mysqli_query($connection, $query)){
            $brojac = 0;
            while($object = mysqli_fetch_object($result)){
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
                $izdvojamoIzPonude[] = $artikal;
                $brojac++;
                if($brojac == 12){
                    break;
                }
            }
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }
        /*Ekrani lg i veći*/
        echo '
            <div class="d-none d-lg-block">
        ';
        prikazArtikalaSlajder(6,1,$izdvojamoIzPonude);
        echo '
            </div>
        ';
        /*Ekrani md*/
        echo '
            <div class="d-none d-md-block d-lg-none">
        ';
        prikazArtikalaSlajder(3,2,$izdvojamoIzPonude);
        echo '
            </div>
        ';
        /*Ekrani sm*/
        echo '
            <div class="d-none d-sm-block d-md-none">
        ';
        prikazArtikalaSlajder(2,3,$izdvojamoIzPonude);
        echo '
            </div>
        ';
        /*Ekrani za sve vrste telefona*/
        echo '
            <div class="d-block d-sm-none">
        ';
        prikazArtikalaSlajder(1,4,$izdvojamoIzPonude);
        echo '
            </div>
        ';
    ?>
    <?php
        echo '
            <div class="d-none d-md-block my-5 px-3">
                <div class="row" style="border:1px solid #dee2e6;">
                    <div class="col-md-6 p-0">
                        <img src="slike-reklame/slika-reklama-1.jpg" class="w-100" alt="Reklama 1">
                    </div>
                    <div class="col-md-6 p-0">
                        <img src="slike-reklame/slika-reklama-2.jpg" class="w-100" alt="Reklama 2">
                    </div>
                </div>
            </div>
            <div class="d-block d-md-none my-5 px-3">
                <div id="carouselExampleControls-reklama" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="slike-reklame/slika-reklama-1.jpg" alt="Reklama 1">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="slike-reklame/slika-reklama-2.jpg" alt="Reklama 2">
                    </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls-reklama" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls-reklama" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        ';        
    ?>
    <h2 class="text-dark text-center font-weight-normal mt-4 mb-4">Najprodavaniji artikli</h2>
    <?php
        $query = "SELECT * FROM Artikal WHERE Aktivan=1 ORDER BY Prodato DESC";
        $najprodavanijiArtikli = array();
        if($result = mysqli_query($connection, $query)){
            $brojac = 0;
            while($object = mysqli_fetch_object($result)){
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
                $najprodavanijiArtikli[] = $artikal;
                $brojac++;
                if($brojac == 12){
                    break;
                }
            }
        }
        else {
            die("Poruka o grešci: " . mysqli_error($connection));
        }
        /*Ekrani lg i veći*/
        echo '
            <div class="d-none d-lg-block">
        ';
        prikazArtikalaSlajder(6,5,$najprodavanijiArtikli);
        echo '
            </div>
        ';
        /*Ekrani md*/
        echo '
            <div class="d-none d-md-block d-lg-none">
        ';
        prikazArtikalaSlajder(3,6,$najprodavanijiArtikli);
        echo '
            </div>
        ';
        /*Ekrani sm*/
        echo '
            <div class="d-none d-sm-block d-md-none">
        ';
        prikazArtikalaSlajder(2,7,$najprodavanijiArtikli);
        echo '
            </div>
        ';
        /*Ekrani za sve vrste telefona*/
        echo '
            <div class="d-block d-sm-none">
        ';
        prikazArtikalaSlajder(1,8,$najprodavanijiArtikli);
        echo '
            </div>
        ';
    ?>    
    </div>

    
    <?php 
        /*Dodavanje elemanata boostrapa vezanih za body kao i javascript i jquery fajlova*/
        require_once "bootstrap-body.php";
    ?>
    <script src="js/js-korpa.js"></script>
    <?php
        require_once "footer-klijent.php";
    ?>
</body>
</html>