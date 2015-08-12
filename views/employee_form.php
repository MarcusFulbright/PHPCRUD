<?php
$edit = isset($this->data) ? true : false;
$submit_url = $edit === true ? '/employee/'.$this->data['id'] : '/employee';
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form action="<?php echo $submit_url ?>" method="POST">
    First Name: <input type="text" name="firstName" value="<?php if ($edit) {echo $this->data['firstName'];}?>"> <br>
    Last Name: <input type="text" name="lastName" value="<?php if($edit) {echo $this->data['lastName'];} ?>"> <br>
    Phone Number: <input type="text" name="phone" placeholder="555-555-5555" value="<?php if($edit) { echo $this->data['phone'];}?>">
    email: <input type="text" name="email" value="<?php if($edit){ echo $this->data['email'];} ?>">
    location:
    <select>
        <?php foreach ($this->locations as $location) {
            if ($edit && $this->data['location'] === $location->getId()) {
                echo '<option selected="selected" value="'.$location->getId().'">'.$location->getName().'</option>';
            } else {
                echo '<option value="'.$location->getId().'">'.$location->getName().'</option>';
            }
        }
        ?>
    </select>
    <input type="submit" value="Submit">
</form>
</body>
</html>