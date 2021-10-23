<?php
if(! isset($_POST['email'])) {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Bug Heptagrammatica</title>
        <link href="css/scrabbleoc.css" rel="stylesheet" />
    </head>
    <body>
    <div id="titre" >
                <h1>Heptagrammatica</h1>
    </div>
    <div style="margin-left : 15px">
     <form name="contact_form" method="post" action="bugmail.php" enctype="multipart/form-data">
     <div style="text-align: left;">
         <b><label for="email">Votre mail :</label></b>
         <input type="email" name="email" id="email" />
         </div>
        <div style="text-align: left;">
            <b><label for="messatge">Message de l'ordinateur :</label></b>
            <input type="text" name="messatge" id="messatge" />
        </div>
        <div style="text-align: left;">
         <legend><b>Mot posé :</b></legend><b>
         <table><tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td></tr>
         <tr><td><input type="text" name="L1" id="L1" size ="1" maxlength="1" /></td>
             <td><input type="text" name="L2" id="L2" size ="1" maxlength="1" /></td>
             <td><input type="text" name="L3" id="L3" size ="1" maxlength="1" /></td>
             <td><input type="text" name="L4" id="L4" size ="1" maxlength="1" /></td>
             <td><input type="text" name="L5" id="L5" size ="1" maxlength="1" /></td>
             <td><input type="text" name="L6" id="L6" size ="1" maxlength="1" /></td>
             <td><input type="text" name="L7" id="L7" size ="1" maxlength="1" /></td>
             <td><input type="text" name="L8" id="L8" size ="1" maxlength="1" /></td>
         </tr><tr></table><br /><br />
         </div>
         <div style="text-align: left;">
         <legend><b>Lettres venant de la réglette (indiquer les numéros de case)</b></legend><br />
          <label for="meslettres">N° des lettres:</label>
         <input type="text" id="meslettres" name="meslettres">
         <br />
         </div>
         <div style="text-align: left;">
         <legend><br /><b>Cases spéciales (indiquer les numéros de case)</b></legend><br />
         <label for="DL">Lettre double :</label>
         <input type="text" id="DL" name="DL">
         <label for="TL">Lettre triple :</label>
         <input type="text" id="TL" name="TL"><br />
         <label for="DW">Mot double :</label>
         <input type="text" id="DW" name="DW">
         <label for="TW">Mot triple :</label>

         <input type="text" id="TW" name="TW"><br /><br />
         </div>
         <div style="text-align: left;">
         <legend><b>Direction</b></legend><br />
         <input type="checkbox" id="vertical" name="vertical">
         <label for="vertical">verticalement</label>
         <input type="checkbox" id="horizontal" name="horizontal">
         <label for="horizontal">horizontalement</label><br /><br />
         </div>
         <div style="text-align: left;">
         <legend><b>Type de placement :</b></legend><br />

         <input type="checkbox" id="croise" name="croise">
         <label for="croise">mot croisé avec un autre</label>
         <input type="checkbox" id="suit" name="suit">
         <label for="suit">lettres ajoutées à la fin d'un mot</label>
         <input type="checkbox" id="precede" name="precede">
         <label for="precede">lettres ajoutées au début d'un mot</label><br /><br />
         </div>
         <div style="text-align: left;">
         <b><label for="commentaires">Commentaires :</label></b>
         <textarea  name="commentaire" cols="100" rows="10" style = "vertical-align:top;" ></textarea>
         <br /><br />
	 <input type="submit" value=" Envoyer ">
         </div>
	</form>
    </div>
</body>
</html>

<?php
} else {

    $email_to = "eve.seguier@laposte.net";
    $email_subject = "bug heptagrammatica";

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
    $messatge = htmlspecialchars($_POST['messatge']);
    $email = htmlspecialchars($_POST['email']); // required
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $L1 = htmlspecialchars($_POST['L1']);
    $L2 = htmlspecialchars($_POST['L2']);
    $L3 = htmlspecialchars($_POST['L3']);
    $L4 = htmlspecialchars($_POST['L4']);
    $L5 = htmlspecialchars($_POST['L5']);
    $L6 = htmlspecialchars($_POST['L6']);
    $L7 = htmlspecialchars($_POST['L7']);
    $L8 = htmlspecialchars($_POST['L8']);
    $meslettres = htmlspecialchars($_POST['meslettres']);
    $DL = htmlspecialchars($_POST['DL']);
    $TL = htmlspecialchars($_POST['TL']);
    $DW = htmlspecialchars($_POST['DW']);
    $TW = htmlspecialchars($_POST['TW']);
    if (isset($_POST['vertical'])) {
        $vertical = htmlspecialchars($_POST['vertical']);
    } else {
        $vertical = "";
    }
    if (isset($_POST['horizontal'])) {
        $horizontal = htmlspecialchars($_POST['horizontal']);
    } else {
        $horizontal = "";
    }
    if (isset($_POST['suit'])) {
        $suit = htmlspecialchars($_POST['suit']);
    } else {
        $suit = "";
    }
    if (isset($_POST['croise'])) {
        $croise = htmlspecialchars($_POST['croise']);
    } else {
        $croise = "";
    }
    if (isset($_POST['precede'])) {
        $precede = htmlspecialchars($_POST['precede']);
    } else {
        $precede = "";
    }

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if(!preg_match($email_exp,$email)) {
      $error_message .=
'L\'adresse e-mail que vous avez entrée ne semble pas être valide.<br />';
    }

      // Prend les caractères alphanumériques + le point et le tiret 6
      //$string_exp = "/^[A-Za-z0-9 .'-]+$/



     $email_message = "Messatge de l'ordenador : ".$messatge."<br />";
     $email_message .= "Email: ".$email."<br />";
     $email_message .= "Mot: ".$L1.$L2.$L3.$L4.$L5.$L6.$L7.$L8."<br />";
     $email_message .= "Lettres posées: ".$meslettres."<br />";
     $email_message .= "Lettres doubles: ".$DL."<br />";
     $email_message .= "Lettres triples: ".$TL."<br />";
     $email_message .= "Mots doubles: ".$DW."<br />";
     $email_message .= "Mots triples: ".$TW."<br />";
     $email_message .= "direction: vertical : ".$vertical." &nbsp;&nbsp;&nbsp;horizontal : ".$horizontal."<br />";
     $email_message .= "croisé: ".$croise."&nbsp;&nbsp;&nbsp;";
     $email_message .= "suit: ".$suit."&nbsp;&nbsp;&nbsp; ";
     $email_message .= "précède: ".$precede."<br />";
     $email_message .= "Commentaire: ".$commentaire."\n";


    // create email headers
    $headers = "Content-type: text/html; charset= utf8\n";
    $headers .= 'From: '.$email."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    mail($email_to, $email_subject, $email_message, $headers);
    echo "Merci de participer à l'amélioration du jeu.<br /><br />";
    echo '<br /><br /><a href="http://heptagrammata.free.fr/index.php"><- retour</a>';
    }
?>
