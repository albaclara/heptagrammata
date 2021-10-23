<?php
$title = $translation["Title_Site"];
$message ='';
if(! isset($_POST['email'])) {
ob_start();  // temporisation de sortie ?>

<div class='a_gauche resized30'><img src="images/alphabet2.jpg"></div>

<div class='a_gauche resized60'>
<b><?php //echo $translation["Hello"]; ?></b>
      
<h2>Contacter le programmeur du site</h2>
<p>Le programmeur de ce site est Ève Séguier. Si vous voulez l'aider à améliorer le jeu, en cas d'erreur ou de calcul erroné du score, cliquez <a href = 'bugmail.php' target='_blank'><b>ici</b></a> pour un rapport détaillé, ou bien utilisez le formulaire ci-dessous.</p>
    
<div style="margin-left : 15px">
<form name="contact_form" method="post" action="index.php?action=contact" enctype="multipart/form-data">
     
<div style="text-align: left;">
<b><label for="email">Votre courriel :</label></b>
<input type="email" name="email" id="email" />
</div>
         
<div style="text-align: left;">
<b><label for="commentaires">Commentaires :</label></b>
<textarea  name="commentaire" cols="100" rows="10" style = "vertical-align:top;" ></textarea>
<br /><br />
<input type="submit" value=" Envoyer ">
</div>
	
</form>
</div>

<h2>Contacter le concepteur du jeu</h2>
<p>Le concepteur de ce jeu est Romain Vaissermann. Vous pouvez le contacter par son <b><a href = 'http://romain.vaissermann.free.fr' target='_blank'>site personnel</a></b>.</p>

<h2>Se renseigner sur l'histoire de l'Heptagrammata</h2>
<p>Un article a paru en juillet 2021 sur la genèse de ce jeu : vous pouvez le lire sur le site de la revue <b><a href = 'https://ch.hypotheses.org/4388' target='_blank'><i>Connaissance hellénique</i></a></b>.</p>

</div>
<?php $players = ob_get_clean();  //Lit le contenu courant du tampon de sortie puis l'efface?>
<?php $board ="" ?>
<?php $rack ="" ?>
<?php $scriptsjava ="<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>"; ?>
<?php require('templateGame.php'); 
} else {

    $email_to = "eve.seguier@laposte.net";
    $email_subject = "message heptagrammatica";

    function died($error) {
        echo
"Nous sommes désolés, mais des erreurs ont été détectées dans le" .
" formulaire que vous avez envoyé. ";
        echo "Ces erreurs apparaissent ci-dessous.<br /><br />";
        echo $error."<br /><br />";
        echo "Merci de corriger ces erreurs.<br /><br />";
        die();
    }

    // si la validation des données attendues existe
     if(!isset($_POST['email']) || !isset($_POST['commentaire'])) {
        died(
'Nous sommes désolés, mais le formulaire que vous avez soumis semble poser' .
' problème.');
    }
    $messatge = "";
    $email = htmlspecialchars($_POST['email']); // required
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email)) {
      $error_message .= 'L\'adresse électronique que vous avez entrée ne semble pas être valide.<br />';
    }

      // Prend les caractères alphanumériques + le point et le tiret 6
      //$string_exp = "/^[A-Za-z0-9 .'-]+$/



     $email_message = $messatge."<br />";
     $email_message .= "Email: ".$email."<br />";
     $email_message .= "Commentaire: ".$commentaire."\n";

    // create email headers
    $headers = "Content-type: text/html; charset= utf8\n";
    $headers .= 'From: '.$email."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    echo mail($email_to, $email_subject, $email_message, $headers);
    echo "Merci : votre message a bien été envoyé<br /><br />";
    echo '<br /><br /><a href="http://heptagrammata.free.fr/index.php"><- retour</a>';
    }
?>
