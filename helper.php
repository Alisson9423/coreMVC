<?php

/**
 * Versão Do Sistema
 */
define('Version','1.0.0');

/**
 * @author Alisson Ferreira
 * @return Retorna o caminho raiz
 */
function caminho_raiz(){
    $site_path = ''.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/'.'';
    return $site_path;
}

/**
 * @param $inf
 * cria cookies com base em um array
 */
function logar($inf){
    foreach ($inf as $key => $value){
        setcookie($key, base64_encode($value),time()+3600,'/');
    }
}

/**
 * @param $inf
 * remove os cookiesda pagina
 */
function logout($inf){

    foreach ($inf as $key => $value){
        setcookie($key,'',time()-3600,'/');
    }
}

/**
 * @param $datapega
 * @return string
 * retorna data dd/mm/aaaa
 */
function Formata_Data($datapega) {
    
    if(!empty($datapega)):
        $data = explode('-', $datapega);
        $datacerta = $data[2] . '/' . $data[1] . '/' . $data[0];
        return $datacerta; 
    endif;
    
}

/**
 * @param $value
 * @return string
 * formata data para ser salva no banco de dados
 */
function Formata_data_DB($value){
    $data = explode('/', $value);
    $datacerta = $data[2] . '-' . $data[1] . '-' . $data[0];
    return $datacerta;

}

/**
 * @param $valor
 * @return mixed|string
 * retorna informações sobre o cookies
 */
function retorna_dados_cookie_usuario_adm($valor){
    
    switch ($valor){
        
    
        case 'usuario':
        return ((!empty($_COOKIE['d']))?trata_string_input(base64_decode($_COOKIE['d'])):"");
        break;
    
    }
}

/**
 * @param $valor
 * @return string
 * retorna uma string formatada em reais pt-br
 */
function formata_reais($valor){
    return 'R$'.number_format($valor,2,',','.');
}

/**
 * @param $inf
 * @return mixed
 * remove caracteres maliciosos
 */
function trata_dados_view($inf){
    $inf_array = array();
    
    parse_str($inf, $inf_array);
    
    foreach ($inf_array as $key => $value) {
        $dados[$key] = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|\\\\)|\'|(\(|\))/",'',$value);
    }

    return $dados;
    
}

/**
 * @param $str
 * @return mixed
 * remove caracteres maliciosos vindo como paramentros
 */
function trata_string_input($str){
    return preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|\\\\)|\'/",'',$str);
}

/**
 * @param $str
 * @return mixed
 * remove caracteres maliciosos vindo como paramentros
 */
function trata_numero_input($str){
    return preg_replace("/[^0-9]/", "", $str);
}

/**
 * @param $datapega
 * @return string
 * retorna dd/mm/aaaa & 11:22
 */
function formata_data_time($datapega) {
    if(!empty($datapega)):
        $dia = explode(' ', $datapega);
    
        $data = str_replace('-', '/', $dia[0]);
        $data = implode("/", array_reverse(explode("/", $data)));
        $hora = $dia[1];

        $datacerta = $data." & ".$hora;

        return $datacerta;
    endif;
}

/**
 * @param type int 0 a 5
 * @return parâmetro da url
 * @author Alisson
 * @example $url[0] /
 * @example $url[1]core
 * @example $url[2]modules
 * @example $url[3]controller
 * @example $url[4]action
 * @example $url[5]parâmetro
 */

function get_url($valor = 5){
   $url = explode("/", $_SERVER['REQUEST_URI']);
   
   switch ($valor){
        case 0:
        return $url[0];
        break;
    
        case 1:
        return $url[1];
        break;
    
        case 2:
        return $url[2];
        break;
    
        case 3:
        return $url[3];
        break;
    
        case 4:
        return $url[4];
        break;
    
        case 5:
        return $url[5];
        break;
    
   }
   
}
/**
 * 
 * @return data
 * @example 2017-05-22 13:51:09
 */
function retorna_data_hora(){
       $data = date('Y-m-d H:i:s');
       return $data;
}

/**
 * 
 * @return data
 * @example 2017-05-22 13:51:09
 */
function retorna_data(){
       $data = date('Y-m-d');
       return $data;
}

/**
 * @param $cpf
 * @return bool
 * valida cpf
 */
function validaCPF($cpf){
    $cpf = preg_replace('/[^0-9]/','', $cpf);

    $digitoA = 0;
    $digitoB = 0;

    for($i = 0, $x =10 ; $i<=8 ; $i++ , $x--){
         $digitoA += $cpf[$i] * $x;
    }

     for($i = 0, $x =11 ; $i<=9 ; $i++ , $x--){
         $digitoB += $cpf[$i] * $x;
         if(str_repeat($i, 11) == $cpf){
             return false;
        }
     }

     $somaA = (($digitoA%11 < 2)? 0:11-($digitoA%11));
     $somaB = (($digitoB%11 < 2)? 0:11-($digitoB%11));



    if($somaA != $cpf[9] || $somaB != $cpf[10]){
        return false;
    }else{
        return true;
    }
}

/**
 * @param $string
 * @return bool
 * valida email
 */
function valida_email($string){
    if(preg_match('/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/i', $string)){
        return true;
    }else{
        return false;
    }
    
}

/**
 * @return mixed
 * retorna dia da semana
 */
function dias_semana(){
    $diaSemana = date('w');

    $diaExt = array(
        "0"=>"Domingo",
        "1"=>"Segunda Feira",
        "2"=>"Terça Feira",
        "3"=>"Quarta Feira",
        "4"=>"Quinta Feira",
        "5"=>"Sexta Feira",
        "6"=>"Sabado"
    );

    return $diaExt[$diaSemana];
}

function saudacao(){
    $data = date('H:i:s');
    $result =(int) substr($data, 0,2);
    
    if($result > 6 && $result <= 12){
        echo "Bom Dia ";
    }elseif($result > 12 && $result <= 18){
        echo "Boa Tarde";
    }else{
        echo "Boa Noite";
    }
}

/**
 * carrega arquivos js
 */
function Cjs_raiz_P_D(){
    
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/js/libs/jquery-2.1.1.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/js/index.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/js/upload.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/js/jquery-ui.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/js/libs/jquery-ui-1.10.4.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/js/bootstrap/bootstrap.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/js/libs/modernizr.custom.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/js/jRespond.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/plugins/core/slimscroll/jquery.slimscroll.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/plugins/core/slimscroll/jquery.slimscroll.horizontal.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/plugins/core/fastclick/fastclick.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/plugins/core/velocity/jquery.velocity.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/plugins/core/quicksearch/jquery.quicksearch.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/plugins/ui/bootbox/bootbox.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/plugins/charts/sparklines/jquery.sparkline.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/js/jquery.dynamic.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/js/main.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() . 'assets/js/pages/blank.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/plugins/ui/notify/jquery.gritter.js?ver=' . Version . '" type="text/javascript"></script>'; 
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/js/pages/modals.min.js?ver=' . Version . '" type="text/javascript"></script>'; 
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/plugins/forms/fancyselect/fancySelect.min.js?ver=' . Version . '" type="text/javascript"></script>'; 
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/plugins/forms/select2/select2.min.js?ver=' . Version . '" type="text/javascript"></script>'; 
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/plugins/forms/maskedinput/jquery.mask.min.js?ver=' . Version . '" type="text/javascript"></script>'; 
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/plugins/forms/bootstrap-datepicker/bootstrap-datepicker.min.js?ver=' . Version . '" type="text/javascript"></script>';
    echo "\n\t\t" . '<script src="' . caminho_raiz() .'assets/plugins/ui/bootstrap-sweetalert/sweet-alert.min.js?ver=' . Version . '" type="text/javascript"></script>'; 

    if (file_exists('App/modules/'.MODULES.'/View/'.CONTROLLER.'/js/scripts-'.CONTROLLER.'.js')) {
        echo "\n\t\t" . '<script src="'.caminho_raiz().'App/modules/'.MODULES.'/View/'.CONTROLLER.'/js/scripts-'.CONTROLLER.'.js?ver=' . Version . '" type="text/javascript"></script>';
	}else{
        echo 'Caminho não encontrado -> App\View\\'.CONTROLLER.'\js\scripts-home.js';
    }

}


/**
 * @author Alisson Ferreia
 * @return Carrega os Arquivos CSS do Template Padrão
 */

function Ccss_raiz_P_D(){
    echo "\n\t\t" . '<link rel="stylesheet" href="' . caminho_raiz() . 'assets/css/icons.css?ver=' . Version . '" />';
    echo "\n\t\t" . '<link rel="stylesheet" href="' . caminho_raiz() . 'assets/css/bootstrap.css?ver=' . Version . '" />';
    echo "\n\t\t" . '<link rel="stylesheet" href="' . caminho_raiz() . 'assets/css/plugins.css?ver=' . Version . '" />';
    echo "\n\t\t" . '<link rel="stylesheet" href="' . caminho_raiz() . 'assets/css/main.css?ver=' . Version . '" />';
    echo "\n\t\t" . '<link rel="stylesheet" href="' . caminho_raiz() . 'assets/css/custom.css?ver=' . Version . '" />';
    echo "\n\t\t" . '<link rel="stylesheet" href="' . caminho_raiz() . 'assets/css/upload.css?ver=' . Version . '" />';
    echo "\n\t\t" . '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . caminho_raiz() . 'assets/img/ico/apple-touch-icon-144-precomposed.png" />';
    echo "\n\t\t" . '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . caminho_raiz() . 'assets/img/ico/apple-touch-icon-114-precomposed.png" />';
    echo "\n\t\t" . '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . caminho_raiz() . 'assets/img/ico/apple-touch-icon-72-precomposed.png" />';
    echo "\n\t\t" . '<link rel="apple-touch-icon-precomposed"  href="' . caminho_raiz() . 'assets/img/ico/apple-touch-icon-57-precomposed.png" />';
    echo "\n\t\t" . '<link rel="icon"  href="' . caminho_raiz() . 'assets/img/ico/favicon.ico" type="image/png" />';
    
}