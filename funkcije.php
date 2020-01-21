<?php    
    function proveraKolacica(){
        if(isset($_COOKIE["Email"])){
            $_SESSION["Email"] = $_COOKIE["Email"];
        }
    }
    function rasporedPaginacije($trazeniArtikli, $brojStrane , $brojnastrani = 8) {
        $start = 0;
        $end = 0;
        $count = 0;
        $brojnastrani = $brojnastrani; /*Koliko njih ce biti prikazano na jednoj strani*/
        if(count($trazeniArtikli) % $brojnastrani == 0)
            $count = count($trazeniArtikli) / $brojnastrani;
        else
            $count = (count($trazeniArtikli) / $brojnastrani);
            
        if ($brojStrane == 1)
        {
            if(count($trazeniArtikli) >= $brojnastrani)
            {
                $start = 0;
                $end = $brojnastrani;                
            }
            else if(count($trazeniArtikli) < $brojnastrani){
                $start = 0;
                $end = count($trazeniArtikli);
            }
        }
        else if($brojStrane > 1 && $brojStrane <= count($trazeniArtikli))
        {
            if(count($trazeniArtikli) >= $brojStrane * $brojnastrani)
            {
                $start = ($brojStrane * $brojnastrani) - $brojnastrani;
                $end = ($brojStrane * $brojnastrani);
            }
            else if(count($trazeniArtikli) < $brojStrane * $brojnastrani){
                $start = ($brojStrane * $brojnastrani) - $brojnastrani;
                $end = count($trazeniArtikli);
            }
        }
        return array("start"=>$start, "end"=>$end, "count"=> ceil($count), "brojnastrani"=>$brojnastrani);
    }
    //Funkcije za sortiranje niza objekata Artikala u rastucem ili opadajucem poretku
    function rastuce($a, $b) {
        return $a->cenaSaPopustom > $b->cenaSaPopustom;
    }
    function opadajuce($a, $b) {
        return $a->cenaSaPopustom < $b->cenaSaPopustom;
    }
    function najstariji($a, $b) {
        return $a->datumDodavanja > $b->datumDodavanja;
    }
    function najnoviji($a, $b) {
        return $a->datumDodavanja < $b->datumDodavanja;
    }


    //Funkcije za sortiranje niza objekata klase Osobe u rastucem ili opadajucem poretku
    function rastuceKor($a, $b) {
        return $a->ime > $b->ime;
    }
    function opadajuceKor($a, $b) {
        return $a->ime < $b->ime;
    }



    function prikazArtikalaSlajder($pomeraj,$rbr,$lista){
        echo '
                <div id="carouselExampleIndicators' . $rbr . '" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
            ';
            $pocetak = 0;
            for($i = 0; $i < (12 / $pomeraj); $i++){
                if($i == 0){
                    echo '
                        <div class="carousel-item active">
                            <div class="row px-1">
                    ';
                }
                else {
                    echo '
                        <div class="carousel-item">
                            <div class="row px-1">
                    ';
                }
                
                for($j=$pocetak; $j < ($pocetak + $pomeraj); $j++){
                    echo '
                        <div class="col-sm-6 col-md-4 col-lg-2 my-3">                            
                                ' . prikaziArtikal($lista[$j]) . '
                        </div>
                    ';
                }
                echo'
                        </div>
                    </div>
                ';
                $pocetak += $pomeraj;
            }
            echo '
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators' . $rbr . '" id="nazad" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators' . $rbr . '" id="napred" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            ';
    }
    function prikaziArtikal($artikal){
        $str = '';
        $str .= '
            <a href="artikal.php?id-artikla=' . $artikal->id . '" class="text-dark artikal-link">
            <div class="card border h-100 artikal-senka">
                <img class="card-img-top border-bottom img-trazeni-artikal" src="' . $artikal->slika .'" alt="Slika u Card-u">
                <div class="card-body p-0 d-flex flex-column">
        ';
        if($artikal->popust > 0) {
            $str .= '
                <div class="mojdiv w-25 bg-info text-warning font-weight-bold mt-2"> -' . $artikal->popust . '%</div>
            ';
        }
        $str .= '
            <h5 class="font-weight-normal mx-2 text-justify mt-2">' . $artikal->opis .'</h5>                            
        ';
        if($artikal->brojStanja > 0){
            $str .= '
                <small class="d-block mx-2 mb-3 text-success"><i class="fas fa-circle artikal-stanje"></i> Na stanju</small>
                <div class="mt-auto">
                <div class="text-right mr-2">
            ';
        }
        else {
            $str .= '
                <small class="d-block mx-2 mb-3 text-danger"><i class="fas fa-circle artikal-stanje"></i> Nije na stanju</small>
                <div class="mt-auto">
                <div class="text-right mr-2">
            ';
        }
        if($artikal->popust > 0) {
            $str .= '
                <h6 class="font-weight-normal mb-0"><s>' . number_format($artikal->cena, 0, ",", ".") .' RSD</s></h6>
                <span class="text-danger"><small>Ušteda ' . number_format($artikal->cena * ($artikal->popust / 100), 0, ",", ".") . ' RSD</small></span>
            ';
        }
            $str .= '
                <h4>' . number_format($artikal->cenaSaPopustom, 0, ",", ".") . ' RSD</h4>
            </div>
            </a>
            <div class="text-center mt-2 mb-2">
            ';
            if(!isset($_SESSION["Prijavljen"]) || $_SESSION["Status"] == "Kupac"){
                $str .= '                    
                    <button id="dodaj-u-korpu" data-id="' . $artikal->id . '" onclick="dodajUKorpu(this)" class="btn btn-dark text-light dugme-korpa text-center px-4 my-3"><span class="font-weight-normal">DODAJ U KORPU</span> <i class="fas fa-shopping-cart"></i></button>
                ';
            } 
        $str .= '
                        </div>
                    </div>
                </div>
            </div>
        ';
        return $str;
    }


    function vratiStranicu($naziv){
        switch($naziv){
            case "Bela tehnika":                
                return "bela-tehnika.php?broj-strane=1";
                break;
            case "Telefonija":
                return "telefonija.php?broj-strane=1";
                break;
            case "TV":
                return "televizija.php?broj-strane=1";
                break;
            case "Klima uređaji":
                return "klima-uređaji.php?broj-strane=1";
                break;
            default:
                break;
        }
    }
    
?>