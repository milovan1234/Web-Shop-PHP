<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
    if(!isset($_GET["id-artikla"])){
        header("Location: svi-artikli-admin.php?naziv-grupe=Bela tehnika&broj-strane=1");
    }
    require_once "rad-sa-bazom.php";
    require_once "klase.php";

    //Vrsi se provera da li id-artikla iz GET metode pripada nekom od artikala
    $id = $_GET["id-artikla"];
    $query = "SELECT * FROM Artikal";
    $artikal = new Artikal();
    $check = false;
    if($result = mysqli_query($connection,$query)){
        while($object = mysqli_fetch_object($result)){
            if($object->Id == $id){
                $artikal->id = $object->Id;
                $artikal->idGrupe = $object->IdGrupe;
                $artikal->naziv = $object->Naziv;
                $artikal->marka = $object->Marka;
                $artikal->brojStanja = $object->BrojStanja;
                $artikal->cena = $object->Cena;
                $artikal->popust = $object->Popust;
                $artikal->opis = $object->Opis;
                $artikal->slika = $object->Slika;
                $check = true;
                break;
            }
        }
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
    if(!$check){
        header("Location: ./");
    }    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Izmena Artikla - Administrator</title>
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
                <form method="POST" action="izmena-artikla.php" onsubmit="return validateForm()"
                    class="bg-dark text-light text-center p-5 form-artikal" enctype="multipart/form-data">
                    <h4 class="font-weight-normal">Izmena Artikla</h4>
                    <!-- Polje u kome ce se prikazivate informacije pri dodavanju novog artikla -->
                    <div class="alert-information alert text-left alert-danger alert-dismissible fade show d-none mt-3"
                        role="alert">
                        <strong></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                        echo '
                            <img data-toggle="modal" data-target="#modal-slika" class="img-izmena border border-info mt-4" src="' . $artikal->slika . '">
                        ';
                    ?>
                    <div class="input-group mb-3 mt-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Grupa artikla</span>
                                <i class="fas fa-edit"></i>
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
                                <i class="fas fa-edit"></i>
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
                                <i class="fas fa-edit"></i>
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
                                <i class="fas fa-edit"></i>
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
                                <i class="fas fa-edit"></i>
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
                                <i class="fas fa-edit"></i>
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
                                <i class="fas fa-edit"></i>
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
                            <span class="tooltiptext">Nova slika</span>
                            <input type="file" name="slika" id="slika">
                        </span>
                    </div>
                    <?php 
                        echo '
                            <input type="hidden" name="putanja-stare-slike" id="putanja-stare-slike">
                            <input type="hidden" name="id-artikla" id="id-artikla">
                        ';
                    ?>
                    <button type="submit" id="submit-button" name="btn-izmeni-artikal"
                        class="btn btn-info py-2 btn-block mt-4">Izmeni Artikal</button>
                </form>
            </div>
            <div class="d-none d-lg-block col-lg-6 pl-3 my-4 text-center">
                <img class="img-fluid" id="slika-zumirano" src="">
            </div>
        </div>
    </div>

    <?php 
        //Modal Slika
        echo '
        <div class="modal fade" id="modal-slika" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <img data-toggle="modal" data-target="#modal-slika" class="img-fluid mx-auto" src="' . $artikal->slika . '">
            </div>
        </div>';
    ?>

    <?php 
        require_once "bootstrap-body.php";
        echo '
            <script>
                $(document).ready(function(){
                    $("#id-artikla").val("' . $artikal->id . '");
                    $("#grupa option[value=' . $artikal->idGrupe . ']").attr("selected","selected");
                    $("#naziv-artikla").val("' . $artikal->naziv . '");
                    $("#marka-artikla").val("' . $artikal->marka . '");
                    $("#broj-artikala").val("' . $artikal->brojStanja . '");
                    $("#cena-artikla").val("' . $artikal->cena . '");
                    $("#snizenje").val("' . $artikal->popust . '");
                    $("#opis-artikla").val("' . $artikal->opis. '");
                    $("#putanja-stare-slike").val("' . $artikal->slika . '");
                });
            </script>
        ';
        if(isset($_SESSION["Uspesna-Izmena-Artikla"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information").removeClass("alert-danger");
                        $(".alert-information").addClass("alert-success");
                        $(".alert-information strong").html("' . $_SESSION["Uspesna-Izmena-Artikla"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Uspesna-Izmena-Artikla"]);
        }
        else if(isset($_SESSION["Greska-Izmena-Artikla"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information strong").html("' . $_SESSION["Greska-Izmena-Artikla"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Greska-Izmena-Artikla"]);
        }
    ?>
    <script>
        function validateForm() {
            let patternNaziv = /^[A-ZČĆŽĐŠ]{1}[čćžšđa-z0-9 ]{1,99}$/g;
            let patternMarka = /^[A-Za-z0-9 ._-čćžšđČĆŽŠĐ]{2,100}$/g;
            let patternOpis = /^[a-zA-Z0-9\s-_.*+-/čćžšđČĆŽŠĐ"']{2,255}$/g;
            if ($("#grupa").val() == "" || $("#naziv-artikla").val() == "" || $("#marka-artikla").val() == "" ||
                $("#broj-artikala").val() == "" || $("#cena-artikla").val() == "" || $("#snizenje").val() == "" ||
                $("#opis-artikla").val() == "") {
                $(".alert-information").addClass("alert-danger");
                $(".alert-information").removeClass("alert-success");
                $(".alert-information").removeClass("d-none");
                $(".alert-information strong").html("Da bi ste izmenili artikal morate popuniti sva polja oznacena zvezdicom koja ste izbrisali prilikom izmene!");
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
            $(".img-izmena").on("mouseenter", function(){
                $("#slika-zumirano").attr("src",$(".img-izmena").attr("src"));
                $("#slika-zumirano").addClass("border border-dark");
            });
            $(".img-izmena").on("mouseleave", function(){
                $("#slika-zumirano").attr("src","");
            });
        });
    </script>

    <script src="./js/js-navigacija-admin.js"></script>
    <?php 
        echo '</div>';
        require_once "footer.php";
    ?>
</body>

</html>