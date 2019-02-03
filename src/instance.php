<?php

namespace moradnejadi\PdoFatFree;

use moradnejadi\PdoFatFree\DB\SQL\Mapper;

class instance// extends Mapper
{
    // Instantiate mapper
    //function __construct(DB\SQL $db)
    //{
        // This is where the mapper and DB structure synchronization occurs
    //    parent::__construct($db, 'vendors');
   // }

    // Specialized query
    function listByCity()
    {
        return $this->select('vendorID,name,city', null, array('order' => 'city DESC'));
        /*
        We could have done the same thing with plain vanilla SQL:
        return $this->db->exec(
            'SELECT vendorID,name,city FROM vendors '.
            'ORDER BY city DESC;'
        );
        */
    }

    public function test(){
        echo 'ok google';
    }



}
