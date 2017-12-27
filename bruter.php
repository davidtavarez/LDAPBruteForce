<?php
const ERROR_MISSING_ARGUMENTS = 1;
const ERROR_LDAP_NOT_FOUND = 2;
const ERROR_FILE_NOT_FOUND = 5;

$arguments = getopt("s:u:p:");
if(count($arguments) !== 3 ){
    exit(ERROR_MISSING_ARGUMENTS);
}
if (file_exists($arguments['u']) === false || file_exists($arguments['p']) === false){
    exit(ERROR_FILE_NOT_FOUND);
}

$users_handle = fopen($arguments['u'], "r");
while (!feof($users_handle)) {
    $user = str_replace(array('.', "\n", "\t", "\r"), '', $trim(fgets($users_handle)));        
    $passwords_handle = fopen($arguments['p'], "r");
    while (!feof($passwords_handle)) 
    {
        $password = str_replace(array("\n", "\t", "\r"), '', $trim(fgets($passwords_handle)));    
    }
    fclose($passwords_handle);
}
fclose($users_handle);
