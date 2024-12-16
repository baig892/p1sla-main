<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Budget to Project/Supervisor</title>
    <?php include '../inc/head.php' ?>
</head>

<body>
    <?php
    $project_id = isset($_REQUEST['project_id']) ? $_REQUEST['project_id'] : '-1';

    if (isset($_REQUEST['submitBtn'])) {
        $supervisor_id = $_REQUEST['supervisor_id'];
        $amount =  $_REQUEST['amount'];
        $date =  $_REQUEST['date'];
        $sql = "INSERT INTO budget (project_id,supervisor_id,amount,date,ack) VALUES ('$project_id','$supervisor_id','$amount','$date','0')";
        echo $sql;
        try {
            $rs = mysqli_query($conn, $sql);
            if ($rs) {
                $status = true;
                $message = "Budget added successfully.";
            } else {
                $status = false;
                $message = "Data entry failed due to reason.";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Duplicate row
                $status = false;
                $message = "Budget is already present in the database.";
            } else {
                $status = false;
                $message = "Data entry failed due to reason: " . $e;
                throw $e; // in case it's any other error
            }
        }
    }
    ?>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Budget</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Budget</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <form name="addForm" id="addForm" method='post' action='budget.php' class="row g-3 needs-validation" novalidate>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add Budget to Project/Supervisor</h5>
                                <div class="row mb-3">
                                    <label for="project_id" class="form-label">Project: </label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="project_id" onchange="this.form.submit();" id="project_id" required>
                                            <option></option>
                                            <?php
                                            $sql = "SELECT id,name FROM project";
                                            if ($result = mysqli_query($conn, $sql)) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    echo "<option " . ($project_id == $row[0] ? 'selected=selected' : '') . " value='$row[0]'>$row[1]</option>";
                                                }
                                                mysqli_free_result($result);
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="supervisor_id" class="form-label">Supervisor: </label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="supervisor_id" id="supervisor_id" required>
                                            <option></option>
                                            <?php
                                            $sql = "SELECT id,name FROM supervisor as s " . (isset($_REQUEST['project_id']) ? " inner join project_supervisor as ps 
                                            where s.id=ps.supervisor_id and ps.project_id=$project_id" : "");
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
                                <div class="row mb-3">
                                    <label for="amount" class="form-label">Amount: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="amount" id="amount" required>
                                        <div class="invalid-feedback">
                                            Please Enter The Amount
                                        </div>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="date" class="form-label">Date: </label>
                                    <div class="col-sm-10">
                                        <input type="date" readonly="readonly"  value="<?= date('Y-m-d'); ?>" class="form-control" id="date" name="date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input class="btn btn-primary" name="submitBtn" value="Submit" type="submit">
                                    <?php
                                    if (isset($status)) {
                                        if ($status == true) {
                                    ?>
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>
                                                    <?= $message ?>
                                                </strong>
                                                <a href='./project-budget.php'>Click here to see all project budgets.</a>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>
                                                    <?= $message ?>
                                                </strong>
                                                <a href='./project-budget.php'><br />Click here to see all project budgets.</a>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <?php include '../inc/footer.php' ?>
</body>

</html>