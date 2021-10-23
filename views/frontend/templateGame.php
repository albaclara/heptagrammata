<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="robots" content="noindex">
        <title><?= $title ?></title>
        <link href="css/scrabbleoc.css?ver=17" rel="stylesheet" />
        <link href="css/hamburger.css?ver=3" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="css/keyboard.css?ver=6" />
    </head>
    <body>
    <div id="contain">


        <div id="headerscrabble" >
            <div id="hamburgerMenu"></div>
        <h1>HEPTAGRAMMATA

<a href="https://24timezones.com" style="text-decoration: none" class="clock24" id="tz24-1629475926-c126-eyJob3VydHlwZSI6IjI0Iiwic2hvd2RhdGUiOiIwIiwic2hvd3NlY29uZHMiOiIxIiwic2hvd3RpbWV6b25lIjoiMCIsInR5cGUiOiJkIiwibGFuZyI6ImZyIn0=" title="heure actuelle" target="_blank" rel="nofollow">
</a>
<script type="text/javascript" src="//w.24timezones.com/l.js" async>
</script> à Athènes

</h1>
	
		
        </div>
        <nav id="largescreen">
             <ul>
                   <li><a href="index.php">Accueil</a></li>
                   <li><a href="index.php?action=players">Partie traditionnelle</a></li>
                    <li><a href="index.php?action=duplicate" target="_blank">Partie duplicate</a></li>
                   <li><a href="index.php?action=duplicatebag" target="_blank">Code duplicate</a></li>
                   <li><a href="index.php?action=help" target="_blank" target="_blank">Règles du jeu</a></li>
                   <li><a href="index.php?action=contact" target="_blank">Contact</a></li>
				   
				   
            </ul>
       </nav>
       <div id="page-wrapper">
        <div id="message" >
                <?= $message ?>
        </div>
        <div id="content" >
            <?= $players ?>
        </div>
        <div id="board" >
            <?= $board ?>
        </div>
        <div id="rack">
            <?= $rack ?>
        </div>

    </div>
    </div>
    </body>
</html>
<?= $scriptsjava ?>
<script type='text/javascript' src='js/hamburger.js'></script>
