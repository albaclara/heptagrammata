<?php
$title = $translation["Title_Site"];
$message ='';
ob_start();  // temporisation de sortie ?>

<div class='a_gauche resized30'><img src="images/PAPYRUS2.jpg"></div>
<div class='a_gauche resized60'>

<p>L'Heptagrammata ressemble au Scrabble.</p>
	
<h3>Début de la partie</h3>

<p>Sept lettres sont tirées au hasard dans le sac. Le joueur doit essayer de créer un mot nouveau avec ses lettres. Le premier joueur doit obligatoirement poser le premier mot au centre du plateau, sur l'étoile. Ce mot doit être composé d'au minimum deux lettres. Le second joueur doit s'appuyer sur ce mot pour placer le sien.</p>

<h3>Calcul du score</h3>

<p>La marque d'un coup est calculée en additionnant la valeur de toutes les lettres de tous les mots nouveaux formés (ceux déjà posés sur la grille mais étendus comptent). Si l'un des joueurs réussit à placer toutes ses sept lettres d'un coup, il gagne une prime de 50 points.</p>

<p>Si l'une des nouvelles lettres est sur une case bleu clair, sa valeur est doublée ; elle est triplée si elle est sur une case bleu foncé. Pour les cases roses ou rouges, le mot est compté double ou triple. Attention : chaque case spéciale ne produit une telle multiplication qu'une seule fois, lors du coup où une lettre vient l'occuper.</p>

<p>Petit rappel de la valeur des cases spéciales :

<ul class="helpsquare"><li class="squareTwiceLetter squaremodel"></li><li>&nbsp;LETTRE COMPTE DOUBLE</li></ul>
<br><br>
<ul class="helpsquare"><li class="squareTripleLetter squaremodel"></li><li>&nbsp;LETTRE COMPTE TRIPLE</li></ul>  
<br><br>
<ul class="helpsquare"><li class="squareTwiceWord squaremodel"></li><li>&nbsp;MOT COMPTE DOUBLE</li></ul>  
<br><br>
<ul class="helpsquare"><li class="squareTripleWord squaremodel"></li><li>&nbsp;MOT COMPTE TRIPLE</li></ul>
</p>

<br><br>

<h3>Fin de partie</h3>
<p>La partie est finie quand le sac est vide et qu’un des joueurs a posé toutes ses lettres, ou que chaque joueur a passé son tour sans pouvoir jouer.</p>

<p>Un bonus est donné au joueur qui a posé toutes ses lettres, il est égal à la somme de la valeur des lettres qui restent aux autres joueurs. Chacun de ces joueurs retire de son score la somme des lettres restant sur sa réglette.</p>

<p>Le joueur qui a alors le score le plus élevé a gagné la partie.</p>

</div>

<form name="form_translate" id="form_translate" method="post" action="" enctype="multipart/form-data">
<input type="hidden" id="translation" name="translation"  value="<?php echo htmlspecialchars(json_encode($translation)) ?>">
</form>

<?php $players = ob_get_clean();  //Lit le contenu courant du tampon de sortie puis l'efface?>
<?php $board ="" ?>
<?php $rack ="" ?>
<?php $scriptsjava ="<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>"; ?>
<?php $scriptsjava .="<script type='text/javascript' src='js/helpLetters.js'></script>"; ?>
<?php require('templateGame.php'); ?>
