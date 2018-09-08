<?php

namespace App\lib;

/**
 * Description of app
 *
 * @author Alisson Ferreira
 */

class app {
    
    private  $modules;
    
    private  $controller = "home";

    private  $mothod;

    private  $param = [];
    
    private  $url = [];


    public function __construct() {

        //Capturando paramentros vindo pela url
        $this->url = self::parseURl(isset($_GET['url'])?$_GET['url'] : "home");

        //Criando uma instancia de uma classe controller 
        $this->controller($this->url[0], $this->url[1]);
        
        //Criando um obj de uma classe controller
        $this->method($this->url[2]);
        
        //setando paramentos para o obj em forma de array
        $this->paran($this->url);

        
        
        switch ($this->controller){
            //Se existir cookie d o usuario tera acesso ao sistema
            case (!empty($_COOKIE['d'])):    
            call_user_func_array([$this->controller, $this->mothod], $this->param);
            break;
        
            //Acesso somente a tela de  login
            case (get_class($this->controller) == 'App\modules\home\Controllers\home' && self::valida($this->mothod)):
            call_user_func_array([$this->controller, $this->mothod], $this->param);
            break;

            //Caso o usuario tente forçar alguma url redireciona para pagina inicial 
            default:   
            header("Location: ".$_SERVER['REQUEST_SCHEME']."://app-shape.com/");
            break;
        }

    }
    
    private function controller($module,$controller){
        //verficando se existe um determinado caminho
        if(file_exists('App/modules/'.$module.'/Controllers/'.((empty($controller))? $this->controller:$controller).'.php')){
            //Atribuindo valores a constantes
            define('CONTROLLER', $controller);
            define('MODULES', $module);

            //removendo elementos do array de url
            unset($this->url[0]);
            unset($this->url[1]);

            //setando valor para variavel module 
            $this->modules = $module;

            //Criando uma instancia de uma classe controller
            $valor = "App\modules\\".$this->modules."\Controllers\\".$controller;
            $this->controller = new $valor;
        }else{
            //se não existir o caminho sera retornado uma tela de erro 404 personalizada para usuario 
            $this->controller =  new \App\modules\home\Controllers\error404();
            $this->mothod = "index";
        }
    }
    
    private function method($method){
        //verificando se o method existe na instancia controller
        if($method && method_exists($this->controller, $method)){

            //atribuindo method a variavel de class
            $this->mothod = $method;

            //Atribuindo valor a constante
            define('METHOD', $method);

            //removendo elementos do array de url
            unset($this->url[2]);
        }else{
            //se não existir o method sera retornado uma tela de erro 404 personalizada para usuario
            $this->controller = new \App\modules\home\Controllers\error404();
            $this->mothod = "index";

            //Atribuindo valor a constante
            define('METHOD', $this->mothod);
            define('CONTROLLER', 'index');
        }
    }
    
    private function paran($param){
        //verificando se existe algum valor vindo como param pela url
        if(empty($param[3])){
            $this->param = [];
        }else{
            //pegando valores do vairavel
            $this->param =  array_values($param);

            //trando possiveis param mal intencionado
            $this->param = trata_paran_url($param);
        }
    }
    
    //Validando url
    private function parseURl($url){

        $array =  explode("/", filter_var(rtrim($url), FILTER_SANITIZE_URL));
        $dados[] = ((!empty($array[0]))?$array[0] = str_replace('-','_',$array[0]):"home");
        $dados[] = ((!empty($array[1]))?$array[1]:"home");
        $dados[] = ((!empty($array[2]))?$array[2]:"index");
        $dados[] = ((!empty($array[3]))?$array[3]:"");
        return $dados;

    }

    //fazendo leitura de xml
    private function xml($valor){
        $valor = str_replace('-','_',$valor);
        if (file_exists('arquivo.xml')) {
            $xml = simplexml_load_file('arquivo.xml');
            foreach($xml->clientes as $key =>$list){
                if($list->nome == $valor){
                    $dados = $list;

                }
            }
            return ((!empty($dados))?$dados:null);
        }
    }
    
    //validando chamadas expecificos
    private function valida($metodo){
        
        $array = array('index','login');
        
        if(in_array($metodo,$array)){
            return true;
        }
    }
}
