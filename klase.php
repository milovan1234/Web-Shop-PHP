<?php
    class Grupa {
        private $id;
        private $naziv;
        private $putanjaSlike;
        private $aktivna;
        public function __get($name){
            return $this->$name;
        }
        public function __set($name, $value){
            $this->$name = $value;
        }
    }

    
    class Korisnik {
        private $id;
        private $ime;
        private $prezime;
        private $email;
        private $lozinka;
        private $status;
        private $putanjaSlike;
        private $aktivan;
        private $datumPrijave;
        public function __get($name){
            return $this->$name;
        }
        public function __set($name, $value){
            $this->$name = $value;
        }
    }

    class Slajder {
        private $id;
        private $putanjaSlike;
        private $aktivna;
        private $izmena;
        private $datumDodavanja;
        public function __get($name){
            return $this->$name;
        }
        public function __set($name, $value){
            $this->$name = $value;
        }
    }

    class Artikal {
        private $id;
        private $idGrupe;
        private $naziv;
        private $marka;
        private $brojStanja;
        private $prodato;
        private $cena;
        private $popust;
        private $cenaSaPopustom;
        private $opis;
        private $slika;
        private $datumDodavanja;
        public function __get($name){
            return $this->$name;
        }
        public function __set($name, $value){
            $this->$name = $value;
        }
    }
?>