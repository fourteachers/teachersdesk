


$(document).ready(function() 
{
	
	$('#keysearch input[type=submit]').click(function(e) {
		e.preventDefault();
	});
	
	$("#print").click(function(){
		$("#printed").show();
		$("#printed").empty();
		var data=$("#tekslist").val();
		//var data2=$('#tekslist :selected').html()
		var html='';
		$.each(data,function (key,val)
		{
			 html+=val+"\r";
		//	console.log($(this).text());
		//console.log(val);
		}
		
		);	
		$("#printed").append(html);
		
	});
	
	$("#tekslist").hide();
	$("#elpslist").hide();
	$("#ccrslist").hide();
	$("#print").hide();
	$("#printed").hide();
	$("#elpschoice").hide();
	
	$("elpsbutton").change( function()
	{
		if ($("#elpsbutton").val() == true)
		{
			$("#elpschoice").show();
		}
	});

    $("#grade").change( function()
	{
		if ($('#subject').length >0)
		{
			var grade=$("#grade").val();
			$("#subject").empty();
			$.getJSON("http://teachingdesk.com/services.php?service=subjects&grade="+grade, function(data)
			{
				$.each(data, function(key, val) 
				{
					
					var html='<option value="'+val.id+'">'+val.name+'</option>';
					$("#subject").append(html);
				});
			});
		}
	});
	
	$("#elpschoice").change( function()
	{
		if ($('#elpslist').length >0)
		{
			var choice=$("#elpschoice").val();
			$("#elpslist").empty();
			$.getJSON("http://teachingdesk.com/services.php?service=elps&section="+choice, function(data)
			{
				$.each(data, function(key, val) 
				{
					var html='<option value="'+val.id+'">'+val.formatstring+'</option>';
					$("#elpslist").append(html);
				});
			});
		}
	});
	
	$("#submit").click( function(e)
	{

		var grade = $("#grade").val();
	
		var subject = $("#subject").val();
		
		//get server responses for size and html for each teks, elps, ccrs...
	//	if ($('#subject').length >0)
	//	{
			var url = "http://teachingdesk.com/services.php?service=teks&grade="+grade+"&subject="+subject;
			if ( $("#keyword").val() != '')
			{
				url += '&search='+$("#keyword").val();
			}
			$("#tekslist").empty();
			$.getJSON(url, function(data)
			{	
				$.each(data, function(key, val) 
				{
					var tekId=val.section;
					if (val.subsection != null)
					{
					  tekId+='.'+val.subsection;
					}
					if (val.subsection2 != null)
					{
					  tekId+='.'+val.subsection2;
					}
					
					
					var html='<option value="'+tekId+' - '+val.description+'">'+tekId+' - '+val.description+'</option>';
					
					$("#tekslist").append(html);
				});
			});
			
			$("#tekslist").show();
			//$("#search_container").fadeOut(2000);
			$("#print").show();
	//	}
		return false;
	});
});
