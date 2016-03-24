$(document).ready(function() {
    //////=======
    /// base ajax
    // $.ajax({
    //     url: url,
    //     data: form.serialize(),
    //     success: function(data){
    //         alert(data);
    //     },
    //     error: function(data){
    //         console.log('error');
    //     }
    // });
    /// base ajax
    //////=======


    // var teste = '2015-08-31 15:00:35';
    // var formattedDate = new Date(teste);
    // var d = formattedDate.getDate();
    // if(d){
    //     d = '0'+d;
    // }
    // var m =  formattedDate.getMonth();
    // m += 1;  // JavaScript months are 0-11
    // if(m){
    //     m = '0'+m;
    // }
    // var y = formattedDate.getFullYear();
    // var h =  formattedDate.getHours();
    // var min =  formattedDate.getMinutes();
    // console.log(d+'/'+m+'/'+y);


    // >>> PlAdminVerCompletoForm
    $('.formPL .save').click(function(){
        $('.save').toggleClass('hide');
        $('.preloader-wrapper').toggleClass('hide');
        var formLocal = $(this).parent().parent().parent();
        var formLocal = formLocal.attr('id');
        var url = $('#url_edit').val();
        var serializeArray = $('#'+formLocal).serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: serializeArray,
            success: function(data){
                console.log(data);
                $('.save').toggleClass('hide');
                $('.preloader-wrapper').toggleClass('hide');
                alert('PL Alterada');
            },
            error: function(data){
                console.log('error');
            }
        });

    });
    // <<< PlAdminVerCompletoForm

    // >>> SAVE BLOCK
    $('.formBlock .save').click(function(){
        var formLocal = '';
        var idModelBlockUrl = '';
        var idPL = '';
        var urlComID = '';
        idPL = $('#pl_id').val();
        urlComID = '/'+idPL;
        formLocal = $(this).parent().parent().parent().parent().parent();
        formLocalName = formLocal.attr('id');
        var verificarForm = formLocalName.split('Form');

        //>>> acho a tag form?
        if(verificarForm[1] == undefined){
            formLocal = $(this).parent().parent().parent().parent().parent().parent();
            formLocalName = formLocal.attr('id');
        }
        //<<< acho a tag form?

        // >>> SE FOR OS BLOCOS DE FOCO ou O QUE É
        if( (formLocalName == 'FocoAdminVerCompletoForm') || (formLocalName == 'OqueEAdminVerCompletoForm') ){
            idModelBlockUrl = $(this).parent().parent().parent().parent().parent();
        }else{
            idModelBlockUrl = $(this).parent().parent().parent().parent().parent();
        }
        // <<< SE FOR OS BLOCOS DE FOCO ou O QUE É


        idModelBlockUrl = idModelBlockUrl.attr('id');
        var idModelBlockName = $('#'+idModelBlockUrl+' #model_rel_name').val();
        var url = $('#'+idModelBlockUrl+' #model_rel_url').val();
        var serializeArray = $('#'+formLocalName).serialize();


        $.ajax({
            type: 'POST',
            url: url+'/'+idModelBlockName+urlComID,
            data: serializeArray,
            accepts: {json: 'application/json'},
            success: function(data){
                console.log(data);
                if(data != ''){
                    //////////////////////////////////////////////////
                    //////////////////////////////////////////////////
                    ///>>> gerar o looping do banco atualizado(PARSE JSON PARA JQUERY)
                    var registros = JSON.parse(data);
                    registros = registros.reverse();
                    if(eval("registros[0]."+idModelBlockName)){
                        //>>> FORMATED DATE
                            var formattedDate = new Date(eval("registros[0]."+idModelBlockName).modified);
                            var d = formattedDate.getDate();
                            if(d < 10){
                                d = '0'+d;
                            }
                            var m =  formattedDate.getMonth();
                            m += 1;  // JavaScript months are 0-11
                            if(m<10){
                                m = '0'+m;
                            }
                            var y = formattedDate.getFullYear();
                            var h =  formattedDate.getHours();
                            if(h<10){
                                h = '0'+h;
                            }
                            var min =  formattedDate.getMinutes();
                        //<<< FORMATED DATE

                        var htmlAtualizacaoData = d+'/'+m+'/'+y;
                        var htmlAtualizacaoHora = h+':'+min;
                        var dataHora = htmlAtualizacaoData+ ' às ' +htmlAtualizacaoHora;
                        var html = '';
                        $( "#"+idModelBlockName+" strong#dataHora" ).text(dataHora);

                        //>>> LISTAR TEXTOS
                            $( "#"+idModelBlockName+" p.text" ).remove();
                            if(idModelBlockName != 'Foco' || idModelBlockName != 'OqueE'){
                                if($( "#"+idModelBlockName).find('edit-text')){
                                    $( "#"+idModelBlockName+" .edit-text").toggleClass('hide');
                                }
                                $.each(registros, function(index, registro) {
                                    htmlTxt = '<p class="text">'+eval("registro."+idModelBlockName).txt+'</p>';
                                    $( "#"+idModelBlockName ).append(htmlTxt);
                                });
                            }
                        //<<< LISTAR TEXTOS

                        $( "#"+formLocalName ).trigger('reset');//<<< RESET FORM
                    }
                    ///<<< gerar o looping do banco atualizado(PARSE JSON PARA JQUERY)
                    //////////////////////////////////////////////////
                    //////////////////////////////////////////////////
                }else{
                    alert('erro ao editar texto');
                }
            },
            error: function(data){
                console.log('error');
                console.log(data);
            }
        });




    });

    // <<< SAVE BLOCK

    $('.btn-edit').click(function(){
        var formLocal = $(this).parent().parent().parent();
        var formLocal = formLocal.attr('id');
        var url = $('#url_edit').val();

        $('#'+formLocal+' .text').toggleClass('hide');
        $('#'+formLocal+' .edit-text').toggleClass('hide');
    });


    //>>> Upload via ajax
    // $('.formBlock #fileUpload').click(function(){
    //     var formLocal = '';
    //     var idModelBlockUrl = '';
    //     var idPL = '';
    //     var urlComID = '';
    //     idPL = $('#pl_id').val();
    //     urlComID = '/'+idPL;
    //     formLocal = $(this).parent().parent().parent().parent().parent();
    //     formLocalName = formLocal.attr('id');
    //     var verificarForm = formLocalName.split('Form');
    //
    //     //>>> acho a tag form?
    //     if(verificarForm[1] == undefined){
    //         formLocal = $(this).parent().parent().parent().parent().parent().parent();
    //         formLocalName = formLocal.attr('id');
    //     }
    //     //<<< acho a tag form?
    //
    //     // >>> SE FOR OS BLOCOS DE FOCO ou O QUE É
    //     if( (formLocalName == 'FocoAdminVerCompletoForm') || (formLocalName == 'OqueEAdminVerCompletoForm') ){
    //         idModelBlockUrl = $(this).parent().parent().parent().parent();
    //     }else{
    //         idModelBlockUrl = $(this).parent().parent().parent().parent().parent().parent();
    //     }
    //     // <<< SE FOR OS BLOCOS DE FOCO ou O QUE É
    //
    //     idModelBlockUrl = idModelBlockUrl.attr('id');
    //     var idModelBlockName = $('#'+idModelBlockUrl+' #model_rel_name').val();
    //     var url = $('#'+idModelBlockUrl+' #model_rel_url').val();
    //     var serializeArray = $('#'+formLocalName).serialize();
    //
    //     var ext = "jpg,png,gif,doc,pdf,zip";
    //     var statusClass = $('#'+formLocalName+' .status');
    //     var buttonClass = $('#'+formLocalName+' .mulitplefileuploader-'+idModelBlockName);
    //     uploadFiles(ext, statusClass, buttonClass);
    //     // alert(statusClass);
    // });
    //<<< Upload via ajax



});
