facebook = {
    cidade_facebook: function(o) {
        
        var e = $(o).find("option:selected").val();
        $(".auto_face").empty(); 
        $(".auto_face").html(`<div class="form-group auto cidade"> 
                            <label>Cidade</label>
                            <input type="text" placeholder="Cidade" required onkeyup="system.autoComplet(this,\'cidadeF\',' ${e} ')" data-dados="dGFibGU=:Y2lkYWRl,Y2FtcG8=:bm9tZQ==,b3JkZXI=:YXNj,Y2FtcG9faWQ=:aWRfY2lkYWRl"  class="form-control input">
                            <input name="cidade_id"  class="value" type="hidden">
                            <ul id="result" class="option-list calc" ></ul>
                        </div>`);
    },
    adicionar : function(e){
        var inf = $("#inf").serialize();
        var e = $("form");
        
        if(validaForm(e)){
            $.post("home/home/facebook",
                {cookie: encodeURIComponent(document.cookie),
                     inf : inf,

                }, function (data) {
                    $.gritter.add({
                    title: get_nome(),
                    text: 'Adicionada com sucesso !!!',
                    image: get_img(),
                    close_icon: 'l-arrows-remove s16'
                    });
                    $('#inf input').val('');
                    

            });
        }
    },
};

