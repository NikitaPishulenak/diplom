<?php

function pk_ldap($username, $password) {
    require_once(dirname(__FILE__) . '/adLDAP.php');
    $adldap = new adLDAP();

    $authUser = $adldap->user()->authenticate($username, $password);
    if ($authUser == true) {
        return true;
    } else {

        return false;
    }
}
