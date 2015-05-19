// TipTip
$("form input[title],a[title],img[title]").each(function(){var b=$(this),a="bottom";b.hasClass("tttop")&&(a="top");b.hasClass("ttbottom")&&(a="bottom");b.hasClass("ttleft")&&(a="left");b.hasClass("ttright")&&(a="right");b.tipTip({defaultPosition:a});$(this).tipTip({maxWidth:"auto",edgeOffset:6,fadeIn:400,fadeOut:400,defaultPosition:a})});

// For Alert Message
$('.alert-message').fadeOut(10000);