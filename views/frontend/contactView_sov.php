<?php
$title = $translation["Title_Site"];
$message ='';
ob_start();  // temporisation de sortie ?>

<div class='a_gauche resized30'><img src="images/alphabet2.jpg"></div>
<div class='a_gauche resized60'>
        <b><?php //echo $translation["Hello"]; ?></b>
        <h2>Contact</h2>
        <p>Si vous voulez m'aider à améliorer le jeu, en cas d'erreur ou de calcul erroné du score, cliquez <a href = 'bugmail.php' target='_blank'><b>ici</b>.
            
            <p><a href="mailto:eve.seguier@laposte.fr">eve.seguier@laposte.fr</a></p>


</div>

<?php $players = ob_get_clean();  //Lit le contenu courant du tampon de sortie puis l'efface?>
<?php $board ="" ?>
<?php $rack ="" ?>
<?php $scriptsjava ="<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>"; ?>
<?php require('templateGame.php'); ?>
