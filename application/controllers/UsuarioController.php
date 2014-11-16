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
        if ($this->getRequest()->isPost()) {
            $cpf = $_POST['cpf'];
            $nome = $_POST['nome'];
            $rg = $_POST['rg'];
            $dataNasc = $_POST['dataNasc'];
            $cep = $_POST['cep'];
            $endereco = $_POST['endereco'];
            $numEndereco = $_POST['numEndereco'];
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            
            $usuarios = new Application_Model_DbTable_Usuario();
            $usuarios->addUsuario($cpf, $nome, $rg, $dataNasc, $cep, $endereco, $numEndereco, $bairro, $cidade, $estado);
            
            $this->_helper->redirector('index');
        }
    }
    
    public function editAction () 
    {
        if ($this->getRequest()->isPost()) {          
            $cpf = $_POST['cpf'];
            $nome = $_POST['nome'];
            $rg = $_POST['rg'];
            $dataNasc = $_POST['dataNasc'];
            $cep = $_POST['cep'];
            $endereco = $_POST['endereco'];
            $numEndereco = $_POST['numEndereco'];
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            
            $usuarios = new Application_Model_DbTable_Usuario();
            $usuarios->updateUsuario($cpf, $nome, $rg, $dataNasc, $cep, $endereco, $numEndereco, $bairro, $cidade, $estado);
            
            $this->_helper->redirector('index');
        } else {
            $cpf = $this->_getParam('cpf');
            $usuarios = new Application_Model_DbTable_Usuario();
            $this->view->usuarios = $usuarios->getUsuario($cpf);
        }
    }
    
    public function deleteAction () 
    {
        if ($this->getRequest()->isPost()) {
        $del = $this->getRequest()->getPost('del');
        if ($del == 'Sim') { 
        $cpf = $this->getRequest()->getPost('cpf');
        $usuarios = new Application_Model_DbTable_Usuario();
        $usuarios->deleteUsuario($cpf);
        }
        $this->_helper->redirector('index');
        } else {
        $cpf = $this->_getParam('cpf');
        $usuarios = new Application_Model_DbTable_Usuario();
        $this->view->usuarios = $usuarios->getUsuario($cpf);
        } 
    }


}



