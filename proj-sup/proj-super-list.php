<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>All Assigned Projects</title>
    <?php include '../inc/head.php' ?>
</head>

<body>

    <!-- ======= Header ======= -->
    <?php include '../inc/header.php' ?>

    <?php include '../inc/sidebar.php' ?>
    <?php
    if (isset($_POST['delete'])) {
        $pid = $_POST['project_id'];
        $sid = $_POST['supervisor_id'];
        // case 'customer':
        $query = "DELETE t1 FROM project_supervisor as t1 INNER JOIN project as t2 on t1.project_id=t2.id INNER JOIN supervisor as t3 on t1.supervisor_id=t3.id where t2.name='$pid' and t3.name='$sid'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if ($result) {
            header('location: ./proj-super-list.php');
        }
    }
    ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>All Assigned Projects</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">All Assigned Projects</li>
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
                                    <a class="icon" href="#" data-bs-toggle="dropdown" style="float:right;"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        <li><a class="dropdown-item" href="project-super.php">Assign Project</a></li>
                                    </ul>
                                </div>
                                <div class="modal fade" id="deleteModal" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="" method="POST">
                                                <div class="modal-body">
                                                    <h4>Are you sure ?</h4>
                                                    <input type="hidden" name="project_id" id="p_delete_id">
                                                    <input type="hidden" name="supervisor_id" id="delete_id">

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id='deleteButton' name="delete" class="btn btn-danger">Delete</button>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">List of all Assigned Projects</h5>

                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Supervisor Name</th>
                                                <th scope="col">Project Name</th>
                                                <th scope="col" data-sortable="false">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $run = mysqli_query($conn, "SELECT t2.name as proj_name, t3.name as sup_name FROM project_supervisor as t1 INNER JOIN project as t2 on t1.project_id=t2.id INNER JOIN supervisor as t3 on t1.supervisor_id=t3.id");
                                            if (mysqli_num_rows($run)) {
                                                while ($fetch = mysqli_fetch_assoc($run)) { ?>
                                                    <tr>
                                                        <td class="sup_n"><?= $fetch['sup_name'] ?></td>
                                                        <td class="proj_n"><?= $fetch['proj_name'] ?></td>
                                                        <td><a class="delete_btn"><i class="bx bxs-trash-alt" style="font-size: 160%;"></i></a></td>
                                                    </tr>

                                            <?php
                                                }
                                            }

                                            ?>
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
                var proj_n = $(this).closest('tr').find('.proj_n').text();
                var sup_n = $(this).closest('tr').find('.sup_n').text();
                console.log(proj_n, sup_n);
                $('#p_delete_id').val(proj_n)
                $('#delete_id').val(sup_n)

                $('#deleteModal').modal('show')
            });


        });
    </script>



    <?php include '../inc/footer.php' ?>

</body>

</html>