<?php

    namespace Senderismo\Modelos ;

    abstract class BaseModel
    {
        protected \PDO $db ;

        public function __construct(\PDO $db)
        {
            $this->db = $db ;
        }
    }
