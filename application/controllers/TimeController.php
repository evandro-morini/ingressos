<?php

class TimeController extends Zend_Controller_Action
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
            $login = $log->getIdentity()->login;
            if ($login != 'admin') {
                $this->_redirect('auth/denied');
            } else {
                $times = new Application_Model_DbTable_Time();
                $this->view->times = $times->fetchAll();
            }
        }
    }

    public function novoAction()
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
                    $nome = $_POST['nome'];
            
                    $times = new Application_Model_DbTable_Time();
                    $times->addTime($nome);
            
                    $this->_helper->redirector('index');
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
            $login = $log->getIdentity()->login;
            if ($login != 'admin') {
                $this->_redirect('auth/denied');
            } else {
                if ($this->getRequest()->isPost()) {          
                    $id = $_POST['id'];
                    $nome = $_POST['nome'];
            
                    $times = new Application_Model_DbTable_Time();
                    $times->updateTime($id, $nome);
                    $this->_helper->redirector('index');
                } else {
                    $id = $this->_getParam('id');
                    $times = new Application_Model_DbTable_Time();
                    $this->view->times = $times->getTime($id);
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
            $login = $log->getIdentity()->login;
            if ($login != 'admin') {
                $this->_redirect('auth/denied');
            } else {
                if ($this->getRequest()->isPost()) {
                    $del = $this->getRequest()->getPost('del');
                    if ($del == 'Sim') { 
                        $id = $this->getRequest()->getPost('id');
                        $times = new Application_Model_DbTable_Time();
                        $times->deleteTime($id);
                    }
                    $this->_helper->redirector('index');
                    } else {
                        $id = $this->_getParam('id');
                        $times = new Application_Model_DbTable_Time();
                        $this->view->times = $times->getTime($id);
                    }
            }
        }
    }

}
