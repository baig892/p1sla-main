<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Labours</title>
    <?php include '../inc/head.php' ?>
</head>

<body>
    <?php
    if(isset($_REQUEST['approveRequestedPay'])) {
        $labour_pay_id = $_REQUEST['labour_pay_id'];
        $sql = "UPDATE labour_pay set ack=1 WHERE id=$labour_pay_id";
        mysqli_query($conn,$sql);
    }
    if (isset($_REQUEST['submitRequestPay'])) {
        $supervisor_id = $_REQUEST['supervisor_id'];
        $labour_id = $_REQUEST['labour_id'];
        $date = $_REQUEST['date'];
        $amount = $_REQUEST['amount'];
        $sql = "INSERT INTO labour_pay (supervisor_id,labour_id,date,amount, ack) VALUES ('$supervisor_id','$labour_id','$date','$amount','0')";
        echo $sql;
        try {
            $rs = mysqli_query($conn, $sql);
            if ($rs) {
                $status = true;
                $message = "Pay requested successfully.";
            } else {
                $status = false;
                $message = "Pay requested failed.";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Duplicate row
                $status = false;
                $message = "Pay is already present in the database.";
            } else {
                $status = false;
                $message = "Pay to database is failed due to: " . $e;
                throw $e;
            }
        }
    }
    ?>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Labours</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Labours</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">Labour Pay</h5>
                                    <?php
                                    // if ($_SESSION['role'] == "ADMIN") { 
                                    ?>
                                    <form method='post' action="<?= $_SERVER['PHP_SELF'] ?>" class="row g-3 needs-validation" novalidate>
                                        <div class="col-sm-10">
                                            <label for="labour_id" class="form-label">Labour: </label>
                                            <select class="form-select" name="labour_id" required>
                                                <option></option>
                                                <?php
                                                $sql = "SELECT id,name FROM labour";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_row($result)) {
                                                        echo "<option value='$row[0]'";
                                                        if (isset($_REQUEST['labour_id'])) {
                                                            $sid = $_REQUEST['labour_id'];
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
                                    <?php
                                    //}
                                    if (isset($_REQUEST['labour_id'])) {
                                    ?>
                                        <h5 class="card-title">Labour Table</h5>
                                        <table class="table table-borderless datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Supervisor</th>
                                                    <th scope="col">Working Days</th>
                                                    <th scope="col">Unit Pay</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Paid</th>
                                                    <th scope="col">Balance</th>
                                                    <th scope="col" data-sortable="false">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $retrieve = "select COUNT(attendance.id) as working_days, labour.pay, supervisor.id as supervisor_id, supervisor.name as supervisor_name
                                            from attendance
                                            inner join labour on attendance.labour_id = labour.id
                                            INNER join supervisor on attendance.supervisor_id = supervisor.id
                                            where labour_id = " . $_REQUEST['labour_id'] . "
                                            group by supervisor_id";
                                                if ($result = mysqli_query($conn, $retrieve)) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                        <tr>
                                                            <td>
                                                                <?= $row['supervisor_name']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $row['working_days']; ?>
                                                            </td>
                                                            <td>
                                                                <?= $row['pay']; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $total = $row['working_days'] * $row['pay'];
                                                                echo $total;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $paid_row = mysqli_fetch_row(mysqli_query(
                                                                    $conn,
                                                                    "select COALESCE(SUM(amount),0) as paid from labour_pay " .
                                                                        " where labour_id=" . $_REQUEST['labour_id'] .
                                                                        " and supervisor_id=" . $row['supervisor_id'] .
                                                                        " and ack=1"
                                                                ));
                                                                $paid = $paid_row[0];
                                                                echo $paid;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?= $total - $paid ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($_SESSION['role'] == "ADMIN") {
                                                                ?>
                                                                    <form method='post' action="<?= $_SERVER['PHP_SELF'] ?>" class="row g-3 needs-validation" novalidate>
                                                                        <input type="hidden" name="supervisor_id" value="<?= $row['supervisor_id'] ?>" />
                                                                        <input type="hidden" name="labour_id" value="<?= $_REQUEST['labour_id'] ?>" />
                                                                        <input type="hidden" name="date" value="<?= date('Y-m-d'); ?>" />
                                                                        <div class="col-md-8">
                                                                            <input type="text" class="form-control" name='amount' required placeholder="Amount" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <button type="submit" name="submitRequestPay" class="btn btn-primary">Request Pay</button>
                                                                        </div>
                                                                    </form>
                                                                    <?php } else {
                                                                    if ($requested_pay = mysqli_query($conn, "select amount,id from labour_pay where ack=0 and supervisor_id=" . $row['supervisor_id'] . " and labour_id=" . $_REQUEST['labour_id'])) {
                                                                        if ($requested_payrow = mysqli_fetch_assoc($requested_pay)) {
                                                                    ?>
                                                                            <form method='post' action="<?= $_SERVER['PHP_SELF'] ?>" class="row g-3 needs-validation" novalidate>
                                                                                <input type="hidden" name="labour_pay_id" value="<?= $requested_payrow['id'] ?>" />
                                                                                <div class="col-md-8">
                                                                                    <input type="text" readonly class="form-control" name='amount' required value="<?= $requested_payrow['amount'] ?>" />
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <button type="submit" name="approveRequestedPay" class="btn btn-primary">Approve</button>
                                                                                </div>
                                                                            </form>
                                                                <?php }
                                                                    }
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->
    <?php include '../inc/footer.php' ?>
</body>

</html>