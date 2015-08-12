<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<a class="create" href="/employee">Create Employee</a>
<h1>Employees</h1>
    <?php
    foreach ($this->employees as $employee) {
        ?>
        <div class="employee">
            <ul>
                <li><?php echo $employee->getFirstName().' '.$employee->getLastName() ?></li>
                <li><?php echo $employee->getPhone()?></li>
                <li><?php echo $employee->getEmail()?></li>
                <li><a class="edit" href="/employee/<?php echo $employee->getId() ?>">Edit</a> </li>
                <li>
                    <form action="/employee/<?php echo $employee->getId() ?>/delete" method="POST">
                        <input type="submit" value="submit">
                    </form>
                </li>
            </ul>
        </div>
        <?php
    }
    ?>
</body>
</html>