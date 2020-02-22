let isEnd = false;

let fetchList = function (type, txt) {
    // type : search , fetch
    if (isEnd == true) {
        return;
    }
    let startNo = $(".pinItem").last().data("no") || 0;
    switch (type) {
        case 'search':
            $.ajax({
                url: "modules/post/api/searchList.php?no=" + startNo + "&query=" + txt,
                type: "GET",
                dataType: "json",
                success: function (result) {
                    // 컨트롤러에서 가져온 방명록 리스트는 result.data에 담겨오도록 했다.
                    // 남은 데이터가 n개 이하일 경우 무한 스크롤 종료
                    let length = result.data.length;
                    // console.log(length);
                    if (length < 5) {
                        isEnd = true;
                    }
                    $.each(result.data, function (idx, vo) {
                        renderList(vo);
                    });
                },
                error: function (request, status, error) {
                    console.log("code = " + request.status + "&message = " + request.responseText + "&error = " + error); // 실패 시 처리
                },
                complete: function () {
                    resizeItems();
                }
            });
            break;
        case 'fetch':
            // console.log("startNo : " + startNo);
            $.ajax({
                url: "modules/post/api/fetchList.php?no=" + startNo,
                type: "GET",
                dataType: "json",
                success: function (result) {
                    // 컨트롤러에서 가져온 방명록 리스트는 result.data에 담겨오도록 했다.
                    // 남은 데이터가 n개 이하일 경우 무한 스크롤 종료
                    let length = result.data.length;
                    // console.log(length);
                    if (length < 5) {
                        isEnd = true;
                    }
                    $.each(result.data, function (idx, vo) {
                        renderList(vo);
                    });
                },
                error: function (request, status, error) {
                    console.log("code = " + request.status + "&message = " + request.responseText + "&error = " + error); // 실패 시 처리
                },
                complete: function () {
                    resizeItems();
                    setTimeout(function () {
                        fetchFlag = false;
                    }, 500);
                }
            });
            break;
        case 'bundle':
            $.ajax({
                url: "modules/bundle/api/fetchBundle.php?no=" + startNo + "&query=" + txt,
                type: "GET",
                dataType: "json",
                success: function (result) {
                    // 컨트롤러에서 가져온 방명록 리스트는 result.data에 담겨오도록 했다.
                    // 남은 데이터가 n개 이하일 경우 무한 스크롤 종료
                    let length = result.data.length;
                    // console.log(length);
                    if (length < 5) {
                        isEnd = true;
                    }
                    $.each(result.data, function (idx, vo) {
                        renderList(vo);
                    });
                },
                error: function (request, status, error) {
                    console.log("code = " + request.status + "&message = " + request.responseText + "&error = " + error); // 실패 시 처리
                },
                complete: function () {
                    resizeItems();
                    setTimeout(function () {
                        fetchFlag = false;
                    }, 500);
                }
            });
            break;
        default:
            break;
    }

}

let fetchComments = function (imgid) {
    $("#commentList").empty();

    const fd = new FormData();
    fd.append('imgid', imgid);

    let sessionid = '';
    $.ajax({
        url: 'modules/member/api/getSid.php', // url where upload the image
        type: 'GET',
        success: function (sid) {
            sessionid = sid;
        }, complete: function () {
            $.ajax({
                url: '//pirare.jupiterflow.com/modules/comment/api/fetchComment.php', // url where upload the image
                type: 'POST',
                data: fd,
                dataType: 'json',
                success: function (result) {
                    switch (result.success) {
                        case true:
                            $.each(result.data,function(idx, vo){
                                renderComment(sessionid, vo);
                            });
                            break;
                        case false:
                            // alert(result.error);
                            break;
                        default:
                            break;
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
}

function deleteComment(idx) {
    if(!confirm("정말 삭제하시겠습니까?"))
        return;
    const imgid = $("#pir_img_id").val();
    const datas = new FormData();
    datas.append('commentid', idx);
    $.ajax({
        url: 'modules/comment/api/deleteComment.php', // url where upload the image
        type: 'POST',
        data: datas,
        dataType: 'json',
        success: function (jsonResult) {
            switch (jsonResult.success) {
                case true:
                    alert("댓글을 삭제하였습니다.");
                    fetchComments(imgid);
                    break;
                case false:
                    alert(jsonResult.error);
                    break;
                default:
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
}

function modifyComment(obj) {
    const parentElem = $(obj).parent().parent();
    parentElem.children('#commentEdit').toggle();
    parentElem.children('#commentEdit').val(parentElem.children('#commentMsg').text());
    parentElem.children('#commentMsg').toggle();
    parentElem.children('#commentEditBtn').toggle();
}

function modifySubmit(obj, idx) {
    const parentElem = $(obj).parent();
    const imgid = $("#pir_img_id").val();
    const editComment = parentElem.children('#commentEdit').val();

    const datas = new FormData();
    datas.append('imgid', imgid);
    datas.append('msg', String(editComment));
    datas.append('commentid', idx);

    $.ajax({
        url: 'modules/comment/api/modifyComment.php', // url where upload the image
        type: 'POST',
        data: datas,
        dataType: 'json',
        success: function (jsonResult) {
            switch (jsonResult.success) {
                case true:
                    alert("댓글을 수정하였습니다.");
                    fetchComments(imgid);
                    break;
                case false:
                    alert(jsonResult.error);
                    break;
                default:
                    break;
            }
        },
        complete: function () {
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('ERRORS: ' + textStatus);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

let renderComment = function (sid, vo) {
    const commentItem = document.createElement('div');
    commentItem.className = "commentItem";
    let html = '<ul><li id="commentAuthor">' + vo.comment_owner_nick + '</li><li id="commentRegistered">' + vo.comment_registered + '</li>';

    if (vo.comment_owner_email === sid)
        html += '<li id="commentOption_Delete" onClick="deleteComment(' + vo.comment_id + ')">삭제</li><li id="commentOption_Modify" onClick="modifyComment(this)">수정</li>';

    html += '</ul><input type="text" id="commentEdit"><input onClick="modifySubmit(this,' + vo.comment_id + ')" id="commentEditBtn" type="button" value="수정"><div id="commentMsg">' + vo.comment_msg + '</div>';
    $(commentItem).append(html);

    $("#commentList").append(commentItem);
    $("#commentList").append('<hr class="commentSpliter">');
}
let renderList = function (vo) {
    // 리스트 html을 정의
    // const svg = "<svg value='" + vo.no + "' class='svgFill cl8e8e8e' height='12' width='12' viewBox='0 0 24 24' aria-hidden='true' role='img'><path d='M12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3M3 9c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm18 0c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3z'></path></svg>";
    const svg = "";
    const imgid = $(".pinItem").last().data("no") + 1 || 1;
    const html = "<div onClick='viewPirPopup(" + vo.img_id + ")' data-no=" + imgid + " class='pinItem grid-item'><img data-no=" + vo.img_id + " class='pinImg' src='" + vo.img_thumb_path + "'>" + svg + "</div>";


    $grid.masonry()
        .append($(html))
        .masonry('appended', $(html));
}