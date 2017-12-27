<?php
$arguments = getopt("u:p:");
if(count($arguments) !== 2 ){
    exit(1);
}
if (file_exists($arguments['u']) === false || file_exists($arguments['p']) === false){
    exit(2);
}
$users_handle = fopen($arguments['u'], "r");
while (!feof($users_handle)) {
    $user = str_replace(array('.', "\n", "\t", "\r"), '', $trim(fgets($users_handle)));        
    $passwords_handle = fopen($arguments['p'], "r");
    while (!feof($passwords_handle)) 
    {

    }
}
fclose($users_handle);
