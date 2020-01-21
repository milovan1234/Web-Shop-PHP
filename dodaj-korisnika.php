<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){    
        //Provera da li je prijavljeni korisnik Administrator
        header("Location: ./");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dodaj Korsinika - Administrator</title>
    <?php 
        require_once "bootstrap-head.php";
    ?>
</head>

<body>
    <?php
        require_once "navigacija-admin.php";
        echo '<div class="main prikaz-deo">';
    ?>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-10 col-lg-6 pl-3 my-4">
                <form method="POST" action="dodavanje-korisnika.php" onsubmit="return validateForm()"
                    class="bg-dark text-light text-center p-5 form-artikal" enctype="multipart/form-data">

                    <h4 class="font-weight-normal">Dodaj Novog Korisnika</h4>
                    <!-- Polje u kome ce se prikazivate informacije pri dodavanju novog artikla -->
                    <div class="alert-information alert text-left alert-danger alert-dismissible fade show d-none mt-3"
                        role="alert">
                        <strong></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="input-group mb-3 mt-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Ime</span>
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input type="text" name="ime" id="ime" class="form-control" placeholder="Ime">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Prezime</span>
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input type="text" name="prezime" id="prezime" class="form-control" placeholder="Prezime">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Email</span>
                                <i class="fas fa-at"></i>
                            </span>
                        </div>
                        <input type="text" name="email" id="email" class="form-control" placeholder="E-mail">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Lozinka</span>
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                        <input type="password" name="lozinka" id="lozinka" class="form-control" placeholder="Lozinka">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>

                    <div class="input-group mb-3 mt-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Status korisnika</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <select class="form-control" id="status" name="status">
                            <option value="">Odaberite status korisnika</option>
                            <option value="Kupac">Kupac</option>
                            <option value="Administrator">Administrator</option>
                        </select>
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <span class="tooltip-bottom">
                            <span class="tooltiptext">Vaša slika</span>
                            <input type="file" name="slika" id="slika">
                        </span>
                    </div>
                    <button type="submit" id="submit-button" name="btn-dodaj-korisnika"
                        class="btn btn-info py-2 btn-block mt-4">Dodaj korisnika</button>

                </form>
            </div>
        </div>
    </div>

    <?php 
        require_once "bootstrap-body.php";
        echo '<script>';
        if(isset($_SESSION["Greska-Dodavanje-Korisnika"])) {
            echo '
                $(document).ready(function() {
                    $(".alert-information").removeClass("d-none");
                    $(".alert-information strong").html("' . $_SESSION["Greska-Dodavanje-Korisnika"] . '");
                });
            ';
            unset($_SESSION["Greska-Dodavanje-Korisnika"]);
        }
        else if(isset($_SESSION["Uspesno-Dodavanje-Korisnika"])){
            echo '
                $(document).ready(function() {
                    $(".alert-information").removeClass("d-none");
                    $(".alert-information").removeClass("alert-danger");
                    $(".alert-information").addClass("alert-success");
                    $(".alert-information strong").html("' . $_SESSION["Uspesno-Dodavanje-Korisnika"] . '");
                });
            ';
            unset($_SESSION["Uspesno-Dodavanje-Korisnika"]);
        }
        echo '</script>';
    ?>

    <script>
        function validateForm(){
            /*Pisanje regularnih izraza pri validiranju imena,prezime,email adrese i lozinke. Provera na klijentskoj strani.*/
            let petternImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]*(?: [A-ZŠĐČĆŽ][a-zšđčćž]*)?$/;
            let patternEmail = /^[A-z0-9\._-]+@[A-z0-9][A-z0-9-]*(\.[A-z0-9_-]+)*\.([A-z]{2,6})$/g;
            let patternLozinka = /^[a-zA-Z0-9\. ]{5,30}$/g;
            if ($("#ime").val() == "" || $("#prezime").val() == "" || $("#email").val() == "" || $("#lozinka").val() == "" || $("#status").val() == "") {
                $(".alert-information").removeClass("d-none");
                $(".alert-information").addClass("alert-danger");
                $(".alert-information").removeClass("alert-success");
                $(".alert-information strong").html(
                    "Greska! Sva polja koja su označena crvenom zvzedicom moraju biti popunjena!");
                return false;
            }
            else {
                let poruka = "";
                if ($("#ime").val().match(petternImePrezime) == null) {
                    $("#ime").val("");
                    poruka += "Ime nije u dozvoljenom formatu.<br>";
                }
                if ($("#prezime").val().match(petternImePrezime) == null) {
                    $("#prezime").val("");
                    poruka += "Prezime nije u dozvoljenom formatu.<br>";
                }
                if ($("#email").val().match(patternEmail) == null) {
                    $("#email").val("");
                    poruka += "Email adresa nije u dozvoljenom formatu.<br>";
                }
                if ($("#lozinka").val().match(patternLozinka) == null) {
                    $("#lozinka").val("");
                    poruka += "Lozinka nije u dozvoljenom formatu - mora imati najmanje 5 karaktera.<br>";
                }
                if (poruka != "") {
                    poruka += "Ispravite navedene greške!";
                    $(".alert-information").addClass("alert-danger");
                    $(".alert-information").removeClass("alert-success");
                    $(".alert-information").removeClass("d-none");
                    $(".alert-information strong").html(poruka);
                    return false;
                }
                return true;
            }
        }
        $(document).ready(function() {
            $(".futer").addClass("d-block");
            $(".futer").addClass("d-lg-none");
        });
    </script>
    <script src="./js/js-navigacija-admin.js"></script>
    <?php 
        echo '</div>';
        require_once "footer.php";
    ?>
</body>

</html>