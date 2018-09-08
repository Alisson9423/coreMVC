<?php

namespace App\modules\home\Controllers;
use App\lib\Controller;

class error404 extends Controller{
    
    public function index() {
        
        $this->load('erro404');
        
    }
        
}
