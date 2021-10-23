<?php
session_start();
$_SESSION["OK"]= "OK";

error_reporting(E_ALL);
ini_set('display_errors',1);
if (isset($_SESSION["OK"])) {
    if ($_SESSION["OK"]== "OK") {
		require('controllers/frontend.php');
			if (isset($_GET['action'])) {
				$action = htmlspecialchars($_GET['action']);
				switch ($action) {
				    case 'home' :
				        home();
				        break;

				    case 'players' :
				        players();
				        break;

				    case 'duplicate' :
				        duplicate();
				        break;

				    case 'junior' :
				        junior();
				        break;

				    case 'game' :
				        game();
				        break;

				    case 'duplicatebag' :
				        duplicatebag();
				        break;

				    case 'help' :
				        help();
				        break;

                    case 'contact' :
                        contact();
                    break;

                    default :
                        home();
			   }  // end switch
		} else {

			home();
		} // end isset($_GET['action'])
	} // end $_SESSION["OK"]== "OK"
} //isset($_SESSION["OK"])