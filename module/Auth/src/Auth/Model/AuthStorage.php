<?php

namespace Auth\Model;

use Zend\Authentication\Storage;

/*
 * @desc: Esta clase hereda los metodos de Storage\Session.
 * Acá podemos sobre-escribir alguno de los metodos de Session.
 * para por ejemplo, modificar el timeout, entre otros.
 * o crear nuevos metodos.
 */

class AuthStorage extends Storage\Session {

    public function setRememberMe($rememberMe = 0, $time = 1209600) {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe() {
        $this->session->getManager()->forgetMe();
    }

}
