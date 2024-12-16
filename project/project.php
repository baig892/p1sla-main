<?php include '../inc/valid_session.php' ?>
<!DOCTYPE html>
<head>
    <title>Add New Project</title>
    <?php include '../inc/head.php' ?>
    <?php
    if (isset($_POST['submit'])) {
        $name = trim($_POST['project_name']);
        $sql = "INSERT INTO `project` ( `name` ) VALUES ('$name')";
        try {
            $rs = mysqli_query($conn, $sql);
            if ($rs) {
                $status = true;
                $message = "Project added successfully.";
            } else {
                $status = false;
                $message = "Project is already present in the list.";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                // Duplicate row
                $status = false;
                $message = "Project is already present in the list.";
            } else {
                throw $e; // in case it's any other error
                $status = false;
                $message = "Data entry failed due to reason: " . $e;
            }
        }
    }
    ?>
</head>

<body>
    <?php include '../inc/header.php' ?>
    <?php include '../inc/sidebar.php' ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Project</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Project</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <form method="post" action='<?php echo $_SERVER['PHP_SELF'] ?>' class="row g-3 needs-validation"
                        novalidate>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Add New Project</h5>
                                <!-- Custom Styled Validation -->
                                <div class="row mb-3">
                                    <label for="project_name" class="form-label">Project Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name='project_name' id="project_name"
                                            required />
                                        <div class="invalid-feedback">
                                            Please Enter The Project Name
                                        </div>
                                        <div class="valid-feedback">
                                            Looks Good!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input class="btn btn-primary" name='submit' type="submit">
                                    <?php if (isset($status)) { 
                                      if ($status==true) {
                                        ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>
                                            <?= $message ?>
                                        </strong>
                                        <a href='./project-list.php'>Click here to see list of projects.</a>
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
                                        <a href='./project-list.php'><br />Click here to see list of projects.</a>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <?php
                                    }}
                                    ?>
                                </div>
                            </div>
                        </div>
                    </form><!-- End Custom Styled Validation -->
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <?php include '../inc/footer.php' ?>
</body>

</html>