<?php
$edit = isset($this->data) ? true : false;
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form action="<?php echo $this->submit_url ?>" method="<?php echo $this->submit_method ?>">
    First Name: <input type="text" name="firstName" value="<?php if ($edit) {echo $this->data['firstName'];}?>"> <br>
    Last Name: <input type="text" name="lastName" value="<?php if($edit) {echo $this->data['lastName'];} ?>"> <br>
    Phone Number: <input type="text" name="phone" placeholder="555-555-5555" value="<?php if($edit) { echo $this->data['phone'];}?>">
    email: <input type="text" name="email" value="<?php if($edit){ echo $this->data['email'];} ?>">
    <input type="submit" value="Submit">
</form>
</body>
</html>