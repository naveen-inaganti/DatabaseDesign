<?
date_default_timezone_set('America/Chicago');
session_start();
$conn =mysqli_connect("localhost","root","root","maindb");
if (!$conn) 
{
  die("Connection Error: ".mysqli_connect_error());
}
if(isset($_POST['card_id']))
{
	$card_id=$_POST['card_id'];
	$tick=0;
	$sql='select f.Card_id, sum(f.Fine_amt) as "fine" from fines f JOIN book_loans b on f.Loan_id=b.Loan_id and b.Date_in <> "0000-00-00" where f.Card_id='.$card_id.' and f.Paid='.$tick. ' group by f.Card_id';
	$sql_1='select f.Card_id, sum(f.Fine_amt) as "fine" from fines f where f.Card_id='.$card_id.' and f.Paid='.$tick. ' group by f.Card_id';
	$result=mysqli_query($conn,$sql);
	$result_1=mysqli_query($conn,$sql_1);
	$num_rows=mysqli_num_rows($result);
	$num_rows_1=mysqli_num_rows($result_1);
	if($num_rows==0)
	{
		
		echo '<h3>No Due For Returned Books</h3>';
		if($num_rows_1==0)
		{
			echo '<h3>No Due For ALL Books</h3>';
		}
		else
		{
			$row=$result_1->fetch_assoc();
			echo '<h3>Total fine for all Books of card_id: '.$row['Card_id'].' is '.$row['fine'].'$</h3>';
		}
	}
	else
	{
		foreach($result_1 as $row)
		{	
			echo '<h3>Total fine for all Books of card_id: '.$row['Card_id'].' is '.$row['fine'].'$</h3>';

		}
		foreach($result as $row)
		{	
			echo '<h3>Total fine for returned Books of card_id: '.$row['Card_id'].' is '.$row['fine'].'$</h3>';

		}
			//$sum_fine=$row[1];
			//$id=$row[0];
	}
}

if(isset($_POST['card_id_1']))
{
	$card_id=$_POST['card_id_1'];
	$sql_fines_update="UPDATE fines f JOIN book_loans b on f.Loan_id=b.Loan_id and b.Date_in<>'0000-00-00' SET Paid=1 WHERE f.Card_id='$card_id' and f.Paid<>1";
	$result=mysqli_query($conn,$sql_fines_update);
	$count=mysqli_affected_rows($conn);
	if($count>0)
	{
	echo '<h3>Payment Success for returned books!</h3>';
	}
	else
	{
		echo '<h3>No Dues Detected for returned books</h3>';
	}

}

if(isset($_POST['card_id_2']))

{
	$card_id=$_POST['card_id_2'];
	$sql_all_fine_select="SELECT distinct Date_out, Due_date, Card_id, Isbn, Loan_id FROM book_loans WHERE Date_in='0000-00-00';";
	$result=mysqli_query($conn,$sql_all_fine_select);
	$num=mysqli_num_rows($result);
	if($num==0)
	{
		echo "allbookscheckedin";
	}
	else
	{
		foreach ($result as $row) 
		{	
			$loan_id=$row['Loan_id'];
			$dateout=$row['Date_out'];
        	$duedate=$row['Due_date'];
        	$cardid=$row['Card_id'];
        	$checkindate=date("Y-m-d");
        	$dateout=strtotime($dateout);
        	$duedate=strtotime($duedate);
        	$checkindate=strtotime($checkindate);
        	round(($checkindate-$dateout) / 86400);
        	if(round(($checkindate-$dateout) / 86400)>=15)
        	{
        			$fine=round(($checkindate-$duedate) / 86400)*0.25;
          			$sql_fine_select="SELECT Loan_id FROM fines WHERE Loan_id='$loan_id'";
          			$result_inner=mysqli_query($conn,$sql_fine_select);
          			if($result_inner->num_rows>0)
          			{
          			  $sql4="UPDATE fines SET Fine_amt='$fine' WHERE Loan_id='$loan_id'";
          			}
         			else 
          			{
           				 $sql4="INSERT INTO fines (Loan_id,Card_id,Fine_amt,Paid) VALUES ('$loan_id','$cardid','$fine',0)";
           			}
          			mysqli_query($conn,$sql4);
        	}
	# code...
		}
		echo 'updatesuccess';
	}
}

?>