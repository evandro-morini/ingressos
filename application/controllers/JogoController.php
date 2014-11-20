<?php

class JogoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {       
        $jogos = new Application_Model_DbTable_Jogo();
        $this->view->jogos = $jogos->fetchAll();
    }

    public function novoAction()
    {
        $log = Zend_Auth::getInstance();
        if (!$log->hasIdentity()) {
            $this->_redirect('auth/denied');
        } else {
            $login = $log->getIdentity()->isAdm;
            if ($login != 1) {
                $this->_redirect('auth/denied');
            } else {
                $times = new Application_Model_DbTable_Time();
                $this->view->times = $times->fetchAll();
        
                if ($this->getRequest()->isPost()) {
                    $nomeTime1 = $_POST['nomeTime1'];
                    $nomeTime2 = $_POST['nomeTime2'];
                    $data = $_POST['data'];
                    $hora = $_POST['hora'];
                    $local = $_POST['local'];
                    $vagas = $_POST['vagas'];
            
                    $jogos = new Application_Model_DbTable_Jogo();
                    $jogos->addJogo($nomeTime1, $nomeTime2, $data, $hora, $local, $vagas);
            
                    $this->_helper->redirector('lista');
                }
            }
        }
    }
    
    public function editAction () 
    {
        $log = Zend_Auth::getInstance();
        if (!$log->hasIdentity()) {
            $this->_redirect('auth/denied');
        } else {
            $login = $log->getIdentity()->isAdm;
            if ($login != 1) {
                $this->_redirect('auth/denied');
            } else {
                $times = new Application_Model_DbTable_Time();
                $this->view->times = $times->fetchAll();
        
                if ($this->getRequest()->isPost()) {          
                    $id = $_POST['id'];
                    $nomeTime1 = $_POST['nomeTime1'];
                    $nomeTime2 = $_POST['nomeTime2'];
                    $data = $_POST['data'];
                    $hora = $_POST['hora'];
                    $local = $_POST['local'];
                    $vagas = $_POST['vagas'];
            
                    $jogos = new Application_Model_DbTable_Jogo();
                    $jogos->updateJogo($id, $nomeTime1, $nomeTime2, $data, $hora, $local, $vagas);
                    $this->_helper->redirector('lista');
                } else {
                    $id = $this->_getParam('id');
                    $jogos = new Application_Model_DbTable_Jogo();
                    $this->view->jogos = $jogos->getJogo($id);
                }
            }
        }
    }
    
    public function deleteAction () 
    {
        $log = Zend_Auth::getInstance();
        if (!$log->hasIdentity()) {
            $this->_redirect('auth/denied');
        } else {
            $login = $log->getIdentity()->isAdm;
            if ($login != 1) {
                $this->_redirect('auth/denied');
            } else {
                if ($this->getRequest()->isPost()) {
                    $del = $this->getRequest()->getPost('del');
                    if ($del == 'Sim') { 
                        $id = $this->getRequest()->getPost('id');
                        $jogos = new Application_Model_DbTable_Jogo();
                        $jogos->deleteJogo($id);
                    }
                    $this->_helper->redirector('lista');
                    } else {
                        $id = $this->_getParam('id');
                        $jogos = new Application_Model_DbTable_Jogo();
                        $this->view->jogos = $jogos->getJogo($id);
                }
            }
        }
    }
    
    public function listaAction()
    {    
        $log = Zend_Auth::getInstance();
        if (!$log->hasIdentity()) {
            $this->_redirect('auth/denied');
        } else {
            $login = $log->getIdentity()->isAdm;
            if ($login != 1) {
                $this->_redirect('auth/denied');
            } else {
                $jogos = new Application_Model_DbTable_Jogo();
                $this->view->jogos = $jogos->fetchAll();
            }
        }
    }

}

