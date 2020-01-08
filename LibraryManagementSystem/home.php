<?php
date_default_timezone_set('America/Chicago');
	session_start();
	$conn = mysqli_connect("localhost","root","root","maindb");
	if (!$conn) 
	{
		die("Connection error: ".mysqli_connect_error());
		
	}
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		$searchstring=$_POST['searchstring'];
		if($searchstring=="" )
		{
			$temp='blankerror';
			echo $temp;
			//alert("Please give input in right way");
		}
		else
		{
			$sql="select ISBN, Title, fullname, availability from (select a.ISBN,Title,GROUP_CONCAT(fullname SEPARATOR ',') 'fullname',availability from `book` a, book_authors b, authors c where a.isbn=b.isbn and b.author_id=c.author_id GROUP BY a.isbn) z where ((z.ISBN like '%$searchstring%') or (z.Title like '%$searchstring%') or (z.fullname like '%$searchstring%'));"; 
			$result=mysqli_query($conn,$sql);
			$count=mysqli_num_rows($result);
			if($count>0){		
				foreach($result as $row)
				{
					//$searchresult[]=$row;
					if($row['availability']=="Not available")
					{
						echo '<tr><td>'.$row['ISBN'].'</td><td>'.$row['Title'].'</td><td>'.$row['fullname'].'</td><td>'.$row['availability'].'</td><td><input type="checkbox" disabled="disabled"/></td></tr>';
					}
					else
					{
						echo '<tr><td>'.$row['ISBN'].'</td><td>'.$row['Title'].'</td><td>'.$row['fullname'].'</td><td>'.$row['availability'].'</td><td><input type="checkbox"/></td></tr>';
					}
				}
				
				//echo json_encode($searchresult);
			}
			else
			{
				echo "There are no Books with the given Input"."<br>";
			}	
		}
	}
?>


