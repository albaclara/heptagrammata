<?php
session_start();
if (isset($_POST['code'])) {
    $code = htmlspecialchars($_POST['code']);
    if ($code == "lexicon") {
        $_SESSION["OK"]= "OK";
        header('location:index.php');
    }
}
?>