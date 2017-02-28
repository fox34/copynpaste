$(function() {

    $('.noJS').hide();
    $('.jsOnly').show();

    // can use encryption
    if ($('#createForm').length > 0) {

        // based loosely on http://stackoverflow.com/a/27612338
        var randomBase64String = '',
            randomStringLength = 40,
            checkReadyness;

        checkReadyness = setInterval(function() {
            if (!sjcl.random.isReady(10)) {
                return;
            }

            while (randomBase64String.length < randomStringLength) {
                randomInt = sjcl.random.randomWords(1, 10)[0];
                randomBase64String += Math.abs(randomInt).toString(36);
            }
            randomBase64String = randomBase64String.substr(0, randomStringLength);

            window.cryptKey = randomBase64String;
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

/*
function getCaret(ctrl) {
    var CaretPos = 0;
    // IE Support
    if (document.selection) { ctrl.focus ();
        var Sel = document.selection.createRange ();
        Sel.moveStart ('character', -ctrl.value.length);
        CaretPos = Sel.text.length;
        // Firefox support
    } else if (ctrl.selectionStart || ctrl.selectionStart == '0')
        CaretPos = ctrl.selectionStart;
    return (CaretPos);
}

function setCaret(ctrl, pos){
    if(ctrl.setSelectionRange) {
        ctrl.focus();
        ctrl.setSelectionRange(pos,pos);
    } else if (ctrl.createTextRange) {
        var range = ctrl.createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }
}

document.onkeypress = function(e) {
    // ctrl+s
    if (e.ctrlKey && e.charCode == 115) {
        e.preventDefault();
        localStorage.setItem('noechoCnpCaret<?=htmlspecialchars($id)?>', getCaret(document.getElementById('value')));
        localStorage.setItem('noechoCnpScrollTop<?=htmlspecialchars($id)?>', document.getElementById('value').scrollTop);
        localStorage.setItem('noechoCnpScrollLeft<?=htmlspecialchars($id)?>', document.getElementById('value').scrollLeft);
        document.getElementById('submit').click();
    }
};

tabOverride.tabSize(4);
tabOverride.set(document.getElementById('value'));
if (localStorage.getItem('noechoCnpCaret<?=htmlspecialchars($id)?>')) {
    setCaret(document.getElementById('value'), localStorage.getItem('noechoCnpCaret<?=htmlspecialchars($id)?>'));
}
if (localStorage.getItem('noechoCnpScrollTop<?=htmlspecialchars($id)?>')) {
    document.getElementById('value').scrollTop = localStorage.getItem('noechoCnpScrollTop<?=htmlspecialchars($id)?>');
}
if (localStorage.getItem('noechoCnpScrollLeft<?=htmlspecialchars($id)?>')) {
    document.getElementById('value').scrollLeft = localStorage.getItem('noechoCnpScrollLeft<?=htmlspecialchars($id)?>');
}
*/
