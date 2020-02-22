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
    const type = getUrlVars()['type'] === 'send' ? 'send' : 'recv';
    const recvMenu = $("#message-top-txt a:nth-child(1)");
    const sendMenu = $("#message-top-txt a:nth-child(2)");

    if (type === 'send') {
        $("th:nth-child(2)").text('받은사람');
        recvMenu.addClass("unselectedMailBox");
        sendMenu.addClass("selectedMailBox");
    } else if (type === 'recv') {
        $("th:nth-child(2)").text('보낸사람');
        recvMenu.addClass("selectedMailBox");
        sendMenu.addClass("unselectedMailBox");
    }
    fetchList(type);

    $("thead tr th:nth-child(1) input[type=checkbox]").on('click', function () {
        const chk = $(this).is(":checked");//.attr('checked');
        $("tbody td input[type=checkbox]").prop('checked', chk);
    });


    $("#messageDeleteBtn").on('click', function () {
        if(!confirm("정말 삭제하시겠습니까?"))
            return false;
        const checkBoxes = $(".form table tbody td:nth-child(1) input[type=checkbox]");
        $.each(checkBoxes, function (idx, vo) {
            const currentCheckBox = $(vo);
            if (currentCheckBox.is(':checked')) {
                $.ajax({
                    url: '//pirare.jupiterflow.com/modules/message/api/deleteMessage.php?type=' + type + '&no=' + currentCheckBox.data('no'),
                    type: 'GET',
                    dataType: 'json',
                    success: function (result) {
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('ERRORS: ' + textStatus);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
    });
});

let fetchList = function (type) {
    $.ajax({
        url: '//pirare.jupiterflow.com/modules/message/api/fetchList.php?type=' + type,
        type: 'GET',
        dataType: 'json',
        success: function (result) {
            $.each(result.data, function (idx, vo) {
                renderMessageList(vo);
            });

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('ERRORS: ' + textStatus);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

let renderMessageList = function (vo) {
    const type = getUrlVars()['type'] === 'send' ? 'send' : 'recv';
    const messageListBody = $(".form table tbody");
    const tr = document.createElement('tr');
    $(tr).append('<td><input type="checkbox" data-no="' + vo.message_no + '"></td>');
    $(tr).append('<td><span>' + vo.message_target_nick + '</span></td>');
    $(tr).append('<td><span>' + vo.message_subject + '</span></td>');
    let dateTime = new Date(Date.parse(vo.message_registered));
    const timeString = convertTimeString(dateTime);
    $(tr).append('<td><span>' + timeString + '</span></td>');

    $(tr).on('click',function(e){
        if(e.target.tagName !== "INPUT"){
            location.href = './view.php?type=' + type + '&no=' + vo.message_no;
        }
    });

    messageListBody.append(tr);

}

let convertTimeString = function (d) {
    const s =
        leadingZeros(d.getFullYear(), 4) + '-' +
        leadingZeros(d.getMonth() + 1, 2) + '-' +
        leadingZeros(d.getDate(), 2) + ' ' +

        leadingZeros(d.getHours(), 2) + ':' +
        leadingZeros(d.getMinutes(), 2);

    return s;
}

function leadingZeros(n, digits) {
    let zero = '';
    n = n.toString();

    if (n.length < digits) {
        for (let i = 0; i < digits - n.length; i++)
            zero += '0';
    }
    return zero + n;
}