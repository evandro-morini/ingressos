<?php

class UsuarioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $usuarios = new Application_Model_DbTable_Usuario();
        $this->view->usuarios = $usuarios->fetchAll();
    }

    public function novoAction()
    {
        // action body
    }


}



