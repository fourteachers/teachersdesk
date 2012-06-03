jQuery(document).ready(function() {



/*-----------------------------------------------------------------------------------*/
/*	Overlay Animation
/*-----------------------------------------------------------------------------------*/

	function thumb_overlay() {
		jQuery('.post-thumb a').hover( function() {
			jQuery(this).find('.overlay').fadeIn(150);
		}, function() {
			jQuery(this).find('.overlay').fadeOut(150);
		});
		
		$('a.tool_tip').animate({'opacity' : .5}).hover(function() {
		$(this).animate({'opacity' : 1});
		}, function() {
			$(this).animate({'opacity' : .5});
		});
		
	}
	
	thumb_overlay();

/*-----------------------------------------------------------------------------------*/
/*	Tipsy Tool Tip
/*-----------------------------------------------------------------------------------*/

	function tipsy_tooltip() {
		$('a.tool_tip').tipsy({fade: true});
	}
	
	tipsy_tooltip();
	
/*-----------------------------------------------------------------------------------*/
/*	Calling the Method
/*-----------------------------------------------------------------------------------*/

		/*$('#slider').nivoSlider({
		//effect:'fade' // Specify sets like: 'fold,fade,sliceDown'
		effect:'fold', // Specify sets like: fold,fade,sliceDown
		slices:20, // For slice animations
		boxCols: 8, // For box animations
		boxRows: 4, // For box animations
		animSpeed:500, // Slide transition speed
		pauseTime:2000, // How long each slide will show
		startSlide:0, // Set starting Slide (0 index)

		});*/
	
	/* portfolio switch*/
	$("a.switch_thumb").toggle(function(){
        $(this).addClass("swap");
        $("ul.display").fadeOut("fast", function() {
            $(this).fadeIn("fast").addClass("thumb_view");
        });
    }, function () {
        $(this).removeClass("swap");
        $("ul.display").fadeOut("fast", function() {
            $(this).fadeIn("fast").removeClass("thumb_view");
        });
    }); 
	
	
	/* image fade when hover*/
	$('#portfolio a img').animate({'opacity' : 1}).hover(function() {
		$(this).animate({'opacity' : .3});
	}, function() {
		jQuery(this).animate({'opacity' : 1});
	});
	
	/*inFieldLabels*/
	/*$("label").inFieldLabels();*/

	/* PrettyPhoto */
	$("#image-grid:first a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'facebook',slideshow:2000, autoplay_slideshow: false});

	
});