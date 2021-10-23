<?php
class PlayerManager {
    public $num;
    public $name;

    public function __construct($num,$nom,$mybag) {
        $this->num = $num;
        $this->name = $nom;
        $this->rack = new RackManager($mybag);
        //$sizerack = $this->rack->sizerack;
        $this->score = 0;

    }

    #function get_rack_str() {
        #Returns the player's rack.
        #return $this->rack->get_rack_str()
    #}

    function increase_score($increase) {
        #Increases the player's score by a certain amount. Takes the increase (int) as an argument and adds it to the score.
        $this->score += $increase;
    }

}
