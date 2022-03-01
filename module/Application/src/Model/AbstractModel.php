<?php

namespace Application\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\AdapterInterface;

abstract class AbstractModel {
    public $adapter;
    public $sql;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->sql = new Sql($this->adapter);
    }
}