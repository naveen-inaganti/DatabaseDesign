$(document).ready(function () {

  $('#tableid').hide();
  $('#fine_div').hide();
  $("#searchuser").on('click',function (e) 
  {
    $('#tableid').hide();
   $('#fine_div').hide();
    $('tbody').html('');
    e.preventDefault();
    var userinput=$("#userinput").val();
    //console.log(userinput);
    $.ajax(
    {
      url: "checkin.php",
      type: "POST",
      data: {"userinput":userinput},
      success: function (data) 
      {
        if(data=='noloans')
        {
          $('#nodues_orloan').html('');
          $('#nodues_orloan').append('No Book loans');
          $('#nodues_orloan').fadeIn();
          $('#nodues_orloan').fadeOut(3000);
        }
        else if(data!='noloans')
        {
          
					 $("tbody").append(data);
            $("#tableid").show();
        }
      }
    });
  });

$("tbody").on('click','td',function()
{
    $("#fine_div").show();
    $('.selectcheckin').removeClass('selectcheckin');

});

$("#fine_cal").on('click',function()
{
    var checkedbooks=[];
    $("#tableid").find("tr").each(function()
          {
            if($(this).find('input[type=checkbox]').is(":checked"))
            {
              var loan_id=$(this).find("td").eq(0).html();
              var isbn=$(this).find("td").eq(2).html();
              checkedbooks.push([loan_id,isbn]);
              $(this).addClass('selectcheckin');
              
            }
          });
    if(checkedbooks.length==0)
    {
      alert("Select a Book to calculate fine!");
    }
    else
    {
        $.ajax(
          {
              url:"checkin.php",
              type:"POST",
              data:{'arraydata':checkedbooks},
              success:function(data)
              {
                  //console.log(data);
                  //console.log("came here");
                if(data=="ZeroFine")
                {
                  var fine_string="<h3>No fine</h3><button class='btn btn-outline-secondary' name='confirmcheckin' id='confirmcheckin'>checkin</button>";
                }
                else
                {
                  var fine_string='<h3>'+data+' $</h3><button class="btn btn-outline-secondary" name="justcheckin" id="justcheckin">Just Check-in</button><button class="btn btn-outline-secondary" name="payconfirmcheckin" id="payconfirmcheckin" style="margin-left:25px;" >payfine and checkin</button>';
                }
                $("#fineDetails").html('');
                $("#fineDetails").append(fine_string);
              }
          });
    }

});



$('#fineDetails').on('click','#confirmcheckin',function()
{
  //console.log("came here");
  var final=[];
  $("#tableid").find("tr").each(function()
      {
        if($(this).find('input[type=checkbox]').is(":checked"))
        {
          var loan_id=$(this).find("td").eq(0).html();
          var isbn=$(this).find("td").eq(2).html();
          final.push([loan_id,isbn]);
        }
      });
      if(final.length==0)
      {
        alert("You Didn't Selected any!");
      }
      else
      {
        $.ajax(
          {
              url:"checkin.php",
              type:"POST",
              data:{'finaldata':final},
              success:function(data)
              {
                $('#fineDetails').html('');
                $('.alert-primary').html('');
                $('.alert-primary').append(data);
                $(".alert-primary").fadeIn();
                $(".alert-primary").fadeOut(3000);
                $('.selectcheckin').remove();
                $('#fine_div').hide();

              }
          });
      }


});

$('#fineDetails').on('click','#justcheckin',function()
{
  //console.log("came to");
  var justcheck_in=[];
  $("#tableid").find("tr").each(function()
      {
        if($(this).find('input[type=checkbox]').is(":checked"))
        {
          var loan_id=$(this).find("td").eq(0).html();
          var isbn=$(this).find("td").eq(2).html();
          justcheck_in.push([loan_id,isbn]);
        }
      });
      if(justcheck_in.length==0)
      {
        alert("You Didn't Selected any Books!");
      }
      else
      {
        $.ajax(
          {
              url:"lms4.php",
              type:"POST",
              data:{'justcheck_in':justcheck_in},
              success:function(data)
              {
                console.log(data);
                $('#fineDetails').html('');
                $('.alert-primary').html('');
                $('.alert-primary').append(data);
                $(".alert-primary").fadeIn();
                $(".alert-primary").fadeOut(3000);
                $('.selectcheckin').remove();
              }
          });
      }


});

$('#fineDetails').on('click','#payconfirmcheckin',function()
{
  //console.log("came to");
  var finalpay=[];
  $("#tableid").find("tr").each(function()
      {
        if($(this).find('input[type=checkbox]').is(":checked"))
        {
          var loan_id=$(this).find("td").eq(0).html();
          var isbn=$(this).find("td").eq(2).html();
          finalpay.push([loan_id,isbn]);
        }
      });
      if(finalpay.length==0)
      {
        alert("You Didn't Selected any!");
      }
      else
      {
        $.ajax(
          {
              url:"lms4.php",
              type:"POST",
              data:{'finaldata_1':finalpay},
              success:function(data)
              {
                console.log(data);
                $('#fineDetails').html('');
                $('.alert-primary').html('');
                $('.alert-primary').append(data);
                $(".alert-primary").fadeIn();
                $(".alert-primary").fadeOut(3000);
                $('.selectcheckin').remove();
              }
          });
      }


});

});
