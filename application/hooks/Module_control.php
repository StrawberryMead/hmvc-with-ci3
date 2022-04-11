<?php

require_once APPPATH.'/modules/controls/initialization.php';

class Module_control{
    function __construct(){

    }
    public function init_module() : bool{

        $module_name = 'administration';
        $database_configs = array(
            'user'=>'user',
            'password' => 'password',
            'host' => 'localhost',
            'schema' => $module_name,
            'port'  => 5432
        );
        $init_parameters = array(
            'module_name' => $module_name,
            'application_path' => APPPATH,
            'database_configs' => $database_configs
        );
        $module = new Initialization($init_parameters);
        $initialized_module = $module->init_module();

        return true;
    }
}