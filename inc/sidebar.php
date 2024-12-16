<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
<!-- ======= Sidebar ======= -->

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="<?= $root; ?>index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <?php if ($_SESSION['role'] == "ADMIN") { ?>
            <li class="nav-item">
                <a class="nav-link <?= ($activePage == 'project-list' || $activePage == 'project') ? '' : 'collapsed'; ?>" data-bs-target="#projects-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-shop"></i><span>Projects</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="projects-nav" class="nav-content collapse <?= ($activePage == 'project-list' || $activePage == 'project') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= $root; ?>project/project-list.php" class="<?= ($activePage == 'project-list') ? 'active' : ''; ?>">
                            <i class="bi bi-list-ol"></i><span>All Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $root; ?>project/project.php" class="<?= ($activePage == 'project') ? 'active' : ''; ?>">
                            <i class="bi bi-plus"></i><span>Add New Project</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Projects Nav -->

            <li class="nav-item">
                <a class="nav-link <?= ($activePage == 'supervisor-list' || $activePage == 'supervisor' || $activePage == 'proj-super-list' || $activePage == 'project-super') ? '' : 'collapsed'; ?>" data-bs-target="#supervisor-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-person-circle"></i><span>Supervisors</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="supervisor-nav" class="nav-content collapse <?= ($activePage == 'supervisor-list' || $activePage == 'supervisor' || $activePage == 'proj-super-list' || $activePage == 'project-super') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= $root; ?>supervisor/supervisor-list.php" class="<?= ($activePage == 'supervisor-list') ? 'active' : ''; ?>">
                            <i class="bi bi-list-ol"></i><span>All
                                Supervisors</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $root; ?>supervisor/supervisor.php" class="<?= ($activePage == 'supervisor') ? 'active' : ''; ?>"> <i class="bi bi-plus"></i><span>Add
                                New Supervisor</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $root; ?>proj-sup/proj-super-list.php" class="<?= ($activePage == 'proj-super-list') ? 'active' : ''; ?>">
                            <i class="bi bi-list-ol">
                            </i><span>All Assigned Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $root; ?>proj-sup/project-super.php" class="<?= ($activePage == 'project-super') ? 'active' : ''; ?>">
                            <i class="bi bi-plus"></i><span>Assign Project</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Supervisors Nav -->
        <?php } ?>

        <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'budget' || $activePage == 'project-budget' || $activePage == 'supervisor-budget') ? '' : 'collapsed'; ?>" data-bs-target="
                #budget-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-currency-dollar"></i><span>Budget</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="budget-nav" class="nav-content collapse <?= ($activePage == 'budget' || $activePage == 'project-budget' || $activePage == 'supervisor-budget') ? 'show' : ''; ?>" data-bs-parent="
                #sidebar-nav">
                <?php if ($_SESSION['role'] == "ADMIN") { ?>
                    <li>
                        <a href="<?= $root; ?>budget/budget.php" class="<?= ($activePage == 'budget') ? 'active' : ''; ?>">
                            <i class="bi bi-plus"></i><span>Add New Budget</span>
                        </a>
                    </li>
                    <!-- <li>
                    <a href="<?= $root; ?>budget/project-budget.php" class="<?= ($activePage == 'project-budget') ? 'active' : ''; ?>">
                        <i class="bi bi-list-ol"></i><span>Project Budget</span>
                    </a>
                </li> -->
                <?php } ?>
                <li>
                    <a href="<?= $root; ?>budget/supervisor-budget.php" class="<?= ($activePage == 'supervisor-budget') ? 'active' : ''; ?>">
                        <i class="bi bi-list-ol"></i><span>Supervisor Budget</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Budget Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'expense' || $activePage == 'project-expense' || $activePage == 'supervisor-expense') ? '' : 'collapsed'; ?>" data-bs-target="#expense-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-stack"></i><span>Expenses</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="expense-nav" class="nav-content collapse 
            <?= ($activePage == 'expense' || $activePage == 'project-expense' || $activePage == 'supervisor-expense') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= $root; ?>expense/expense.php" class="<?= ($activePage == 'expense') ? 'active' : ''; ?>">
                        <i class="bi bi-plus"></i><span>Add New Expense</span>
                    </a>
                </li>

                <?php if ($_SESSION['role'] == "ADMIN") { ?>
                    <!-- <li>
                    <a href="<?= $root; ?>expense/project-expense.php" class="<?= ($activePage == 'project-expense') ? 'active' : ''; ?>">
                        <i class="bi bi-list-ol"></i><span>Project Expenses</span>
                    </a>
                </li> -->
                <?php } ?>

                <li>
                    <a href="<?= $root; ?>expense/supervisor-expense.php" class="<?= ($activePage == 'supervisor-expense') ? 'active' : ''; ?>">
                        <i class="bi bi-list-ol"></i><span>Supervisor Expenses</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Expenses Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($activePage == 'labour' || $activePage == 'labour-list' || $activePage == 'attendance-list' || $activePage == 'attendance-sheet' || $activePage == 'labour-pay') ? '' : 'collapsed'; ?>" data-bs-target="#labour-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>Labour</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="labour-nav" class="nav-content collapse <?= ($activePage == 'labour' || $activePage == 'labour-list' || $activePage == 'attendance-list' || $activePage == 'attendance-sheet' || $activePage == 'labour-pay') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= $root; ?>labour/labour.php" class="<?= ($activePage == 'labour') ? 'active' : ''; ?>">
                        <i class="bi bi-plus"></i><span>Add New Labour</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $root; ?>labour/labour-list.php" class="<?= ($activePage == 'labour-list') ? 'active' : ''; ?>">
                        <i class="bi bi-list-ol"></i><span>All Labours</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $root; ?>labour/labour-pay.php" class="<?= ($activePage == 'labour-pay') ? 'active' : ''; ?>">
                        <i class="bi bi-list-ol"></i><span>Pay Labours</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $root; ?>attendance/attendance-list.php" class="<?= ($activePage == 'attendance-list') ? 'active' : ''; ?>">
                        <i class="bi bi-list-check"></i><span>Attendance List</span>
                    </a>
                </li>
                <?php if ($_SESSION['role'] == "SUPERVISOR") { ?>
                    <li>
                        <a href="<?= $root; ?>attendance/attendance-sheet.php" class="<?= ($activePage == 'attendance-sheet') ? 'active' : ''; ?>">
                            <i class="bi bi-list-check"></i><span>Attendance sheet</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </li><!-- End Expenses Nav -->

        <!-- <li class="nav-heading">Pages</li> -->

    </ul>


</aside><!-- End Sidebar-->