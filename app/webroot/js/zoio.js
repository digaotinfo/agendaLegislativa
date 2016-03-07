$(document).ready(function() {
    //////=======
    /// base ajax
    // $.ajax({
    //     url: url,
        // data: serializeArray,
        // accepts: {json: 'application/json'},
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



    $ ('.ano') .mask ('0000');

    // >>> PlAdminVerCompletoForm
    $('.formPL .save').click(function(){
        $('.save').toggleClass('hide');
        $('.preloader-wrapper').toggleClass('hide');
        var formLocal = $(this).parent().parent().parent();
        var formLocal = formLocal.attr('id');
        var url = $('#url_edit').val();
        var serializeArray = $('#'+formLocal).serialize();

        var pl_id = $("#pl_id").val();

        $.ajax({
            type: 'POST',
            url: url,
            data: serializeArray,
            success: function(data){
                console.log(data);
                $('.save').toggleClass('hide');
                $('.preloader-wrapper').toggleClass('hide');


                // $('#modalPlAlteradaSucesso').openModal();


                // >>> ENVIAR EMAIL

                Materialize.toast('<span>Notificar por E-mail</span><a class="btn-flat yellow-text enviarEmail-sim" href="#!">Sim<a><a class="btn-flat yellow-text enviarEmail-nao" href="#!">Não<a>', 5000);

                $('.enviarEmail-nao').click(function(){
                    $('#toast-container').remove();
                });
                $('.enviarEmail-sim').click(function(){
                    $('#modalEnviarAtualizacaoEmail').openModal();

                    var urlEmail = $('#enviar_pl_email_generico').val();
                    var urlEmailCompleta = '';
                    var serializeEnvioAtualizacao = $('form#atualizacaoPorEmail').serialize();

                    urlEmailCompleta = urlEmail
                    console.log(urlEmailCompleta);
                    // debugger;


                    $('.enviarAtualizacaoEmail').click(function(){
                        var checkValues =   $('input[name="enviarParaUsuarios[]"]:checked').map(function(){
                                                return this.value;
                                            }).get();




                        $('#modalEnviarAtualizacaoEmail').closeModal();
                        $('#modalEmailEnviando').openModal();
                        $.ajax({
                            type: 'POST',
                            url: urlEmailCompleta,
                            data: { idUsuarios: checkValues },
                            accepts: {json: 'application/json'},
                            success: function(data){
                                console.log(data);


                                if(data == true){
                                    $('#modalEmailEnviando').closeModal();
                                    envioEmail(data);
                                }else{
                                    $('#modalEmailErroNoEnvio').closeModal();
                                }

                            },
                            error: function(data){
                                console.log('error');
                                console.log(data);
                            }
                        });
                    });
                });
                // >>> ENVIAR EMAIL



            },
            error: function(data){
                $('#modalPlAlteradaErro').openModal();
                console.log(data);
                console.log('error');
            }
        });

    });
    // <<< PlAdminVerCompletoForm

    // >>> SAVE BLOCK
    $('.form.save').click(function(){
        // console.log("aqui...");

        var elemento = $(this);
        var nameBlock = $(this).attr('data-nameBlock');
        var btnAlter = '';
        var urlCompleto = '';
        btnAlter = $(this).attr('id');
        var nameModel = btnAlter.split('form_');
        nameModel = nameModel[1];
        var formName = $('#'+nameModel+'AdminVerCompletoForm').attr('id');
        var url = $('#'+formName+' #url_alter_data').val();
        var serializeArray = $('#'+formName).serialize();
        var textos = $("#"+nameModel.toLowerCase()+"_texto").html( tinymce.get(nameModel.toLowerCase()+"_texto").getContent() );
        var tipo = $('#selectTipo').val();
        // console.log(nameModel);

        if( (nameModel == 'Foco') || (nameModel == 'OqueE') || (nameModel == 'NossaPosicao') ){
            urlCompleta = $('.section#'+nameModel+' #url_alter_data').val()+'/'+tipo;
        }else{
            urlCompleta = url+'/'+nameModel+'/0/'+tipo;
        }


        // console.log($(elemento).find("i.material-icons"));
        // if ($(elemento).find("i.material-icons")) {
        //     $(elemento).find("i.material-icons").addClass('fa-spin');
        // }


        $.ajax({
            type: 'POST',
            url: urlCompleta,
            data: serializeArray+'&' + $.param(textos),
            accepts: {json: 'application/json'},
            success: function(data){
                // console.log(data);

                if(data != ''){
                    //////////////////////////////////////////////////
                    //////////////////////////////////////////////////
                    ///>>> gerar o looping do banco atualizado(PARSE JSON PARA JQUERY)
                    var registros = JSON.parse(data);
                    if(nameModel == 'Foco' || nameModel == 'OqueE' || nameModel == 'NossaSituacao'){
                        registros = registros;
                    }else{
                        registros = registros.reverse();
                    }
                    if(eval("registros[0]['Pl']."+nameModel)){
                        //>>> FORMATED DATE PL
                            var formattedDate = new Date(eval("registros[0]['Pl']."+nameModel)[0].modified);
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
                            if(min<10){
                                min = '0'+min;
                            }
                        //<<< FORMATED DATE PL

                        var htmlAtualizacaoData = d+'/'+m+'/'+y;
                        var htmlAtualizacaoHora = h+':'+min;
                        var dataHora = htmlAtualizacaoData+ ' às ' +htmlAtualizacaoHora;
                        var html = '';
                        $( "#"+nameModel+" strong#dataHora" ).text(dataHora);

                        //>>> LISTAR TEXTOS
                        // console.log(nameModel);
                            $( "#"+nameModel+" .texto, #"+nameModel+" .atualizacao-feita" ).remove();
                            // $( "#"+nameModel+" p, #"+nameModel+" .atualizacao-feita" ).remove();


                            if( (nameModel == 'Foco') || (nameModel == 'OqueE') || (nameModel == 'NossaPosicao') ){
                                $.each(registros, function(index, registro) {
                                    //>>> FORMATED DATE LogAtualizacao
                                        var formattedDate = new Date(registro.LogAtualizacaoPl.modified);
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
                                        if(min<10){
                                            min = '0'+min;
                                        }
                                        var htmlAtualizacaoData = d+'/'+m+'/'+y;
                                        var htmlAtualizacaoHora = h+':'+min;
                                        var dataHora = htmlAtualizacaoData+ ' às ' +htmlAtualizacaoHora;
                                    //<<< FORMATED DATE LogAtualizacao
                                    if($("#"+nameModel).find('atualizadoJS')){
                                        $("#"+nameModel+" .atualizadoJS").remove();
                                    }

                                    if($.trim( eval("registro.Pl."+nameModel)[index].arquivo ) != ''){
                                        htmlTxt = htmlTxt+'<p class="text">'+eval("registro['Pl']."+nameModel).txt+'<br><a href="'+webroot+eval("registro[Pl]."+nameModel).arquivo+'" target="_blank" class="waves-effect waves-light btn green darken-3"><i class="material-icons left">file_download</i>Baixar Arquivo</a></p>';
                                    }else{
                                        htmlTxt = '<div class="atualizadoJS"><div class="atualizacao-feita blockInf"><small class="atualizacao-realizada"><span>atualizado por: '+registro.LogAtualizacaoPl.usuario_nome+'</strong> em <strong id="dataHoraAtualizado">'+dataHora+'</strong> </small></div>';
                                        htmlTxt = htmlTxt+'<div class="text">'+eval("registro.Pl."+nameModel)[index].txt+'</div></div>';
                                    }
                                    $( "#"+nameModel ).append(htmlTxt);

                                    // tinymce.activeEditor.setContent("teste");

                                    if($( "#"+nameModel).find('edit-text')){
                                        // tinymce.activeEditor.execCommand('mceSetContent', false, eval("registro['Pl']."+nameModel).txt);
                                        // tinymce.activeEditor.setContent("teste");
                                        $( "#"+nameModel+" .edit-text").toggleClass('hide');
                                    }
                                });
                            }else{
                                if($( "#"+nameModel).find('edit-text')){
                                    $( "#"+nameModel+" .edit-text").toggleClass('hide');
                                }

                                var cont=0;
                                $.each(registros, function(index, registro) {
                                    // console.log(registro);
                                    //>>> FORMATED DATE LogAtualizacao
                                        var formattedDate = new Date(registro.LogAtualizacaoPl.modified);
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
                                        var htmlAtualizacaoData = d+'/'+m+'/'+y;
                                        var htmlAtualizacaoHora = h+':'+min;
                                        var dataHora = htmlAtualizacaoData+ ' às ' +htmlAtualizacaoHora;
                                    //<<< FORMATED DATE LogAtualizacao

                                    // console.log( registro.LogAtualizacaoPl.arquivo);

                                    if( $.trim(registro.LogAtualizacaoPl.arquivo) != ''){
                                        htmlTxt = '<div class="atualizacao-feita blockInf"><small class="atualizacao-realizada"><span>atualizado por: '+registro.LogAtualizacaoPl.usuario_nome+'</strong> em <strong id="dataHoraAtualizado">'+dataHora+'</strong> </small></div>';
                                        htmlTxt = htmlTxt+'<p class="text">'+registro.LogAtualizacaoPl.txt+'<br><a href="'+webroot+registro.LogAtualizacaoPl.arquivo+'" target="_blank" class="waves-effect waves-light btn green darken-3"><i class="material-icons left">file_download</i>Baixar Arquivo</a></p>';
                                    }else{
                                        if(cont == 0){
                                            htmlTxt = '<p class="text">'+registro.Pl.Situacao[0].txt+'</p>';
                                        }else{
                                            htmlTxt="";
                                        }
                                        htmlTxt = htmlTxt+'<div class="atualizacao-feita blockInf"><small class="atualizacao-realizada"><span>atualizado por: '+registro.LogAtualizacaoPl.usuario_nome+'</strong> em <strong id="dataHoraAtualizado">'+dataHora+'</strong> </small></div>';
                                        htmlTxt = htmlTxt+'<p class="text">'+registro.LogAtualizacaoPl.txt+'</p>';

                                        cont++;
                                    }

                                    $( "#"+nameModel ).append(htmlTxt);

                                });

                            }
                        //<<< LISTAR TEXTOS
                        ///<<< gerar o looping do banco atualizado(PARSE JSON PARA JQUERY)
                        //////////////////////////////////////////////////
                        //////////////////////////////////////////////////

                        $( "#"+formName ).trigger('reset');//<<< RESET FORM
                        $('.ajax-file-upload-statusbar').remove();
                        $('.arquivo_'+nameModel).val('');





                        // >>> ENVIAR EMAIL
                        $('.enviarEmail-nao').click(function(){
                            $('#toast-container').remove();
                        });
                        $('.enviarEmail-sim').click(function(){
                            $('#modalEnviarAtualizacaoEmail').openModal();

                            var urlEmail = $('#enviar_pl_email').val();
                            var urlEmailCompleta = '';
                            var serializeEnvioAtualizacao = $('form#atualizacaoPorEmail').serialize();


                            if( (nameModel == 'Foco') || (nameModel == 'OqueE') || (nameModel == 'NossaSituacao') ){
                                urlEmailCompleta = urlEmail+'/'+nameModel+'/'+registros[0]['LogAtualizacaoPl']['id']+'/'+nameBlock;
                            }else{
                                registros = registros.reverse();
                                urlEmailCompleta = urlEmail+'/'+nameModel+'/'+registros[0]['LogAtualizacaoPl']['id']+'/'+nameBlock;
                            }

                            $('.enviarAtualizacaoEmail').click(function(){
                                var checkValues =   $('input[name="enviarParaUsuarios[]"]:checked').map(function(){
                                                        return this.value;
                                                    }).get();




                                $('#modalEnviarAtualizacaoEmail').closeModal();
                                $('#modalEmailEnviando').openModal();
                                $.ajax({
                                    type: 'POST',
                                    url: urlEmailCompleta,
                                    data: { idUsuarios: checkValues },
                                    accepts: {json: 'application/json'},
                                    success: function(data){
                                        // console.log(data);
                                        if(data == true){
                                            $('#modalEmailEnviando').closeModal();
                                            envioEmail(data);
                                        }else{
                                            $('#modalEmailErroNoEnvio').closeModal();
                                        }
                                    },
                                    error: function(data){
                                        console.log('error');
                                        console.log(data);
                                    }
                                });
                            });
                        });
                        // >>> ENVIAR EMAIL

                    }



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

    // >>> SAVE BLOCK
    $('.form.save-tarefa').click(function(){
        // console.log("ESTE AQUI");
        var elemento = $(this);
        var nameBlock = $(elemento).attr('data-nameBlock');
        var idDaTarefa = $(elemento).attr('data-idDaTarefa');
        var nameModel = $(elemento).attr('data-nameModel');
        var formName = $('#'+nameModel+'AdminVerCompletoForm').attr('id');
        var serializeArray = $('#'+formName).serialize();
        var urlCompleta = $(elemento).attr('data-urlPl');

        var titulo = $('#'+nameModel.toLowerCase()+'_tituloNew').val();
        var descricao = tinymce.get(nameModel.toLowerCase()+'_textoNew').getContent();
        var entrega = $('#'+nameModel.toLowerCase()+'_entregaNew').val();

        // $('.contentTarefaPl').remove();

        // console.log($(elemento).find("i.material-icons"));
        $(elemento).find("i.material-icons").addClass('fa-spin');

        $.ajax({
            type: 'POST',
            url: urlCompleta,
            data: {
                nameModel: nameModel,
                idDaTarefa: idDaTarefa,
                nameBlock: nameBlock,
                titulo: titulo,
                descricao: descricao,
                entrega: entrega
            },
            // data: serializeArray+'&' + $.param(textos),
            accepts: {json: 'application/json'},
            success: function(data){
                // console.log(data);

                if(data != ''){
                    $(elemento).find("i.material-icons").removeClass('fa-spin');

                    //////////////////////////////////////////////////
                    //////////////////////////////////////////////////
                    ///>>> gerar o looping do banco atualizado(PARSE JSON PARA JQUERY)
                    var registros = JSON.parse(data);
                    ////////////////////////////////////////////////////////
                    /////////////////////////////////////////
                    //////// >>>> enviar por email
                    $('#editTarefa_'+idDaTarefa).closeModal();
                    $('#modalNotificacaoPorEmail').openModal();
                    $('.enviarNotificacaoPorEmail').click(function(){
                        var urlEnviarNotificacaoPorEmail = $(this).attr('data-urlEnviarNotificacaoPorEmail');

                        $.ajax({
                            type: 'POST',
                            url: urlEnviarNotificacaoPorEmail+'/'+registros[0]['lastIDTarefa'],
                            data: {
                                idDaTarefa: idDaTarefa,
                                nameBlock: nameBlock,
                            },
                            accepts: {json: 'application/json'},
                            success: function(dataTarefa){

                                if(dataTarefa != ''){
                                    $('#modalNotificacaoPorEmail').closeModal();
                                    $('#modalEmailEnviado').openModal();
                                    location.reload();
                                }else{
                                    alert('erro ao editar texto');
                                }
                            },
                            error: function(dataTarefa){
                                console.log('error');
                                console.log(dataTarefa);
                            }
                        });
                    });

                    $(".naoEnviarNotificacaoPorEmail").click(function(event) {
                        console.log("AQUIiiiii");
                        location.reload();
                    });

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

    // >>> EDIT TAREFA
    $('.form.btnEditTarefa').click(function(){
        var nameBlock   = $(this).attr('data-nameBlock');
        var idDaTarefa  = $(this).attr('data-tarefaId');
        var nameModel = $(this).attr('data-nameModel');
        var urlCompleta = $(this).attr('data-urlEditTarefa');

        var formName = $('#'+nameModel+'AdminVerCompletoForm').attr('id');
        var serializeArray = $('#'+formName).serialize();
        var titulo = $('#'+nameModel.toLowerCase()+'_titulo_'+idDaTarefa).val();
        var descricao = tinymce.get(nameModel.toLowerCase()+'EditDescricao_'+idDaTarefa).getContent();
        var entrega = $('#'+nameModel.toLowerCase()+'_dataEntrega_'+idDaTarefa).val();
        // var ativo = $('#idTarefa_'+idDaTarefa+' #tarefapl_ativo').val();
        var realizado = $("input[class="+nameModel.toLowerCase()+"_realizadaClass_"+idDaTarefa+"][value=1]").is(":checked");
        if(realizado == 1){
            realizado = 1;
        }else{
            realizado = 0;
        }


        $.ajax({
            type: 'POST',
            url: urlCompleta,
            data: {
                nameModel: nameModel,
                idDaTarefa: idDaTarefa,
                nameBlock: nameBlock,
                titulo: titulo,
                descricao: descricao,
                entrega: entrega,
                realizado: realizado
            },
            accepts: {json: 'application/json'},
            success: function(data){
                // console.log(data);

                if(data != ''){
                    //////////////////////////////////////////////////
                    //////////////////////////////////////////////////
                    ///>>> gerar o looping do banco atualizado(PARSE JSON PARA JQUERY)
                    var registros = JSON.parse(data);

                    ////////////////////////////////////////////////////////
                    /////////////////////////////////////////
                    //////// >>>> enviar por email
                    $('#editTarefa_'+idDaTarefa).closeModal();
                    $('#modalNotificacaoPorEmail').openModal();
                    $('.enviarNotificacaoPorEmail').click(function(){
                        var urlEnviarNotificacaoPorEmail = $(this).attr('data-urlEnviarNotificacaoPorEmail');

                        $.ajax({
                            type: 'POST',
                            url: urlEnviarNotificacaoPorEmail+'/'+idDaTarefa,
                            data: {
                                idDaTarefa: idDaTarefa,
                                nameBlock: nameBlock,
                            },
                            accepts: {json: 'application/json'},
                            success: function(dataTarefa){

                                if(dataTarefa != ''){
                                    $('#modalNotificacaoPorEmail').closeModal();
                                    $('#modalEmailEnviado').openModal();
                                    location.reload();
                                }else{
                                    alert('erro ao editar texto');
                                }
                            },
                            error: function(dataTarefa){
                                console.log('error');
                                console.log(dataTarefa);
                            }
                        });
                    });

                    $(".naoEnviarNotificacaoPorEmail").click(function(event) {
                        console.log("AQUIiiiii");
                        location.reload();
                    });

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
    // <<< EDIT TAREFA

    $('.btn-edit').click(function(){
        var btnLocal = $(this).attr('id');
        btnLocalId = btnLocal.split('edit_');
        var url = $("#mostrarContentTextArea").val();

        $.ajax({
            type: "POST",
            url: url,
            data: {nameModel: btnLocalId[1]},
            accepts: {json: 'application/json'},
            success: function(data){
                var registros = JSON.parse(data);
                var texto = eval("registros."+btnLocalId[1]).txt;
                tinymce.get(btnLocalId[1].toLowerCase()+"_texto").setContent(texto);

                $('.section#'+btnLocalId[1]+' .text').toggleClass('hide');
                $('.section#'+btnLocalId[1]+' .edit-text').toggleClass('hide');
                $( "#"+btnLocalId[1]+" .texto" ).toggleClass('hide');
            },
            error: function(data){
                console.log('error');
                console.log(data);

                $('.section#'+btnLocalId[1]+' .text').toggleClass('hide');
                $('.section#'+btnLocalId[1]+' .edit-text').toggleClass('hide');
                $( "#"+btnLocalId[1]+" .texto" ).toggleClass('hide');
            }
        });


    });


    $('.btn-edit-tarefa').click(function(){
        var btnLocal = $(this).attr('id');
        var idTarefa = $(this).attr('data-idproposicao');
        btnLocalId = btnLocal.split('edit_');
        var url = $("#mostrarContentTextAreaTarefa").val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                nameModel: btnLocalId[1],
                idTarefa: idTarefa
            },
            accepts: {json: 'application/json'},
            success: function(data){
                // console.log('deu certo o click 2');
                // console.log(data);
                var registros = JSON.parse(data);
                $( "#"+btnLocalId[1]+" .texto.tarefa_"+idTarefa ).toggleClass('hide');
                $('.section#'+btnLocalId[1]+' .edit-text#idTarefa_'+idTarefa).toggleClass('hide');
            },
            error: function(data){
                console.log('error');
                console.log(data);

                $('.section#'+btnLocalId[1]+' .text').toggleClass('hide');
                $('.section#'+btnLocalId[1]+' .edit-text').toggleClass('hide');
                $( "#"+btnLocalId[1]+" .texto" ).toggleClass('hide');
            }
        });


    });






    // >>> ADD TIPO PL
    $('.add-tipoPl').click(function() {
        var url = $('#url_addTipo').val();
        window.location.replace(url);
    });
    // <<< ADD TIPO PL




    // >>> ADD SITUACAO PL
    $('.add-situacaoPl').click(function() {
        var url = $('#add_situacaoPl').val();
        window.location.replace(url);
    });
    // <<< ADD SITUACAO PL



    // >>> ADD TEMA PL
    $('.add-tema').click(function() {
        var url = $('#add_tema').val();
        window.location.replace(url);
    });
    // <<< ADD TEMA PL



    // >>> GERAR PDF
    $('.gerarPdf').click(function(){
        $('#modalGerandoRelatorio').openModal();
        var url = $('#urlGerarRelatorio').val();
        var serializeArray = $('form#gerarRelatorio').serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: serializeArray,
            accepts: {json: 'application/json'},
            success: function(data){
                // console.log(data);
                var registros = JSON.parse(data);
                // console.log(registros);
                if(registros['url'] != false){
                    $('#modalRelatorioGerado .baixarArquivo').attr('href', webroot+registros['url']);
                    $('#modalRelatorioGerado #enviarLinkPdf').val(registros['url']);
                    $('#modalGerandoRelatorio').closeModal();
                    $('#modalRelatorioGerado').openModal();

                    $('.enviarEmail').click(function(){
                        // console.log('enviarEMail');
                        $('#modalRelatorioGerado').closeModal();
                        $('#modalEnviarAtualizacaoEmail').openModal();
                        var urlEmailRelatorio = $('input#enviarRelatorioEmail').val();

                        $('.enviarRelatorioEmail').click(function(){
                            // console.log('enviarRelatorioEmail');
                            var serializeArrayEmail = $('form#enviarRelatorioEmail').serialize();
                            var checkValues =   $('input[name="enviarParaUsuarios[]"]:checked').map(function(){
                                                    return this.value;
                                                }).get();
                            var arquivo = $('#enviarLinkPdf').val();
                            // console.log( $('#enviarLinkPdf').val() );
                            // console.log(serializeArrayEmail);

                            $.ajax({
                                type: 'POST',
                                url: urlEmailRelatorio,
                                data: {
                                    idUsuarios: checkValues,
                                    urlArquivo: arquivo
                                },
                                // data: serializeArrayEmail,
                                accepts: {json: 'application/json'},
                                success: function(data){
                                    // console.log(data);

                                    if(data == true){
                                        $('#modalEnviarAtualizacaoEmail').closeModal();
                                        $('#modalEmailEnviado').openModal();
                                    }
                                },
                                error: function(data){
                                    console.log(data);
                                    console.log('error');
                                }
                            });


                        });
                    });
                }else{
                    $('#modalRelatorioVazio').openModal();
                    $('#modalGerandoRelatorio').closeModal();
                }
            },
            error: function(data){
                console.log(data);
                console.log('error');
            }
        });
    });
    // <<< GERAR PDF


    //>>> DELETE PROPOSICAO
    $('a.deletePL').click(function() {
        var url = $(this).attr('id');
        var redirect = $('#list-proposicoes').val();

        $.ajax({
            type: 'POST',
            url: url,
            accepts: {json: 'application/json'},
            success: function(data){
                var result = JSON.parse(data);
                if(result['sucess'] == true){
                    $('#modalDeletePl').closeModal();
                    window.location.replace(redirect);
                }
            },
            error: function(data){
                console.log(data);
                console.log('error');
            }
        });
    });
    //<<< DELETE PROPOSICAO

    //>>> RELATORIO CONDITIONS
    $('.conditions a').click(function(){
        var nameClassofClick = $(this).attr('class');
        var typeConditions = nameClassofClick.split(' ');
        var typeLegend = typeConditions[2].split('legend_');
        $('.'+typeConditions[1]).toggleClass('hide');
        $('#type_option_'+typeConditions[1]).val(typeLegend[1]);
    });
    //<<< RELATORIO CONDITIONS


    //>>> Fluxograma
    /*
    *
    * modal btn-etapaJaExistente
    */
    $('.btn-etapaJaExistente').click(function(){
        $('#modalOpcaoEtapas').closeModal();
        $('#modalEtapas').openModal();
    });
    /*
    *
    * modal btn-subEtapaJaExistente
    */
    $('.btn-subEtapaJaExistente').click(function(){
        var etapa = $(this).attr('data-etapaID');
        var URLsubEtapaDestaEtapa = $(this).attr('data-subetapasdestaetapa');
        $('#modalOpcaoSubEtapas_'+etapa).closeModal();
        $('#modalSubEtapaDaEtapaID_'+etapa).openModal();
        var selectDropdown = $("#selectSubEtapaList");

        $.ajax({
            type: "POST",
            url: URLsubEtapaDestaEtapa,
            dataType: 'json',
            success: function(data){
                // Clear the content
                $(".selecionarSubEtapa select").empty().html(' ');

                // And add a new value
                if (data) {
					$('.selecionarSubEtapa select').append($("<option value='0'>Selecione a Sub-Etapa</option>"));
					$('.selecionarSubEtapa select').material_select();
                    $.each(data, function(index, value){
                        $('.selecionarSubEtapa select').append($("<option>",{
                            value: value['FluxogramaSubEtapa']['id'],
                            text: value['FluxogramaSubEtapa']['subetapa']
                        }));
                    });
                    $('.selecionarSubEtapa select').material_select();
                    $('.formFluxogramaSubEtapa > span.caret').remove();
                }

                // Update the content clearing the caret
                $(".selecionarSubEtapa select").material_select('update');
                $(".selecionarSubEtapa select").closest('.input-field').children('span.caret').remove();

            },
            error: function(data){
                console.log('deu erro');
                console.log(data);
            },
        });

    });
    /*
    *
    * modal btn-subEtapaADD
    */
    $('.btn-subEtapaADD').click(function(){
        var etapa = $(this).attr('data-etapaID');

        $('#modalOpcaoSubEtapas_'+etapa).closeModal();
        $('#modalNovaEtapa_'+etapa).openModal();
    });
    //<<< Fluxograma


});


function envioEmail(data){
    if(data == true){
        $('#modalEmail').closeModal();
        $('#modalEmailEnviado').openModal();
    }else{
        $('#modalEmailErroNoEnvio').openModal();
    }
}
