<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <a class="btn btn-success" href="/employee">Create Employee</a>
    <h1>Employees</h1>
        <?php
        foreach ($this->employees as $employee) {
            ?>
            <div class="employee">
                <ul>
                    <li><?php echo $employee->getFirstName().' '.$employee->getLastName() ?></li>
                    <li><?php echo $employee->getPhone()?></li>
                    <li><?php echo $employee->getEmail()?></li>
                    <li><a class="btn btn-primary" href="/employee/<?php echo $employee->getId() ?>">Edit</a> </li>
                    <li>
                        <form action="/employee/<?php echo $employee->getId() ?>/delete" method="POST">
                            <input type="submit" value="submit" class="btn btn-danger">
                        </form>
                    </li>
                </ul>
            </div>
            <?php
        }
        ?>
</div>
</body>
</html>