//ativando o data table 
$(document).ready(function() {
    $('#example').DataTable();
    //ativar datatable

    //------------------------------------
    // var data_inicial = document.getElementById('data_inicial');
    // var data_final = document.getElementById('data_final');
    // var hora_inicial = document.getElementById('hora_inicial');
    // var hora_final = document.getElementById('hora_final');
    // //---
    //preeenchendo datas atuais
    // var data_temp = new Date();
    // var data_string = data_temp.toISOString();
    // var data_atual = data_string.split("T", 2);
    // console.log(data_temp, data_string, data_atual);
    // data_inicial.value = data_atual[0];
    // data_final.value = data_atual[0];
    // //preenchendo horas -> preeenchendo mesmo
    // //console.log(data_atual[1]);
    // //AUTO PREEENCHER DATA
    // hora_inicial.value = data_atual[1].split(":", 1) + ":00";
    // hora_final.value = data_atual[1].split(":", 1) + ":00";

});





function parseStringToDate(dateStr, horaStr) {
    var parts = dateStr.split("-");
    //console.log(parts);
    return new Date(parts[0] + "-" + parts[1] + "-" + parts[2] + "T" + horaStr + ":00");
}

// function RetornaDataHoraAtual(){
//     var dNow = new Date();
//     var localdate = dNow.getDate() + '-' + (dNow.getMonth()+1) + '-' + dNow.getFullYear() ;
//     var hora = dNow.getHours() + ':' + dNow.getMinutes();
//     return localdate,hora;
//   }
  
// console.log();
//inicio valida form


setTimeout(function(){
        $('#erro_login').remove();
},3000);
//----------------------------------------
function ValidaFormInsert() {
    //FAZER VALIDAÇÃO DE DATA AQUIIII
    var data_inicio = $('#data_inicial').val();
    var hora_inicio = $('#hora_inicial').val();
    var data_final = $('#data_final').val();
    var hora_final = $('#hora_final').val();
    var data_atual = new Date();
    console.log(parseStringToDate(data_inicio, hora_inicio));
  //  console.log(RetornaDataHoraAtual());
    if (parseStringToDate(data_inicio, hora_inicio) >= parseStringToDate(data_final, hora_final)) {
        //mostrar error
        $('#alert_erro').html('INTERVALO DE DATA INVALIDA').fadeIn(300).delay(5000).fadeOut(400);
        $('#data_inicial').focus();
        $('#hora_inicial').focus();
        $('#data_final').focus();
        $('#hora_final').focus().slideDown(500);

        return false;
    }

    if((parseStringToDate(data_inicio, hora_inicio) >= data_atual ) || (parseStringToDate(data_final, hora_final) >= data_atual ) ){

        $('#alert_erro').html('INTERVALO DE DATA INVALIDA').fadeIn(300).delay(5000).fadeOut(400);
        $('#data_inicial').focus();
        $('#hora_inicial').focus();
        $('#data_final').focus();
        $('#hora_final').focus().slideDown(500);

        return false;
    }

}
//----------------------------------------




//---------------------------
//formulario insere
// $(document).ready(function() {
//     $('#botao').click(function() {
//         //variavel recebe isso ou aquilo
//         var data_inicio = $('#data_inicio').val();
//         var data_final = $('#hora_final').val();
//         var hora_inicio = $('#data_final').val();
//         var hora_final = $('#hora_final').val();
//         console.log(data_final, data_inicial);


//     });

// });
//fim formulario insere

//------------------------------------------------
// var data = new Date()
// var dia = data.getDate();

// ativando tabela de apontamento pendentes

//fim tabela apontamentos pendentes



//ABRINDO MODEL E PEGANDO DADOS PARA ALETRAR E APAGAR
// fazer isso para que eu possa ja deixar o formulario montado com os selcts lá
$(".btn-sm[data-target='#myModal']").click(function() {
    // var id = $(this).parent().find('tr').attr('id');
    // // console.log(id);
    // var id = $('#tabela_apontamentos tr').click(function () { 
    //     //var id = $(this).parent().find('tbody tr').attr('id');
    //     //var id = $(this).attr("id");
    //     //alert(id);
    //     return $(this).attr("id");
    // });
    // var str = JSON.stringify(id, null, 4); // (Optional) beautiful indented output.
    // alert(str);
    // var teste = $(this).text();
    // alert(teste);


    var columnHeadings = $("thead th").map(function() {
        return $(this).text();
    }).get();

    columnHeadings.pop();
    // console.log(columnHeadings);
    var columnValues = $(this).parent().siblings().map(function() {
        return $(this).text();
    }).get();
    //console.log();
    console.log(columnValues);
    //esse é um select 
    //$('#edita_cliente').val(ok);
    $('#id_linha_edita').val(columnValues[0]);
    $('#edita_num_chamado').val(columnValues[1]);
    $("#edita_cliente").val($('option:contains("' + columnValues[2] + '")').val());
    $("#edita_tp_atv").val($('option:contains("' + columnValues[3] + '")').val());
    $("#edita_atv").val($('option:contains("' + columnValues[4] + '")').val());
    //var data =new Date();
    //console.log(data);
    //columnValues[5] = columnValues[5].replace(" ", "T");
    var data_inicio = columnValues[5].split(" ");
    //console.log(data_inicio);
    $('#edita_dt_ini').val(data_inicio[0]);
    $('#edita_time_ini').val(data_inicio[1]);
    //columnValues[6] = columnValues[6].replace("", "T");
    var data_fim = columnValues[6].split(" ");
    $('#edita_dt_fim').val(data_fim[0]);
    $('#edita_time_fim').val(data_fim[1]);

    $("#edita_tp_hr").val($('option:contains("' + columnValues[7] + '")').val());

    //------------------------------------------------------------------------------------

    //-- preeencher a o select dinamico de dentro da opção editar
    var tipo_atividade_id = $('#edita_tp_atv').val();
    console.log(tipo_atividade_id);
    $.ajax({
            type: "GET",
            data: "tipo_atividade_id=" + tipo_atividade_id,
            url: "/apontamento/baseCadastro",
            async: false
        }).done(function(data) {
            //console.log($.parseJSON(data));
            var atividades = "";
            $.each($.parseJSON(data), function(chave, valor) {
                atividades += '<option value="' + valor.id + '">' + valor.nome + '</option>'

            });
            $('#edita_atividade').html(atividades);
        })
        //----------------------------------------------------------------------------
        // --------------------------- preeencher contrato edita

    var cliente_id = $('#edita_cliente').val();
    $.ajax({
            type: "GET",
            data: "cliente_id=" + cliente_id,
            url: "/apontamento/baseCadastro",
            async: false
        }).done(function(data) {
            var contratos = "";
            $.each($.parseJSON(data), function(chave, valor) {
                contratos += '<option value="' + valor.id + '">' + valor.contrato + '</option>'

            });
            $('#edita_contrato').html(contratos);
        })
        //fim preeencher contrato editaaaaa ----------------------------------------------

});

$('.modal-footer .btn-primary').click(function() {
    //BOTAO SALVAR
    //SERIALIZO FORMULARIO E ENVIO PRA ROTA DE ALTERAR
    //var teste =$('#edita_isso').serialize() ;
    //console.log(teste);
    // $('form[name="edita_isso"]').submit(
    // //     function(){
    // //     $.ajax({
    // //         url: "/apontamento/alterarApotamento",
    // //         method: "POST",
    // //         data: $('#edita_isso').serialize(),
    // //         type:'json',
    // //         success: function(data) {
    // //             if (data.error) {
    // //                 printErrorMsg(data.error);
    // //             } else {
    // //                 console.log(data);
    // //                 alert(data);
    // //                 //window.location.href = "/apontamento/alterarApotamento";
    // //             }
    // //         }
    // //     });
    // // }
    // );

    //FAZER VALIDAÇÃO DE DATA AQUI
    var form = $('#edita_isso').serialize();
    //var teste = "0k";
    //console.log("ok");
    $.ajax({
        type: "POST",
        data: form,
        url: "/apontamento/alterarApotamento",
        async: false
    }).done(function(data) {
        console.log(data);
        //exibir mensagem ou erro
        if (data == 1)
            window.location.href = '/apontamento';
        else
            //console.log(data);
            $('#erro_edita').html(data).fadeIn(300).delay(5000).fadeOut(400);

        //se tiver tudo certo eu só recarrego a pagina
    }).fail(function(xhr, status, error) {
        //Ajax erro
        $('#erro_edita').html("deu erro");

        $('#erro_edita').fadeIn(300).delay(1500).fadeOut(400);
        //alert('Error -');
    })

});




$('#exclui_apontamento').click(function() {
    //BOTAO excluir
    //SERIALIZO O FORMULARIO E ENVIO PARA A ROTA DE APAGAR
    //pego o ID E  ENVIO VIA GET

    // $('#edita_isso').submit(function (){
    //     var teste =$('#edita_isso').serialize() ;
    //     console.log(teste);
    // });
    var form = $('#edita_isso').serialize();
    //var teste = "0k";
    //console.log("ok");
    $.ajax({
        type: "POST",
        data: form,
        url: "/apontamento/excluirApotamento",
        async: false
    }).done(function(data) {
        console.log(data);
        //exibir mensagem ou erro
        //se tiver tudo certo eu só recarrego a pagina
        window.location.href = '/apontamento';
        //exibir mensagem ou erro
        $('#erro_edita').html("");

    }).fail(function(xhr, status, error) {
        //Ajax erro
        $('#erro_edita').html("deu erro");
        //alert('Error -');
    })


});

// FIM ABRINDO MODAL R


//PREEENCENDO SELECTS----------------------------------




$('#cliente').on('change load DOMContentLoaded', function(e) {
    var cliente_id = $(this).val();
    $.ajax({
        type: "GET",
        data: "cliente_id=" + cliente_id,
        url: "/apontamento/baseCadastro",
        async: false
    }).done(function(data) {
        var contratos = "";
        $.each($.parseJSON(data), function(chave, valor) {
            contratos += '<option value="' + valor.id + '">' + valor.contrato + '</option>'

        });
        $('#contrato').html(contratos);
    })
})



$('#tipo_atividade').change(function(e) {
    var tipo_atividade_id = $(this).val();
    //console.log(tipo_atividade_id);
    $.ajax({
        type: "GET",
        data: "tipo_atividade_id=" + tipo_atividade_id,
        url: "/apontamento/baseCadastro",
        async: false
    }).done(function(data) {
        //console.log($.parseJSON(data));
        var atividades = "";
        $.each($.parseJSON(data), function(chave, valor) {
            atividades += '<option value="' + valor.id + '">' + valor.nome + '</option>'

        });
        $('#atividade').html(atividades);
    })

})



//--------------- form editar/excluir dados -------------

$('#edita_cliente').on('change load DOMContentLoaded', function(e) {
    var cliente_id = $(this).val();
    $.ajax({
        type: "GET",
        data: "cliente_id=" + cliente_id,
        url: "/apontamento/baseCadastro",
        async: false
    }).done(function(data) {
        var contratos = "";
        $.each($.parseJSON(data), function(chave, valor) {
            contratos += '<option value="' + valor.id + '">' + valor.contrato + '</option>'

        });
        $('#edita_contrato').html(contratos);
    })
})



$('#edita_tp_atv').on('change load DOMContentLoaded', function(e) {
    var tipo_atividade_id = $(this).val();
    //console.log(tipo_atividade_id);
    $.ajax({
        type: "GET",
        data: "tipo_atividade_id=" + tipo_atividade_id,
        url: "/apontamento/baseCadastro",
        async: false
    }).done(function(data) {
        //console.log($.parseJSON(data));
        var atividades = "";
        $.each($.parseJSON(data), function(chave, valor) {
            atividades += '<option value="' + valor.id + '">' + valor.nome + '</option>'

        });
        $('#edita_atividade').html(atividades);
    })

})

$(document).ready(function() {

});
//FIM PREECHE SELCT


// pagina historico 
$(document).ready(function() {
    // adicionando input
    $('#historico thead th').each(function(indice) {
        console.log(indice);
        // if (indice < 5){
        var title = $(this).text();
        // $(this).html( '<p> frwwfrfrw</p>' );
        $(this).html('<input size="10" type="text" placeholder="' + title + '" />');

        // }

    });

    $('#historico').DataTable({
        "responsive": true,
        "scrollCollapse": true,
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "Todos"]
        ],

        // "scrollY"   :'50vh',
        "language": {
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "Nada encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(filtrado de _MAX_ registros no total)"
        }
    });
    // DataTable
    var table = $('#historico').DataTable();

    // Apply the search
    table.columns().every(function() {
        var that = this;

        $('input', this.header()).on('keyup change clear', function() {
            if (that.search() !== this.value) {
                that
                    .search(this.value)
                    .draw();
            }
        });
    });
});


// fim pagina historico

//-----------------------------------------------------------



// função para validar o formulario de inserção
//----------------------------------------------------


// function validarFomr(frm) {

//     var datainicio = frm.data_inicial.value;
//     var datafinal = frm.data_inicial.value;

//     i

// }

//---------------------------------

//ativando o data table de apontamento pendentes

//---------------------------//


//MODAL DA PAGINA PENDENTES
//------------------------------------------------------
$(".btn-sm[data-target='#modalHist']").click(function() {

    console.log("entrei");
    var columnHeadings = $("thead th").map(function() {
        return $(this).text();
    }).get();

    columnHeadings.pop();
    // console.log(columnHeadings);
    var columnValues = $(this).parent().siblings().map(function() {
        return $(this).text();
    }).get();
    //console.log();
    console.log(columnValues);


    $('#id_hist').val(columnValues[0]);
    $('#cliente_hist').val(columnValues[3]);
    $('#nome_hist').val(columnValues[1]);
    $('#duracao_hist').val(columnValues[6]);
    $('#num_chamado_hist').val(columnValues[4]);
    $('#data_hist').val(columnValues[5]);


});

// enviar para rota de revisar pendentes
$("#revisar_pendentes").click(function() {

    //FAZER VALIDAÇÃO DE DATA AQUI
    var form = $('#pendentes_aceitar').serialize();
    //var teste = "0k";
    //console.log("ok");
    $.ajax({
        type: "POST",
        data: form,
        url: "/editaveis/Pendentes",
        async: false
    }).done(function(data) {
        console.log(data);
        //exibir mensagem ou erro
        if (data == 1)
            $('#edita_pendente_msg').html("Alteração sugerida com sucesso").fadeIn(250).delay(4000).fadeOut(300);
        //     window.location.href = '/apontamento';
        // else
        //     $('#erro_edita').html(data).fadeIn(300).delay(5000).fadeOut(400);

        //se tiver tudo certo eu só recarrego a pagina
    })


});