function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(window).on('load', function () {
    const message_target = $("#message_target");
    const message_registered = $("#message_registered");
    const message_subject = $("#message_subject");
    const message_body = $("#message_body");

    const type = getUrlVars()['type'] === 'send' ? 'send' : 'recv';

    if (type === 'send') {
        $("#message-top-txt > a").text('보낸 쪽지');
        $("label[for=message_target]").text("받은 사람");
    } else if (type === 'recv') {
        $("#message-top-txt > a").text('받은 쪽지');
        $("label[for=message_target]").text("보낸 사람");
    }
    $.ajax({
        url: '//pirare.jupiterflow.com/modules/message/api/fetchMessage.php?type=' + type + '&no=' + getUrlVars()['no'],
        type: 'GET',
        dataType: 'json',
        success: function (result) {
            console.log(result);
            switch (result.success) {
                case true:
                    message_target.val(result.message_target_nick);
                    message_registered.val(result.message_registered);
                    message_subject.val(result.message_subject);
                    message_body.val(result.message_body);
                    $("#message-top-ref:nth-child(2)").on('click',function(){ // 답장
                        location.href = './send.php?reply=' + result.message_target_nick;
                    });
                    break;
                case false:
                    alert(result.error);
                    location.href = './list.php?type=' + type;
                    break;
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('ERRORS: ' + textStatus);
        },
        cache: false,
        contentType: false,
        processData: false
    });

    $("#message-top-ref:nth-child(3)").on('click',function(){ // 목록
        location.href = './list.php?type=' + type;
    });

});