<?php

namespace App\Template;
/**
 * Created by PhpStorm.
 * User: Alisson
 * Date: 02/08/2018
 * Time: 07:59
 */
class View implements Template{


    public function render($render = null){
         $this->path = 'App/modules/'.MODULES.'/View/'. CONTROLLER .'/'.((!empty($render))?$render:'index').'.phtml';
        if($this->fileExists($this->path)){
            return $this->path;
        }
    }


    private function fileExists($file){
        if(file_exists($file)){
            return TRUE;
        }else{
            die('Erro Não foi localizado o arquivo '.$file);
        }
    }

}