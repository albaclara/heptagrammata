<?php
class BagManager {

    public function __construct() {
        //$this->pointsletters = array( 'A'=>1, 'B'=>3, 'C'=>2, 'D'=>2, ' E'=>1, 'F'=>6, 'G'=>3, 'H'=>8, 'I'=>1, 'J'=>8, 'L'=>1, 'M'=>2, 'N'=>1, 'O'=>1, 'P'=>3, 'Q'=>8, 'R'=>1, 'S'=>1, 'T'=>1, 'U'=>2, 'V'=>3, ' X'=>10 , 'Z'=>8);
        $this->bag = array();
    }

    function add_to_bag($letter, $quantity) {
        #Adds a certain quantity of a certain tile to the bag. Takes a tile and an integer quantity as arguments.
        for ($i = 1; $i <= $quantity; $i++) {
            $this->bag[] = $letter;
        }
    }

    function  initialize_bag($dialect,$range) {
        // Adds the intial 102 tiles to the bag .Contains 100 letters and two blank represented by # for normal board
       $bag= array();
       if ($range == "junior") {
            $bag["ancient-greek"]= array("A"=> 11, "E"=> 10,"I"=> 9,"O"=> 8,"N"=> 8,"Σ"=>8,"T"=> 6,"Y"=> 5,"P"=> 5,"Π"=>4,"M"=> 4,"H"=> 4,"K"=> 3,"Λ"=> 3,"Ω"=>3,"Θ"=>2,"Δ"=>2,"Γ"=>2,"Φ"=>1,"X"=> 1,"B"=> 1,"Ξ"=> 1,"Z"=> 1,"Ψ"=> 1,"#"=> 2);

       }  else {
            $bag["ancient-greek"]= array("A"=> 11, "E"=> 10,"I"=> 9,"O"=> 8,"N"=> 8,"Σ"=>8,"T"=> 6,"Y"=> 5,"P"=> 5,"Π"=>4,"M"=> 4,"H"=> 4,"K"=> 3,"Λ"=> 3,"Ω"=>3,"Θ"=>2,"Δ"=>2,"Γ"=>2,"Φ"=>1,"X"=> 1,"B"=> 1,"Ξ"=> 1,"Z"=> 1,"Ψ"=> 1,"#"=> 2);

       }
       foreach( $bag[$dialect] as $key => $value ) {
           $this->add_to_bag($key, $value);
       }
       shuffle($this->bag);

    }

    function reload($myobjects) {
        #Returns the number of tiles left in the bag.
        //$this->pointsletters = json_decode($myobjects)[0]->pointsletters;
        $this->bag = json_decode($myobjects)[0]->bag;

    }

    function take_from_bag() {
        #Removes a tile from the bag and returns it to the user. This is used for replenishing the rack.
        if ($this->get_bag_length() > 0) {
            $letter = array_shift($this->bag);
            return $letter;
        } else {
            return "";
        }


    }

    function get_bag_length() {
        $strbag = implode("",$this->bag);
        return mb_strlen($strbag);
        //return sizeof($this->bag);
    }

    function bag_html()  {
        //An HTML representation of the bag
        $strHTML = '';
        foreach ($this->bag as $letter) {
            $strHTML .= $letter;
        }
        $strHTML .= '';
        return $strHTML;

    }

}
