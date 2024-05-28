const selecti = document.querySelector('#disponivel');

$(document).ready(function(){
    $('#agendamento, input[name="Sala"]').change(function(){
        let data = $('#agendamento').val();
        let sala = $('input[name="Sala"]:checked').val();

        console.log('passou aqui')
        console.log(data, sala)
        $.ajax({
            url: './script/verifica_horario.php',
            type: 'post',
            data: {date: data, sala: sala},
        }).done(function(resposta){
            selecti.innerHTML = resposta;
        });
    });
});