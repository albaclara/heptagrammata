<?php
$title = $translation["Title_Site"];
$message ='';
ob_start();  // temporisation de sortie ?>

<div class='a_gauche resized30'><img src="images/coupe2.jpg"></div>

<div class='a_gauche resized60'>

<div>
    
	<b><?php //echo $translation["Hello"]; ?></b>
    
	<!--<h2>Déclaration du joueur</h2>-->
	
<h2>Partie duplicate à 2, 3 ou 4 joueur(s)</h2>

<form name="form_players" method="post" action="index.php?action=game" enctype="multipart/form-data">

<p><?php echo $translation["HelloDuplicate1"]; ?></p>

<p><?php echo $translation["HelloDuplicate2"]; ?></p>

<p><?php echo $translation["HelloDuplicate3"]; ?></p>

<p><?php echo $translation["HelloDuplicate4"]; ?></p>

<h3><label for="ficduplicate" ><?php echo $translation["Label_DuplicateEnterCode"]; ?></label></h3>
<p>
	
<input type="text" name="ficduplicate"id="ficduplicate" /><span class="error-form"></span>
<input type="hidden" name="duplicate" id="ficduplicate" value="oc" /></p>
<input type="hidden" name="dialect" value="ancient-greek">
<input type="hidden" name="range" value="normal">
         
<h3><label for="ficduplicate" ><?php echo $translation["Label_DuplicateEnterPlayer"]; ?></label></h3>
    
<div class="article">
<input type="text" name="name__0" id="name__0" /><span class="error-form"></span>
</div>
    
<div id="sendNamePlayers">
<input type="submit" id="valid" class="button1" value="<?php echo $translation["Button_Send_Duplicate"]; ?>" />
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
