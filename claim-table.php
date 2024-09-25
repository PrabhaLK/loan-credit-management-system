<?php
    require_once('config/db.php');
    $query = "Select * from claim_info";
    $result = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=s, initial-scale=1.0">
    <title>Claim Table</title>
    
    
    <!-- jquery added  -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    

     <!-- DataTables CSS -->
        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

     <!-- Bootstrap JS (required for DataTables) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
            crossorigin="anonymous"></script>
    <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#claimTable').DataTable();
        });






        $(document).ready(function() {
    $('.edit_data').on('click', function() {
        $('#exampleModal').modal('show');

        // Get the closest <tr> to the button clicked
       
        $tr = $(this).closest('tr');

        
        // Map each <td> text to an array
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        // Populate modal fields with data
        $('#ClaimID').val(data[0]);
        $('#Name').val(data[1]);
        $('#Category').val(data[2]);
        $('#SubCategory_1').val(data[3]);
        $('#SubCategory_2').val(data[4]);
        $('#PerDay').val(data[5]);
        $('#PerIncident').val(data[6]);
        $('#PerYear').val(data[7]);
        $('#PerLife').val(data[8]);
        $('#ResetTime').val(data[9]);
    });
});


        
        
    </script>

    <style>

      .body{
          background-image:url('./images/back.jpg');  
        }  

      .table{
        paddingg: 15px;
      }
      .tb-background {
  background-image: url('./images/back.jpg');
  background-size: cover; /* Ensure the background covers the entire table */
  background-repeat: no-repeat; /* Prevent background from repeating */
}


    </style>
    
</head>
<body>

 <!-- Edit pop up form -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Database</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="updatecode.php" method="POST">
                <div class="modal-body">
                <div class="form-group mb-3">
                    <input type="hidden" class="form-control" name="ClaimID" id="ClaimID" placeholder="Enter valied ID">
                  </div> 
                  <div class="form-group mb-3">
                    <input type="text" class="form-control" name="Name" id="Name" placeholder="Enter valied Name">
                  </div> 
                  <div class="form-group mb-3">
                    <input type="number" class="form-control" name="Category" id="Category" placeholder="Enter valied Category">
                  </div>
                  <div class="form-group mb-3">
                    <input type="number" class="form-control" name="SubCategory_1" id="SubCategory_1" placeholder="Enter valied SubCategory 1">
                  </div>
                  <div class="form-group mb-3">
                    <input type="number" class="form-control" name="SubCategory_2" id="SubCategory_2" placeholder="Enter valied SubCategory 2">
                  </div>
                  <div class="form-group mb-3">
                    <input type="number" class="form-control" name="PerDay" id="PerDay" placeholder="Enter valied PerDay">
                  </div>
                  <div class="form-group mb-3">
                    <input type="number" class="form-control" name="PerIncident" id="PerIncident" placeholder="Enter valied PerIncident">
                  </div>
                  <div class="form-group mb-3">
                    <input type="number" class="form-control" name="PerYear" id="PerYear" placeholder="Enter valied PerYear">
                  </div>
                  <div class="form-group mb-3">
                    <input type="number" class="form-control" name="PerLife" id="PerLife" placeholder="Enter valied PerLife">
                  </div>
                  
                  <div class="form-group mb-3">
                    <input type="number" class="form-control" name="ResetTime" id="ResetTime" placeholder="Enter valied Reset Time">
                  </div>
                  
                </div>

        
        <div class="modal-footer">
          <button type="button" name="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" name="update" class="btn btn-primary" />
        </div>
      </form>
      </div>
    </div>
  </div>
           
            
          </div>
        </div>
      </div>
    </div>


    <div class="table">
      <table class="table table-bordered " >
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
            while($row=mysqli_fetch_assoc($result))
            {
            
            
            
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
                <td><button type="button" class="btn btn-primary edit_data" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button> </td>
                <td><a href="#" class="btn btn-danger">Delete</a></td>
              </tr>
          <?php


          
            }
          ?>  
          </tr>
          

          
      </tbody>
</table>
  </div>

    
   

    
</body>
</html>