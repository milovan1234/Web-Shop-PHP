<?php

    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
    require_once "rad-sa-bazom.php";
    require_once "klase.php";
    $query = "SELECT * FROM Korisnik WHERE Id=" . $_SESSION["Id"];
    $korisnik = new Korisnik();
    if($result = mysqli_query($connection,$query)){
        $object = mysqli_fetch_object($result);
        $korisnik->ime = $object->Ime;
        $korisnik->prezime = $object->Prezime;
        $korisnik->slika = $object->Slika;
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }

    echo '
        <div class="d-none d-lg-block">
            <div class="sidenav position-fixed h-100 bg-dark pt-4">                
                <a href="" class="px-3 py-1 d-block text-light text-center text-decoration-none">
                    <img src="./web-shop.png" class="img-admin-panel">
                </a>
                <a class="px-3 py-1 ml-1 text-center text-info font-weight-bold">
                    <img src="' . $korisnik->slika . '" class="img-user-sign img-responsive my-2"/>
                    <span>' . $korisnik->ime . " " . $korisnik->prezime . '</span>
                </a>
                <a href="" class="px-3 py-1 ml-1 d-block text-decoration-none text-info font-weight-bold"><i class="fas fa-envelope fa-poruke"></i> Poruke</a>
                <a href="./" class="px-3 mt-3 py-1 ml-1 d-block text-light text-decoration-none item">Glavna strana</a>                
                <a href="svi-artikli.php?naziv-grupe=Bela tehnika&broj-strane=1" class="px-3 py-1 ml-1 d-block text-light text-decoration-none item">Svi artikli</a>
                <a href="dodaj-artikal.php" class="px-3 py-1 ml-1 d-block text-light text-decoration-none item">Dodaj artikal</a>
                <a href="svi-korisnici.php?broj-strane=1" class="px-3 py-1 ml-1 d-block text-light text-decoration-none item">Svi korisnici</a>
                <a href="dodaj-korisnika.php" class="px-3 py-1 ml-1 d-block text-light text-decoration-none item">Dodaj korisnika</a>
                <a href="slajder-pocetna.php" class="px-3 py-1 ml-1 d-block text-light text-decoration-none item">Slajder početna</a>
                <a href="dodaj-sliku-slajder.php" class="px-3 py-1 ml-1 d-block text-light text-decoration-none item">Dodaj slajder-sliku</a>
                <a href="logout.php" class="px-3 py-1 ml-1 d-block text-light text-decoration-none item">Odjavite se</a>
            </div>
        </div>
        <div class="d-block d-lg-none sticky-top">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-0 sticky-top">
                <a class="navbar-brand p-0 m-0" href="./svi-artikli.php?naziv-grupe=Bela tehnika&broj-strane=1">
                    <img src="./web-shop.png" class="img-user">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-1">
                        <li class="nav-item mx-2">
                            <img src="' . $korisnik->slika . '" class="img-user-sign img-responsive my-2"/>
                            <span class="text-info font-weight-bold">' . $korisnik->ime . " " . $korisnik->prezime . '</span>
                        </li>
                        <li class="nav-item mx-2">
                            <a href="" class="nav-link text-info font-weight-bold"><i class="fas fa-envelope fa-poruke"></i> Poruke</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link text-light nav-linija" href="./">Glavna strana</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link nav-linija text-light" href="svi-artikli.php?naziv-grupe=Bela tehnika&broj-strane=1">Svi artikli</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link nav-linija text-light" href="dodaj-artikal.php">Dodaj artikal</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link nav-linija text-light" href="svi-korisnici.php?broj-strane=1">Svi korisnici</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link nav-linija text-light" href="dodaj-korisnika.php">Dodaj korisnika</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link nav-linija text-light" href="slajder-pocetna.php">Slajder početna</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link nav-linija text-light" href="dodaj-sliku-slajder.php">Dodaj slajder-sliku</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link nav-linija text-light" href="logout.php">Odjavite se</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    ';
?>