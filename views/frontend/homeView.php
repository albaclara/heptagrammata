<?php
$title = $translation["Title_Site"];
$message ='';
ob_start();  // temporisation de sortie ?>

<div class='a_gauche resized30'><img src="images/alexandros-romanos.png"><br /><span style="font-size: 0.9rem;font-style: italic;"><a href="http://heptagrammata.free.fr/images/alexandros-romanos.png">&nbsp;&nbsp;&nbsp;Partie-marathon des 18-20 août 2021</a></span></div>
<div class='a_gauche resized60'>
        <b><?php //echo $translation["Hello"]; ?></b>
        <h2>Heptagrammata, comment ça marche ?</h2>
            <p>En cliquant sur <a href="index.php?action=players" class='txtredbold'>PARTIE TRADITIONNELLE</a> dans le menu haut, vous pouvez jouer sur un ordinateur à 1, 2, 3 ou 4 joueurs autour de l'ordinateur et chacun aura ses propres lettres.</p>
            <p>Si vous êtes seul à votre ordinateur, vous pouvez aussi jouer en duplicate avec un ami ou des amis. Grâce au code que vous leur enverrez, ils tireront les mêmes lettres dans le même ordre que vous. Voici comment faire :
            <ul>
                <li> cliquez sur <a href="index.php?action=duplicatebag" class='txtredbold'>Code duplicate</a> dans le menu haut pour générer un code d'identification,</li>
                <li> transmettez-le à vos amis par le moyen de votre choix,</li>
                <li> cliquez sur <a href="index.php?action=duplicate" class='txtredbold'>PARTIE DUPLICATE</a> dans le menu haut. Lui fera de même de son côté.</li>
            </ul>
        </p>
        <p>Votre partie, quelle que soit sa forme, peut durer aussi longtemps que ne s'interrompt pas la connexion internet de votre navigateur. Pour votre information : lors de nos tests, une de nos parties s'est ainsi étendue sur plusieurs journées.
		</p>
		<p>Que le meilleur gagne !
        </p>
		<br>
		<p align=right>
		<a href="http://www.mon-compteur.fr"><img src="http://www.mon-compteur.fr/html_c01genv2-232423-2" border="0" /></a> visiteurs depuis le 22 août 2021.</p>
</div>

<?php $players = ob_get_clean();  //Lit le contenu courant du tampon de sortie puis l'efface?>
<?php $board ="" ?>
<?php $rack ="" ?>
<?php $scriptsjava ="<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>"; ?>
<?php require('templateGame.php'); ?>
