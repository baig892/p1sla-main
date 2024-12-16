<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project</title>
    <?php
    include '../inc/head.php';
    if (isset($_POST['delete_project'])) {
        $id = $_POST['project_id'];
        // case 'customer':
        $query = "DELETE FROM project WHERE id ='$id'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if ($result) {
            header('location: project-list.php');
        }
    }
    ?>
</head>

<body>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Project Table</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Project Table</li>
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
                                        <li><a class="dropdown-item" href="Project.php">Add Project</a></li>
                                    </ul>
                                </div>
                                <div class="modal fade" id="deleteModal" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Alert</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="#" method="POST">
                                                <div class="modal-body">
                                                    <h4>Are you sure ?</h4>
                                                    <input type="hidden" name="project_id" id="delete_id">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id='deleteButton' name="delete_project" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title"> Project Table</h5>

                                    <table class="table table-striped datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Name</th>
                                                <!-- <th scope="col" data-sortable="false">Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $retrieve = "SELECT * FROM project";
                                            if ($result = mysqli_query($conn, $retrieve)) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                    <tr>
                                                        <td class="stud_id"><?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <!-- <td><a class="delete_btn"><i class="bx bxs-trash-alt" style="font-size: 160%;"></i></a></td> -->
                                                    </tr>
                                            <?php


                                                }
                                                mysqli_free_result($result);
                                            }
                                            ?>
                                        <tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
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