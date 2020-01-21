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
    <title>Dodaj Artikal - Administrator</title>
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
                <form method="POST" action="dodavanje-artikla.php" onsubmit="return validateForm()"
                    class="bg-dark text-light text-center p-5 form-artikal" enctype="multipart/form-data">
                    <h4 class="font-weight-normal">Dodaj Novi Artikal</h4>
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
                                <span class="tooltiptext">Grupa artikla</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <select class="form-control" id="grupa" name="grupa">
                            <option value="">Odaberite grupu artikla</option>
                            <?php
                                //Citanje iz baze svih grupa i popunjavanje padajuce liste
                                $query = "SELECT * FROM Grupa WHERE Aktivna=1";
                                if($result = mysqli_query($connection,$query)){
                                    while($object = mysqli_fetch_object($result)){
                                        echo '<option value="' . $object->Id . '">' . $object->Naziv . '</option>';
                                    }
                                }
                                else {
                                    die("Poruka o grešci: " . mysqli_error($connection));
                                }
                            ?>
                        </select>&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Naziv artikla</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <input type="text" name="naziv-artikla" id="naziv-artikla" class="form-control"
                            placeholder="Naziv artikla">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Marka artikla</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <input type="text" name="marka-artikla" id="marka-artikla" class="form-control"
                            placeholder="Marka artikla">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Broj artikala</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <input type="number" min="0" max="200" name="broj-artikala" id="broj-artikala"
                            class="form-control" placeholder="Broj artikla na stanju">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Cena artikla</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <input type="number" min="0" max="1000000" name="cena-artikla" id="cena-artikla"
                            class="form-control" placeholder="Cena artikla">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Snizenje artikla</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <input type="number" min="0" max="99" name="snizenje" id="snizenje" class="form-control"
                            placeholder="Snizenje 0 - 99%">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Opis artikla</span>
                                <i class="fas fa-cart-plus"></i>
                            </span>
                        </div>
                        <textarea name="opis-artikla" id="opis-artikla" placeholder="Kratak opis artikla"
                            class="form-control"></textarea>&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>&nbsp;
                        <span class="tooltip-bottom">
                            <span class="tooltiptext">Slika artikla</span>                            
                            <input type="file" name="slika" id="slika">
                        </span>
                    </div>
                    <button type="submit" id="submit-button" name="btn-dodaj-artikal"
                        class="btn btn-info py-2 btn-block mt-4">Dodaj Artikal</button>
                </form>
            </div>
        </div>
    </div>

    <?php 
        require_once "bootstrap-body.php";
        if(isset($_SESSION["Uspesno-Dodat-Artikal"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information").removeClass("alert-danger");
                        $(".alert-information").addClass("alert-success");
                        $(".alert-information strong").html("' . $_SESSION["Uspesno-Dodat-Artikal"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Uspesno-Dodat-Artikal"]);
        }
        else if(isset($_SESSION["Greska-Dodat-Artikal"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information strong").html("' . $_SESSION["Greska-Dodat-Artikal"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Greska-Dodat-Artikal"]);
        }
    ?>
    <script>
        function validateForm() {
            let patternNaziv = /^[A-ZČĆŽĐŠ]{1}[čćžšđa-z0-9 ]{1,99}$/g;
            let patternMarka = /^[A-Za-z0-9 ._-čćžšđČĆŽŠĐ]{2,100}$/g;
            let patternOpis = /^[a-zA-Z0-9\s-_.*+-/čćžšđČĆŽŠĐ"']{2,255}$/g;
            if ($("#grupa").val() == "" || $("#naziv-artikla").val() == "" || $("#marka-artikla").val() == "" ||
                $("#broj-artikala").val() == "" || $("#cena-artikla").val() == "" || $("#snizenje").val() == "" ||
                $("#opis-artikla").val() == "" || $("#slika").val() == "") {
                $(".alert-information").addClass("alert-danger");
                $(".alert-information").removeClass("alert-success");
                $(".alert-information").removeClass("d-none");
                $(".alert-information strong").html("Na formi za dodavanje novog artikla sva polja naznacena zvezdicom moraju biti popunjena!");
                return false;
            } else {
                let poruka = "";
                if ($("#naziv-artikla").val().match(patternNaziv) == null) {
                    $("#naziv-artikla").val("");
                    poruka += "Naziv artikla nije u dozvoljenom formatu.<br>";
                }
                if ($("#marka-artikla").val().match(patternMarka) == null) {
                    $("#marka-artikla").val("");
                    poruka += "Marka artikla u dozvoljenom formatu.<br>";
                }  
                if ($("#opis-artikla").val().match(patternOpis) == null) {
                    $("#opis-artikla").val("");
                    poruka += "Opis artikla nije u dozvoljenom formatu.<br>";
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
    <script src="js/js-navigacija-admin.js"></script>
    <?php 
        echo '</div>';
        require_once "footer.php";
    ?>
</body>

</html>