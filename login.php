<?php 
    session_start();
    if(isset($_SESSION["Prijavljen"])){
        header("Location: ./");
    }
    //$_SESSION["UspesnaPrijava"] - Ovim proveravamo da li se korisnik uspesno ili neuspesno prijavio
    require_once "funkcije.php";
    proveraKolacica();
    $email = isset($_SESSION["Email"]) ? $_SESSION["Email"] : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veb Prodavnica - Prijavite se</title>
    <?php 
        require_once "bootstrap-head.php";
    ?>
</head>

<body>
    <?php 
        require_once "navigacija.php";
    ?>


    <div class="row m-0 mt-5">
        <div class="offset-sm-2 offset-md-3 offset-lg-4"></div>
        <div class="col-sm-8 col-md-6 col-lg-4">
            <form action="login-submit.php" class="login-form p-5 bg-dark text-light" onsubmit="return validateForm()"
                method="post">
                <h3 class="font-weight-normal text-info mb-4 text-center">Prijavi se</h3>

                <!-- Ovde se prikazuju poruke o greskama -->
                <div class="alert-information alert alert-danger alert-dismissible fade show d-none" role="alert">
                    <strong></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-append">
                        <span class="input-group-text tooltip-bottom">
                            <span class="tooltiptext">Vaš email</span>
                            <i class="fas fa-at"></i>
                        </span>
                    </div>
                    <input type="text" name="email" id="email" value="<?php echo $email;?>" class="form-control" placeholder="E-mail">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-append">
                        <span class="input-group-text tooltip-bottom">
                            <span class="tooltiptext">Vaša lozinka</span>
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                    <input type="password" name="lozinka" id="lozinka" class="form-control" placeholder="Lozinka">
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="zapamti-email" id="zapamti-email" value="true" checked>
                        <label class="custom-control-label text-left" for="zapamti-email">Zapamti email</label>
                    </div>
                </div>
                <button type="submit" name="btn-login" class="btn btn-info py-2 btn-block mt-4">Prijavi se</button>
                <div class="mt-5 text-center">
                    Nemate Vaš nalog? <a href="register.php" class="ml-1 text-info">Registrujte se</a>
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
        let patternEmail = /^[A-z0-9\._-]+@[A-z0-9][A-z0-9-]*(\.[A-z0-9_-]+)*\.([A-z]{2,6})$/g;
        let paternLozinka = /^[a-zA-Z0-9. ]*$/g;
        if ($("#lozinka").val() == "" || $("#email").val() == "") {
            $(".alert-information").removeClass("d-none");
            $(".alert-information strong").html("Greska! Polja za email i lozinku moraju biti popunjena!");
            return false;
        } else {
            let poruka = "";
            if ($("#email").val().match(patternEmail) == null) {
                poruka += "Email adresa sadrži nedozvoljene karatkere.<br>";
            }
            if ($("#lozinka").val().match(paternLozinka) == null) {
                poruka += "Lozinka nije u dozvoljenom formatu ili sadrzi nedozvoljene karaktere.<br>";
            }
            if (poruka != "") {
                $(".alert-information").removeClass("d-none");
                $(".alert-information strong").html(poruka);
                return false;
            }
            return true;
        }
    }
    </script>
    <?php 
        if(isset($_SESSION["Greska-Prijava"])){
            echo '
                <script>
                    $(document).ready(function() {
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information strong").html("Uneti podaci nisu tačni. Pokušaj te ponovo da se prijavite!");
                    });
                </script>
            ';
            unset($_SESSION["Greska-Prijava"]);
        }
    ?>


    <?php 
        require_once "footer.php";
    ?>
</body>

</html>