$(document).ready(function() {
	$(".delete_sidebar").click(function(a){											
		thisItem = $(this).attr('rel');
		$('.sidebars[rel='+thisItem+']').hide();
	});
});
		

// Functions for admin control panel's slider - Add, Edit, Remove images
function addRowToTable()
{
	var tbl = document.getElementById('demo');
	var lastRow = tbl.rows.length;
	// if there's no header row in the table, then iteration = lastRow + 1
	var iteration = lastRow;
	var row = tbl.insertRow(lastRow);

	// left cell
	var cellLeft = row.insertCell(0);
	var textNode = document.createTextNode(iteration);
	cellLeft.appendChild(textNode);

	// right cell
	var cellRight = row.insertCell(1);
	var el = document.createElement('input');
	el.type = 'text';
	el.name = 'gm_sidebar_list_url_' + iteration;
	el.id = 'gm_sidebar_list_url_' + iteration;
	//el.size = 40;
	el.setAttribute('style', 'width:457px;');
	el.onkeypress = keyPressTest;
	cellRight.appendChild(el);


}
function keyPressTest(e, obj)
{
  var validateChkb = document.getElementById('chkValidateOnKeyPress');
  if (validateChkb.checked) {
    var displayObj = document.getElementById('spanOutput');
    var key;
    if(window.event) {
      key = window.event.keyCode; 
    }
    else if(e.which) {
      key = e.which;
    }
    var objId;
    if (obj != null) {
      objId = obj.id;
    } else {
      objId = this.id;
    }
    displayObj.innerHTML = objId + ' : ' + String.fromCharCode(key);
  }
}

function removeRowFromTable()
{
  var tbl = document.getElementById('demo');
  var lastRow = tbl.rows.length;
  if (lastRow > 1) tbl.deleteRow(lastRow - 1);
}
