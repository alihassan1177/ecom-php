<?php

namespace App\traits;

trait Singleton {
    public static function getInstance(){
        $instances = [];
        $called_class = get_called_class();

        if (!isset($instances[$called_class])) {
            $instances[$called_class] = new $called_class;
        }

        return $instances[$called_class];
        
    }
}