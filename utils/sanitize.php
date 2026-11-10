<?php
function sanitize(string $data){
    return strip_tags(stripslashes(trim($data)));
}

?>