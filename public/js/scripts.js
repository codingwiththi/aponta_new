//ativando o data table 
$(document).ready(function() {
    $('#example').DataTable();
} );

//ABRINDO MODEL E PEGANDO DADOS PARA ALETRAR E APAGAR
//posso apagar todos os inputs do formulario assim que eu clickar e deixar só o de escolher
// fazer isso para que eu possa ja deixar o formulario montado com os selcts lá
$(".btn-sm[data-target='#myModal']").click(function () {
    var columnHeadings = $("thead th").map(function () {
        return $(this).text();
    }).get();
    columnHeadings.pop();
    // console.log(columnHeadings);
    var columnValues = $(this).parent().siblings().map(function () {
        return $(this).text();
    }).get();
    // var modalBody = $('<div id="modalContent"></div>');
    // var modalForm = $('<form role="form" name="modalForm" action="teste_edit.php" method="post">');
    // $.each(columnHeadings, function (i, columnHeader) {
    //     var formGroup = $('<div class="form-group"></div>');
    //     formGroup.append('<label for="' + columnHeader + '">' + columnHeader + '</label>');
    //     formGroup.append('<input class="form-control" name="' + columnHeader + i + '" id="' + columnHeader + i + '" value="' + columnValues[i] + '" />');
    //     formGroup.append('#input_teste');
    //     modalForm.append(formGroup);
    // });
    // modalBody.append(modalForm);
    // $('.modal-body').html(modalBody);
    //var ok = $('#edita_cliente option:selected').text();
    //var ok = 
    console.log(columnValues);
    //esse é um select 
    //$('#edita_cliente').val(ok);
    $('#edita_num_chamado').val(columnValues[0]);
    $("#edita_cliente").val( $('option:contains("'+columnValues[1] +'")').val() );
    $("#edita_tp_atv").val( $('option:contains("'+columnValues[2] +'")').val() );
    $("#edita_atv").val( $('option:contains("'+columnValues[3] +'")').val() );
    //var data =new Date();
    //console.log(data);

    $('#edita_dt_ini').val("2019-12-05T22:02");            
    $('#edita_dt_fim').val(columnValues[5]);
    $("#edita_tp_hr").val( $('option:contains("'+columnValues[6] +'")').val() );
});
$('.modal-footer .btn-primary').click(function () {
    //BOTAO SALVAR
    //SERIALIZO FORMULARIO E ENVIO PRA ROTA DE ALTERAR
    $('form[name="edita_isso"]').submit();
});

$('.modal-footer .btn-danger').click(function () {
    //BOTAO excluir
    //SERIALIZO O FORMULARIO E ENVIO PARA A ROTA DE APAGAR
    $('form[name="edita_isso"]').submit();
});

// FIM ABRINDO MODAL R


//PREEENCENDO SELECTS 
$('#cliente').change( function(e){
        var cliente_id = $(this).val();
        $.ajax({
            type:"GET",
            data:"cliente_id="+ cliente_id,
            url:"/apontamento/baseCadastro",
            async:false
        }).done(function (data) {
            var contratos ="";
            $.each($.parseJSON(data) ,function(chave,valor){
                contratos += '<option value="'+valor.id + '">'+valor.contrato+ '</option>' 

            });
            $('#contrato').html(contratos);
        })
    })



        $('#tipo_atividade').change( function(e){
        var tipo_atividade_id = $(this).val();
        //console.log(tipo_atividade_id);
        $.ajax({
            type:"GET",
            data:"tipo_atividade_id="+ tipo_atividade_id,
            url:"/apontamento/baseCadastro",
            async:false
        }).done(function (data) {
            //console.log($.parseJSON(data));
            var atividades ="";
            $.each($.parseJSON(data) ,function(chave,valor){
                atividades += '<option value="'+valor.id + '">'+valor.nome+ '</option>' 

            });
            $('#atividade').html(atividades);
            })

         })



//FIM PREECHE SELCT