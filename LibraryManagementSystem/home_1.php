<?php
date_default_timezone_set('America/Chicago');
	session_start();

	$conn = mysqli_connect("localhost","root","root","maindb");
	if (!$conn) 
	{
		die("Connection error: ".mysqli_connect_error());
		
	}
    $moveoutdate=date("Y-m-d");
	$duedate=Date('Y-m-d', strtotime("+14 days"));	
	if(isset($_POST['row1']) && isset($_POST['row2'])&& isset($_POST['row3'])){

		 $bookids=$_POST['row1'];
		 //$bookid2=$_POST['row2'];
		 //$bookid3=$_POST['row3'];
		 $cardid=$_POST['row2'];
         $length=$_POST['row3'];
         $sql="select loan_id from book_loans where card_id='$cardid' and date_in='0000-00-00';"; 
		 $result=mysqli_query($conn,$sql);
		 $numof_rows=mysqli_num_rows($result);
		 $totalbooks=($length)+($numof_rows);
		if($totalbooks>3)
		{
			echo $length."booklimiterror";
		}
		else
		{
			/*if($bookid1!='')*/
			foreach ($bookids as $row) 
				# code...
			
			{
				$insert_sql="insert into book_loans (Isbn,Card_id,Date_out,Due_date,Date_in) values ('$row','$cardid','$moveoutdate','$duedate','0000-00-00'); ";
				$update_sql="update book set availability='Not available' where ISBN='$row' ;";
				$insert_result=mysqli_query($conn,$insert_sql);
				$update_result=mysqli_query($conn,$update_sql);
			}

			/*if($bookid2!='')
			{
				$insert_sql="insert into book_loans (Isbn,Card_id,Date_out,Due_date,Date_in) values ('$bookid2','$cardid','$moveoutdate','$duedate','0000-00-00'); ";
				$update_sql="update book set availability='Not available' where ISBN='$bookid2' ;";
				$insert_result=mysqli_query($conn,$insert_sql);
				$update_result=mysqli_query($conn,$update_sql);
			}
			if($bookid3!='')
			{
				$insert_sql="insert into book_loans (Isbn,Card_id,Date_out,Due_date,Date_in) values ('$bookid3','$cardid','$moveoutdate','$duedate','0000-00-00'); ";
				$update_sql="update book set availability='Not available' where ISBN='$bookid3' ;";
				$insert_result=mysqli_query($conn,$insert_sql);
				$update_result=mysqli_query($conn,$update_sql);
			}*/

				$sql4="insert into fines select book_loans.loan_id,'$cardid',0,0 from Book_loans where card_id='$cardid' and date_in='0000-00-00' and date_out=CURRENT_DATE() and loan_id not in (select loan_id from `fines`);";
				$result4=$conn->query($sql4);
				echo "Successs";
				mysqli_close($conn);
			}
		}
?>