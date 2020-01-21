<?php
    session_start();
    if(!(isset($_SESSION["Prijavljen"]) &&  $_SESSION["Status"] == "Administrator")){ //Provera da li je prijavljeni korisnik Admin
        header("Location: ./");
    }
    if(!isset($_GET["id-korisnika"])){
        header("Location: svi-korisnici.php?broj-strane=1");
    }
    require_once "rad-sa-bazom.php";
    require_once "klase.php";
    $id = $_GET["id-korisnika"];
    $query = "SELECT * FROM Korisnik WHERE Id!=" . $_SESSION["Id"];
    $k = new Korisnik();
    $check = false;
    if($result = mysqli_query($connection,$query)){
        while($object = mysqli_fetch_object($result)){
            if($object->Id == $id){
                $k->id = $object->Id;
                $k->ime = $object->Ime;
                $k->prezime = $object->Prezime;
                $k->email = $object->Email;
                $k->lozinka = $object->Lozinka;
                $k->status = $object->Status;
                $k->putanjaSlike = $object->Slika;
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Izmena Korisnika - Administrator</title>
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
                <form method="POST" action="izmena-korisnika.php" onsubmit="return validateForm()"
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

                    <?php
                        echo '
                            <img data-toggle="modal" data-target="#modal-slika" class="img-izmena border border-info mt-4" src="' . $k->putanjaSlike . '">
                        ';
                    ?>

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
                        <input type="text" name="email" id="email" class="form-control" placeholder="E-mail" readonly>&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text tooltip-bottom">
                                <span class="tooltiptext">Nova Lozinka</span>
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                        <input type="password" name="lozinka" id="lozinka" class="form-control" placeholder="Nova Lozinka">&nbsp;
                        <div class="input-group-append">
                            <span class="text-danger">&nbsp;</span>
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

                    <?php 
                        echo '
                            <input type="hidden" name="putanja-stare-slike" id="putanja-stare-slike">
                            <input type="hidden" name="id-korisnika" id="id-korisnika">
                            <input type="hidden" name="stara-lozinka" id="stara-lozinka">
                        ';
                    ?>


                    <button type="submit" id="submit-button" name="btn-izmeni-korisnika"
                        class="btn btn-info py-2 btn-block mt-4">Izmeni korisnika</button>

                </form>
            </div>
        </div>
    </div>

    <?php 
        //Modal Slika
        echo '
            <div class="modal fade" id="modal-slika" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <img data-toggle="modal" data-target="#modal-slika" class="img-fluid" src="' . $k->putanjaSlike . '">
                </div>
            </div>
        ';
    ?>

    <?php 
        require_once "bootstrap-body.php";
        echo '
            <script>
                $(document).ready(function(){
                    $("#id-korisnika").val("' . $k->id . '");
                    $("#status option[value=' . $k->status . ']").attr("selected","selected");
                    $("#ime").val("' . $k->ime . '");
                    $("#prezime").val("' . $k->prezime . '");
                    $("#email").val("' . $k->email . '");
                    $("#stara-lozinka").val("' . $k->lozinka . '");
                    $("#putanja-stare-slike").val("' . $k->putanjaSlike . '");
                });
            </script>
        ';
        if(isset($_SESSION["Uspesno-Izmena-Korisnika"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information").removeClass("alert-danger");
                        $(".alert-information").addClass("alert-success");
                        $(".alert-information strong").html("' . $_SESSION["Uspesno-Izmena-Korisnika"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Uspesno-Izmena-Korisnika"]);
        }
        else if(isset($_SESSION["Greska-Izmena-Korisnika"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information strong").html("' . $_SESSION["Greska-Izmena-Korisnika"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Greska-Izmena-Korisnika"]);
        }
    ?>
    <script>
        function validateForm(){
            /*Pisanje regularnih izraza pri validiranju imena,prezime,email adrese i lozinke. Provera na klijentskoj strani.*/
            let petternImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]*(?: [A-ZŠĐČĆŽ][a-zšđčćž]*)?$/;
            let patternEmail = /^[A-z0-9\._-]+@[A-z0-9][A-z0-9-]*(\.[A-z0-9_-]+)*\.([A-z]{2,6})$/g;
            let patternLozinka = /^[a-zA-Z0-9\. ]{5,30}$/g;
            if ($("#ime").val() == "" || $("#prezime").val() == "" || $("#email").val() == "" || $("#status").val() == "") {
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
                if ($("#lozinka").val().match(patternLozinka) == null && $("#lozinka").val() != "") {
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