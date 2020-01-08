$(document).ready(function()
{
	$("#register").on('click',function(e)
	{
		e.preventDefault();
		var val=$("#newuserform").serialize();
		$.ajax(
		{
			url:"borrow.php",
			type:"POST",
			data:val,
			success:function(data)
			{
				if($.trim(data)=="ssn_duplicated")
				{
					$("#submitresults").html("Error: SSN User Already Exsists");
					$("#submitresults").css("color","red");

				}
				else if($.trim(data)=="nullvalues")
				{
					$("#submitresults").html("Don't Leave Name, SSN and Address Fields Blank!");
					$("#submitresults").css("color","red");
				}
				else if($.trim(data)=="ssnnp")
				{
					$("#submitresults").html("Please Enter SSN in format(xxx-xx-xxxx)");
					$("#submitresults").css("color","red");
				}
				else
				{
					data=$.parseJSON(data);
					$.each(data,function(key,value)
					{
						var card_id=value.card_no;
						var fname=value.fname;
						var lname=value.lname;
						var status= "Registration Successful. Here is your Library ID, "+fname+': '+card_id;
						$("#submitresults").html(status);
						$("#submitresults").css("color","green");
						
					});
				}
			},
			error:function()
			{
				alert("Connection failed");
			}

		});
	});
});
