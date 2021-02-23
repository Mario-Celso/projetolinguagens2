$(document).ready(function () {
    $('.input-zip').terminadedigitar(function () {
        let myClass = document.getElementsByClassName('input-zip');
        for (let i = 0; i < myClass.length; i++) {
            let zip = $('.input-zip').eq(i).val();
            if (zip !== "") {
                $.ajax({
                    cache: false,
                    method: 'get',
                    url: "https://viacep.com.br/ws/" + zip + "/json/",
                    dataType: 'json',
                    success: function (data) {
                        $('.input-zip').eq(i).val(data.cep);
                        $('.input-address').eq(i).val(data.logradouro);
                        $('.input-district').eq(i).val(data.bairro);
                        $('.input-city').eq(i).val(data.localidade);
                        $('.input-state').eq(i).val(data.uf);
                    }
                });
            }
        }



    }, 1000);

});