<?php
$edit = isset($this->data) ? true : false;
$submit_url = $edit === true ? '/employee/'.$this->data['id'] : '/employee';
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
<?php
    if (isset($this->errors)) {
        echo '<div class="alert-danger">'.$this->errors.'</div>';
    }
?>
<div class="container">
    <form action="<?php echo $submit_url ?>" method="POST">
        <div class="form-group">
            <label for="firstName">First Name: </label>
            <input class="form-control" id="firstName" type="text" name="firstName" value="<?php if ($edit) {echo $this->data['firstName'];}?>">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name: </label>
            <input class="form-control" id="lastName" type="text" name="lastName" value="<?php if($edit) {echo $this->data['lastName'];} ?>"> <br>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number: </label>
            <input class="form-control" type="text" name="phone" placeholder="555-555-5555" value="<?php if($edit) { echo $this->data['phone'];}?>">
        </div>
        <div class="form-group">
            <label for="email">email: </label>
            <input class="form-control" id="email" type="text" name="email" value="<?php if($edit){ echo $this->data['email'];} ?>">
        </div>
        <div class="form-group">
            <label for="location">location: </label>
            <select class="form-control" name="location" id="location">
                <?php foreach ($this->locations as $location) {
                    if ($edit && $this->data['location'] === $location->getId()) {
                        echo '<option selected="selected" value="'.$location->getId().'">'.$location->getName().'</option>';
                    } else {
                        echo '<option value="'.$location->getId().'">'.$location->getName().'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <input type="submit" value="Submit" class="btn btn-success">
    </form>
</div>
</body>
</html>