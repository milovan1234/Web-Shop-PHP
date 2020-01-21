<?php
    session_start();
    if(!isset($_SESSION["Prijavljen"])){
        header("Location: ./");
    }
    require_once "rad-sa-bazom.php";
    require_once "klase.php";
    $id = $_SESSION["Id"];
    $query = "SELECT * FROM Korisnik WHERE Id=" . $id;
    $kor = new Korisnik();
    if($result = mysqli_query($connection,$query)){
        $object = mysqli_fetch_object($result);
        $kor->id = $object->Id;
        $kor->ime = $object->Ime;
        $kor->prezime = $object->Prezime;
        $kor->email = $object->Email;
        $kor->status = $object->Status;
        $kor->putanjaSlike = $object->Slika;
        $kor->aktivan = $object->Aktivan;
        $kor->datumPrijave = $object->Prijava;
    }
    else {
        die("Poruka o grešci: " . mysqli_error($connection));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Veb Prodavnica - Profil korisnika</title>
    <?php
        require_once "bootstrap-head.php";
    ?>
</head>
<body>
    <?php
        require_once "navigacija.php";
    ?>
    <div class="px-3">
        <div class="container bg-dark text-light mt-5 profil">
                <div class="row">
                    <div class="col-12 col-md-4 p-2 p-md-5 text-center">
                        <?php
                            echo '
                                <div id="slika-profil" class="mx-auto mb-3">
                                    <img src="' . $kor->putanjaSlike . '" class="img-fluid rounded-circle img-thumbnail"/>
                                </div>
                                <p class="text-secondary font-weight-bold"><span class="text-info">Poslednja prijava:</span> ' 
                                . date("d.m.Y H:i",strtotime($kor->datumPrijave)) . '</p>
                            ';
                        ?>                        
                        <!--<button type="button" class="btn btn-info px-3 font-weight-bold">
                            <label for="promeni-sliku" class="d-inline">Dodaj novu sliku</label>
                        </button>
                        <input type="file" class="d-none mx-auto" name="promena-slike" id="promeni-sliku">-->
                    </div>               
                    <div class="col-12 col-md-8 p-2 p-md-5">
                        <form action="izmena-profila.php" method="post" onsubmit="return validateForm()">
                            <h3 class="text-center mt-3 mb-4 font-weight-normal">Vaš profil</h3>
                            <!-- Polje u kome ce se prikazivate informacije pri dodavanju novog artikla -->
                            <div class="alert-information alert text-left alert-danger alert-dismissible fade show d-none mt-3"
                                role="alert">
                                <strong></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="form-row">
                                <div class="col-12 col-md-6 p-2">
                                    <label for="ime" class="font-weight-bold">Vaše Ime:</label>
                                    <input type="text" class="form-control" name="ime" id="ime">
                                </div>
                                <div class="col-12 col-md-6 p-2">
                                    <label for="prezime" class="font-weight-bold">Vaše Prezime:</label>
                                    <input type="text" class="form-control" name="prezime" id="prezime">
                                </div>
                                <div class="col-12 col-md-12 p-2">
                                    <label for="email" class="font-weight-bold">Vaš Email:</label>
                                    <input type="text" class="form-control" name="email" id="email" readonly>
                                </div>
                                <div class="col-12 col-md-6 p-2">
                                    <label for="stara-lozinka" class="font-weight-bold">Stara lozinka:</label>
                                    <input type="password" class="form-control" name="stara-lozinka" id="stara-lozinka" placeholder="Stara lozinka">
                                </div>
                                <div class="col-12 col-md-6 p-2">
                                    <label for="nova-lozinka" class="font-weight-bold">Nova Lozinka:</label>
                                    <input type="password" class="form-control" name="nova-lozinka" id="nova-lozinka" placeholder="Nova lozinka">
                                </div>
                                <div class="col-12 col-md-12 p-2">
                                    <label for="status" class="font-weight-bold">Vaš Status:</label>
                                    <input type="text" class="form-control" name="status" id="status" readonly>
                                </div>
                            </div>
                            <button type="submit" name="btn-izmeni-profil" class="btn btn-info font-weight-bold px-4 py-2 mt-3">Izmeni profil</button>
                        </form>
                    </div>
                </div>
        </div>
    </div>


    <?php
        require_once "bootstrap-body.php";
        echo '
            <script>
                $(document).ready(function(){
                    $("#ime").val("' . $kor->ime . '");
                    $("#prezime").val("' . $kor->prezime . '");
                    $("#email").val("' . $kor->email . '");
                    $("#status").val("' . $kor->status . '");
                });
            </script>
        ';
        if(isset($_SESSION["Uspesno-Izmena-Profila"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information").removeClass("alert-danger");
                        $(".alert-information").addClass("alert-success");
                        $(".alert-information strong").html("' . $_SESSION["Uspesno-Izmena-Profila"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Uspesno-Izmena-Profila"]);
        }
        else if(isset($_SESSION["Greska-Izmena-Profila"])){
            echo '
                <script>
                    $(document).ready(function(){
                        $(".alert-information").removeClass("d-none");
                        $(".alert-information strong").html("' . $_SESSION["Greska-Izmena-Profila"] . '");
                    });
                </script>
            ';
            unset($_SESSION["Greska-Izmena-Profila"]);
        }
    ?>
    <script>
        function validateForm(){
            /*Pisanje regularnih izraza pri validiranju imena,prezime,email adrese i lozinke. Provera na klijentskoj strani.*/
            let petternImePrezime = /^[A-ZŠĐČĆŽ][a-zšđčćž]*(?: [A-ZŠĐČĆŽ][a-zšđčćž]*)?$/;
            let patternLozinka = /^[a-zA-Z0-9\. ]{5,30}$/g;
            if ($("#ime").val() == "" || $("#prezime").val() == "" || $("#status").val() == "") {
                $(".alert-information").removeClass("d-none");
                $(".alert-information").addClass("alert-danger");
                $(".alert-information").removeClass("alert-success");
                $(".alert-information strong").html(
                    "Greska! Polja koja menjate ne smete ostaviti prazna!");
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
                if ($("#nova-lozinka").val().match(patternLozinka) == null && $("#nova-lozinka").val() != "") {
                    $("#nova-lozinka").val("");
                    poruka += "Nova lozinka nije u dozvoljenom formatu - mora imati najmanje 5 karaktera.<br>";
                }
                if ($("#stara-lozinka").val().match(patternLozinka) == null && $("#stara-lozinka").val() != "") {
                    $("#stara-lozinka").val("");
                    poruka += "Stara lozinka nije u dozvoljenom formatu - mora imati najmanje 5 karaktera.<br>";
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
        require_once "footer.php";
    ?>
</body>
</html>