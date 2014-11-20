<?php

class Application_Model_DbTable_Sorteio extends Zend_Db_Table_Abstract
{

    protected $_name = 'sorteio';
    
    public function addSorteio($data, $idResponsavel, $idJogo, $sorteados)
    {
        $data = array(
            'data' => $data,
            'idResponsavel' => $idResponsavel,
            'idJogo' => $idJogo,
            'sorteados' => $sorteados,
        );        
    $this->insert($data);
    }

}

