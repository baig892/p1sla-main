<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project - Expenses</title>
    <?php include '../inc/head.php' ?>
</head>

<body>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Project-Expense</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Project-Expense</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <form method='post' action='<?php echo $_SERVER['PHP_SELF'] ?>' class="row g-3 needs-validation" novalidate>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List of all expenses occured in a Project</h5>
                                <!-- Custom Styled Validation -->
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
                                                        if ($pid === $row[0])
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
                                                <th scope="col">Description</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Bill</th>
                                                <th scope="col">Acknowledge</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($_POST['submit'])) {
                                                $pid = $_REQUEST['project_id'];
                                                $sql = "SELECT * FROM expense  where expense.project_id=" . $pid;
                                                $run = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($run)) {
                                                    while ($fetch = mysqli_fetch_assoc($run)) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                $rs_supervisor = mysqli_query($conn, "SELECT * FROM supervisor where id=" . $fetch['supervisor_id']);
                                                                echo mysqli_fetch_assoc($rs_supervisor)['name'];
                                                                ?>
                                                            </td>
                                                            <td><?= $fetch['expense']; ?></td>
                                                            <td><?= $fetch['description']; ?></td>
                                                            <td><?= $fetch['date']; ?></td>
                                                            <td> <a target="_blank" href="upload/<?= $fetch['bill']; ?>"><?= $fetch['bill']; ?></a></td>
                                                            <?php if ($fetch['ack'] == 1) { ?>
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
                                <div class="col-12">
                                    <form action = "createzip.php" method="GET">
                                        <button type="submit" class="btn btn-primary downzip">All download</button>
                                    </form>
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