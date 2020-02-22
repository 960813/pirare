function resizeItems(){
// layout Masonry after each image loads
    $grid.imagesLoaded().progress( function() {
        $grid.masonry();
    });
    $grid.masonry('reloadItems');

}

$(window).on("resize", resizeItems);
