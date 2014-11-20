<?php

class Application_Model_DbTable_Auth extends Zend_Db_Table_Abstract
{

    protected $_name = 'auth';
    
    public function getAuth($cpf) 
    {
        $row = $this->fetchRow('userCpf = ' . $cpf);
        if (!$row) {
            throw new Exception("Não foi possível localizar o Usuário de CPF: $cpf");
        }
    return $row->toArray(); 
    }
    
    public function addAuth($login, $pw, $cpf)
    {
        $data = array(
            'login' => $login,
            'pw' => sha1($pw),
            'userCpf' => $cpf,
        );        
    $this->insert($data);
    }
    
    public function updateAuth($login, $pw, $cpf)
    {
        $data = array(
            'login' => $login,
            'pw' => sha1($pw),
            'userCpf' => $cpf,
        );        
    $this->update($data, 'userCpf = '. $cpf);
    }
    
     public function deleteAuth($cpf)
    {
        $this->delete('userCpf =' . $cpf);
    }
    
    public function setadmAuth($cpf)
    {
        $data = array(
            'isAdm' => 1,
        );
        $this->update($data, 'userCpf = '. $cpf);
    }

}

