<?php include '../inc/valid_session.php' ?>
<html>

<head>
    <title>Attendance sheet</title>
    <?php include '../inc/head.php' ?>
</head>
<body>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <?php
    if (isset($_POST['project_id']) && isset($_POST['labour_id']) && isset($_POST['date'])) {
        $date = $_POST['date'];
        $labour_id = $_POST['labour_id'];
        $project_id = $_POST['project_id'];
        $attendance_id = isset($_POST['attendance_id']) ? $_POST['attendance_id'] : -1;
        $supervisor_id = $_SESSION["id"];
        if ($attendance_id != -1) {
            $sql = "UPDATE `attendance` SET labour_id='$labour_id', date='$date', project_id='$project_id', supervisor_id=$supervisor_id WHERE id=$attendance_id";
        } else {
            $sql = "INSERT INTO `attendance` (`project_id`, `labour_id`, `date`, `supervisor_id`) value ($project_id,$labour_id,'$date', $supervisor_id)";
        }
        try {
            $rs = mysqli_query($conn, $sql);
            if ($rs) {
                $status = true;
                $message = "Attendence submitted successfully.";
            } else {
                $status = false;
                $message = "Attendence is already submitted for this project.";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $status = false;
                $message = "Attendence is already submitted for this project.";
            } else {
                $status = false;
                $message = "Data entry failed due to reason: " . $e;
            }
        }
    }
    ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Attendence Sheet</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Attendance Sheet</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="card" style="overflow-x: auto;">
                    <div class="card-body">
                        <h5 class="card-title">Attendance Sheet</h5>
                        <?php if (isset($status) && $status == true) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>
                                <?= $message ?>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php } else if (isset($status) && $status == false) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>
                                <?= $message ?>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>
                        <table>
                            <thead>
                                <tr>
                                    <?php
                                    $y = date("Y");
                                    $m = date("m");
                                    $dd = date("d");
                                    $f = date("F");
                                    echo "<th>$f</th>";
                                    $d = cal_days_in_month(CAL_GREGORIAN, $m, $y);
                                    for ($i = 1; $i <= $d; $i++) {
                                        echo '<th><center>' . $i . '</center></th>';
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($labour_rs = mysqli_query($conn, "SELECT * FROM labour")) {
                                    while ($labour_row = mysqli_fetch_assoc($labour_rs)) {
                                        $labour_id = $labour_row['id'];
                                        echo '<tr>';
                                        echo '<td>' . $labour_row['name'] . '</td>';
                                        for ($col = 1; $col <= $d; $col++) {
                                            $today = "$y/$m/$col";
                                            $found = false;
                                            $options = "";
                                            $supervisor_id_found_existing = -1;
                                            if ($project_rs = mysqli_query($conn, "SELECT id,name FROM project")) {
                                                while ($project_row = mysqli_fetch_assoc($project_rs)) {
                                                    $project_id = $project_row['id'];
                                                    $options .= "<option value=$project_id ";
                                                    $attendance_sql = "SELECT id, supervisor_id FROM attendance as a WHERE a.project_id=$project_id AND a.labour_id=$labour_id AND a.date='$today'";
                                                    if ($attendance_rs = mysqli_fetch_assoc(mysqli_query($conn, $attendance_sql))) {
                                                        $attendance_id = $attendance_rs['id'];
                                                        $supervisor_id_found_existing = $attendance_rs['supervisor_id'];
                                                        $found = true;
                                                        $options .= " selected='selected' ";
                                                    }
                                                    $options .= ">" . $project_row['name'] . "</option>";
                                                }
                                                mysqli_free_result($project_rs);
                                            }
                                            echo "<td>";
                                            echo '<form method="post" action="attendance-sheet.php" class="needs-validation" novalidate>';
                                            echo "<input type='hidden' name='labour_id' value=$labour_id />";
                                            echo "<input type='hidden' name='date' value=$today />";
                                            echo '<select name="project_id" onchange="this.form.submit()" ';
                                            $disabled  =  $supervisor_id_found_existing !=-1 && $supervisor_id_found_existing != $_SESSION['id'] ? 'disabled' : '';
                                            echo $disabled . ' style="max-width:100px">';
                                            echo "<option></option>";
                                            echo $options;
                                            echo "</select>";
                                            if ($found)
                                                echo '<input type="hidden" name="attendance_id" value="' . $attendance_id . '" />';
                                            echo "</form>";
                                            echo "</td>";
                                        }
                                        echo "</tr>";
                                    }
                                    mysqli_free_result($labour_rs);
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include '../inc/footer.php' ?>
</body>
</html>