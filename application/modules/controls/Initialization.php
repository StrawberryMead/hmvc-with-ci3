<?php

class Initialization{

    private string $module_name;
    private string $module_path;
    private array $database_configs;

    function __construct(array $init_parameters){
        
        $required_parameters = array(
            'module_name',
            'application_path',
            'database_configs'
        );

        $is_parameters_complete = empty(array_diff($required_parameters, array_keys($init_parameters)));

        if(!$is_parameters_complete){
            return false;
        }

        foreach($required_parameters as $parameters){
            if(isset($init_parameters[$parameters])){
                $$parameters = $init_parameters[$parameters];
            }
        }

        $this->module_name =  $module_name;
        $this->module_path =  "{$application_path}/modules/{$module_name}";
        $this->database_configs = $database_configs;
    }

    private function is_module_initialized() : bool {
        return file_exists($this->module_path);
    }

    public function init_module() : bool{
        if(empty($this->module_name)){
            return false;
        }

        $module_name = $this->module_name;
        $module_path = $this->module_path;

        if(!$this->is_module_initialized()){
            return false;
        }

        exec("git pull https://user:password@bitbucket.org/user/repo.git {$module_name} {$module_path}");

        return $this->is_module_initialized();
    }

    private function init_module_database() : void {

    }
}