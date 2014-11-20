<?php
require_once 'Zend\Pdf.php';

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
            $usuarios = new Application_Model_DbTable_Usuario();
            $this->view->usuario = $usuarios->getUsuario($cpf);
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
            $login = $log->getIdentity()->isAdm;
            if ($login != 1) {
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
            $login = $log->getIdentity()->isAdm;
            if ($login != 1) {
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
        
        $log = Zend_Auth::getInstance();
        if ($log->hasIdentity()) {
            $cpf = $log->getIdentity()->userCpf;
            $msg = '';
            
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
        $this->view->jogos = $jogos->getJogo($idJogo);
        $this->view->data = date("d/m/Y H:i:s");
    }
    
    public function meujogoAction()
    {
        $cpf = $this->_getParam('cpf');
        $usuarios = new Application_Model_DbTable_Usuario();
        $dadosUsuario = $usuarios->getUsuario($cpf);
        $idJogo = $dadosUsuario['sorteado'];
        $jogos = new Application_Model_DbTable_Jogo();
        if($idJogo == '')
        {
            $msg = 'Você ainda não foi sorteado, por favor continue aguardando.';
            $this->view->msg = $msg;
        } else {
            $dadosJogo = $jogos->getJogo($idJogo);
            $this->view->jogos = $dadosJogo;
        }
    }
    
    public function ticketAction()
    {
        require_once 'Zend/Pdf.php';
        
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $pdf = new Zend_Pdf();
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4_LANDSCAPE);
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
        
        $cpf = $this->_getParam('cpf');
        $usuarios = new Application_Model_DbTable_Usuario();
        $dadosUsuario = $usuarios->getUsuario($cpf);
        $idJogo = $dadosUsuario['sorteado'];
        $jogos = new Application_Model_DbTable_Jogo();
        if($idJogo == '')
        {
            $page->drawText('Você ainda não foi sorteado, por favor continue aguardando.', 100, 100);
        } else {
            $dadosJogo = $jogos->getJogo($idJogo);
            $page->drawText('CPF ', 50, 500, 'UTF-8');
            $page->drawText($cpf, 80, 500, 'UTF-8');
            $page->drawText('Cod. Jogo', 50, 450, 'UTF-8');
            $page->drawText($dadosJogo['id'], 120, 450, 'UTF-8');
            $page->drawText('Seleção mandante', 200, 400, 'UTF-8');
            $page->drawText($dadosJogo['nomeTime1'], 200, 350, 'UTF-8');
            $page->drawText('Seleção visitante', 400, 400, 'UTF-8');
            $page->drawText($dadosJogo['nomeTime2'], 400, 350, 'UTF-8');
            $page->drawText('Data', 50, 300, 'UTF-8');
            $page->drawText($dadosJogo['data'], 90, 300, 'UTF-8');
            $page->drawText('Hora', 50, 250, 'UTF-8');
            $page->drawText($dadosJogo['hora'], 90, 250, 'UTF-8');
            $page->drawText('Local', 50, 200, 'UTF-8');
            $page->drawText($dadosJogo['local'], 90, 200, 'UTF-8');
        }
        
        $page->drawText('Sistema de Ingressos', 50, 50, 'UTF-8');
        $pdf->pages[0] = $page;

        header('Content-Type: application/pdf');
        echo $pdf->render();
    }

}
