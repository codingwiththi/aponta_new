//ativando o data table 
$(document).ready(function() {
    $('#example').DataTable();

});
//---------------------------



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
        window.location.href = '/apontamento';
        //exibir mensagem ou erro
        $('#erro_edita').html("");

        //se tiver tudo certo eu só recarrego a pagina
    }).fail(function(xhr, status, error) {
        //Ajax erro
        $('#erro_edita').html("deu erro");
        //alert('Error -');
    })

});

$('.modal-footer .btn-danger').click(function() {
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