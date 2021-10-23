<?php
class GameManager  {

    public function __construct($nbplayers,$players,$mybag) {
        $this->nbplayers = $nbplayers;
        $this->currentplayer = 0;
        $this->currentround = 1;
        $playersObj =array();
        for ($i = 0; $i < $nbplayers; $i++) {
            //${'player'.strval($i)}  = new PlayerManager($i, $players[$i],$mybag,true);
            ${'player'.strval($i)}  = new PlayerManager($i, $players[$i],$mybag);
            $playersObj[$i] = ${'player'.strval($i)};
        }

        $this->players = $playersObj;
        $this->numberturnskip = 0;
    }

    function initialize() {
        foreach ($this->players as $player) {
            $player->rack->replenish_rack();
        }
    }

    function reload($myobjects,$myword,$mybag,$mynewrack) {

        $this->currentplayer = json_decode($myobjects)[2]->currentplayer;
        $this->numberturnskip =  json_decode($myobjects)[2]->numberturnskip;
        $this->currentround =  json_decode($myobjects)[2]->currentround;
        $scrabble = false;
        //word not  empty (player has  not missed turn)
        for ($i = 0; $i < $this->nbplayers; $i++) {
            $this->players[$i]->score = json_decode($myobjects)[2]->players[$i]->score;
            $this->players[$i]->rack = new RackManager($mybag,false);
            $this->players[$i]->rack->rack = json_decode($myobjects)[2]->players[$i]->rack->rack;
            $this->players[$i]->rack->sizerack = json_decode($myobjects)[2]->players[$i]->rack->sizerack;
            if ($i != $this->currentplayer) {
               $this->players[$i]->rack->bag = $mybag;
           } else {
               if ($myword != "") {
                      //check if there is a scrabble
                      $this->numberturnskip = 0;
                      $sizeoldrack =  $this->players[$i]->rack->sizerack;
                      if (($sizeoldrack==7) and (empty($mynewrack))) {
                          $scrabble = true;
                          $this->players[$i]->rack->sizerack = 0;
                      }
                       $this->players[$i]->rack->rack = array();
                     // if current player, we just add letters non employed for word
                     foreach ($mynewrack as $letter){
                         $this->players[$i]->rack->rack[] = $letter;
                         $this->players[$i]->rack->sizerack = sizeof( $this->players[$i]->rack->rack);
                     }

                     $this->players[$i]->rack->bag = $mybag;
                     $this->players[$i]->rack->replenish_rack();
                     $this->players[$i]->rack->sizerack = sizeof($this->players[$i]->rack->rack);
                 //word  empty (player has missed turn)
                 } else {
                     $this->numberturnskip += 1;
                     $this->players[$i]->rack->rack = json_decode($myobjects)[2]->players[$i]->rack->rack;
                 }
                 $this->bag = $this->players[$i]->rack->bag->bag;
                 if ($myword == "") {
                     $this->numberturnskip +=1;
                 } else {
                     $this->numberturnskip =0;
                 }
             }
         }
         return $scrabble ;
     }

}
