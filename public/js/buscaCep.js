
$(function() {
    $("#UsuarioCep").blur(function () {
    var cep = $(this).val();    
    $.ajax({
            contentType: "application/json",
            crossDomain: true,
            dataType: 'jsonp',
            data: cep, 
            url: 'http://correiosapi.apphb.com/cep/'+cep,
            statusCode: {
            200: function(data) {
                console.log(data);
            } // Ok
            , 400: function(msg) {
                console.log(msg);
            } // Bad Request
            , 404: function(msg) {
                 console.log("CEP não encontrado!!");
            } // Not Found
        }
    }).done(function(endereco) {
        $("#UsuarioUf").val(endereco.estado);
        $("#UsuarioCidade").val(endereco.cidade);
        $("#UsuarioEndereco").val(endereco.tipoDeLogradouro + " " + endereco.logradouro);
        $("#UsuarioBairro").val(endereco.bairro);
        })
    })
});