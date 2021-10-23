<?php
class RackManager {

    public function __construct($bag) {
        $this->rack = array();
        $this->sizerackmax = 7;
        $this->bag = $bag;
        $this->sizerack = 0;
        $this->word = "";
    }

    function add_to_rack() {
    //Adds a tile to the rack.
        if ($this->bag->get_bag_length() >0) {
            $this->rack[] = $this->bag->take_from_bag();
        }
    }


    function remove_from_rack($num_tile) {
        //Removes a tile from the rack
        unset($this->rack[array_search($num_tile, $this->rack)]);
    }

    function replenish_rack() {
        // Adds tiles to the rack after a turn such that the rack will have the number of tiles corresponding to the size maximum defined for a rack (if possible
        while (($this->sizerack < $this->sizerackmax) and ($this->bag->get_bag_length() > 0)){
            $this->add_to_rack();
            $this->sizerack +=1;
        }
        $this->sizerack = sizeof($this->rack);
    }


    #function rack_html($currentplayer) :string {
    function rack_html($currentplayer)   {
        //HTML representation of a square
        global $pointsletters;
        $stringHTML = '<div class="tiles">';
        $position =1;
        if ($currentplayer) {
            $class="draggable-element";
        } else {
            $class="nodraggable-element";
        }
        foreach($this->rack as $letter) {
            if ($letter == '#') {
                $letter =' ';
            }
            $text = '<b>'.$letter.'</b><span class="valueletterrack ">'.'&nbsp;'.$pointsletters[$letter].'</span>';
            $stringHTML .=  '<div class="'.$class.'" >'.$text.'</div>';
            $position +=1;
        }
        $stringHTML .= '</div>';
        return $stringHTML;
    }

    function val_rack()  {
        //sum of points of the letters of a rack (used at the end of the game)
        global $pointsletters;
        $val =0;
        foreach($this->rack as $letter) {
            if ($letter != '#') {
                $val += $pointsletters[$letter];
            }
        }
        return $val;
    }
}
