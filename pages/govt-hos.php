<?php
include('../config/db.php');
$type = isset($_GET['type']) ? $_GET['type'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boostrap css  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.min.js">

    <title></title>
    <style>
        .left-sec {
            width: 50%;
            float: left;
        }

        .right-sec {
            width: 50%;
            float: right;
        }

        .right-up {
            height: 50%;
            padding-top: 10%;
            padding-right: 2%;
            position: inherit;
        }

        .right-down {
            background-color: green;
            height: 50%;
            padding: 0;
        }

        .Header {
            color: black;
            text-align: center;
            padding: 30px;
            text-decoration: none;
            display: inline-block;
            font-size: 36px;
        }

        .left-up {
            height: 50%;
            padding-top: 10%;
            position: inherit;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="left-sec">
        <div class="Header">
            <?php echo ($type); ?>
        </div>
        <div class="left-up">
            <div class="container">
                <div class="row my-4">
                    <div class="col-lg-9 mx-auto">
                        <div class="card shadow">
                            <div class="card-header">
                                <h4> Add Items </h4>
                            </div>
                            <div class="card-body p-4">
                                <form action="#" method="POST" id="add_form">
                                    <div id="show_item">
                                        <div class="row">
                                            <p>Number of Dates</p>
                                            <div class="col-md-7 mb-3">
                                                <input type="number" style="margin-left:37%" name="number_of_dates[]" id="" class="form-control" placeholder="Item_name" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <p>Surgical and Medical Treatments</p>
                                            <div class="col-md-7 mb-3">
                                                <input type="number" name="number_of_dates[]" id="" class="form-control" placeholder="Item_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button class="btn btn-success add_item_btn">Add More</button>
                                        </div>
                                        <div class="row">
                                            <p>Surgical and Medical Treatments</p>
                                            <div class="col-md-7 mb-3">
                                                <input type="number" name="number_of_dates[]" id="" class="form-control" placeholder="Item_name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button class="btn btn-success add_item_btn">Add More</button>
                                        </div>
                                        <div class="row my-auto">
                                            <button class="btn btn-primary add_item_btn">Send Details</button>
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="right-sec">
        <div class="right-up">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Created On</th>
                                <th>Updated On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <?php if (count($users) > 0) : ?>  -->
                            <?php foreach ($users as $user) : ?>
                                <tr>
                                    <td>bxjnjksnkjcn</td>
                                    <td>bxjnjksnkjcn</td>
                                    <td>bxjnjksnkjcn</td>
                                    <td>bxjnjksnkjcn</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">No Users</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="right-down">
            <h4>Right up div</h4>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

</html>