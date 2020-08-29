var idorder = 0;
    Conekta.setPublicKey("key_KRNM8gTJdgrXuzcXsteJw9w");    

    var conektaSuccessResponse = function (token){
        document.getElementById('conektaTokenId').value = token.id;
        idorder = token.id;

        if($('#year').val() <= 19){
            alert('La tarjeta ya expiro');
        }else{
            jsPay();
        }
    }

    var conektaErrorResponseHandler = function (response){
        var form = document.getElementById('card-form');
        alert(response.message_to_purchaser);
    }

    $(document).ready(function(){
        $('#card-form').submit(function(event){
            event.preventDefault();
            var form = $('#card-form');
            Conekta.Token.create(form,conektaSuccessResponse,conektaErrorResponseHandler)
        })
    })

    function jsPay(){
        let iconSuccess = "<svg width='6em' height='6em' viewBox='0 0 16 16' class='bi bi-check-square' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/><path fill-rule='evenodd' d='M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z'/></svg>"
        let iconError = "<svg width='6em' height='6em' viewBox='0 0 16 16' class='bi bi-info-circle-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>"
        let params = $('#card-form').serialize();
        let url="../controllers/pay.php";
        $.post(url,params,function(data){
            $('#modal-success').modal('show')

            if( data.response == "1"){

                $("#icon-message").html( iconSuccess );
                $("#message").html("El pago y la cita se realizaron satisfactoriamente, redireccionando...");
                setTimeout(() => {
                    $('#modal-success').modal('hide')
                    target = '_blank';
                    window.location.href=`../../citasmedicas/reportes/imprimir_cita.php?id_alu=${data.id}`
                }, 3000);
            }else{
                $("#icon-message").html( iconError );
                $("#message").html(`<span class='text-danger'>${data.response}</span>, vuelve a intentarlo en otro momento.`);
                setTimeout(() => $('#modal-success').modal('hide'), 5000);
            }
        })
    }

    function jsClean(){
        $('.form-control').prop("value","");
        $('#conektaTokenId').prop("value","")
    }
