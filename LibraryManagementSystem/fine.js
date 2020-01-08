$(document).ready(function()
{
	var card_id;
	$('#fine_div').html('');
	$('#searchuser').on('click',function(e)
	{
		$('#fine_div').html('');
		e.preventDefault();
		card_id=$('#userinput').val();
		//console.log(card_id);
		if(card_id=='')
		{
			alert('Please input card_id to search fine amount!');
		}
		else
		{
			//console.log(card_id);
			$.ajax({
				url:'fine.php',
				type:'POST',
				data:{'card_id':card_id},
				success:function(data)
				{
					
					$('#fine_div').html('');
         			$('#fine_div').append(data);
         			$('#fine_div').fadeIn();
          			$('#fine_div').fadeOut(4000);
				}
			});
		}

	});

	$('#fine_cal').on('click',function()
	{
		//console.log(card_id);
		card_id=$('#userinput').val();
		if(card_id=='')
		{
			alert('Please input card_id to pay fine amount!');
		}
		else
		{
		$.ajax(
		{
			url:'fine.php',
			type:'POST',
			data:{'card_id_1':card_id},

			success:function(data)
			{
				//console.log(data);
				$('#fine_div').html('');
         			$('#fine_div').append(data);
         			$('#fine_div').fadeIn();
          			$('#fine_div').fadeOut(4000);
			}

		});
		}
	});

	$('#fineupdate').on('click',function()
	{
		var card_id_2='ALL';
		$.ajax(
		{
			url:'fine.php',
			type:'POST',
			data:{'card_id_2':card_id_2},
			success:function(data)
			{
				if(data=='allbookscheckedin')
				{
					$('#update_text').html('');
         			$('#update_text').append('All Books are Checked in, so try calculate if there are any fines');
         			$('#update_text').fadeIn();
          			$('#update_text').fadeOut(4000);
				}
				else if(data=='updatesuccess')
				{
					$('#update_text').html('');
         			$('#update_text').append('All Books fines are updated successfully!');
         			$('#update_text').fadeIn();
          			$('#update_text').fadeOut(4000);
				}
			}
		})
	});

});