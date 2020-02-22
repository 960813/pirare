function viewPirPopup(imgid) {
    const viewPirPopup = $("#addPirWrap #viewPirPopup");
    const PirScreenFilter = $("#addPirWrap #screenFilter");

    const viewAuthor = $(viewPirPopup).children("#viewPirPopupContent").children("#viewAuthor");
    const viewImg = $(viewPirPopup).children("#viewPirPopupContent").children("#popupLeftContent").children("#viewImg");
    const viewMsg = $(viewPirPopup).children("#viewPirPopupContent").children("#popupRightContent").children("#viewMsg");
    const viewTag = $(viewPirPopup).children("#viewPirPopupContent").children("#popupRightContent").children("#viewTag");
    const viewBundle = $(viewPirPopup).children("#viewPirPopupContent").children("#popupRightContent").children("#viewBundle");

    const commentList = $("#commentList");
    commentList.empty();

    $("#viewComment input[type=text]").val('');
    $('#pir_img_id').val(imgid);

    viewMsg.css('height', '150px');

    PirScreenFilter.show();
    $.ajax({
        url: 'modules/post/api/fetchPir.php', // url where upload the image
        type: 'GET',
        data: {id: imgid},
        dataType: 'json',
        success: function (data) {
            const img_msg = data['img_msg'];
            const img_owner_email = data['img_owner_email'];
            const img_owner_no = data['img_owner_no'];
            const img_owner_nick = data['img_owner_nick'];
            const img_path = data['img_path'];
            const img_registered = data['img_registered'];
            const img_tag_id = data['img_tag_id']; // Array
            const img_tag_name = data['img_tag_name'].join(','); // Array
            const img_bundle_id = data['img_bundle_id'];
            const img_bundle_txt = data['img_bundle_txt'];

            viewAuthor.empty();
            viewImg.attr('src', '');

            viewMsg.prop('readonly', true);
            viewMsg.val('');

            viewTag.prop('readonly', true);
            viewTag.val('');

            viewBundle.prop('disabled', true);
            viewBundle.empty();
            viewBundle.append('<option value="" selected></option><option value="addBundle">번들 등록</option>');
            viewBundle.on('change', function (e) {
                const bundletxt = $(this).val();
                // console.log("bundletxt : " + bundletxt);
                switch (bundletxt) {
                    case 'addBundle': // 번들 등록
                        // bundle 추가 팝업 띄우기
                        const bundleinput = prompt("추가할 번들을 입력해주세요.");
                        if (bundleinput) {
                            const option = "<option value='" + bundleinput + "'>" + bundleinput + "</option>";
                            $(this).append(option);
                            $(this).children('option').last().attr("selected", "selected");
                        }
                        break;
                    case 'noneBundle': // 번들 선택 안함
                        break;
                    default: // 그 외 번들 선택
                        break;
                }
            });
            const pirAuthor = document.createElement('div');
            pirAuthor.id = "pirAuthor";
            $(pirAuthor).text(img_owner_nick);

            const pirRegistered = document.createElement('div');
            pirRegistered.id = "pirRegistered";
            $(pirRegistered).text(img_registered);

            const pirControlMenu = "<svg class='svgFill cl8e8e8e' height='22' width='22' viewBox='0 0 24 24'><path d=\"M12 9c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3M3 9c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm18 0c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3z\"></path></svg>";
            let pirScrollMenu = '<div class="pirScrollMenu"><div class="scrollMenu_item"><span>게시글 공유</span></div><hr class="HeaderLine"><div class="scrollMenu_item"><span>이미지 다운로드</span></div>';


            $.ajax({
                url: 'modules/member/api/getSid.php', // url where upload the image
                type: 'GET',
                success: function (sid) {
                    if (sid) {
                        $("#viewComment > input[type=text]").css('display', 'block');
                        $("#viewComment > input[type=button]").css('display', 'block');
                        $("#viewComment > input[type=text]").prop('disabled', false);
                        $("#viewComment > input[type=button]").prop('disabled', false);
                    } else {
                        $("#viewComment > input[type=text]").css('display', 'none');
                        $("#viewComment > input[type=button]").css('display', 'none');
                        $("#viewComment > input[type=text]").prop('disabled', true);
                        $("#viewComment > input[type=button]").prop('disabled', true);
                    }

                    if (img_owner_email === sid)
                        pirScrollMenu += '<hr class="HeaderLine"><div class="scrollMenu_item"><span>수정</span><hr class="HeaderLine"></div><div class="scrollMenu_item"><span>삭제</span></div></div>';
                    else
                        pirScrollMenu += '</div>';
                },
                complete: function () {
                    viewAuthor.append(pirAuthor);
                    viewAuthor.append(pirRegistered);
                    viewAuthor.append(pirControlMenu);
                    viewAuthor.append(pirScrollMenu);

                    const pirScrollMenuElement = $(".pirScrollMenu");
                    $(viewAuthor).children('svg').on('click', function () {
                        pirScrollMenuElement.fadeToggle(200);
                    });
                    const shareSpan = pirScrollMenuElement.children('.scrollMenu_item:nth-of-type(1)').children('span');
                    const downloadSpan = pirScrollMenuElement.children('.scrollMenu_item:nth-of-type(2)').children('span');
                    const modifySpan = pirScrollMenuElement.children('.scrollMenu_item:nth-of-type(3)').children('span');
                    const deleteSpan = pirScrollMenuElement.children('.scrollMenu_item:nth-of-type(4)').children('span');

                    shareSpan.on('click', function () {
                        const tempElem = document.createElement('input');
                        tempElem.value = 'https://pirare.jupiterflow.com/?no=' + imgid
                        this.appendChild(tempElem);

                        tempElem.select();
                        document.execCommand("copy");
                        this.removeChild(tempElem);
                        alert("게시글 주소가 복사되었습니다.");
                        $(this).parent().parent().fadeToggle(200);
                    });
                    downloadSpan.on('click', function () {
                        location.href = '//pirare.jupiterflow.com/modules/post/api/downloadPir.php?id=' + imgid;
                        $(this).parent().parent().fadeToggle(200);
                    });

                    modifySpan.on('click', function () {
                        if ($('.modifySubmitBtn').length)
                            return;

                        const popupContent = $('#viewPirPopupContent');

                        viewMsg.prop('readonly', false);
                        viewTag.prop('readonly', false);
                        viewBundle.prop('disabled', false);
                        viewMsg.trigger('focus');

                        const modifyBtn = document.createElement('input');
                        modifyBtn.type = 'button';
                        modifyBtn.className = 'modifySubmitBtn';
                        modifyBtn.value = '수정';

                        $(modifyBtn).on('click', function () {
                            let datas = new FormData();
                            datas.append('id', imgid);
                            datas.append('msg', String(viewMsg.val()));
                            datas.append('tag', String(viewTag.val()));
                            datas.append('bundle',String(viewBundle.val()));

                            $.ajax({
                                url: 'modules/post/api/modifyPir.php', // url where upload the image
                                type: 'POST',
                                data: datas,
                                dataType: 'json',
                                success: function (jsonResult) {
                                    switch (jsonResult.success) {
                                        case true:
                                            alert("게시글을 수정하였습니다.");
                                            location.reload();
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
                        });

                        $("#viewBundle").after(modifyBtn);
                        pirScrollMenuElement.fadeToggle(200);
                        popupContent.scrollTop($(viewMsg).position().top - $(viewMsg).height());
                    });

                    deleteSpan.on('click', function () {
                        const confirmFlag = confirm("정말 삭제하시겠습니까?");
                        if (confirmFlag) {
                            // deletePir ajax 호출
                            $.ajax({
                                url: "modules/post/api/deletePir.php?no=" + imgid,
                                type: "GET",
                                dataType: "json",
                                success: function (result) {
                                    switch (result.success) {
                                        case true:
                                            alert("게시글을 삭제하였습니다.");
                                            location.reload();
                                            break;
                                        case false:
                                            alert(result.error);
                                            break;
                                        default:
                                            break;
                                    }
                                },
                                error: function (request, status, error) {
                                    console.log("code = " + request.status + "&message = " + request.responseText + "&error = " + error); // 실패 시 처리
                                }
                            });
                        }
                    });

                    viewImg.attr('src', img_path);
                    viewMsg.val(img_msg);
                    viewTag.val(img_tag_name);

                    $.ajax({
                        url: "modules/bundle/api/getBundleItems.php",
                        type: "GET",
                        dataType: "json",
                        success: function (result) {
                            switch (result.success) {
                                case true:
                                    $.each(result.data, function (idx, vo) {
                                        const optionElem = document.createElement('option');
                                        optionElem.value = vo['bundle_txt'];
                                        if (vo['bundle_id'] === img_bundle_id)
                                            optionElem.selected = true;
                                        optionElem.innerHTML = vo['bundle_txt'];
                                        viewBundle.append(optionElem);
                                    });
                                    break;
                                case false:
                                    alert(result.error);
                                    break;
                                default:
                                    break;
                            }
                        },
                        error: function (request, status, error) {
                            console.log("code = " + request.status + "&message = " + request.responseText + "&error = " + error); // 실패 시 처리
                        }
                    });

                    fetchComments(imgid);

                    $('body').addClass('layer-popup');
                    viewPirPopup.show();


                }
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('ERRORS: ' + textStatus);
        },
        cache: false,
        contentType: false
    });

}