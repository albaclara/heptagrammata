<?php
class BoardManager {

    public function __construct($range) {

        if ($range == "junior") {
            $this->width = 13;
            $this->height = 13;
        } else {
            $this->width = 17;
            $this->height = 17;
        }

        $ACROSS = 1;
        $this->directions = array($ACROSS, $this->height, -$ACROSS, -$this->height);
        $this->board=array();
        $this->boardplayed=array();
        // store positions of blanks put on the board (line,column)
        $this->blankpositions=array();
        $this->squarestyle = array('#'=>'squareBorder', ':'=>'squareTwiceLetter', ';'=>'squareTripleLetter', '-'=>'squareTwiceWord', '='=>'squareTripleWord', '.'=>'squareSingleLetter ', '*'=>'squareStar','squareLetter'=>'squareLetter');
        #$this->squarelegend = array('#'=>'', ':'=>'DL', ';'=>'TL', '-'=>'DM', '='=>'TM', '.'=>' ', '*'=>'&#10029'," "=>" ");
        $this->squarelegend = array('#'=>'', ':'=>' ', ';'=>' ', '-'=>' ', '='=>' ', '.'=>' ', '*'=>'&#10029'," "=>" ");


        $this->initializeSquaresValueBoard($range);
        $this->initializeBoardPlayed($range);
    }

    function initializeSquaresValueBoard($range) {
        if ($range == "junior") {
            $this->board[0] =  '#############';
            $this->board[1] =  '#=..:.=.:..=#';
            $this->board[2] =  '#.;..-.-..;.#';
            $this->board[3] =  '#..-..:..-..#';
            $this->board[4] =  '#:..;...;..:#';
            $this->board[5] =  '#.-..:.:..-.#';
            $this->board[6] =  '#=.:..*..:.=#';
            $this->board[7] =  '#.-..:.:..-.#';
            $this->board[8] =  '#:..;...;..:#';
            $this->board[9] =  '#..-..:..-..#';
            $this->board[10] = '#.;..-.-..;.#';
            $this->board[11] = '#=..:.=.:..=#';
            $this->board[12] = '#############';
        } else {
            $this->board[0] =  '#################';
            $this->board[1] =  '#=..:...=...:..=#';
            $this->board[2] =  '#.-...;...;...-.#';
            $this->board[3] =  '#..-...:.:...-..#';
            $this->board[4] =  '#:..-...:...-..:#';
            $this->board[5] =  '#....-.....-....#';
            $this->board[6] =  '#.;...;...;...;.#';
            $this->board[7] =  '#..:...:.:...:..#';
            $this->board[8] =  '#=..:...*...:..=#';
            $this->board[9] =  '#..:...:.:...:..#';
            $this->board[10] = '#.;...;...;...;.#';
            $this->board[11] = '#....-.....-....#';
            $this->board[12] = '#:..-...:...-..:#';
            $this->board[13] = '#..-...:.:...-..#';
            $this->board[14] = '#.-...;...;...-.#';
            $this->board[15] = '#=..:...=...:..=#';
            $this->board[16] = '#################';
        }
    }

    function initializeBoardPlayed($range) {
        if ($range == "junior") {
            $this->boardplayed[0] =  '#############';
            $this->boardplayed[1] =  '#=..:.=.:..=#';
            $this->boardplayed[2] =  '#.;..-.-..;.#';
            $this->boardplayed[3] =  '#..-..:..-..#';
            $this->boardplayed[4] =  '#:..;...;..:#';
            $this->boardplayed[5] =  '#.-..:.:..-.#';
            $this->boardplayed[6] =  '#=.:..*..:.=#';
            $this->boardplayed[7] =  '#.-..:.:..-.#';
            $this->boardplayed[8] =  '#:..;...;..:#';
            $this->boardplayed[9] =  '#..-..:..-..#';
            $this->boardplayed[10] = '#.;..-.-..;.#';
            $this->boardplayed[11] = '#=..:.=.:..=#';
            $this->boardplayed[12] = '#############';
        } else {
            $this->boardplayed[0] =  '#################';
            $this->boardplayed[1] =  '#=..:...=...:..=#';
            $this->boardplayed[2] =  '#.-...;...;...-.#';
            $this->boardplayed[3] =  '#..-...:.:...-..#';
            $this->boardplayed[4] =  '#:..-...:...-..:#';
            $this->boardplayed[5] =  '#....-.....-....#';
            $this->boardplayed[6] =  '#.;...;...;...;.#';
            $this->boardplayed[7] =  '#..:...:.:...:..#';
            $this->boardplayed[8] =  '#=..:...*...:..=#';
            $this->boardplayed[9] =  '#..:...:.:...:..#';
            $this->boardplayed[10] = '#.;...;...;...;.#';
            $this->boardplayed[11] = '#....-.....-....#';
            $this->boardplayed[12] = '#:..-...:...-..:#';
            $this->boardplayed[13] = '#..-...:.:...-..#';
            $this->boardplayed[14] = '#.-...;...;...-.#';
            $this->boardplayed[15] = '#=..:...=...:..=#';
            $this->boardplayed[16] = '#################';
        }
    }


    function reload($myobjects) {
        $this->boardplayed =  json_decode($myobjects)[1]->boardplayed;
        $this->blankpositions = json_decode($myobjects)[1]->blankpositions;
    }

    function board_html()  {
        //An HTML representation of the board.
        $boardhtml = array();
        $letterline = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O"];
        $indicetab = 0;
        $boardhtml[$indicetab] = '<table id="board" ><tr>';
        $indicetab += 1;
        $stringHTML = '';
        //border
        for ($i=0; $i<$this->width; $i++) {
            if (($i <2)  or ($i == $this->width)){
                $stringHTML .= '<td></td>';
            } else {
                $stringHTML .= '<td>'.($i-1).'</td>';
            }
        }
        $boardhtml[$indicetab] = $stringHTML;
        $indicetab += 1;
        $boardhtml[$indicetab] =  '</tr>';
        $indicetab += 1;
        $indiceline = 0;

        foreach($this->boardplayed as $boardline) {
            $boardhtml[$indicetab] = '<tr id="'.$indiceline.'" >';
            // numbering lines
            if (($indiceline ==0)  or ($indiceline == $this->height-1)){
                $stringHTML = '<td></td>';
            } else {
                //$stringHTML = '<td>'.$indiceline.'</td>';
                $stringHTML = '<td>'.$letterline[$indiceline-1].'</td>';
            }

            $indicetab += 1;

            for ($i=0; $i<mb_strlen($boardline); $i++) {
                $square = mb_substr($boardline , $i,1);
                if (preg_match("#^[ABEFHIKMNOPTXYZabefhikmnoptxyz ΛΩΣΠΛΘΔΓΦΞΨ]+$#",$square)) {
                    $letter = $square;
                } else {
                    $letter = "";
                }
                $indicetab += 1;
                $stringHTML .= $this->square_html( $square,$letter,$indiceline,$i);
            }
            $indicetab += 1;
            $boardhtml[$indicetab] = $stringHTML."</tr>";
            $indicetab += 1;
            $indiceline += 1;
        }
        $boardhtml[$indicetab] = '</table>';

        return $boardhtml;
    }

    #function square_html(string $sqsymbol,string $letter,$line,$col) :string {
    function square_html( $sqsymbol, $letter,$line,$col)  {
        global $pointsletters;
        //An HTML representation of a square
        $txt = $letter;
        //$id = intval($line)+"_"+intval($col);

        $id =strval($col);
        if ($letter=="") {
            $txt = $this->squarelegend[$sqsymbol];
            //return "<td class='".$this->squarestyle[$sqsymbol]."' id = '".$id."' >".$txt."</td>" ;
            return "<td id='".$line."_".$id."' class='".$this->squarestyle[$sqsymbol]."'>".$txt."</td>" ;
        } else {
            $position = array($line,$col,$letter);
            if (! empty($this->blankpositions) and in_array($position,$this->blankpositions)) {
                //$txt = '<b>&nbsp;</b><span class="valueletterboard ">0</span>';
                $txt = '<b><span class="blankboard">'.$letter.'</b><span class="valueletterboard ">0</span></span>';
            } else {
                $txt = '<b>'.$letter.'</b><span class="valueletterboard ">'.$pointsletters[$letter].'</span>';
            }
            return "<td class='".$this->squarestyle['squareLetter']."' id='".$line."_".$id."'  >".$txt."</td>" ;
        }
    }

    #function square_contents(string $col,string $line) :string {
    function square_contents( $col,  $line){
        //return contents of the square in board_played
        return mb_substr($this->boardplayed[$line], $col,1) ;
    }

    function nextNsquare( $column, $line,  $direction,$n) {
    // this function returns the nth next square
        if ($direction == 'right') {
            $square = $this->square_contents($column+$n,$line);
        } else {
            $square = $this->square_contents($column,$line+$n);
        }
        return $square;
    }
    function previousNsquare(  $column, $line, $direction,$n) {
    // this function returns the nthprevious square
        if ($direction == 'right') {
            $square = $this->square_contents($column-$n,$line);
        } else {
            $square = $this->square_contents($column,$line-$n);
        }
        return $square;
    }

   function nextNposition( $col,  $line,  $direction,$n) {

        if ($direction == 'right') {
            $col = $col+$n;
        } else {
            $line = $line+$n;
        }
        $position = array($col,$line);
        return $position;
    }

    function previousNposition( $col, $line, $direction,$n) {

         if ($direction == 'right') {
             $col = $col-$n;
         } else {
             $line = $line-$n;
         }
         $position = array($col,$line);
         return $position;
     }

     function squareIsBlank(  $line,  $col) {
         $ok=false;
         $posblank =array($line,$col);
         foreach ($this->blankpositions as $elem) {
            if (($posblank[0]==$elem[0]) and ($posblank[1]==$elem[1])) {
                $ok=true;
            }
         }
         return $ok;
    }

}
