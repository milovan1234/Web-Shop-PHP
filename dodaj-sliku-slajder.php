<?php 
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dodaj slajder-sliku - Administrator</title>
    <?php 
        require_once "bootstrap-head.php";
    ?>
</head>

<body>
    <?php
        require_once "navigacija-admin.php";
        require_once "rad-sa-bazom.php";
        echo '<div class="main prikaz-deo">';
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-10 col-lg-6 pl-3 my-4">
                <form method="POST" action="dodavanje-slike-slajder.php" onsubmit="return validateForm()"
                    class="bg-dark text-light text-center p-5 form-artikal" enctype="multipart/form-data">
                    <h4 class="font-weight-normal">Dodaj sliku za Slajder</h4>
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
                                <span class="tooltiptext">Status slike</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <select class="form-control" id="status" name="status">
                            <option value="">Odaberite status slike</option>
                            <option value="0">Nekativna</option>
                            <option value="1">Ativna</option>
                        </select>&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>&nbsp;
                        <span class="tooltip-bottom">
                            <span class="tooltiptext">Slika slajder</span>                            
                            <input type="file" name="slika" id="slika">
                        </span>
                    </div>
                    <button type="submit" id="submit-button" name="btn-dodaj-sliku"
                        class="btn btn-info py-2 btn-block mt-4">Dodaj sliku za Slajder</button>
                </form>
            </div>
        </div>
    </div>
    <?php 
        require_once "bootstrap-body.php";
        if(isset($_SESSION["Uspesno-Dodata-Slika"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information").removeClass("alert-danger");
                        $(".alert-information").addClass("alert-success");
                        $(".alert-information strong").html("' . $_SESSION["Uspesno-Dodata-Slika"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Uspesno-Dodata-Slika"]);
        }
        else if(isset($_SESSION["Greska-Dodata-Slika"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information strong").html("' . $_SESSION["Greska-Dodata-Slika"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Greska-Dodata-Slika"]);
        }
    ?>
    <script>
        function validateForm() {
            if ($("#status").val() == "" || $("#slika").val() == "") {
                $(".alert-information").addClass("alert-danger");
                $(".alert-information").removeClass("alert-success");
                $(".alert-information").removeClass("d-none");
                $(".alert-information strong").html("Na formi za dodavanje novog artikla sva polja naznacena zvezdicom moraju biti popunjena!");
                return false;
            } else {
                return true;
            }
        }
        $(document).ready(function() {
            $(".futer").addClass("d-block");
            $(".futer").addClass("d-lg-none");
        });
    </script>
    <script src="js/js-navigacija-admin.js"></script>
    <?php 
        echo '</div>';
        require_once "footer.php";
    ?>
</body>

</html>