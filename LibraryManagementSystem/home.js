$(document).ready(function()
{
	$("#tableid").hide();
	$("#cardiddiv").hide();
	$("#moveout").hide();
	$('#moveoutafterselect').hide();
	$("#searchsubmit").on("click",function(e)
	{   
		//1$("#moveoutafterselect").html("Anything Left or Ready to Move out with Books?");
		//2$("#moveoutafterselect").attr("id","moveout");
        e.preventDefault();
        $("#content").html("");
        //$("#content").empty();
		$("#cardiddiv").hide();
		$("#moveout").hide();
		$('#moveoutafterselect').hide();

		var searchstring=$("#booksearch").val();
		$.ajax(
		{
			url:"home.php",
            type:"POST",
            data:{'searchstring':searchstring},
            success:function(data)
            {
             	//var temper=$.trim(data);
             	//console.log(data);
             	//console.log("came here");
             	if($.trim(data)=="blankerror")
             	{
					alert("Please give input in right way");
					//console.log("came here");
				}
				else
				{
				$("#tableid").append(data);
				$("#tableid").show();
				$("#content").one("click",function()
				{
					console.log('came here lego');
					$("#moveout").show();
				});
				$("#moveoutdiv").off().on("click",'#moveout',function()
				{
					var checkedbooks=[];
					$("#tableid").find("tr").each(function()
					{
						if($(this).find('input[type=checkbox]').is(":checked"))
						{
							var book_id=$(this).find("td").eq(0).html();
							var book_title1=$(this).find("td").eq(1).html();
							var book_author=$(this).find("td").eq(2).html();
							checkedbooks.push(book_id);
							
						}
					});
					if(checkedbooks.length>3)
					{
						alert("Apologies, You can movout either 3 or less than 3");
					}
					else if(checkedbooks.length<=0)
					{
						alert("Apologies, Please Select Books to Moveout!");
					}
					else
					{
						$("#cardiddiv").show();
						$("#moveout").hide();
						$('#moveoutafterselect').show();

						//3$("#moveout").html("Checkout");
						//4$("#moveout").attr("id","moveoutafterselect");
						$("#moveoutdiv").off().on("click",'#moveoutafterselect',function()
						{
           					var confirmedcheckout=[];
           					$("#tableid").find("tr").each(function()
							{
						
								if($(this).find('input[type=checkbox]').is(":checked"))
								{
									var book_id=$(this).find("td").eq(0).html();
									var book_title=$(this).find("td").eq(1).html();
									var book_author=$(this).find("td").eq(2).html();
	   								confirmedcheckout.push(book_id);
								}
							});
							var cardid=$("#cardid").val();
							if(cardid=='')
							{
							   alert("Please enter proper card_id");
							}
							else{
							var count=confirmedcheckout.length;
							console.log(count);
							$.ajax(
							{
								url:"home_1.php",
								type:"POST",
								data:{'row1': confirmedcheckout,'row2':cardid,'row3':count},
								success:function(data)
								{
									console.log(data);
									console.log("came here");
									if(data=="Successs")
									{
										alert("Issued Successfully");
									}
									else
									{
									alert("Exceeded Max Books");
									}
								}
							});
						}
						});
					}
				});
				}
			},
            error:function()
            {
				alert("Error Loading the file\n");
			}
		});
	});
});


