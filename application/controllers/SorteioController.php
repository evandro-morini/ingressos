<?php

class SorteioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
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
                //Quem realiza o sorteio
                $idResponsavel = $log->getIdentity()->userCpf;
                //Jogo a ser sorteado
                $idJogo = $this->_getParam('idJogo');
                //Data em que foi realizado o sorteio
                $data = date("Y-m-d");
                
                //Define array com CPF dos interessados e a quantidade
                $usuarios = new Application_Model_DbTable_Usuario();
                $reservas = $usuarios->getUsuarioJogos($idJogo);
                $numReservas = sizeof($reservas);
                
                //Define array com dados do jogo enúmero de entradas disponíveis
                $jogos = new Application_Model_DbTable_Jogo();
                $dadosJogo = $jogos->getJogo($idJogo);
                $numVagas = $dadosJogo['vagas'];                  
                
                //inicia a variável que será usada no sorteio
                $sorteados = '';
                
                //Realização do Sorteio caso haja vagas
                if($numVagas > 0) {              
                    $newVagas = $numVagas;
                    
                    //Se o número de interessados for menor ou igual ao número de vagas
                    if($numReservas <= $numVagas) {
                        for($i = 0; $i < $numReservas; $i++) {
                            $usuarios->atualizaSorteado($reservas[$i], $idJogo);
                            $newVagas -= 1;
                            $jogos->atualizaVagas($idJogo, $newVagas);
                            $sorteados .= (string)$reservas[$i] . ' ';
                        }
                    $sorteios = new Application_Model_DbTable_Sorteio();
                    $sorteios->addSorteio($data, $idResponsavel, $idJogo, $sorteados);
                    } else {
                        if($numReservas > $numVagas) {
                            for($i = 0; $i < $numVagas; $i++) {
                                //faz o sorteio
                                $numero = array_rand($reservas);
                                $usuarios->atualizaSorteado($reservas[$numero], $idJogo);
                                $newVagas -= 1;
                                $jogos->atualizaVagas($idJogo, $newVagas);
                                $sorteados .= (string)$reservas[$numero] . ' ';
                                //retira o sorteado de dentro do array
                                foreach($reservas as $valor)
                                {
                                    if( $valor != $numero )
                                    {
                                        array_push($newReservas, $valor);
                                    }
                                }
                                //atribui o novo array já sem usuário sorteado e salva o sorteio
                                $reservas = $newReservas;
                                $sorteios = new Application_Model_DbTable_Sorteio();
                                $sorteios->addSorteio($data, $idResponsavel, $idJogo, $sorteados);
                            }
                        }
                    } 

                    //ELSE Para sortear quando os interessados forem em maior número que as vagas
                
                $this->view->dadosJogo = $dadosJogo;
                $this->view->sorteados = $sorteados;
                $this->view->idResponsavel = $idResponsavel;
                $this->view->data = $data;
                
                
                } else {
                    $msg = 'Você pode realizar sorteios somente para jogos com ingressos disponíveis!';
                    $this->view->msg = $msg;
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
                $sorteios = new Application_Model_DbTable_Sorteio();
                $this->view->sorteios = $sorteios->fetchAll();
            }
        }
    }
    
}

