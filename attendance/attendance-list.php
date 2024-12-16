<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Attendance List</title>
    <?php include '../inc/head.php'; ?>
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
</head>

<body>
    <!-- ======= Header ======= -->
    <?php include '../inc/header.php' ?>
    <!-- End Header -->
    <?php include '../inc/sidebar.php' ?>
    <?php if (isset($_POST['delete_labour'])) {
        $id = $_POST['attendance_id'];
        $query = "DELETE FROM attendance WHERE id ='$id'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        if ($result) {
            header('location: attendance-list.php');
        }
    } ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Attendance Table</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Attendance Table</li>
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
                                        <li><a class="dropdown-item" href="#">Add Attendance</a></li>
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
                                                    <input type="hidden" name="attendance_id" id="delete_id">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id='deleteButton' name="delete_labour" class="btn btn-danger">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"> Attendance Table</h5>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Index</th>
                                                <th scope="col">Project</th>
                                                <th scope="col">Labour</th>
                                                <th scope="col">Supervisor</th>
                                                <th scope="col">Date</th>
                                                <?php if ($_SESSION['role'] == "ADMIN") { ?>
                                                    <th scope="col" data-sortable="false">Action</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $run = mysqli_query($conn, "SELECT a.id, a.date, p.name as project_name, s.name as supervisor_name, l.name as labour_name FROM attendance a inner join project p on a.project_id=p.id inner join supervisor s on a.supervisor_id = s.id inner join labour l on a.labour_id= l.id;");
                                            if (mysqli_num_rows($run)) {
                                                while ($fetch = mysqli_fetch_assoc($run)) { ?>
                                                    <tr>
                                                        <td class="stud_id"><?= $fetch['id']; ?></td>
                                                        <td><?= $fetch['project_name'] ?></td>
                                                        <td><?= $fetch['labour_name'] ?></td>
                                                        <td><?= $fetch['supervisor_name'] ?></td>
                                                        <td><?php echo $fetch['date']; ?></td>
                                                        <?php if ($_SESSION['role'] == "ADMIN") { ?>
                                                            <td><a class="delete_btn"><i class="bx bxs-trash-alt" style="font-size: 160%;"></i></a></td>
                                                        <?php } ?>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
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