<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<a class="create" href="<?php $this->router->generate('employee_form')?>">Create Employee</a>
<h1>Employees</h1>
    <?php
    foreach ($this->employees as $employee) {
        ?>
        <div class="employee">
            <ul>
                <li><?php echo $employee->getFirstName().' '.$employee->getLastName() ?></li>
                <li><?php echo $employee->getPhone()?></li>
                <li><?php echo $employee->getEmail()?></li>
                <li><a class="edit" href="<?php $this->router->generate('employee_form', ['id' => $employee->getId()])?>">Edit</a> </li>
                <li><a class="delete" href="<?php $this->router->generate('delete', ['id' => $employee->getId()])?>">Delete</a></li>
            </ul>
        </div>
        <?php
    }
    ?>
</ul>
</body>
</html>