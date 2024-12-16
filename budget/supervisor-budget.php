<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Budget given to Supervisor</title>
    <?php include '../inc/head.php' ?>
</head>

<body>

    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <?php
    if (isset($_GET['id'])) {
        $sql = "UPDATE budget SET ack='1' WHERE id=" . $_GET['id'];
        $rs = mysqli_query($conn, $sql);
        if ($rs) {
            $status = true;
            $message = "Budget approve successfully.";
        } else {
            $status = false;
            $message = "Budget not approved. Some error occured.";
        }
    }
    ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Budget given to Supervisor</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Budget given to Supervisor</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Budget given to Supervisor</h5>
                            <div class="row mb-3">
                                <?php if ($_SESSION['role'] == "ADMIN") { ?>
                                    <form method='post' action="<?= $_SERVER['PHP_SELF'] ?>" class="row g-3 needs-validation" novalidate>

                                        <div class="col-sm-10">
                                            <label for="supervisor_id" class="form-label">Supervisor: </label>
                                            <select class="form-select" name="supervisor_id" required>
                                                <option></option>
                                                <?php
                                                $sql = "SELECT id,name FROM supervisor";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_row($result)) {
                                                        echo "<option value='$row[0]'";
                                                        if (isset($_REQUEST['supervisor_id'])) {
                                                            $sid = $_REQUEST['supervisor_id'];
                                                            if ($sid === $row[0])
                                                                echo 'selected="selected"';
                                                        }
                                                        echo ">$row[1]</option>";
                                                    }
                                                    mysqli_free_result($result);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-10">
                                            <input class="btn btn-primary" name='submitBtn' type="submit">
                                        </div>
                                    </form>
                                <?php } ?>
                            </div>
                            <div class="row mb-3">
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Acknowledge</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_REQUEST['supervisor_id']) || isset($_SESSION["id"])) {
                                            $supervisor_id = isset($_REQUEST['supervisor_id']) ? $_REQUEST['supervisor_id'] : $_SESSION["id"];
                                            $sql = "select * from budget where budget.supervisor_id=" . $supervisor_id;
                                            $rs = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($rs)) {
                                                while ($row = mysqli_fetch_assoc($rs)) { ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            $rs_project = mysqli_query($conn, "SELECT name FROM project where id=" . $row['project_id']);
                                                            echo mysqli_fetch_assoc($rs_project)['name'];
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['amount']; ?></td>
                                                        <td><?php echo $row['date']; ?></td>

                                                        <?php
                                                        if ($row['ack'] == 1) {
                                                            echo "<td><span class='badge bg-success'>Approved</span></td>";
                                                        } else {
                                                            if ($_SESSION['role'] == "ADMIN")
                                                                echo "<td><span class='badge bg-danger'>Pending</span></td>";
                                                            else
                                                                echo "<td><a href='supervisor-budget.php?id=" . $row["id"] . "'>Approve</a></td>";
                                                        }
                                                        ?>
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

                </div>
            </div>
        </section>
    </main>

    <?php include '../inc/footer.php' ?>
</body>

</html>