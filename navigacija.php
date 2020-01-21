<?php 
    require_once "rad-sa-bazom.php";
    require_once "klase.php";
    require_once "funkcije.php";
    $query = "SELECT * FROM Grupa";
    $imenaGrupa = [];
    if($result = mysqli_query($connection,$query)){
        while($object = mysqli_fetch_object($result)){
          $grupa = new Grupa();
          $grupa->naziv = $object->Naziv;
          $imenaGrupa[] = $grupa;
        }
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
    /*VIDLJIVO ZA SVE KOJI PRISTUPAJU SAJTU SA BILO KOJIM AKREDITIVIMA*/
    echo '
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-0 sticky-top">
        <a class="navbar-brand p-0 m-0" href="./">
          <img src="./web-shop.png" class="img-user">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-1">
            <li class="nav-item mx-2">
              <a class="nav-link text-light nav-linija" href="./">Početna</a>
            </li>';        
                for($i = 0; $i < count($imenaGrupa); $i++){
                  echo '
                    <li class="nav-item mx-2"">
                      <a class="nav-link nav-linija text-light" href="' . vratiStranicu($imenaGrupa[$i]->naziv) . '">' . $imenaGrupa[$i]->naziv . '</a>
                    </li>';
                }
    echo '
          </ul>
          <ul class="navbar-nav ml-auto">  
          <li class="nav-item mx-2">
            <form method="GET" action="pretraga.php?broj-strane=1" class="form-inline d-none d-lg-block my-lg-1">
              <input class="form-control pretraga" type="search" id="pretraga" name="pretraga" placeholder="Pretraga..." aria-label="Search"><button class="btn btn-info my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
              <input type="hidden" name="broj-strane" value="1">
            </form>
          </li>
    ';
    if(!isset($_SESSION["Status"]) || (isset($_SESSION["Status"]) && $_SESSION["Status"] == "Kupac")){/*KORISNIK I GOST*/
      echo '
            <li class="nav-item dropdown mx-2">
              <a id="link-korpa" class="nav-link text-light" href="korpa.php">
                <i class="fas fa-shopping-cart glavna-korpa"></i>
                <sup class="text-info"><h6 class="d-inline" id="korpa-ukupno-artikala">0</h6></sup> 
                <span id="cena-korpa-ukupno">0.00 RSD</span>                
              </a>
            </li>
      ';
    }
    if(isset($_SESSION["Status"]) && $_SESSION["Status"] == "Administrator"){ /*ADMIN*/
      echo '
            <li class="nav-item mx-2">
              <a class="nav-link text-light nav-linija" href="./svi-artikli.php?naziv-grupe=Bela tehnika&broj-strane=1">Rad sa Podacima</a>
            </li>
            <!--
            <li class="nav-item dropdown mx-2">
              <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Rad sa podacima
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Svi korisnici</a>
                <a class="dropdown-item" href="svi-artikli-admin.php?naziv-grupe=Bela tehnika&broj-strane=1">Svi Artikli</a>
                <a class="dropdown-item" href="dodaj-artikal.php">Dodaj Artikal</a>
              </div>
            </li>
            -->
      ';
    }
      
    if(isset($_SESSION["Status"]) && ($_SESSION["Status"] == "Kupac" ||  $_SESSION["Status"] == "Administrator")) { /*ADMIN ILI KORISNIK*/
      $query = "SELECT * FROM Korisnik WHERE Id=" . $_SESSION["Id"];
      $ime_prezime = "";
      $putanja_slike = "";
      if($result = mysqli_query($connection,$query)){
        $object = mysqli_fetch_object($result);
        $ime_prezime = $object->Ime . " " . $object->Prezime;
        $putanja_slike = $object->Slika;
      }
      else {
        die("Poruka o grešci: " . mysqli_error($connection));
      }
      echo '
            <li class="nav-item dropdown mx-2">
              <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="' . $putanja_slike . '" class="img-user-sign img-responsive"/>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <span class="dropdown-item text-info font-weight-bold disabled" > ' . $ime_prezime . '</span>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="profil-korisnika.php">Profil</a>
      ';
      if($_SESSION["Status"] == "Kupac") {
        echo '
          <a class="dropdown-item" href="#">Poruka za Administraciju</a>
        ';
      }
      else if( $_SESSION["Status"] == "Administrator") {
        echo '
          <a class="dropdown-item" href="#">Poruke</a>
        ';
      }
      echo '
                <a class="dropdown-item" href="logout.php">Odjavite se</a>
              </div>
            </li>
      ';
    }
    
    if(!isset($_SESSION["Status"])){ /*SAMO GOST*/
      echo '
            <li class="nav-item dropdown mx-2">
              <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-user user-icon mr-1"></i> Profil
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="login.php">Prijavite se</a>
                <a class="dropdown-item" href="register.php">Registrujte se</a>
              </div>
            </li>
      ';
    }
    echo '
          </ul>
        </div>
      </nav>
    ';
?>