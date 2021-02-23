function v() {

    let value = $('#value').val();

    if(value < 0.0006)
        $('#value').removeClass('is-valid').addClass('is-invalid');
    else
        $('#value').removeClass('is-invalid').addClass('is-valid');

    let fee_estimate = $('#fee_estimate').val();
    value = value.replace(',', '.');

    let fee = value * 0.03;
    let fee_blockchain_e = fee_estimate * 224;
    let fee_blockchain = (fee_blockchain_e) * (Math.pow(10, -8));
    let final_value = value - fee - fee_blockchain;
    final_value = (final_value < 0) ? 0 : final_value;

    $('#fee').val(fee.toFixed(8));
    $('#fee_blockchain').val(fee_blockchain.toFixed(8));
    $('#final_value').val(final_value.toFixed(8));
}


$(document).ready(function () {
    $('.value_btc').mask("#.########");
    $('#value').terminadedigitar(function () {
        v();
    }, 100);
    $('#value').blur(function () {
        v();
    });
    $('#wallet').blur(function () {
        v();
        w();
    });
});


function w() {
    var valid = WAValidator.validate($('#wallet').val(), 'bitcoin');
    if ($('#wallet').val() == "") {
        $('#wallet').addClass('is-invalid');
    }
    if ($('#wallet').val() != "")
        if (!valid) {
            $('#wallet').addClass('is-invalid');
            $('#wallet').val("");
        } else {
            $('#wallet').removeClass('is-invalid').addClass('is-valid');
        }
}


function cpfCnpj() {
    let options = {
        onKeyPress : function(cpfcnpj, e, field, options) {
            let masks = ['000.000.000-009', '00.000.000/0000-00'];
            let mask = (cpfcnpj.length > 14) ? masks[1] : masks[0];
            $('.cpfcnpj').mask(mask, options);
        }
    };

    $('.cpfcnpj').mask('000.000.000-009', options);
}