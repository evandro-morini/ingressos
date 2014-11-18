<?php

class Application_Model_DbTable_Time extends Zend_Db_Table_Abstract
{
    protected $_name = 'time';
    
    public function getTime($id) 
    {
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Não foi possível localizar o time de código: $id");
        }
    return $row->toArray(); 
    }
    
    public function addTime($nome)
    {
        $data = array(
            'id' => '',
            'nome' => $nome,
        );        
    $this->insert($data);
    }
    
    public function updateTime($id, $nome)
    {
        $data = array(
            'id' => $id,
            'nome' => $nome,
        );        
    $this->update($data, 'id = '. $id);
    }
    
    public function deleteTime($id)
    {
        $this->delete('id =' . $id);
    }

}

