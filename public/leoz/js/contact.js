$(document).ready(function () {
    let myClass = document.getElementsByClassName('input-contact');
    let contactText = document.getElementsByClassName('contact');

    for (let i = 0; i < myClass.length; i++) {
        let contact = $('.input-contact').eq(i).val();
        if (contact !== 1) {
            let $text = $('.contact').eq(i);
            $text.mask('(00)00000-0000')
        }


    }
});