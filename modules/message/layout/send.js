let memberNickArr = [];
let memberNoArr = [];

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

    const messageReceiver = $("#message_receiver");
    const messageSubject = $("#message_subject");
    const messageBody = $("#message_body");

    const PirScreenFilter = $("#message-view #screenFilter");
    const messageMemberList = $("#message-member-list");
    const tbody = $("#message-member-list table tbody");

    const reply = getUrlVars()['reply'];
    if (reply) {
        messageReceiver.val(decodeURI(reply));
        $("#message-top-txt a").text('쪽지 답장');
        messageReceiver.css('width', '100%');
        $("#messageSearchBtn").css('display', 'none');
    }
    $("#messageSearchBtn").on('click', function () {
        $('body').addClass('layer-popup');

        tbody.empty();
        PirScreenFilter.show();
        $.ajax({
            url: '//pirare.jupiterflow.com/modules/member/api/getMemberList.php',
            type: 'GET',
            dataType: 'json',
            success: function (result) {
                console.log(result);
                $.each(result.data, function (idx, vo) {
                    renderMessageList(vo);
                });
            },
            complete: function () {
                messageMemberList.show();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('ERRORS: ' + textStatus);
            },
            cache: false,
            contentType: false,
            processData: false
        });

    });
    $("th input[type=checkbox]").on('click', function () {
        const chk = $(this).is(":checked");//.attr('checked');
        $("tbody td input[type=checkbox]").prop('checked', chk);
    });
    const memberSubmit = $("#message-member-submit");
    memberSubmit.on('click', function () {
        const checkBoxes = $("#message-member-list table tbody td:nth-child(1) input[type=checkbox]");
        memberNickArr = [];
        memberNoArr = [];
        $.each(checkBoxes, function (idx, vo) {
            const currentCheckBox = $(vo);
            if (currentCheckBox.is(':checked')) {
                const currentMemberNo = currentCheckBox.data('no');
                const currentMemberNick = currentCheckBox.parent().parent().children("td:nth-child(2)").children('span').text();
                memberNickArr.push(currentMemberNick);
                memberNoArr.push(currentMemberNo);
            }
        });
        messageReceiver.val(memberNickArr.join(','));

        $('body').removeClass('layer-popup');
        PirScreenFilter.hide();
        messageMemberList.hide();
    });
    PirScreenFilter.on('click', function () {
        $('body').removeClass('layer-popup');
        PirScreenFilter.hide();
        messageMemberList.hide();
    });


    const messageSendBtn = $("#messageSendBtn");
    messageSendBtn.on('click', function () {
        if (messageReceiver.val().length === 0) {
            alert("받는 사람을 선택해주세요.");
            messageReceiver.trigger('focus');
            return false;
        }
        if (messageSubject.val().length === 0) {
            alert("제목을 입력해주세요.");
            messageSubject.trigger('focus');
            return false;
        }
        if (messageBody.val().length === 0) {
            alert("내용을 입력해주세요.");
            messageBody.trigger('focus');
            return false;
        }
        const datas = new FormData();
        datas.append('receiver', String(messageReceiver.val()));
        datas.append('subject', String(messageSubject.val()));
        datas.append('body', String(messageBody.val()));

        $.ajax({
            url: '//pirare.jupiterflow.com/modules/message/api/sendMessage.php', // url where upload the image
            type: 'POST',
            data: datas,
            dataType: 'json',
            success: function (result) {
                switch (result.success) {
                    case true:
                        location.href = "./list.php?type=recv";
                        break;
                    case false:
                        alert(result.error);
                        break;
                    default:
                        break;
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


});

let renderMessageList = function (vo) {
    const messageListBody = $("#message-member-list table tbody");
    const tr = document.createElement('tr');

    let checkboxHTML = '';
    if (memberNickArr.includes(vo.member_nickname)) {
        checkboxHTML = '<input type="checkbox" checked data-no="' + vo.member_no + '">';
    } else {
        checkboxHTML = '<input type="checkbox" data-no="' + vo.member_no + '">';
    }
    $(tr).append('<td>' + checkboxHTML + '</td>');
    $(tr).append('<td><span>' + vo.member_nickname + '</span></td>');

    messageListBody.append(tr);
}