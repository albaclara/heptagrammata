<?php
function translation($dialect) {
    $translation = [];
    $root = simplexml_load_file('xml/translation.tmx') or die("Failed to load");
    $body = $root->body;
    foreach($body->tu as $tu) {
        $key = (string) $tu->attributes()->tuid;
        foreach($tu->children() as $tuv) {
            if ($tuv->attributes("xml",TRUE) == $dialect) {
                $translation[$key] = $tuv->seg;
            }
        }
     }
     return $translation;
}
?>
