<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Expense List</title>
    <?php include '../inc/head.php' ?>
</head>

<body>
    <!-- ======= Header ======= -->
    <?php include '../inc/header.php' ?>
    <<!-- End Header -->
        <?php include '../inc/sidebar.php' ?>
        <?php
        if (isset($_GET['id'])) {
            // case 'customer':
            $query = 'DELETE FROM expense WHERE id = ' . $_GET['id'];
            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        }
        ?>
        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Expense Table</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item">Expense Table</li>
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
                                        <a class="icon" data-bs-toggle=" dropdown" style="float:right;"><i class="bi bi-three-dots"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                            <li class="dropdown-header text-start">
                                                <h6>Filter</h6>
                                            </li>
                                            <li><a class="dropdown-item" href="expense.php">Add Expense</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"> Expense Table</h5>
                                        <table class="table table-borderless datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Index</th>
                                                    <th scope="col">Project</th>
                                                    <th scope="col">Supervisor</th>
                                                    <th scope="col">Expense</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Bill</th>
                                                    <th scope="col" data-sortable="false">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $project_q = mysqli_query($conn, "SELECT * FROM project");
                                                $projectarray =  array();
                                                while ($project = mysqli_fetch_assoc($project_q)) {
                                                    $projectarray[] = $project;
                                                }
                                                $supervisor = mysqli_query($conn, "SELECT * FROM supervisor");
                                                $supervisorarr =  array();
                                                while ($super = mysqli_fetch_assoc($supervisor)) {
                                                    $supervisorarr[] = $super;
                                                }
                                                $run = mysqli_query($conn, "SELECT * FROM expense");
                                                if (mysqli_num_rows($run)) {
                                                    while ($fetch = mysqli_fetch_assoc($run)) { ?>
                                                        <tr>
                                                            <td><?php echo $fetch['id']; ?></td>
                                                            <td><?php
                                                                $rs_project = mysqli_query($conn, "SELECT * FROM project where id=" . $fetch['project_id']);
                                                                echo mysqli_fetch_assoc($rs_project)['name'];
                                                                ?></td>
                                                            <td><?php
                                                                foreach ($supervisorarr as $supervisor2) {
                                                                    if ($supervisor2['id'] == $fetch['supervisor_id']) {
                                                                        echo $supervisor2['name'];
                                                                    }
                                                                }
                                                                ?></td>
                                                            <td><?php echo $fetch['expense']; ?></td>
                                                            <td><?php echo $fetch['description']; ?></td>
                                                            <td><?php echo $fetch['date']; ?></td>
                                                            <td>
                                                                <a target="_blank" href="upload/<?php echo $fetch['bill']; ?>">
                                                                    <?php echo $fetch['bill']; ?>
                                                                </a>
                                                            </td>
                                                            <td><a href="expense-list.php?action=delete&id='<?php echo $fetch['id']; ?>'"><i class="bx bxs-trash-alt" style="font-size: 160%;"></i></a></td>
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
        <?php include '../inc/footer.php' ?>
</body>

</html>