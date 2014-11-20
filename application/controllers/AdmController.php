<?php

class AdmController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $log = Zend_Auth::getInstance();
        if (!$log->hasIdentity()) {
            $this->_redirect('auth/denied');
        } else {
            $login = $log->getIdentity()->isAdm;
            if ($login != 1) {
                $this->_redirect('auth/denied');
            }
        }
    }


}

