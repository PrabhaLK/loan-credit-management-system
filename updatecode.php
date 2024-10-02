<?php
    $conn =mysqli_connect("localhost","root", "");
    $db =mysqli_select_db($conn,'insurance_as');

    if(isset($_POST['update'])){

        $id =$_POST['ClaimID'];
        $name =$_POST['Name'];
        $category =$_POST['Category'];
        $subcategory1 =$_POST['SubCategory_1'];
        $subcategory2 =$_POST['SubCategory_2'];
        $day =$_POST['PerDay'];
        $incident =$_POST['PerIncident'];
        $year =$_POST['PerYear'];
        $life =$_POST['PerLife'];
        $time =$_POST['ResetTime'];

        $query = "UPDATE claim_info SET 
            Name='$name',
            Category='$category',
            `SubCategory 1`='$subcategory1',
            `SubCategory 2`='$subcategory2',
            PerDay='$day',
            PerIncident='$incident',
            PerYear='$year',
            PerLife='$life',
            ResetTime='$time'
          WHERE ClaimID = '$id'";

        
        $query_run =mysqli_query($conn,$query);

        if($query_run)
        {
            echo '<script> alert("Data Updated"); </script>';
            header("location:claim-table.php");
        }
        else
        {
            echo '<script> alert("Data Not Updated"); </script>';
        }
    }
?>