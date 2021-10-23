<?php
//home = homepage where players are declared
//game = page where game is played or when game is over

// $translation
if (isset($_POST['dialect'])) {
    $_SESSION["dialecte"]= htmlspecialchars($_POST['dialect']);
} else {
    if  (! isset($_SESSION["dialecte"])) {
        $_SESSION["dialecte"]="ancient-greek";
    }
}
//load translation of messages, errors ...
require('inc/translation.php');
$translation = translation($_SESSION["dialecte"]);

if (isset($_POST['range'])) {
    $_SESSION["range"]= htmlspecialchars($_POST['range']);
} else {
    if  (! isset($_SESSION["range"])) {
        $_SESSION["range"]="normal";
    }
}


// object player contains name, rack, score
require_once('models/PlayerManager.php');
require_once('models/BoardManager.php');
require_once('models/BagManager.php');
require_once('models/RackManager.php');
// object game contains players, number turns skipped, current round, num current player
require_once('models/GameManager.php');
require_once('inc/functionsphp.php');
require_once('inc/importexport.php');



function home()
{
  global  $translation;
  require('views/frontend/homeView.php');
}

function players()
{
  global  $translation;
  unset($_POST);
  require('views/frontend/playersView.php');
}


function duplicate()
{
  global  $translation;
  require('views/frontend/duplicateView.php');
}

function duplicatebag()
{
    global $pointsletters;
    global  $translation;
    $code="";
    if (isset($_POST['dialectbag'])) {
        $_SESSION["dialectebag"]= htmlspecialchars($_POST['dialectbag']);
        $dialectbag = $_SESSION["dialectebag"];
        unset($_SESSION["dialectebag"]);
        $pointsletters = uploadtiles($dialectbag);
        $mybag = new BagManager();
        $mybag->initialize_bag($dialectbag,$_SESSION["range"]);
        $code = time();
        $name_file = "duplicatebag_".$code.".txt";
        file_put_contents ( "./duplicate/".$name_file ,$mybag->bag);

    }
    require('views/frontend/duplicatebagView.php');

}

function game()
{

    global $pointsletters;
    global  $translation;
    //$pointsletters = array( ' '=>0,'A'=>1, 'B'=>3, 'C'=>2, 'D'=>2, 'E'=>1, 'F'=>6, 'G'=>3, 'H'=>8, 'I'=>1, 'J'=>8, 'L'=>1, 'M'=>2, 'N'=>1, 'O'=>1, 'P'=>3, 'Q'=>8, 'R'=>1, 'S'=>1, 'T'=>1, 'U'=>2, 'V'=>3, 'X'=>10 , 'Z'=>8);
    $pointsletters = uploadtiles($_SESSION["dialecte"]);
    $scrabble = false;
    $endofgame = false;
    $firstround = firstRound($_POST);
    $badcode = false;

    if ($firstround) {
        $duplicate = false;

        //check data from form
        $nbplayers = $_POST['nbplayer'];
        $players = array();
        $ok = true;
        // acquisition players' names
        $players = listPlayers($nbplayers,$_POST);
        if (in_array("", $players)) {
            $ok = false;
        }
        if (isset($_POST['duplicate'])) {
            $duplicate = true;
            $ficduplicate= "./duplicate/duplicatebag_".$_POST['ficduplicate'].".txt";
            if (! file_exists($ficduplicate)) {
                $ok = false;
                $badcode = true;
            }
        } else {
            $duplicate = false;
        }
        if ($ok) {
            // creation board, bag, players, game
            $myboard = new BoardManager($_SESSION["range"]);
            $mybag = new BagManager();
            if (! $duplicate) {
                $mybag->initialize_bag($_SESSION["dialecte"],$_SESSION["range"]);
            } else {
                $strbag = file_get_contents ( $ficduplicate);
                //$mybag->bag = str_split($strbag);
                for ($i = 0; $i <strlen($strbag); $i++) {
                    $mybag->bag[$i] = mb_substr($strbag,$i,1);
                }
            }

            $mygame = new GameManager($nbplayers,$players,$mybag);
            $mygame->initialize();
        } else {
            if (! $badcode) {
                throw new Exception("une erreur s'est produite");
            }
        }
    // if it's not the first time that this page is upload
    } else {
        $myword =htmlspecialchars(strtoupper($_POST['word']));
        $mycolumn = htmlspecialchars($_POST['columnfirstletter']);
        $myline = htmlspecialchars($_POST['linefirstletter']);
        $mydirection = htmlspecialchars($_POST['direction']);
        $mynewrack = json_decode($_POST['newrack']);
        $blanksused = json_decode($_POST['blankused']);

        // creation board, bag, players, game
        $myboard = new BoardManager($_SESSION["range"]);
        $mybag = new BagManager();

        // recovery objects board, bag, players, game from input field myobjects and replenish player rack
        $myobjects = htmlspecialchars_decode($_POST['myobjects']);
        //object 0 = bag, object 1 = board, objet 2 = game
        $mybag->reload($myobjects);
        $myboard->reload($myobjects);
        $nbplayers = json_decode($myobjects)[2]->nbplayers;
        $players = array();
        for ($i = 0; $i < $nbplayers; $i++) {
            $players[$i] = json_decode($myobjects)[2]->players[$i]->name;
        }
        $mygame = new GameManager($nbplayers,$players,$mybag);
        $scrabble = $mygame->reload($myobjects,$myword,$mybag,$mynewrack);
        $mygame->currentround += 1;
        if ($myword != "") {
           $message = checkFormGame($myword,$mycolumn,$myline,$mydirection);
           if ($message !="") {
               throw new Exception($message);
           }
       }

       // compute score and write word on board, not the first turn, because the first turn there is no word on the board,
       // player has not miss his turn
        if ($myword != "") {
            //update score
            $mygame->players[$mygame->currentplayer]->score += score($myword,$blanksused,$mycolumn,$myline,$mydirection,$myboard,$scrabble);
            // write word on the board
            writeWord($myword,$mycolumn,$myline,$mydirection,$myboard);
        }
        //Check if end of game
        // pour fin du jeu il faudra aussi tester nombre de tours sautés qand personne ne peut finir
        $iswinner = false;
        $winner = "";
        $sizerackcurrentplayer = $mygame->players[$mygame->currentplayer]->rack->sizerack;
        // check if current player has his rack empty or if  turns was skip
        if ($mygame->numberturnskip > $nbplayers) {
            $endofgame = true;
        } elseif (($sizerackcurrentplayer == 0) and ($mybag->get_bag_length()==0)) {
            $endofgame = true;
            $iswinner = true;
        }


        if ($endofgame) {
            // add up in $remains value of each rack except the one of winner
            if ($iswinner) {
                $remains = remain($mygame->players);
                $mygame->players[$mygame->currentplayer]->score += $remains;
            }
            // define $winner
            if ($iswinner) {
                $scores = array();
                for ($i = 0; $i < $mygame->nbplayers; $i++) {
                    $scores[$mygame->players[$i]->name] = $mygame->players[$i]->score;
                }
                arsort($scores);
                $winner = array_keys($scores)[0];
            }
        }

        // define next current player
        $mygame->currentplayer +=1;
        if ($mygame->currentplayer >= $mygame->nbplayers) {
            $mygame->currentplayer=0;
        }

    }
    if (! $badcode) {
        $nbbagtiles = $mybag->get_bag_length();
        $thisbag = json_encode($mybag);
        $thisboard = json_encode($myboard);
        $thisgame = json_encode($mygame);
        $myobjects = '['.$thisbag.','.$thisboard.','.$thisgame.']';
    }
    require('views/frontend/gameView.php');
}

function help()
{
  global  $translation;
  require('views/frontend/helpView.php');
}


function contact()
{
  global  $translation;
  require('views/frontend/contactView.php');
}
