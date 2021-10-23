<?php
$title = $translation["Title_Site"];
$message ='';
ob_start();  // temporisation de sortie
?>
<div class='a_gauche resized30'><img src="images/lettres2.jpg"></div>
<div class='a_gauche resized60'>
        <b><?php //echo $translation["Hello"]; ?></b>
        <?php
echo $translation["Txt_bagduplicate"]."<br />";
if ($code != "") {
    echo '<span class="txtredbold">'.$code.'</span>';
} else {
    ?>
        <form name="form_players" method="post" action="index.php?action=duplicatebag" enctype="multipart/form-data">
    <input type="hidden" name="dialectbag" value="ancient-greek">
        <br />
        <input type="submit" id="valid" class="button1" value="<?php echo $translation["Button_Send"]; ?>" />
    </form>

</div>
<?php
 }
$players = ob_get_clean();  //Lit le contenu courant du tampon de sortie puis l'efface?
$board ="";
$rack ="";
?>
<?php $scriptsjava ="<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script><script src='js/declarationPlayers.js' async></script>"; ?>
<?php require('templateGame.php'); ?>
