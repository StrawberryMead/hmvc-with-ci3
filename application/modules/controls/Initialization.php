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

        if($this->is_module_initialized()){
            return false;
        }

        exec("git clone -b {$module_name} https://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@github.com/StrawberryMead/hmvc-with-ci3.git {$module_path}");

        return $this->is_module_initialized();
    }

    public function uninstall_module() : bool{
        
        if(empty($this->module_name)){
            return false;
        }

        $module_name = $this->module_name;
        $module_path = $this->module_path;

        if(!($this->is_module_initialized())){
            return false;
        }
        $module = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($module_path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($module as $module_item) {
            $remove_module = ($module_item->isDir() ? 'rmdir' : 'unlink');
            chmod($module_item->getRealPath(), 0777);
            $remove_module($module_item->getRealPath());
        }
        
        chmod($module_path, 0777);
        rmdir($module_path);

        // $this->remove_dir($module_path);
        
        return !($this->is_module_initialized());
    }

    private function remove_dir(string $dir) : void{    
        if (is_dir($dir)) { 
            $objects = scandir($dir);
            foreach ($objects as $object) { 
              if ($object != "." && $object != "..") { 
                if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                    $this->remove_dir($dir. DIRECTORY_SEPARATOR .$object);
                else
                  unlink($dir. DIRECTORY_SEPARATOR .$object); 
              } 
            }
            rmdir($dir); 
        } 
    }

    private function init_module_database() : void {

    }
}