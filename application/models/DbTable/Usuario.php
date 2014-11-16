<?php

class Application_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuario';

    public function getUsuario($cpf) 
    {
        $row = $this->fetchRow('cpf = ' . $cpf);
        if (!$row) {
            throw new Exception("Não foi possível localizar o Usuário de CPF: $cpf");
        }
    return $row->toArray(); 
    }
    
    public function addUsuario($cpf, $nome, $rg, $dataNasc, $cep, $endereco, $numEndereco, $bairro, $cidade, $estado)
    {
        $data = array(
            'cpf' => $cpf,
            'nome' => $nome,
            'rg' => $rg,
            'dataNasc' => $dataNasc,
            'cep' => $cep,
            'endereco' => $endereco,
            'numEndereco' => $numEndereco,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
        );        
    $this->insert($data);
    }
    
    public function updateUsuario($cpf, $nome, $rg, $dataNasc, $cep, $endereco, $numEndereco, $bairro, $cidade, $estado)
    {
        $data = array(
            'cpf' => $cpf,
            'nome' => $nome,
            'rg' => $rg,
            'dataNasc' => $dataNasc,
            'cep' => $cep,
            'endereco' => $endereco,
            'numEndereco' => $numEndereco,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
        );        
    $this->update($data, 'cpf = '. $cpf);
    }
    
    public function deleteUsuario($cpf)
    {
        $this->delete('cpf =' . $cpf);
    }

}

