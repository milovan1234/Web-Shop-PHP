<?php 
    session_start();
    if(isset($_SESSION["Prijavljen"])){
        header("Location: ./");
    }
    //$_SESSION["Prijavljen"] - Ovim indetifikujemo ako je korisnik prijavljen da ne moze opet doci na ovu stranicu
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veb Prodavnica - Registrujte se</title>
    <?php 
        require_once "bootstrap-head.php";
    ?>
</head>

<body>
    <?php 
        require_once "navigacija.php";
    ?>

    <div class="row m-0 mt-5">
        <div class="offset-sm-2 offset-lg-4"></div>
        <div class="col-sm-8 col-lg-4">
            <form action="register-submit.php" class="login-form p-5 bg-dark text-light"
                onsubmit="return validateForm()" enctype="multipart/form-data" method="POST">
                <h3 class="font-weight-normal text-info mb-4 text-center">Registruj se</h3>

                <!-- Ovde ce biti prikazivane poruke o greskama ili uspesnoj registraciji -->
                <div class="alert-information alert alert-danger alert-dismissible fade show d-none" role="alert">
                    <strong></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text tooltip-bottom">
                            <span class="tooltiptext">Vaše ime</span>
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
                            <span class="tooltiptext">Vaše prezime</span>
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
                            <span class="tooltiptext">Vaš email</span>
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
                            <span class="tooltiptext">Vaša lozinka</span>
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                    <input type="password" name="lozinka" id="lozinka" class="form-control" placeholder="Lozinka">&nbsp;
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
                <button type="submit" id="submit-button" name="btn-register"
                    class="btn btn-info py-2 btn-block mt-4">Registruj
                    se</button>
                <a href="login.php" class="btn btn-success py-2 btn-block mt-4">Prijavi se</a>

                <div class="mt-4 text-center">
                    Pročitajte, <a href="#" class="ml-1 text-info">uslove korišćenja</a>
                </div>
            </form>
        </div>
    </div>


    <?php        
        require_once "bootstrap-body.php";
    ?>
    <script>
    $(document).ready(function() {
        $(".futer").removeClass("bg-dark");
        $(".futer").addClass("text-dark");
        $(".futer").addClass("font-weight-bold");
    });

    function validateForm() {
        /*Pisanje regularnih izraza pri validiranju imena,prezime,email adrese i lozinke. Provera na klijentskoj strani.*/
        let petternImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]*(?: [A-ZŠĐČĆŽ][a-zšđčćž]*)?$/;
        let patternEmail = /^[A-z0-9\._-]+@[A-z0-9][A-z0-9-]*(\.[A-z0-9_-]+)*\.([A-z]{2,6})$/g;
        let patternLozinka = /^[a-zA-Z0-9\. ]{5,30}$/g;

        if ($("#ime").val() == "" || $("#prezime").val() == "" || $("#email").val() == "" || $("#lozinka").val() == "") {
            $(".alert-information").removeClass("d-none");
            $(".alert-information").addClass("alert-danger");
            $(".alert-information").removeClass("alert-success");
            $(".alert-information strong").html(
                "Greska! Sva polja koja su označena crvenom zvzedicom moraju biti popunjena!");
            return false;
        } else {
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
    </script>
    <?php
        echo '<script>';
        if(isset($_SESSION["Greska-Regsitracija"])) {
            echo '
                $(document).ready(function() {
                    $(".alert-information").removeClass("d-none");
                    $(".alert-information strong").html("' . $_SESSION["Greska-Regsitracija"] . '");
                });
            ';
            unset($_SESSION["Greska-Regsitracija"]);
        }
        else if(isset($_SESSION["Uspesno-Registracija"])){
            echo '
                $(document).ready(function() {
                    $(".alert-information").removeClass("d-none");
                    $(".alert-information").removeClass("alert-danger");
                    $(".alert-information").addClass("alert-success");
                    $(".alert-information strong").html("' . $_SESSION["Uspesno-Registracija"] . '");
                });
            ';
            unset($_SESSION["Uspesno-Registracija"]);
        }
        echo '</script>';
    ?>

    <?php 
        require_once "footer.php";
    ?>
</body>

</html>