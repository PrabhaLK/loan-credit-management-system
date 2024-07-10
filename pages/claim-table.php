<?php
require_once('../config/db.php');
$query = "Select * from claim_info";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=s, initial-scale=1.0">
  <title>Claim Table</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <style>
    .body {
      background-image: url('./images/back.jpg');
    }

    .table {
      paddingg: 15px;
    }

    .tb-background {
      background-image: url('./images/back.jpg');
      background-size: cover;
      /* Ensure the background covers the entire table */
      background-repeat: no-repeat;
      /* Prevent background from repeating */
    }
  </style>

</head>

<body>
  <div class="table">
    <table class="table table-bordered ">
      <thead>
        <tr>
          <th scope="col">ClaimID</th>
          <th scope="col">Name</th>
          <th scope="col">Category</th>
          <th scope="col">SubCategory 1</th>
          <th scope="col">SubCategory 2</th>
          <th scope="col">PerDay</th>
          <th scope="col">PerIncident</th>
          <th scope="col">PerYear</th>
          <th scope="col">PerLife</th>
          <th scope="col">ResetTime</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody class="tb-background">
        <tr>
          <?php
          while ($row = mysqli_fetch_assoc($result)) {



          ?>
            <td><?php echo $row['ClaimID'] ?></td>
            <td><?php echo $row['Name'] ?></td>
            <td><?php echo $row['Category'] ?></td>
            <td><?php echo $row['SubCategory 1'] ?></td>
            <td><?php echo $row['SubCategory 2'] ?></td>
            <td><?php echo $row['PerDay'] ?></td>
            <td><?php echo $row['PerIncident'] ?></td>
            <td><?php echo $row['PerYear'] ?></td>
            <td><?php echo $row['PerLife'] ?></td>
            <td><?php echo $row['ResetTime'] ?></td>
            <td><a href="#" class="btn btn-primary click_edit_btn">Edit</a></td>
            <td><a href="#" class="btn btn-danger">Delete</a></td>
        </tr>
      <?php



          }
      ?>
      </tr>


      </tbody>
    </table>
  </div>


  <!-- <script>
      $(document).ready(function() {
        $('.edit_data').click(function(e){
          e.preventDefault();

          var user_id =$(this).closest('tr').find('.user_id').text();
          // consol.log(user_id);

          $.ajax({
            method:"POST",
            url:"login.php",
            data:{
              'click_edit_btn':true,
              'user_id':user_id,
            },
            success: function (response){
              // console.log(response);
              $('.view_user_data').html(response);
              $('#viewuserrmodel').modal('show');
            }
          });

        }
      })


    </script> -->



</body>

</html>