<?php

namespace App\modules\home\Controllers;
use App\lib\Controller;
use App\modules\home\Models\homeModel;

class home extends Controller{
    //por padrão toda classe controller executa automaticamente o method index caso não chame outro method
    public function index(){
        if(!empty($_COOKIE['d'])):
            $this->load();
        else:
            $this->onePage('login');
        endif;
    }

    public function login(){
        $db_model = new homeModel();
        $valor = filter_input_array(INPUT_POST,FILTER_DEFAULT);
        $db_model->login($valor['inf']);
    }

    public function Logout(){
        Logout($_COOKIE);
    }


}
