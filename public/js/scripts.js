$(document).ready(function() {
    $('#example').DataTable();
} );


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
    var ok = $('#edita_cliente option:selected').text();
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
    //vai pra pagina de salvar
    $('form[name="edita_isso"]').submit();
});
$('.modal-footer .btn-danger').click(function () {
    //BOTAO excluir
    //vai pra pagina de php para upd
    $('form[name="edita_isso"]').submit();
});

