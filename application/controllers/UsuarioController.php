<?php

class UsuarioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $log = Zend_Auth::getInstance();
        if ($log->hasIdentity()) {
            $cpf = $log->getIdentity()->userCpf;
            $auth = new Application_Model_DbTable_Auth();
            $this->view->auth = $auth->getAuth($cpf);
        } else {
            $this->_redirect('auth/login');
        }
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
            
            $login = $_POST['login'];
            $pw = $_POST['pw'];
            
            $usuarios = new Application_Model_DbTable_Usuario();
            $usuarios->addUsuario($cpf, $nome, $rg, $dataNasc, $cep, $endereco, $numEndereco, $bairro, $cidade, $estado);
            
            $auth = new Application_Model_DbTable_Auth();
            $auth->addAuth($login, $pw, $cpf);
            
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
            $auth = new Application_Model_DbTable_Auth();
            $this->view->auth = $auth->getAuth($cpf);
        }
    }
    
    public function deleteAction () 
    {
        $log = Zend_Auth::getInstance();
        if (!$log->hasIdentity()) {
            $this->_redirect('auth/denied');
        } else {
            $login = $log->getIdentity()->login;
            if ($login != 'admin') {
                $this->_redirect('auth/denied');
            } else {
                if ($this->getRequest()->isPost()) {
                $del = $this->getRequest()->getPost('del');
                if ($del == 'Sim') { 
                $cpf = $this->getRequest()->getPost('cpf');
                $usuarios = new Application_Model_DbTable_Usuario();
                $auth = new Application_Model_DbTable_Auth ();
                $auth->deleteAuth($cpf);
                $usuarios->deleteUsuario($cpf);
                }
                $this->_helper->redirector('lista');
                } else {
                $cpf = $this->_getParam('cpf');
                $usuarios = new Application_Model_DbTable_Usuario();
                $this->view->usuarios = $usuarios->getUsuario($cpf);
                } 
            }
        }
    }
    
    public function listaAction ()
    {
        $log = Zend_Auth::getInstance();
        if (!$log->hasIdentity()) {
            $this->_redirect('auth/denied');
        } else {
            $login = $log->getIdentity()->login;
            if ($login != 'admin') {
                $this->_redirect('auth/denied');
            } else {
                $usuarios = new Application_Model_DbTable_Usuario();
                $this->view->usuarios = $usuarios->fetchAll();
            }
        }
    }
    
    public function reservaAction ()
    {
        $idJogo = $this->_getParam('idJogo');
        
        $j1 = 'jogo1'; $j2 = 'jogo2'; $j3 = 'jogo3';
        
        $usuarios = new Application_Model_DbTable_Usuario();
        
        $jogos = new Application_Model_DbTable_Jogo ();
        $this->view->jogos = $jogos->getJogo($idJogo);
        
        $log = Zend_Auth::getInstance();
        if ($log->hasIdentity()) {
            $cpf = $log->getIdentity()->userCpf;
            
            $qtdReservas1 = $usuarios->verificaReserva($cpf, $j1);
            if ($qtdReservas1['jogo1'] == '') {
                $usuarios->reservaJogo($cpf, $idJogo, $j1);
                
            } else {
                $qtdReservas2 = $usuarios->verificaReserva($cpf, $j2);
                if ($qtdReservas2['jogo2'] == '') {
                $usuarios->reservaJogo($cpf, $idJogo, $j2);
                } else {
                    $qtdReservas3 = $usuarios->verificaReserva($cpf, $j3);
                    if ($qtdReservas3['jogo3'] == '') {
                    $usuarios->reservaJogo($cpf, $idJogo, $j3);
                    } else {
                        $msg = 'Você já efetuou as três reservas possíveis!';
                        $this->view->msg = $msg;
                    }
                }
            }
        } else {
            $this->_redirect('auth/login');
        }
    }

}
