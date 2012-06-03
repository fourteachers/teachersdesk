jQuery(document).ready(function ($) {
        $('tr.row2 td').css('backgroundColor', '#eeeeee');
		$('table tbody a.control').live('click', function (e) {
        e.preventDefault(); 
            var tr = $(this);
            var iterations = 0;
            while(tr.attr('tagName') != 'TR') {
                tr = tr.parent();
                iterations += 1;
                if (iterations == 100) {
                    return false;
                }
            }

        if ($(this).attr('rel') == 'up' && tr.prev().length)
            tr.fadeTo('medium', 0.1, function () {
                tr.insertBefore(tr.prev()).fadeTo('fast', 1);
                reorder();
            });
        else if ($(this).attr('rel') == 'down' && tr.next().length)
            tr.fadeTo('fast', 0.1, function () {
                tr.insertAfter(tr.next()).fadeTo('fast', 1);
           	reorder();
            });
        else
            return false;

       return false;
        });

		var mouseX, mouseY, lastX, lastY = 0;
		var need_select_workaround = typeof $(document).attr('onselectstart') != 'undefined';
		$().mousemove(function(e) { mouseX = e.pageX; mouseY = e.pageY; });
   
		$('#demo2 tbody tr').mousedown(function (e) {
	 
        lastY = mouseY;
        var tr = $(this);
        tr.find('td').fadeTo('fast', 0.2);
        $('tr', tr.parent() ).not(this).bind('mouseenter', function(){
        if (mouseY > lastY) {
                 $(this).after(tr);
        } else {
                $(this).before(tr);
        }
        lastY = mouseY;
        });

        $('body').mouseup(function () {
           tr.find('td').fadeTo('fast', 1);
           $('tr', tr.parent()).unbind('mouseenter');
           $('body').unbind('mouseup');

		   if (need_select_workaround)
		$(document).unbind('selectstart');
           reorder(); 
        });

	e.preventDefault();

	if (need_select_workaround)
	    $(document).bind('selectstart', function () { return false; });
        return false;
    }).css('cursor', 'move');

    function reorder () {
		var position = 1;
       		$('#demo tbody tr, #demo2 tbody tr').each(function () {
		$('td:first', $(this)).text(position);
		$("input", $(this)).attr("id","ml_slider_cp_url_"+position);
		$("input", $(this)).attr("name","ml_slider_cp_url_"+position);

		$('td', $(this)).css('backgroundColor', position % 2 ? '' : '#eeeeee');
		position += 1;
	});
  }
});