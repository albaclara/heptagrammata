<?php
$title = $translation["Title_Site"];
$message ='';
$players = '';
$board = "";
if (! $badcode) {
    foreach($myboard->board_html() as $myline) {
        $board .= $myline;
    }
}
?>
<?php ob_start();  // temporisation de sortie

if (! $endofgame) {

    if ($badcode) {
        echo "<p>votre code est erroné</p>";

    } else {
        echo "<div>";
        //echo '<h2>La partie</h2>';
        //echo "<p>Si vous voulez m'aider à améliorer le jeu, en cas d'erreur ou de calcul erroné du score, cliquez <a href = 'bugmail.php' target='_blank'><b>ici</b>.</a></p>";
        if (! $firstround) {
            $verbplural= "";
            $nounplural="";
            if ($nbbagtiles > 1) {
                $verbplural= "n";
                $nounplural="s";
            }

            echo "<p><em>Il reste dans le sac <span class='txtredbold' >".$nbbagtiles." lettre".$nounplural."</span></em></p>";
        }
        echo '<div class="rackCurrentPlayer" >';
        $player = $mygame->players[$mygame->currentplayer];
        echo '<div class="rackNamePlayer">';
            echo $player->name;
        echo '</div>';
        echo '<div class="rackScorePlayer">';
            echo $player->score.'pts';
        echo '</div>';
        echo '<div class="raz"></div>';
        echo '<div class="racktiles">';
        echo $player->rack->rack_html(True);
        echo '</div>';
        echo '<div class="raz"> </div>';
        echo '<div class="choiceword" >';
        ?>
            <form name="form_word" id="form_word" method="post" action="index.php?action=game" enctype="multipart/form-data">
            <p>
            <label for="word" ><b><?php echo $translation["Label_Word"]; ?> :</b></label>
            <textarea id="word" name="word" rows="1" cols="20" readonly></textarea><br />
            <em><?php echo $translation["Txt_Keyboard"]."</em>";?>
            </p>
            <?php require_once('inc/keyboard.php'); ?>
            <p id="inputWord">
           <?php echo $translation["Txt_Linecolumn"]; ?><br />
            <!-- <label for="columnfirstletter" ><?php echo $translation["Label_Column"]; ?> :</label> -->
            <input type="hidden" name="columnfirstletter" id="columnfirstletter" maxlength="2" size="2" />
            <!-- <label for="linefirstletter" ><?php echo $translation["Label_Line"]; ?> :</label> -->
            <input type="hidden" name="linefirstletter" id="linefirstletter" maxlength="2" size="2" /><br />
            <!-- <em><?php echo $translation["Txt_Position"]; ?></em><br /> -->

            <?php echo $translation["Label_Direction"]." : ";?>
            <input type="radio" id="horizontal" name="direction" value="right" checked>
            <label for="horizontal"><?php echo $translation["Label_Horizontal"]; ?></label>
            <input type="radio" id="vertical" name="direction" value="down">
            <label for="vertical"><?php echo $translation["Label_Vertical"]; ?></label><br />

            </p>
            <?php
            if ($nbplayers<2) {  
                echo '<input type="button" id="miss" class="button1" name="miss" value="'.$translation["Button_MissAlone"].'">';
            } else {
                echo '<input type="button" id="miss" class="button1" name="miss" value="'.$translation["Button_Miss"].'">';
            } ?>
            <input type="button" id="validation"  class="button1" name="validation" value="<?php echo $translation["Button_Validation"]; ?>">
            <input type="button" id="confirmation" class="button1" value="<?php echo $translation["Button_Confirmation"]; ?>" />
            <input type="button"  id="annulation" class="button1" value="<?php echo $translation["Button_Annulation"]; ?>"  >

            <!--<input type="button" id="congres"  class="button1" name="congres" value="<?php echo $translation["Button_Congres"]; ?>">-->
            <div class="raz"></div>
            <div id="infobeforevalidation"></div>
        </div>
        <?php
        // save the objects of the page
        $thisbag = json_encode($mybag);
        $thisboard = json_encode($myboard);
        $thisgame = json_encode($mygame);
        $myobjects = '['.$thisbag.','.$thisboard.','.$thisgame.']';
        ?>
        <input type="hidden" id="linemax" name="linemax"  value="<?php echo $myboard->width-2 ?>">
        <input type="hidden" id="colmax" name="colmax"  value="<?php echo $myboard->height-2 ?>">
        <input type="hidden" id="myobjects" name="myobjects"  value="<?php echo htmlspecialchars($myobjects) ?>">
        <input type="hidden" id="myboard" name="myboard"  value="<?php echo htmlspecialchars(json_encode($myboard->boardplayed)) ?>">
        <input type="hidden" id="numround" name="numround"  value="<?php echo $mygame->currentround ?>">
        <input type="hidden" id="myrack" name="myrack"  value="<?php echo htmlspecialchars(json_encode($player->rack->rack)) ?>">
        <input type="hidden" id="newrack" name="newrack"  value="[]">
        <input type="hidden" id="blankused" name="blankused"  value="[]">
        <input type="hidden" id="translation" name="translation"  value="<?php echo htmlspecialchars(json_encode($translation)) ?>">
        <!-- to pass number of players to javascript-->
        <input type="hidden" id="playersnb" name="playersnb"  value="<?php echo $nbplayers ?>">
        <input type="hidden" id="dialect" name="dialect"  value="<?php echo $_SESSION["dialecte"] ?>">



        </form>
        <?php
        echo '</div>'; // div choice word
        echo '</div>'; // div rackplayer
        foreach ($mygame->players as $player) {

            if ($player->num != $mygame->currentplayer) {
                echo '<div class="rackPlayer">';
                echo '<div class="rackNamePlayer">';
                    echo $player->name;
                echo '</div>';
                echo '<div class="rackScorePlayer">';
                    echo $player->score.'pts';
                echo '</div>';
                echo '<div class="raz"> </div>';
                echo '<div class="racktiles">';
                echo $player->rack->rack_html(False);
                echo '</div>';
                echo '<div class="raz"> </div>';
                echo '</div>'; // div rackplayer
            }
        }
    }
    //end of game
} else {
    foreach ($mygame->players as $player) {
        echo '<div class="rackPlayer">';
        echo '<div class="rackNamePlayer">';
            echo $player->name;
        echo '</div>';
        echo '<div class="rackScorePlayer">';
            echo $player->score.'pts';
        echo '</div>';
        echo '<div class="raz"> </div>';
        echo '<div class="racktiles">';
        echo $player->rack->rack_html(False);
        echo '<div class="raz"> </div>';
        if (($player->name == $winner) and (sizeof($mygame->players)>1)) {
            echo "<b>Bravo !</b>";
        }
        echo '</div>';
        echo'</div>';
    }
    echo '<div>';
    echo '<form name="form_replay" id="form_replay" method="post" action="index.php?action=home" enctype="multipart/form-data">';
    echo '<input class="button1" type="submit" id="replay" value='.$translation["Button_Replay"].'" />';
    echo '</form>';
    echo '</div>';
}

?>
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
<script type="text/javascript">
  $(function() {
      $('.draggable-element').arrangeable();
  });
</script>
<?php
$rack = ob_get_clean();  //Lit le contenu courant du tampon de sortie puis l'efface

$scriptsjava ="";
$scriptsjava .="<script type='text/javascript' src='js/drag-arrange.js'></script>";
$scriptsjava .="<script type='text/javascript' src='js/game.js' async></script>";
$scriptsjava .="<script src='js/functions.js' async></script>";
$scriptsjava .="<script type='text/javascript' src='js/popup.js'></script>";
$scriptsjava .="<script type='text/javascript' src='js/keyboard.js'></script>";
require('templateGame.php'); ?>
