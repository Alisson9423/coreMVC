<?php

namespace App\lib;
use App\Template\Fotter;
use App\Template\Header;
use App\Template\Slidebar;
use App\Template\Template;
use App\Template\View;
use App\Template\login;

/**
 * Description of Controller
 *
 * @author Alisson Ferreira CPF 128-157-876.28
 */
class Controller{
    private $header = "header";
    private $slide = "slidebar-menu";
    private $view = "index";
    private $footer = "footer";
    protected $registry;


    //Este method é utilizado para ler dados de propriedades inacessíveis
    public function __get( $key ){
        $this->registry =  $key;
    }

    //Este method é executado ao escrever dados em propriedades inacessíveis.
    public function __set($name, $value){

        $this->registry[$name] = $value;
    }

    //renderiza os elemntos para usuário 
    protected function load($render = null){
        
        $this->render(new Header(),$this->header);
        $this->render(new Slidebar(),$this->slide);
        $this->view(new View(),$render);
        $this->render(new Fotter(),$this->footer);

    }

    //Method recebe uma instancia que implmenta a interface Template
    private function render(Template $template,$render){
        return $template->render($render);
    }

    //Renderizando a view com suas variaveis
    protected function view(Template $template,$render = null){
        
        if(!empty($this->registry)):
            foreach ($this->registry as $key => $value) {
                $$key = $value;
            }

        endif;

        include_once $template->render($render);
    }

    //Renderiza uma unica pagina
    protected function onePage($page){
        $this->render(new login(),$page);
    }

    /**
     * @param string $slide
     */
    public function setSlide($slide){
        $this->slide = $slide;
    }

    /**
     * @param string $header
     */
    public function setHeader($header){
        $this->header = $header;
    }

    /**
     * @param string $view
     */
    public function setView($view){
        $this->view = $view;
    }

    /**
     * @param string $footer
     */
    public function setFooter($footer){
        $this->footer = $footer;
    }

    

}
