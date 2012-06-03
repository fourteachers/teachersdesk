jQuery(document).ready(function(){
	jQuery('.settings').slideUp();
	jQuery('.slideToggle h3').click(function(){
		jQuery(this).parent().next('.settings').slideToggle('slow');
	});
});