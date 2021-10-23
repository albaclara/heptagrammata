<?php

function firstRound($varPost) {
    if (! empty($varPost['nbplayer'])) {
        $firstround = true;
    } else {
        $firstround = false;
    }
    return $firstround;
}

function listPlayers($nbplayers,$varPost) {
    for ($i = 0; $i < $nbplayers; $i++) {
        if (! empty($_POST['name__'.strval($i)])) {
        $nameplayer = strtoupper(htmlspecialchars($_POST['name__'.strval($i)]));
            $players[$i] = trim($nameplayer);
        }
    }
    return $players;
}

function uploadtiles($dialect) {
    $pointsletters = array();
    $pointsletters["ancient-greek"] = array("A"=> 1, "E"=> 1,"I"=> 1,"O"=> 1,"N"=> 1,"Σ"=>1,"T"=> 2,"Y"=> 2,"P"=> 2,"Π"=>2,"M"=> 2,"H"=> 2,"K"=> 3,"Λ"=> 3,"Ω"=>3,"Θ"=>4,"Δ"=>4,"Γ"=>4,"Φ"=>8,"X"=> 8,"B"=> 10,"Ξ"=> 10,"Z"=> 10,"Ψ"=> 10," "=> 0);

    return $pointsletters[$dialect];
}
function checkFormGame($myword,$mycolumn,$myline,$mydirection) {

    $message = "";
    //check if letters in alphabet
    if (!preg_match("#^[ABEFHIKMNOPTXYZΩΣΠΛΘΔΓΦΞΨ]+#",$myword) ) {
        $message = $myword."mot  incorrect";
    } else {
        //check if num direction, line and num column correct
        if (($myline<1) or ($mycolumn<1) or ($myline>15) or ($mycolumn>15)) {
            $message = $mycolumn." numéro de colonne ou de ligne incorrect";
        } else {
            if (($mydirection =='down') and  ($myline>15-mb_strlen($myword)+1)){
                $message = $myline." numéro de ligne incorrect";
            } else {
                if (($mydirection =='right') and ($mycolumn>15-mb_strlen($myword)+1)) {
                    $message = $mycolumn." numéro de colonne incorrect";
                }
            }
            if (! in_array($mydirection,['down','right'])) {
                $message = $mydirection." direction incorrecte";
            }
        }
    }
    return $message;
}

function writeWord($myword,$mycolumn,$myline,$mydirection,$myboard) {
    if ($mydirection == 'right') {
        $tempo = "";
        $before = mb_substr($myboard->boardplayed[$myline],0,$mycolumn);
        $after = mb_substr($myboard->boardplayed[$myline],$mycolumn+mb_strlen($myword),$myboard->width+2);
        for ($i =$mycolumn; $i < $mycolumn+mb_strlen($myword); $i++) {
            $tempo .= mb_substr($myword,$i-$mycolumn,1);
            //$myboard->boardplayed[$myline][$i]= mb_substr($myword,$i-$mycolumn,1);
         }
         $myboard->boardplayed[$myline]=$before.$tempo.$after;
    } else {
        // direction = down
        for ($i = $myline; $i < $myline+mb_strlen($myword); $i++) {
            $before= mb_substr($myboard->boardplayed[$i],0,$mycolumn);
            $after= mb_substr($myboard->boardplayed[$i],$mycolumn+1,$myboard->width+2);
            $tempo = mb_substr($myword,$i- $myline,1);
            $myboard->boardplayed[$i]=$before.$tempo.$after;
        }

    }
}

function score($myword,$blankused,$mycolumn,$myline,$mydirection,$myboard,$scrabble) {
    $col = $mycolumn;
    $line = $myline;
    $sortletters = array();
    $position = array();
    $directioninv = directionInverse($mydirection);

    // sort the letters beetween rack and board, 0 =on the board, 1 = on the rack
    $sortletters = rackOrBoard($myword, $col, $line, $myboard,$mydirection);
    // return for each position of word 1 if letter before in the inverse direction and otherwise 0
    $wordbefore = wordsCrossing($mycolumn,$myline,$mydirection,$myboard,$myword,true);
    // return for each position of word 1 if letter after in the inverse direction and otherwise 0
    $wordafter = wordsCrossing($mycolumn,$myline,$mydirection,$myboard,$myword,false);
    // compute best place for blank when same letter than blank appends more than on time in the word
    for ($i =0; $i <mb_strlen($myword); $i++) {
      if ($sortletters [$i]==1) {
        if (in_array($i,$blankused)) {
            $blankusepos = array_search($i,$blankused);
            $letterblanco = mb_substr($myword,$i,1);
            $valsameletter = bestplaceforblanco($i,$myword, $mycolumn,$myline, $mydirection, $sortletters, $myboard, $blankused);
            $posblanco = $i;
            $valblanco = $valsameletter[$i];
            $posmin = $i;
            for ($j =0; $j <mb_strlen($myword); $j++) {
                if (mb_substr($myword,$j,1) == $letterblanco) {
                  if ($valsameletter[$j] < $valblanco) {
                    $blankused[$blankusepos] = $j;
                  }
                }
            }
        }
      }
    }

    // computing word's points
    $points = scoreWord($myword, $mycolumn, $myline, $mydirection, $sortletters, $myboard, $blankused);
    // we look after words created in the direction inverse
    // for each letter of the word
    for ($i =0; $i <mb_strlen($myword); $i++) {
        $multi = 1;
        $col = $mycolumn;
        $pointsup = 0;
        $square = $myboard->nextNsquare($mycolumn,$myline,$mydirection,$i);
        $multi = multiplier($square);
        $position = $myboard->nextNposition($mycolumn,$myline,$mydirection,$i);
        $col =  $position[0];
        $line =  $position[1];
        $letterword = mb_substr($myword,$i,1);
        $valueletter = letterValue($letterword,$sortletters[$i],$col,$line,$square,$multi,$myboard);
        // a word in the direction inverse begins before this letter
        if ($wordbefore[$i]==1) {
            // store points of the letter of the word before the rest
           $pointsup += $valueletter ;
           $position = $myboard->previousNposition($col,$line,$directioninv,1);
           $pointsup += scoreWordCrossing($position,$myboard,$directioninv,true);
           if ($wordafter[$i]==1) {
               $position = $myboard->nextNposition($mycolumn,$myline,$mydirection,$i);
               $pointsup += scoreWordCrossing($position,$myboard,$directioninv,false);
           }
           $pointsup = $pointsup*$multi;
        } else {
            if ($wordafter[$i]==1) {
                $pointsup  += $valueletter ;
                $position = $myboard->nextNposition($col,$line,$directioninv,1);
                $pointsup += scoreWordCrossing($position,$myboard,$directioninv,false);
                $pointsup = $pointsup*$multi;
            }

        }
        $points += $pointsup;
    }
    if ($scrabble) {
        $points += 50;
    }
    return $points;
}

function squareValue($letter,$square,$mycolumn,$myline,$myboard) {
    global $pointsletters;
    $value = 0;
    if (! ($myboard->squareIsBlank($myline,$mycolumn))) {
        $value = $pointsletters[$letter];
        if ($square == ':') {
            $value = 2*$value;
        } elseif ($square == ';') {
            $value = 3*$value;
        }
    }
    return $value;
}

function wordsCrossing($mycolumn,$myline,$mydirection,$myboard,$myword,$before) {
    $wordscrossing = array();
    $directioninv = directionInverse($mydirection);
    $col = $mycolumn ;
    $line = $myline;

    for ($j =0; $j <mb_strlen($myword); $j++) {
        $square = $myboard->square_contents($col,$line);
        if (preg_match("#^[ABEFHIKMNOPTXYZΩΣΠΛΘΔΓΦΞΨ]#",$square)) {
                $wordscrossing[$j] = 0;
        } else {
            if ($before) {
                $square = $myboard->previousNsquare($col,$line,$directioninv,1);
            } else {
                $square = $myboard->nextNsquare($col,$line,$directioninv,1);
            }
            if (! preg_match("#^[ABEFHIKMNOPTXYZΩΣΠΛΘΔΓΦΞΨ]#",$square) ) {
                $wordscrossing[$j] = 0;
            } else {
                $wordscrossing[$j] = 1;
            }
        }
        if ($before) {
            $position = $myboard->nextNposition($col,$line,$mydirection,1);
        } else {
            $position = $myboard->nextNposition($col,$line,$mydirection,1);
        }
        $col =  $position[0];
        $line =  $position[1];
    }
    return $wordscrossing;
}

function multiplier($square) {
    $multi = 1;
    if (($square == '-') or ($square == '*')) {
        $multi = 2;
    }  elseif ($square == '=') {
        $multi = 3;
    }
    return $multi;

}

function directionInverse($direction) {
    if ($direction == 'right') {
        $directioninv = "down";
    } else {
        $directioninv = "right";
    }
    return $directioninv;
}

function remain($players) {
    $remains = 0;
    foreach ($players as $player) {
        $remains += $player->rack->val_rack();
        $player->score = $player->score - $player->rack->val_rack();
    }
    return $remains;
}

function rackOrBoard($myword, $col, $line, $myboard,$mydirection) {
// sort of the letters beetween rack and board, 0 =on the board, 1 = on the rack
    $sortletters = array();
    for ($i =0; $i <mb_strlen($myword); $i++) {
        $square = $myboard->square_contents( $col,$line);
        $letter = mb_substr($myword,$i,1);
        if (preg_match("#^[ABEFHIKMNOPTXYZΩΣΠΛΘΔΓΦΞΨ]#",$square) ) {
             array_push($sortletters,0);
        }else {
            array_push($sortletters,1);
        }
        $position = $myboard->nextNposition($col,$line,$mydirection,1);
        $col =  $position[0];
        $line =  $position[1];
    }
    return $sortletters;
}

function scoreWord($myword, $col, $line, $mydirection, $sortletters,$myboard,$blankused) {
    $multi = 1;
    $points = 0;
    $strmulti =  "multi : ".strval($multi);
    $strpoint = "lettres : ";
    for ($i =0; $i <mb_strlen($myword); $i++) {
        $letter = mb_substr($myword,$i,1);
        if ($sortletters[$i]==0) {
        //letters already on the board
            //used to verify if blank
            $position = array($line,$col,$letter);
            if ((empty($myboard->blankpositions)) or (! in_array($position,$myboard->blankpositions))) {
                $value = squareValue($letter,"",$col,$line,$myboard);
                $points += $value;
                $strpoint = $strpoint." ".strval($value)."(".$letter."[".strval($sortletters[$i])."]) , ";
            }

        } else {
        //letters on the rack
            $square = $myboard->square_contents($col,$line);
            $oldmulti = $multi;
            $multi = $multi*multiplier($square);
            if ($multi != $oldmulti) {
                $strmulti = $strmulti." -> ".strval($multi)."(".$letter."[".strval($sortletters[$i])."])";
            }
            // if it's not a blank wich is played on this square
            if (! in_array($i,$blankused)) {
                $value = squareValue($letter,$square,$col,
                $line,$myboard);
                $points += $value;
                $strpoint = $strpoint." ".strval($value)."(".$letter."[".strval($sortletters[$i])."]) , ";
            }else {
                $myboard->blankpositions[]=array($line,$col,$letter);
                $strpoint = $strpoint." 0 blank (".$letter."[".strval($sortletters[$i])."]) , ";
            }
        }
        //computing of the position of the next letter
        $position = $myboard->nextNposition($col,$line,$mydirection,1);
        $col =  $position[0];
        $line =  $position[1];
    }
    $points = $points*$multi;
    return $points;
}



function letterValue($letterword,$letteronrack,$col,$line,$square,$multi,$myboard) {
    if ($letteronrack==0) {
        // if letter was already on the board, not x2, x3
        $valueletter = squareValue($letterword,"",$col,$line,$myboard);
    } else {
        $valueletter = squareValue($letterword,$square,$col,$line,$myboard);
        $multi = $multi*multiplier($square);
    }
    return $valueletter;
}

function scoreWordCrossing($position,$myboard,$directioninv,$before) {

    $pointsup = 0;
    $col =  $position[0];
    $line =  $position[1];
    $square = $myboard->square_contents($col,$line);

    while ((preg_match("#^[ABEFHIKMNOPTXYZΩΣΠΛΘΔΓΦΞΨ]#",$square))) {
        $value = squareValue($square,"",$col,$line,$myboard);
        $pointsup += $value;
        if ($before) {
            $position = $myboard->previousNposition($col,$line,$directioninv,1);
        } else {
            $position = $myboard->nextNposition($col,$line,$directioninv,1);
        }
        $col =  $position[0];
        $line =  $position[1];
        $square = $myboard->square_contents($col,$line);

    }
    return $pointsup;
}

function bestplaceforblanco($pos,$myword, $col, $line, $mydirection, $sortletters, $myboard, $blankused) {
  $myletter = mb_substr($myword,$pos,1);
  $valsameletters = array();
  for ($i =0; $i <mb_strlen($myword); $i++) {
    if ((mb_substr($myword,$i,1) == $myletter) and  ($sortletters [$i]==1)) {
      $square = $myboard->square_contents($col,$line);
      $valsameletters[$i] = squareValue($myletter,$square,$col,$line,$myboard);
    } else {
      $valsameletters[$i] = 0;
    }
    $position = $myboard->nextNposition($col,$line,$mydirection,1);
    $col =  $position[0];
    $line =  $position[1];
  }
  return $valsameletters;
}
