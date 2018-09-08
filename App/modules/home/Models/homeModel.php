<?php

namespace App\modules\home\Models;
use App\lib\Model;


/**
 * Description of homeModel
 *
 * @author Alisson
 */
class homeModel extends Model{

    public function login($inf){
        
        $sql = "select * from login 
        where usuario = '".$inf['usuario']."' and senha = '".md5($inf['senha'])."'";
        $result = $this->linhaLeft($sql);

        if(($result->usuario == $inf['usuario']) && ($result->senha == md5($inf['senha']))){
            $dados_login['d'] = ((!empty($result->usuario))?$result->usuario:null);
            $dados_login['e'] = ((!empty($result->senha))?$result->senha:null);
            logar($dados_login);
            echo "1";
        }else{
            echo "Usuario ou Senha Não Confere";
        }
        
    }

}
