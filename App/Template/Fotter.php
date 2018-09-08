<?php

namespace App\Template;
/**
 * Created by PhpStorm.
 * User: Alisson
 * Date: 02/08/2018
 * Time: 08:00
 */
class Fotter implements Template{

    //renderiza um arquivo phtml
    public function render($render = null){
        include_once ($this->setPath($render));
    }

    //verifica se existe o araquivo e retorna o caminho
    private function setPath($render){

        $this->path = 'App/Template/layouts/'.$render.'.phtml';

        if($this->fileExists($this->path)){
            return $this->path;
        }

    }

    //retorna true e existir o caminho
    private function fileExists($file){
        if(file_exists($file)){
            return true;
        }else{
            die('Erro Não foi localizado o arquivo '.$file);
        }
    }
}