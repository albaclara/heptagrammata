<?php
class RackManager {

    public function __construct() {
        $this->rack = array();
        $this->sizerackmax = 7;
        $this->sizerack = 0;
        $this->pointsletters = array(' '=>0,'A'=>1, 'B'=>3, 'C'=>2, 'D'=>2, 'E'=>1, 'F'=>6, 'G'=>3, 'H'=>8, 'I'=>1, 'J'=>8, 'L'=>1, 'M'=>2, 'N'=>1, 'O'=>1, 'P'=>3, 'Q'=>8, 'R'=>1, 'S'=>1, 'T'=>1, 'U'=>2, 'V'=>3, 'X'=>10 , 'Z'=>8);

    }
}

class BagManager {

    public function __construct() {
        $this->pointsletters = array( 'A'=>1, 'B'=>3, 'C'=>2, 'D'=>2, ' E'=>1, 'F'=>6, 'G'=>3, 'H'=>8, 'I'=>1, 'J'=>8, 'L'=>1, 'M'=>2, 'N'=>1, 'O'=>1, 'P'=>3, 'Q'=>8, 'R'=>1, 'S'=>1, 'T'=>1, 'U'=>2, 'V'=>3, ' X'=>10 , 'Z'=>8);
        $this->bag = array();
        $this->initialize_bag();
    }

    function add_to_bag($letter, $quantity) {
        #Adds a certain quantity of a certain tile to the bag. Takes a tile and an integer quantity as arguments.
        for ($i = 1; $i <= $quantity; $i++) {
            $this->bag[] = $letter;
        }
    }

    function  initialize_bag() {
        #Adds the intial 102 tiles to the bag .Contains 100 letters and two blank represented by #
        $this->add_to_bag("A", 15);
        $this->add_to_bag("B", 2);
        $this->add_to_bag("C", 2);
        $this->add_to_bag("D", 3);
        $this->add_to_bag("E", 11);
        $this->add_to_bag("F", 2);
        $this->add_to_bag("G", 2);
        $this->add_to_bag("H", 2);
        $this->add_to_bag("I", 8);
        $this->add_to_bag("J", 2);
        $this->add_to_bag("L", 3);
        $this->add_to_bag("M", 3);
        $this->add_to_bag("N", 6);
        $this->add_to_bag("O", 6);
        $this->add_to_bag("P", 2);
        $this->add_to_bag("Q", 1);
        $this->add_to_bag("R", 8);
        $this->add_to_bag("S", 8);
        $this->add_to_bag("T", 6);
        $this->add_to_bag("U", 3);
        $this->add_to_bag("V", 2);
        $this->add_to_bag("X", 1);
        $this->add_to_bag("Z", 2);
        $this->add_to_bag("#", 2);
        shuffle($this->bag);
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>essai</title>
        <link href="css/scrabbleoc.css" rel="stylesheet" />
    </head>
    <body>
        <?php
        $myrack = new RackManager;
        $mybag =new BagManager;
        $valeur = json_encode($myrack);
        $valeur2 = json_encode($mybag);
        $valeurs = '['.$valeur.','.$valeur2.']';
        //var_dump(json_decode($valeurs));
        //echo json_decode($valeurs)[0]->sizerackmax;
        echo $valeurs;
    ?>
    <form name="form_word" method="post" action="test2.php" enctype="multipart/form-data">
    <input type = "hidden" value="<?php echo htmlspecialchars($valeurs) ?>" id="test" name="test">
    <input type="submit" id="valid" value="Envoyer" />
        </form>
    </body>
</html>
