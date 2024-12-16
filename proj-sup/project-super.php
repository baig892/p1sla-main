<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assign Project</title>
    <?php include '../inc/head.php' ?>
</head>

<body>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>

    <main id="main" class="main">

        <?php
        if (isset($_POST['submit'])) {
            $supervisor_id =  $_REQUEST['supervisor_id'];
            $project_id =  $_REQUEST['project_id'];

            $sql = "INSERT INTO project_supervisor(project_id,supervisor_id)  VALUES ('$project_id','$supervisor_id') ";
            try {
                $rs = mysqli_query($conn, $sql);
                if ($rs) {
                    $status = true;
                    $message = "Supervisor is assigned to a project successfully.";
                } else {
                    $status = false;
                    $message = "Supervisor is already assigned to this project.";
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) {
                    // Duplicate row
                    $status = false;
                    $message = "Supervisor is already assigned to this project.";
                } else {
                    throw $e; // in case it's any other error
                    $status = false;
                    $message = "Data entry failed due to reason: " . $e;
                }
            }
        }
        ?>

        <div class="pagetitle">
            <h1>Assign Project</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Assign Project</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-10">
                    <form action='#' method='post' class="row g-3 needs-validation" novalidate>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Assign Project</h5>
                                <div class="row mb-3">
                                    <label for="supervisor_id" class="col-sm-2 col-form-label"
                                        style="padding:0px ;">Supervisor: </label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="supervisor_id" required>
                                            <option></option>
                                            <?php
                                            // $sql = "SELECT id,name FROM supervisor as s " . (isset($_POST['project_id'])? " inner join project_supervisor as ps where s.id=ps.supervisor_id": "");
                                            $sql = "SELECT id,name FROM supervisor";
                                            if ($result = mysqli_query($conn, $sql)) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='". $row['id'] . "'>". $row['name']."</option>";
                                                }
                                                mysqli_free_result($result);
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="project_id" class="col-sm-2 col-form-label" style="padding:3px;">Project: </label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="project_id" required>
                                            <option></option>
                                            <?php
                                            $sql = "SELECT id,name FROM project";
                                            if ($result = mysqli_query($conn, $sql)) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    echo "<option value='$row[0]'>$row[1]</option>";
                                                }
                                                mysqli_free_result($result);
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    <?php
                                    if (isset($status)) { 
                                        if($status == true) {
                                    ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>
                                            <?= $message ?>
                                        </strong>
                                        <a href='./proj-super-list.php'><br />Click here to see list of supervisors
                                            assigned to projects.</a>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <?php
                                    } else {
                                    ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>
                                            <?= $message ?>
                                        </strong>
                                        <a href='./proj-super-list.php'><br />Click here to see list of supervisors
                                            assigned to projects.</a>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <?php
                                    }}
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <?php include '../inc/footer.php' ?>
</body>

</html>