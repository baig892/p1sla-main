<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project - Budget</title>
    <?php include '../inc/head.php' ?>
</head>

<body>

    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Project-Budget</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Project-Budget</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <form method='post' action='<?php echo $_SERVER['PHP_SELF'] ?>' class="row g-3 needs-validation" novalidate>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List of all budgets assgined to a Project</h5>
                                <div class="row mb-3">
                                    <label for="inputText" class="form-label">Project: </label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="project_id" required>
                                            <option></option>
                                            <?php
                                            $sql = "SELECT id,name FROM project";
                                            if ($result = mysqli_query($conn, $sql)) {
                                                while ($row = mysqli_fetch_row($result)) {
                                                    echo "<option value='$row[0]'";
                                                    if (isset($_REQUEST['project_id'])) {
                                                        $pid = $_REQUEST['project_id'];
                                                        if($pid === $row[0])
                                                            echo 'selected="selected"';
                                                    }
                                                    echo ">$row[1]</option>";
                                                }
                                                mysqli_free_result($result);
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-12" style="margin-top: 20px;">
                                        <input class="btn btn-primary" name='submit' type="submit">
                                    </div>
                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Supervisor</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Acknowledge</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_POST['submit'])) {
                                                $project_id = $_REQUEST['project_id'];
                                                $sql = "SELECT * FROM budget where budget.project_id=" . $project_id;
                                                $rs = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($rs)) {
                                                    while ($row = mysqli_fetch_assoc($rs)) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $rs_supervisor = mysqli_query($conn, "SELECT * FROM supervisor where id=" . $row['supervisor_id']);
                                                                echo mysqli_fetch_assoc($rs_supervisor)['name'];
                                                                ?>
                                                            </td>
                                                            <td><?= $row['amount']; ?></td>
                                                            <td><?= $row['date']; ?></td>
                                                            <?php if ($row['ack'] == 1) { ?>
                                                                <td><span class="badge bg-success">Approved</span></td>
                                                            <?php } else { ?>
                                                                <td><span class="badge bg-danger">Pending</span></td>
                                                            <?php } ?>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form><!-- End Custom Styled Validation -->
                </div>
            </div>
        </section>
    </main>
    <?php include '../inc/footer.php' ?>
</body>

</html>