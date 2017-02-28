$(function() {

    $('.noJS').hide();
    $('.jsOnly').show();

    // can use encryption
    if ($('#createForm').length > 0) {

        // based loosely on http://stackoverflow.com/a/27612338
        var cryptKey = '',
            randomStringLength = 40,
            checkReadyness;

        checkReadyness = setInterval(function() {
            if (!sjcl.random.isReady(10)) {
                return;
            }

            while (cryptKey.length < randomStringLength) {
                randomInt = sjcl.random.randomWords(1, 10)[0];
                cryptKey += Math.abs(randomInt).toString(36);
            }
            cryptKey = cryptKey.substr(0, randomStringLength);

            window.cryptKey = cryptKey;
            $('#encrypt').prop('disabled', false);
            $('#encryptStatus').hide();

            clearInterval(checkReadyness);
        }, 1);

        $('#createForm').on('submit.encrypt', function() {

            // no further processing
            if (!$('#encrypt').is(':checked')) {
                return true;
            }

            // encrypt using crypt key
            $('#createForm').attr('action', $('#createForm').attr('action') + '#' + window.cryptKey);
            $('#encrypted').val(sjcl.encrypt(window.cryptKey, $('#value').val()));
            $('#value').val('');
            return true;

        });
    }

    // just created: append crypt key
    if ($('#entryURL').length > 0 && window.location.hash.length > 0) {
        $('#entryURL').val($('#entryURL').val() + window.location.hash).focus();
    }

    // decrypt contents
    if ($('#encrypted').length > 0 && window.location.hash.length > 0) {
        $('#entry').val(sjcl.decrypt(window.location.hash.substr(1), $('#encrypted').val()));
    }

    // once-link
    if ($('#onceLink').length > 0 && window.location.hash.length > 0) {
        $('#onceLink').show().attr('href', $('#onceLink').attr('href') + window.location.hash);
    }

});
