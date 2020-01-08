<?php
date_default_timezone_set('America/Chicago');
session_start();
$conn =mysqli_connect("localhost","root","root","maindb");
if (!$conn) 
{
  die("Connection Error: ".mysqli_connect_error());
}
if(isset($_POST['userinput']))
{
  $search=$_POST['userinput'];
  $sql="select book_loans.Loan_id, book_loans.Isbn, book_loans.Card_id, borrower.fname, borrower.lname,book.Title FROM book_loans LEFT JOIN borrower ON book_loans.Card_id=borrower.card_no LEFT JOIN book ON book_loans.Isbn=book.Isbn where (book_loans.Isbn='$search' or book_loans.Card_id='$search' or borrower.fname like '%$search%' or borrower.lname like '%$search%') AND book_loans.Date_in='0000-00-00';";
  $result=mysqli_query($conn,$sql);
  $result_num_rows=mysqli_num_rows($result);
  if($result_num_rows>0)
  {
    
    foreach($result as $row)
    {
      echo '<tr style={cursor: pointer}><td id="loanid">'.$row['Loan_id'].'</td><td>'.$row['Card_id'].'</td><td id="isbn">'.$row['Isbn'].'</td><td>'.$row['fname'].' '.$row['lname']. '</td><td>'.$row['Title'].'</td><td><input type="checkbox" id="checkbox"/></td></tr>';
    }
  }
  else if($result1->num_rows==0)
  {
    echo "noloans";
  }
}

if(isset($_POST['arraydata']))
{
  $myarraydata=$_POST['arraydata'];
  $sum=0;
  foreach($myarraydata as $rows) 
  { 
       $loan_id=$rows[0];
       $isbn=$rows[1];
       $sql_select_loanid="SELECT Date_out, Due_date, Card_id, Isbn FROM book_loans WHERE Loan_id='$loan_id'";
       $result=mysqli_query($conn,$sql_select_loanid);
       $num=mysqli_num_rows($result);
       if($num>0)
      {
        $row=$result->fetch_assoc();
        $dateout=$row['Date_out'];
        $duedate=$row['Due_date'];
        $cardid=$row['Card_id'];
        $checkindate=date("Y-m-d");
        $dateout=strtotime($dateout);
        $duedate=strtotime($duedate);
        $checkindate=strtotime($checkindate);
        round(($checkindate-$dateout) / 86400);

        if(round(($checkindate-$dateout) / 86400)<15)
        {
          $sum=$sum+0;
        }
        else 
        {
          $fine=round(($checkindate-$duedate) / 86400)*0.25;
          $sql_fine_select="SELECT Loan_id FROM fines WHERE Loan_id='$loan_id'";
          $result=mysqli_query($conn,$sql_fine_select);
          if($result->num_rows>0)
          {
            $sql4="UPDATE fines SET Fine_amt='$fine' WHERE Loan_id='$loan_id'";
          }
          else 
          {
            $sql4="INSERT INTO fines (Loan_id,Card_id,Fine_amt,Paid) VALUES ('$loan_id','$cardid','$fine',0)";
           }
          mysqli_query($conn,$sql4);
          $sum=$sum+$fine;
        }

      }
  }
  if($sum==0)
  {
    echo "ZeroFine";
  }
  else
  {
    echo $sum;
  }
}






if(isset($_POST['finaldata']))
{
  $paydata=$_POST['finaldata'];
  foreach($paydata as $pay)
  {
    $loan_id=$pay[0];
    $isbn=$pay[1];
    $date=date("Y-m-d");
    $sql_update_loans="UPDATE book_loans SET Date_in='$date' WHERE Loan_id='$loan_id'";
    $sql_update_book="UPDATE book SET Availability='Available' WHERE Isbn='$isbn'";
    $sql_delete_fines="DELETE FROM fines WHERE Loan_id='$loan_id'";
    mysqli_query($conn,$sql_update_loans);
    mysqli_query($conn,$sql_update_book);
    mysqli_query($conn,$sql_delete_fines);  
  }
  echo "Hoal There are no Dues and Books are Checked in successfully!";
}


if(isset($_POST['justcheck_in']))
{
  $justcheckin=$_POST['justcheck_in'];
  foreach($justcheckin as $pay)
  {
    $loan_id=$pay[0];
    $isbn=$pay[1];
    $date=date("Y-m-d");
    $sql_loans_update="UPDATE book_loans SET Date_in='$date' WHERE Loan_id='$loan_id'";
    $sql_book_update="UPDATE book SET Availability='Available' WHERE Isbn='$isbn'";
    mysqli_query($conn,$sql_loans_update);
    //mysqli_query($conn,$sql_fines_update);
    mysqli_query($conn,$sql_book_update);  
  }
  echo "The Books are Checked in successfully With Payment Due!";
}





if(isset($_POST['finaldata_1']))
{
  $payfinal=$_POST['finaldata_1'];
  foreach($payfinal as $pay)
  {
    $loan_id=$pay[0];
    $isbn=$pay[1];
    $date=date("Y-m-d");
    $sql_loans_update="UPDATE book_loans SET Date_in='$date' WHERE Loan_id='$loan_id'";
    $sql_fines_update="UPDATE fines SET Paid=1 WHERE Loan_id='$loan_id'";
    $sql_book_update="UPDATE book SET Availability='Available' WHERE Isbn='$isbn'";
    mysqli_query($conn,$sql_loans_update);
    mysqli_query($conn,$sql_fines_update);
    mysqli_query($conn,$sql_book_update);  
  }
  echo "The Payment is Made and Books are Checked in successfully!";
}

?>
