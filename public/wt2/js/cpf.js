jQuery.validator.addMethod("document", function(value, element) {
    value = jQuery.trim(value);

    value = value.replace('.','');
    value = value.replace('.','');
    value = value.replace('/','');
    let doc = value.replace('-','');
    if (doc.length <= 11){
        while(doc.length < 11) doc = "0"+ doc;
        var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
        var a = [];
        var b = new Number;
        var c = 11;
        for (i=0; i<11; i++){
            a[i] = doc.charAt(i);
            if (i < 9) b += (a[i] * --c);
        }
        if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
        b = 0;
        c = 11;
        for (y=0; y<10; y++) b += (a[y] * c--);
        if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

        var retorno = true;
        if ((doc.charAt(9) != a[9]) || (doc.charAt(10) != a[10]) || doc.match(expReg)) retorno = false;

        return this.optional(element) || retorno;
    } else if (doc.length >= 14) {
        // Elimina CNPJs invalidos conhecidos
        if (doc == "00000000000000" || doc == "11111111111111" ||
            doc == "22222222222222" || doc == "33333333333333" ||
            doc == "44444444444444" || doc == "55555555555555" ||
            doc == "66666666666666" || doc == "77777777777777" ||
            doc == "88888888888888" || doc == "99999999999999") {
            return false;
        }

        tamanho = doc.length - 2;
        numeros = doc.substring(0,tamanho);
        digitos = doc.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;

        tamanho = tamanho + 1;
        numeros = doc.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)){
            return false;
        }

        return this.optional(element) || true;
    }


}, "Informe um numero de documento válido");