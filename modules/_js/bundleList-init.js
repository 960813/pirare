let isEnd = false;
let fetchBundleList = function (type, txt) {
    if (isEnd == true) {
        return;
    }
    let startNo = $(".pinItem").last().data("no") || 0;
    $.ajax({
        url: "//pirare.jupiterflow.com/modules/bundle/api/fetchList.php?no=" + startNo,
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
};

let bundleView = function(bundle_id){
    location.href = '//pirare.jupiterflow.com/?type=bundle&query=' + bundle_id;
}
let renderList = function (vo) {
    const title = '<div class="bundle_txt"><' + vo.bundle_txt + '></div>';
    const bundleid = $(".pinItem").last().data("no") + 1 || 1;
    const html = "<div onclick=\"bundleView('" + vo.bundle_txt + "')\" data-no=" + bundleid + " class='pinItem grid-item'><img data-no=" + vo.bundle_id + " class='pinImg' src='" + vo.bundle_thumb_path + "'>" + title + "</div>";


    $grid.masonry()
        .append($(html))
        .masonry('appended', $(html));
};
let $grid;

let uploadFlag = false;

// 소스 내용 자체는 참 쉽다.
let fd = new FormData();


// 일단 FormData를 local변수로 하나 생성하고
function handleFileUpload(files) {
    fd = new FormData(); // FormData를 초기화 하는 이유는 드랍시마다 초기화 하려고..
    // 그리드도 초기화
    // $("#theGrid01").jqGrid("clearGridData", true).trigger("reloadGrid");

    // fd에 파일을 추가한다.
    fd.append('pir_image', files[0]);

    // 파일 사이즈를 구해서
    let sizeStr = "";
    let sizeKB = files[0].size / 1024;
    if (Number(sizeKB) > 1024) {
        let sizeMB = sizeKB / 1024;
        sizeStr = sizeMB.toFixed(2) + " MB";
    } else {
        sizeStr = sizeKB.toFixed(2) + " KB";
    }
    // alert(files[0].type);
    if (/^image/.test(files[0].type)) {

        var reader = new FileReader();

        reader.readAsDataURL(files[0]);


        reader.onloadend = function () {
            $('#imgSection').css("background-image", "url(" + this.result + ")");
            $('#imgSection').css("background-size", "320px 320px");
            $("#uploadCloud").hide();
            uploadFlag = true;
        };

    } else {
        return -1;
    }

    var parameters = {
        // 초기 데이터를 넣고
        initdata: {"FILE_NAME": files[0].name, "FILE_SIZE": sizeStr},
        position: "last",
        useDefValues: false,
        useFormatter: false,
        addRowParams: {
            extraparam: {},
            keys: true
        }
    };
    console.log(parameters);

}

$(window).on("load", function () {

// external _js: masonry.pkgd._js, imagesloaded.pkgd._js

// init Masonry
    $grid = $('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer',
        // gutter: 20
    });

    const addPirButton = $(".addPirButton");


    const PirScreenFilter = $("#addPirWrap #screenFilter");
    const addPirPopup = $("#addPirWrap #addPirPopup");

    addPirButton.on('click', function () {
        $("#inputSection button").prop('disabled',false);
        $("#bundletxt").empty();
        $("#bundletxt").append('<option value="noneBundle" selected></option><option value="addBundle">번들 등록</option>');

        $('body').addClass('layer-popup');
        $.ajax({
            url: '//pirare.jupiterflow.com/modules/bundle/api/getBundleItems.php',
            type: 'GET',
            dataType: 'json',
            success: function (result) {
                // console.log(result);
                $.each(result.data, function (idx, vo) {
                    let bundle_txt = vo.bundle_txt;
                    const option = "<option value='" + bundle_txt + "'>" + bundle_txt + "</option>";
                    // console.log(option);
                    $("#bundletxt").append(option);
                });
                PirScreenFilter.show();
                addPirPopup.show();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('ERRORS: ' + textStatus);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    PirScreenFilter.on('click', function () {
        $('body').removeClass('layer-popup');


        $(".modifySubmitBtn").remove();

        PirScreenFilter.hide();
        addPirPopup.hide();
    });

    $("#pirFileUpload").on('change', function (e) {
        const uploadFlag = handleFileUpload(e.target.files);
        if (uploadFlag === -1) {
            alert("지원하지 않는 파일 형식입니다.");
        } else {
            uploadCloud.hide();
        }
        uploadCloud.hide();
    });


    $("#bundletxt").on('change', function (e) {
        const bundletxt = $(this).val();
        // console.log("bundletxt : " + bundletxt);
        switch (bundletxt) {
            case 'addBundle': // 번들 등록
                // bundle 추가 팝업 띄우기
                const bundleinput = prompt("추가할 번들을 입력해주세요.");
                if (bundleinput) {
                    const option = "<option value='" + bundleinput + "'>" + bundleinput + "</option>";
                    $("#bundletxt").append(option);
                    $("#bundletxt > option").last().attr("selected", "selected");
                }
                break;
            case 'noneBundle': // 번들 선택 안함
                break;
            default: // 그 외 번들 선택
                break;
        }
    });

    $("#tagtxt").on('propertychange change keyup paste input', function () {
        $(this).val($(this).val().replace(' ', '').replace('&', '').replace('?', ''));
    });

    $("#inputSection button").on('click', function (e) {
        // e.preventDefault();

        const msg = $('#inputSection textarea').val();
        const tag = $('#tagtxt').val();
        let bundle = '';

        if ($('#bundletxt').val() !== 'addBundle' && $('#bundletxt').val() !== 'noneBundle')
            bundle = $('#bundletxt').children("option:selected").text();

        if (!fd.get('pir_image')) {
            alert("이미지를 등록해주세요.");
            return -1;
        } else if (!msg) {
            alert("설명 메시지를 입력해주세요.");
            return -1;
        }

        $("#inputSection button").prop('disabled',true);
        fd.append('msg', msg);
        fd.append('tag', tag);
        fd.append('bundle', bundle);


        $.ajax({
            url: '//pirare.jupiterflow.com/modules/post/api/writePir.php', // url where upload the image
            type: 'POST',
            data: fd,
            dataType: 'json',
            mimeType: 'multipart/form-data',
            xhr: function () { //XMLHttpRequest 재정의 가능
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    let percent = e.loaded * 100 / e.total;
                    $("#inputSection button").html(String(percent.toFixed(2)) + "%");
                    console.log(String(percent.toFixed(2)) + "%");
                });

                return xhr;
            },
            success: function (data) {
                console.log(data);
                location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    const uploadCloud = $("#uploadCloud");

    const imgSection = $("#imgSection");
    uploadCloud.on('dragleave', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('background-color', 'transparent');
        // console.log('dragleave');
    });
    uploadCloud.on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('background-color', 'rgba(222,222,222,0.6)');
        // console.log('dragover');
    });
    uploadCloud.on('drop', function (e) {
        e.preventDefault();
        $(this).css('background-color', 'transparent');
        let files = e.originalEvent.dataTransfer.files;
        // console.log('drop');
        const uploadFlag = handleFileUpload(files);
        if (uploadFlag === -1) {
            alert("지원하지 않는 파일 형식입니다.");
        }
    });


    uploadCloud.on('click', function (e) {
        // console.log("uploadColoud click");
        $("#pirFileUpload").trigger('click');
    });
    uploadCloud.on('mouseenter', function () {
        $(this).css('background-color', 'rgba(222,222,222,0.6)');
        // console.log('uploadCloud mouseenter');
        if (uploadFlag)
            uploadCloud.show();
    });
    uploadCloud.on('mouseleave', function (e) {
        $(this).css('background-color', 'transparent');
        // console.log('uploadCloud mouseleave');
        if (uploadFlag)
            uploadCloud.hide();
    });

    imgSection.on('click', function (e) {
        // console.log("imgSection click");
        $("#pirFileUpload").trigger('click');
    });
    imgSection.on('mouseenter', function () {
        // console.log('imgSection mouseenter');
        if (uploadFlag)
            uploadCloud.show();
    });
    imgSection.on('mouseleave', function () {
        // console.log("imgSection mouseleave");
        if (uploadFlag)
            uploadCloud.hide();
    });
    imgSection.on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        uploadCloud.show();
    });

    fetchBundleList();
});
$(window).on("scroll", function () {
    let $window = $(this);
    let scrollTop = $window.scrollTop();
    let windowHeight = $window.height();
    let documentHeight = $(document).height();

    // scrollbar의 thumb가 바닥 전 30px까지 도달 하면 리스트를 가져온다.
    if (scrollTop + windowHeight + 30 > documentHeight) {
        fetchBundleList();
    }
});