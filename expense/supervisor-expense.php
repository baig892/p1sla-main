<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Expense from Supervisor</title>
    <?php include '../inc/head.php' ?>
</head>

<body>

    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <?php
    if (isset($_GET['id'])) {
        $sql = "UPDATE expense SET ack='1' WHERE id=" . $_GET['id'];
        $rs = mysqli_query($conn, $sql);
        if ($rs) {
            $status = true;
            $message = "Expense approve successfully.";
        } else {
            $status = false;
            $message = "Expense not approved. Some error occured.";
        }
    } ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Expense from Supervisor</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Expense from Supervisor</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Expense from Supervisor</h5>


                            <div class="row mb-3">
                                <form method='post' action="<?= $_SERVER['PHP_SELF'] ?>" class="row g-3 needs-validation" novalidate>
                                    <?php if ($_SESSION['role'] == "ADMIN") { ?>
                                        <div class="col-sm-10">
                                            <label for="supervisor_id" class="form-label">Supervisor: </label>
                                            <select class="form-select" name="supervisor_id" required>
                                                <option></option>
                                                <?php
                                                $sql = "SELECT id,name FROM supervisor";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['id'] . "'";
                                                        if (isset($_REQUEST['supervisor_id'])) {
                                                            $supervisor_id = $_REQUEST['supervisor_id'];
                                                            if ($supervisor_id === $row['id'])
                                                                echo 'selected="selected"';
                                                        }
                                                        echo ">" . $row['name'] . "</option>";
                                                    }
                                                    mysqli_free_result($result);
                                                    
                                                }
                                                
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <input class="btn btn-primary" name='submitBtn' type="submit" >
                                        </div>
                                    <?php } ?>

                                </form>
                            </div>
                            <div class="row mb-3">
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Bill</th>
                                            <th scope="col">Acknowledge</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_REQUEST['supervisor_id']) || isset($_SESSION["id"])) {
                                            $supervisor_id = isset($_REQUEST['supervisor_id']) ? $_REQUEST['supervisor_id'] : $_SESSION["id"];
                                            $sql = "SELECT * FROM expense  where expense.supervisor_id=" . $supervisor_id;
                                            $rs = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($rs)) { ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $rs_project = mysqli_query($conn, "SELECT * FROM project where id=" . $row['project_id']);
                                                        echo mysqli_fetch_assoc($rs_project)['name'];
                                                        ?>
                                                    </td>
                                                    <td><?= $row['expense']; ?></td>
                                                    <td><?= $row['date']; ?></td>
                                                    <td>
                                                        <a target="_blank" href="upload/<?= $row['bill']; ?>"><?= $row['bill']; ?></a>
                                                    </td>
                                                    <?php
                                                    if ($row['ack'] == 1) {
                                                        echo "<td><span class='badge bg-success'>Approved</span></td>";
                                                    } else {
                                                        if ($_SESSION['role'] == "SUPERVISOR")
                                                            echo "<td><span class='badge bg-danger'>Pending</span></td>";
                                                        else
                                                            echo "<td><a href='supervisor-expense.php?id=" . $row["id"] . "'>Approve</a></td>";
                                                    }
                                                    ?>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                </table>
                            </div>
                            
                            <div class="col-12">
                                <a class="btn btn-primary" href="createzip.php?id=<?php echo $supervisor_id ?>">Check</a>
                                <!-- <form action = "createzip.php" method="GET">
                                    
                                    <button type="submit" >All download</button>
                                </form> -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include '../inc/footer.php' ?>

    <!-- <script>
        $(document).ready(function(){
    $('.downzip').click(function(<?php ?>){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'createzip.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            console.log(response)
        });
    });
});
</script> -->
</body>

</html>