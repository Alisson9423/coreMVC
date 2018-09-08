/**
 * aplica mascara nos input
 */
$(document).ready(function() {
   mask();  
});

var helperForm = {
    login(e){
        e.preventDefault();
        let action = document.querySelector('form').action;
        let array = {};
        
        let findElemnt = Array.from(document.querySelectorAll('form input,textarea,select'));
    
        findElemnt.forEach(function(e){
            array[e.name] = e.value;
        });

        
        $.post(action,
        {
    
            inf: array
    
        }, function (data) {
            if(data == 1){
                setTimeout(function(){
                    location.reload();
                }, 
                1000);
            }else{
                $.gritter.add({
                title: 'System',
                text: data,
                image: 'http://'+url_construct()[2]+'/assets/img/avatars/cortana.jpg',
                close_icon: 'l-arrows-remove s16'
                });
            }
        }); 
       
    },
    add(e){
        e.preventDefault();
        let action = document.querySelector('form').action;
        
        let array = {};
        
        let findElemnt = Array.from(document.querySelectorAll('form input,textarea,select'));
    
        findElemnt.forEach(function(e){
            if(e.name != ''){
                array[e.name] = e.value;
            }
        });
    
        $.post(action,
        {
    
            inf: array
    
        }, function (data) {
            $.gritter.add({
            title: 'System',
            text: data,
            image: 'http://'+url_construct()[2]+'/assets/img/avatars/cortana.jpg',
            close_icon: 'l-arrows-remove s16'
            });
            Array.from(document.querySelectorAll('form input')).forEach(e =>e.value = "");
        });
    }
}
/**
 * 
 * @param data 
 * formata data
 * dd/mm/aaaa ou dd/mm/aaaa 11:22
 * 
 */
function formata_data_time(data = null){
    if(data == null){
        return '';
    }else{
        var dia = data.split(' ');
        return dia[0].split('-').reverse().join('/')+((dia[1] == null)?'':' & ' +dia[1]);
    }
}
/**
 * 
 * @param  n 
 * retorna uma string formatada no padrão pt-br
 */
function formatReal(n){
    let valor = parseFloat(n);
    return "R$ " + valor.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
}

function status_pagseguro(id = null){
    let rs = ((id)?id:0);
    let status = ["Pendente","Aguardando pagamento","Em análise","Pago","Pago","Em disputa","Devolvida","Cancelada"];
    return status[rs];
}
/**
 * 
 * @param  action 
 * formata url para post
 */
function url_post(action = ''){
    var url_atual = window.location.href;
    var array =  url_atual.split("/");
    var index =  array[0]+"//"+array[2]+""+"/"+array[3]+"/"+array[4]+"/"+action;
    return index;
}
/**
 * Constroi uma url a partir do contexto
 */
function url_construct(){
    var url_atual = window.location.href;
    var array =  url_atual.split("/");
    return array;
}

/**
 * retorna id vindo pela url
 */
function id_post(){
    var url_atual = window.location.href;
    var array =  url_atual.split("/");
    var index =  array[6];
    return index;
}
/**
 * url para usuario sair do sistema
 */
function sair(){
    return url_construct()[0]+"//"+url_construct()[2]+"/home/home/Logout";
}

/**
 * aplica mascara nos input
 */
function mask(){
    
    $('input[data-mask=porcento]').mask('00,00');
    $('input[data-mask=n]').mask('0000');
    $('input[data-mask=altura]').mask('0,00');
    $('input[data-mask=peso]').mask('00,000');
    $('input[data-mask=data_site]').mask('00/00/0000');
    $('input[data-mask=time]').mask('00:00');
    $('input[data-mask=cnpj]').mask('00.000.000/0000-00');
    $('input[data-mask=tel]').mask('(00)90000-0000',{
    translation: {
            '9': {
              pattern: /[9]/, optional: true
            }
        }   
    });
    $('input[data-mask=cep]').mask('00000-000');
    $('input[data-mask=money]').mask('000,00', {reverse: true});
}    

/**
 * sai do sistema 
 */
function Logout(){
    $.post(sair(),
            {cookie: encodeURIComponent(document.cookie),
            
            }, function (data) {
                $(location).attr('href', url_construct()[0]+'//'+url_construct()[2]+'');
        });
}