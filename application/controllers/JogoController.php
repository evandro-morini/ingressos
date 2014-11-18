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
            
            $this->_helper->redirector('index');
        }
    }
    
    public function editAction () 
    {
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
            $this->_helper->redirector('index');
        } else {
            $id = $this->_getParam('id');
            $jogos = new Application_Model_DbTable_Jogo();
            $this->view->jogos = $jogos->getJogo($id);
        }
    }
    
    public function deleteAction () 
    {
        if ($this->getRequest()->isPost()) {
        $del = $this->getRequest()->getPost('del');
        if ($del == 'Sim') { 
        $id = $this->getRequest()->getPost('id');
        $jogos = new Application_Model_DbTable_Jogo();
        $jogos->deleteJogo($id);
        }
        $this->_helper->redirector('index');
        } else {
        $id = $this->_getParam('id');
        $jogos = new Application_Model_DbTable_Jogo();
        $this->view->jogos = $jogos->getJogo($id);
        } 
    }


}

