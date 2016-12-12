//var talks = $('section#talks  article');
//
//$(talks).each(function(i) {
//    $(this).addClass('talk-' + i);
//    $(this).find('h3').prepend(i + '. ');
//});


var talksSorted = null;

var sortTalks = function() {
    console.log('SORTING');
    talksSorted = $('section#talks  article');
    talksSorted.sort(function(a, b) {
        return parseFloat($(a).offset().top) - parseFloat($(b).offset().top);
    });

    $(talksSorted).each(function(i, el) {
        $(this).find('h3').prepend(i + '. ');
        console.log(talks[i]);
        talk = talks[i];
      $(talk).animate({left:$(el).offset().left}); 
      $(el).animate({right:$(talk).offset().left});
        //$(talk).insertBefore($(el));
    });
};
//sortTalks();



//$(window).resize(sortTalks);


