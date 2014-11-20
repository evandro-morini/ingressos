<?php

class Application_Model_DbTable_Jogo extends Zend_Db_Table_Abstract
{
    protected $_name = 'jogo';

    public function getJogo($id) 
    {
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Não foi possível localizar o jogo de código: $id");
        }
    return $row->toArray(); 
    }
    
    public function addJogo($nomeTime1, $nomeTime2, $data, $hora, $local, $vagas)
    {
        $data = array(
            'id' => '',
            'nomeTime1' => $nomeTime1,
            'nomeTime2' => $nomeTime2,
            'data' => $data,
            'hora' => $hora,
            'local' => $local,
            'vagas' => $vagas,
        );        
    $this->insert($data);
    }
    
    public function updateJogo($id, $nomeTime1, $nomeTime2, $data, $hora, $local, $vagas)
    {
        $data = array(
            'id' => $id,
            'nomeTime1' => $nomeTime1,
            'nomeTime2' => $nomeTime2,
            'data' => $data,
            'hora' => $hora,
            'local' => $local,
            'vagas' => $vagas,
        );        
    $this->update($data, 'id = '. $id);
    }
    
    public function deleteJogo($id)
    {
        $this->delete('id =' . $id);
    }
    
    public function atualizaVagas($id, $vagas)
    {
        $data = array(
            'vagas' => $vagas,
        );
        $this->update($data, 'id = '. $id);
    }

}

