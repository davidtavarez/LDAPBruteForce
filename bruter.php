<?php
const ERROR_MISSING_ARGUMENTS = 1;
const ERROR_CAN_NOT_CONNECT = 2;
const ERROR_FILE_NOT_FOUND = 5;

$arguments = getopt("s:u:p:");
if (count($arguments) !== 3)
{
    exit(ERROR_MISSING_ARGUMENTS);
}
if (file_exists($arguments['u']) === false || file_exists($arguments['p']) === false)
{
    exit(ERROR_FILE_NOT_FOUND);
}

$ldap_connection = ldap_connect($arguments['s']) or exit(ERROR_CAN_NOT_CONNECT);
$valid_credentials = array();
$users_handle = fopen($arguments['u'], 'r');
$remove_chars = array(
    "\n",
    "\t",
    "\r"
);

while (!feof($users_handle))
{
    $user = str_replace($remove_chars, '', trim(fgets($users_handle)));
    $passwords_handle = fopen($arguments['p'], "r");
    while (!feof($passwords_handle))
    {
        $password = str_replace($remove_chars, '', trim(fgets($passwords_handle)));
        if (strlen($user) > 0 && strlen($password) > 0)
        {
            if (ldap_bind($ldap_connection, $user, $password))
            {
                $valid_credentials[] = array(
                    'user' => $user,
                    'password' => $password
                );
            }
        }
    }

    fclose($passwords_handle);
}

fclose($users_handle);

foreach($valid_credentials as $credential)
{
    echo $credential['user'] . " : " . $credential['password'] . "\n";
}
