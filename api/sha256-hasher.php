<?php
function encryptPassword($plaintext_password, $salt = NULL) {
    $password = array();
    $password['salt'] = isset($salt) ? $salt : fCryptography::random();
    $password['hash'] = hash('sha256', ($plaintext_password . $password['salt']));
    return $password;
}
$password = encryptPassword('liras86[purr');
print_r($password);
?>