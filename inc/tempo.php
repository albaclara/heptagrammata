<?php
// ==================================
function bestplaceforblanco($pos,$myword, $col, $line, $mydirection, $sortletters, $myboard, $blankused) {
  $myletter = $myword[$pos];
  $valsameletters = array();
  for ($i =0; $i <mb_strlen($myword); $i++) {
    if (($myword[$i] == $myletter) and  ($sortletters [$i]==1)) {
      $square = $myboard->square_contents($col,$line);
      if (! in_array($i,$blankused)) {
            $valsameletters[$i] = squareValue($letter,$square,$col,$line,$myboard);
        } else {
            $valsameletters[$i] = 0;
        }
    } else {
      $valsameletters[$i] = 0;
    }
    $position = $myboard->nextNposition($col,$line,$mydirection,1);
    $col =  $position[0];
    $line =  $position[1];
  }
  return $valsameletters[$i];
}
// ==================================
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
// ==================================
    for ($i =0; $i <mb_strlen($myword); $i++) {
      if ($sortletters [$i]==1) {
        if (in_array($i,$blankused)) {
            $valsameletter = bestplaceforblanco($pos,$myword, $mycolumn,$myline, $mydirection, $sortletters, $myboard, $blankused);
            echo $valsameletter;
      }
    }
// ==================================
    // computing word's points
    $points = scoreWord($myword, $mycolumn, $myline, $mydirection, $sortletters, $myboard, $blankused);
    // we look after words created in the direction inverse
    // for each letter of the word
    for ($i =0; $i <mb_strlen($myword); $i++) {
        $multi = 1;
        $col = $mycolumn;
        $pointsup = 0;
        $square = $myboard->nextNsquare($mycolumn,$myline,$mydirection,$i);
        //modif=====================================================
        $multi = multiplier($square);
        // fin modif ============================================
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
?>
