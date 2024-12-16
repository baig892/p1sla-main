<?php include '../inc/connection.php' ?>
<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>


<html lang="en">

<head>

    <?php include '../inc/head.php' ?>
    <script>
        function test(anchor) {
            var conf = confirm('Are you sure want to delete this budget record?');
            if (conf == true)
                alert("record deleted on row;");
        }
    </script>
</head>

<body>
    <?php

    if (isset($_GET['id'])) {
        $query = 'DELETE FROM budget WHERE id = ' . $_GET['id'];
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
       
    }
    ?>

    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">BudgetTable</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown" style="float:right;"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="budget.php">Add Budget</a></li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Budget Table</h5>


                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr></tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Supervisor_id</th>
                                            <th scope="col">Project_id</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                            <th scope="col" data-sortable="false">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $retrieve = "SELECT * FROM budget ";
                                            if ($result = mysqli_query($conn, $retrieve)) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    echo '<tr>
                                            <td>' . $row[0] . '</td>
                                            <td>' . $row[1] . '</td>
                                            <td>' . $row[2] . '</td>
                                            <td>' . $row[3] . '</td>
                                            <td>' . $row[4] . '</td>
                                            <td><a href="budget-list.php?action=delete & id=' . $row[0] . '" class="btn btn-danger" onclick="test()" name="alert">Delete</a></td>
                                            </tr>';
                                                }
                                                mysqli_free_result($result);
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->




    <?php include '../inc/footer.php' ?>

</body>

</html>