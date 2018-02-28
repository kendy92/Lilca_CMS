
$(function(){
	$( ".datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd'
	}); //initialize date picker
	$('.summernote').summernote({
		lang: 'vi-VN',
		height: 300,                 // set editor height
  		minHeight: null,             // set minimum height of editor
 		 maxHeight: null,             // set maximum height of editor
  		focus: true
	});

    $("ul.dashboard-menu > li.dropdown").on('click',function(){
       $(this).children("ul").slideToggle(500);
    });

    $(".profile-pic").slideDown(500);

});
