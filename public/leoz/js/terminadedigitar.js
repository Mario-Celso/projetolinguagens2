jQuery.fn.extend({
    terminadedigitar: function (callback, timeout) {
        timeout = timeout || 1e3;
        var timeoutReference,
            doneTyping = function (el) {
                if (!timeoutReference) return;
                timeoutReference = null;
                callback.call(el);
            };
        return this.each(function (i, el) {
            var $el = $(el);
            $el.is(':input') && $el.keyup(function () {
                if (timeoutReference) clearTimeout(timeoutReference);
                timeoutReference = setTimeout(function () {
                    doneTyping(el);
                }, timeout);
            }).blur(function () {
                doneTyping(el);
            });
        });
    }
});