<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Expense to Project/Supervisor</title>
    <?php include '../inc/head.php' ?>
</head>

<body>

    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>

    <?php
    $status = false;
    $message = "";
    $project_id = isset($_REQUEST['project_id']) ? $_REQUEST['project_id'] : '-1';

    if (isset($_POST['submitBtn'])) {
        $expense =  $_REQUEST['expense'];
        $description =  $_REQUEST['description'];
        $date =  $_REQUEST['date'];
        $supervisor_id =  $_REQUEST['supervisor_id'];

        $image = NULL;
        $sql = "INSERT INTO expense(project_id,supervisor_id,expense,description,date,bill) VALUES ($project_id,$supervisor_id,$expense,'$description','$date','$image')";
        $rs = mysqli_query($conn, $sql);
      
        $GLOBALS['pictureID']=mysqli_insert_id($conn);
        if ($rs == true) {
            if(isset($_FILES['bill'])){
                
                $fe = substr($_FILES["bill"]["name"], strrpos($_FILES["bill"]["name"], '.'));
                $target_dir = "";

                $GLOBALS['target_file'] = $target_dir . $pictureID.$fe;
                $tmp_name = $_FILES['bill']['tmp_name'];
                
                move_uploaded_file($tmp_name, 'upload/' . $target_file);
                  
            }
           
            $sql1="UPDATE expense SET bill='$target_file' where id=$pictureID";
            $rs1=mysqli_query($conn,$sql1);
            echo $rs1;
            
            $status = true;
            $message = "Expense is saved successfully.";
            
        } 
        else {
            $status = false;
            $message = "Expense not saved.";
        }
    }
        
    ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Expense</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Expense</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <form method='post' action='<?= $_SERVER['PHP_SELF'] ?>' class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add Expense to Project/Supervisor</h5>
                                <div class="row mb-3">
                                    <label for="project_id" class="form-label">Project: </label>
                                    <div class="col-sm-10">
                                        <select class="form-select" id="project_id" name="project_id" required onchange="this.form.submit();">
                                            <option></option>
                                            <?php
                                            $sql = "SELECT id,name FROM project";
                                            if (isset($_SESSION["role"]) && $_SESSION["role"] == "SUPERVISOR") {
                                                $supervisor_id = $_SESSION["id"];
                                                $sql .= " as p inner join project_supervisor ps on p.id=ps.project_id where ps.supervisor_id=$supervisor_id";
                                            }
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

                                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "ADMIN") { ?>
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
                                <?php } else {
                                    echo "<input type='hidden' name='supervisor_id' value='" . $_SESSION["id"] . "' />";
                                } ?>

                                <div class="row mb-3">
                                    <label for="expense" class="form-label">Expense Amount: </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="expense" id="expense" required>
                                        <div class="invalid-feedback">
                                            Please Enter The Expense Amount
                                        </div>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="form-label">Description: </label>
                                    <div class="col-sm-10">
                                        <textarea name='description' id="description" type='text' class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="date" class="form-label">Date: </label>
                                    <div class="col-sm-10">
                                        <input readonly="readonly" type="date" value="<?= date('Y-m-d'); ?>" class="form-control" id="date" name="date" required class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="bill" class="form-label">Bill Upload: </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" accept="image/*,application/pdf" name='bill' type="file" id="bill">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input class="btn btn-primary" name='submitBtn' type="submit">
                                    <?php
                                    if ($status == true) {
                                    ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>
                                                <?= $message ?>
                                            </strong>
                                            <a href='./supervisor-expense.php'>Click here to see all expenses per supervisor.</a>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php
                                    }
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