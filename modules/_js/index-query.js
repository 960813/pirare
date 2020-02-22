let searchType = 'fetch;'
let searchQuery = '';
let fetchFlag = false;
// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
$(window).on("load", function () {
    searchType = getUrlVars()["type"];
    searchQuery = getUrlVars()["query"];
    const no = getUrlVars()["no"];
    if(no)
        viewPirPopup(no);

    if (searchType != 'search' && searchType != 'bundle')
        searchType = 'fetch';
    fetchList(searchType, searchQuery);


});
$(window).on("scroll", function () {
    let $window = $(this);
    let scrollTop = $window.scrollTop();
    let windowHeight = $window.height();
    let documentHeight = $(document).height();

    // console.log("documentHeight:" + documentHeight + " | scrollTop:" + scrollTop + " | windowHeight: " + windowHeight );

    // scrollbar의 thumb가 바닥 전 30px까지 도달 하면 리스트를 가져온다.
    if (scrollTop + windowHeight + 30 > documentHeight) {
        if (fetchFlag == false) {
            searchType = getUrlVars()["type"];
            searchQuery = getUrlVars()["query"];
            if(searchType!='search')
                searchType = 'fetch';
            fetchList(searchType,searchQuery);
        }
        fetchFlag = true;
    }
});