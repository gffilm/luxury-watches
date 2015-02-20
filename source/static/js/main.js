// Full list of configuration options available here:
// https://github.com/hakimel/reveal.js#configuration

$(function () {

    // Wufoo
    var Wufoo = (function () {

        // class vars
        var pub = {};

        /********************************************************
         * submit:void
         *
         * Submit form to wufoo
         ********************************************************
        /                                                      */
        pub.submit = function(form) {

            var $form = $(form),
                url  = $form.attr('action') + '?hash=' + $form.data('wufooFormId'),
                data = $form.serialize();

            $.ajax({
                url        : url,
                type       : 'POST',
                data       : data,
                dataType   : 'xml',
                beforeSend : _before($form)
            }).done(function(resp) {
                switch($(resp).find('Success').text()) {
                    case '1':  // Success
                        _yeah($form, $(resp));
                        break;
                    case '0':  // Error(s)
                        _oops($form, $(resp));
                        break;
                }
            }).fail(function(resp) {
                _ef($(resp));
            });
        };

        /********************************************************
         * reset:void
         *
         * Resets the form back to init state
         ********************************************************
        /                                                      */
        pub.reset = function(form) {
            var $form = $(form);

            $form.removeClass('success');
            $form.find('.error').removeClass('error');
            $form.find('input[type=text], textarea').val('');
        }

        /********************************************************
         * _before:void
         *
         * Before form is sumbitted
         ********************************************************
        /                                                      */
        function _before($form) {
            $form.find('.error').removeClass('error');
        }

        /********************************************************
         * yeah:void
         *
         * If submit is a success
         ********************************************************
        /                                                      */
        function _yeah($form, $xml) {
            $form.parent().addClass('success');
        };

        /********************************************************
         * oops:void
         *
         * If there were validation errors
         ********************************************************
        /                                                      */
        function _oops($form, $xml) {
            $xml.find('FieldError').each(function() {
              $form.find('#' + $(this).find('ID').text()).addClass('error');
            });
        };

        /********************************************************
         * ef:void
         *
         * If there was a failure to submit form
         ********************************************************
        /                                                      */
        function _ef($xml) {
            //console.log($xml);
        };

        return pub;
    }());
});