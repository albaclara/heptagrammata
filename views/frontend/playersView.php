<?php
$title = $translation["Title_Site"];
$message ='';
ob_start();  // temporisation de sortie ?>

<div class='a_gauche resized30'><img src="images/ephese2.jpg"></div>

<div class='a_gauche resized60'>

<div>

<b><?php //echo $translation["Hello"]; ?></b>

<h2>Partie traditionnelle à 1, 2, 3 ou 4 joueur(s)</h2>
<form name="form_players" method="post" action="index.php?action=game" enctype="multipart/form-data">
<p><?php echo $translation["Hello"]; ?></p>
<input type="hidden" name="dialect" value="ancient-greek">
<input type="hidden" name="range" value="normal">

<h3><?php echo $translation["Title_InputPlayers"] ;?></h3>
<label><?php echo $translation["Txt_InputPlayers"]; ?></label><br /><br />

<div class="article">
<input type="text" name="name__0" id="name__0" /><span class="error-form"></span>
</div>

<div id="ajoutSupprimerArticle">
<input type="button" class="addArticle button1" rel="article" name="button" value="<?php echo $translation["Button_Add"]; ?>">
<input type="button" class="delArticle button1" rel="article" name="button2" value="<?php echo $translation["Button_Delete"]; ?>">
</div>

<div id="sendNamePlayers">
<input type="submit" id="valid" class="button1" value="<?php echo $translation["Button_Send"]; ?>" />
<input type="hidden" id="translation" name="translation"  value="<?php echo htmlspecialchars(json_encode($translation)) ?>">
</div>

<div id="nbplayers"></div>
</form >
</div>

<?php $players = ob_get_clean();  //Lit le contenu courant du tampon de sortie puis l'efface?>
<?php $board ="" ?>
<?php $rack ="" ?>
<?php $scriptsjava ="<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script><script src='js/declarationPlayers.js' async></script>"; ?>
<?php require('templateGame.php'); ?>
