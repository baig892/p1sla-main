<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Supervisor</title>
    <?php include '../inc/head.php' ?>

</head>

<body>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <?php
    if (isset($_POST['delete_supervisor'])) {
        $id = $_POST['supervisor_id'];
        // case 'customer':
        $query = "DELETE FROM supervisor WHERE id ='$id'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if ($result) {
            header('location: supervisor-list.php');
        }
    }
    ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Supervisors</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">All Supervisor</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="filter">
                                    <a class="icon" data-bs-toggle="dropdown" style="float:right;"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="supervisor.php">Add Supervisor</a></li>
                                    </ul>
                                </div>
                                <div class="modal fade" id="deleteModal" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                                <div class="modal-body">
                                                    <h4>Are you sure ?</h4>
                                                    <input type="hidden" name="supervisor_id" id="delete_id">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id='deleteButton' name="delete_supervisor" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">All Supervisors</h5>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Index</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Balance</th>
                                                <!-- <th scope="col" data-sortable="false">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $retrieve = "SELECT * FROM supervisor ";
                                            if ($result = mysqli_query($conn, $retrieve)) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $id = $row['id'];
                                            ?>
                                                    <tr>
                                                        <td class="stud_id"><?= $id ?></td>
                                                        <td><?= $row['name']; ?></td>
                                                        <td><?= $row['email']; ?></td>
                                                        <?php
                                                        $sql = "SELECT 
                                                        (SELECT COALESCE(SUM(amount), 0) FROM `budget` where ack=1 and supervisor_id=$id)
                                                         - 
                                                        (SELECT COALESCE(SUM(expense), 0) FROM `expense` WHERE ack=1 and supervisor_id=$id)
                                                         - 
                                                        (SELECT COALESCE(SUM(amount),0) FROM `labour_pay` WHERE ack=1 and supervisor_id=$id) as balance";
                                                        if($row1=mysqli_fetch_assoc(mysqli_query($conn,$sql))){
                                                            echo '<td>' . $row1['balance'] . '</td>';
                                                        }

                                                        ?>
                                                        <!-- <td><a class="delete_btn"><i class="bx bxs-trash-alt" style="font-size: 160%;"></i></a></td> -->
                                                    </tr>
                                            <?php
                                                }
                                                mysqli_free_result($result);
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- End Recent Sales -->
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <script>
        $(document).ready(function() {
            $('.delete_btn').click(function(e) {
                e.preventDefault();
                var stud_id = $(this).closest('tr').find('.stud_id').text();
                console.log(stud_id);
                $('#delete_id').val(stud_id)
                $('#deleteModal').modal('show')
            });


        });
    </script>




    <?php include '../inc/footer.php' ?>

</body>

</html>