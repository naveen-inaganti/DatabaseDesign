<?php
	session_start();
	$conn =mysqli_connect("localhost","root","root","maindb");
    if (!$conn) 
    {
		die("Connection issue: ".mysqli_connect_error());
	}
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		$ssn=$_POST['ssn'];
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$mail=$_POST['mail'];
		$address=$_POST['address'];
		$city=$_POST['city'];
		$state=$_POST['state'];
		$phone=$_POST['phone'];
		$lenssn=strlen($ssn);
		if($ssn=="" || $fname=="" || $lname=="" || $address=="")
		{
			echo "nullvalues";
		}
		//else if($lenssn!=11)
		//{
		//	echo "ssnnp";
		//}
		else
		{
			$insert_sql="insert into borrower (ssn,fname,lname,email,address,city,state,phone) values ('$ssn','$fname','$lname','$mail','$address','$city','$state','$phone');";
			$select_sql="select * from borrower where ssn='$ssn';";
			$result=mysqli_query($conn,$select_sql);
			$result_num_rows=mysqli_num_rows($result);
			if($result_num_rows>0)
			{
				echo "ssn_duplicated";
			}
			else
			{
				$insert_result=mysqli_query($conn,$insert_sql);
				$select_array=array();
				$select_result=mysqli_query($conn,$select_sql);
				foreach($select_result as $row)
				{
					$select_array[]=$row;
				}
				echo json_encode($select_array);
			}
			 
        }

	}


?>
