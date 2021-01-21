<?php

// Checking to see if we have started a session yet, and if not we are starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('../Models/database.php');
require_once('../Models/validate.php');
require_once('../Models/category_db.php');

// If the user_id stored in the session isnt equal to 1 or 2, it will redirect the user to the persmission_error.php
if($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 2){
    include('../Views/permission_error.php');
    exit();
}

//Setting our default values to empty string if they don't exist
if(!isset($email)){ $email = ''; }
if(!isset($first_name)){ $first_name = ''; }
if(!isset($last_name)){ $last_name = ''; }
if(!isset($add_return_value)){ $add_return_value = ''; }

// Get all permissions
$permissions = get_permissions();

?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Add User Form</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<!-- the body section -->
<body>

    <div class="container">

        <main>
            <h1>Add User</h1><br>

            <form action="../Controllers/add_user.php" method="post"
                id="add_user_form">

                <!-- Using a foreach we will assign the values of the permission level drop down based on whats stored in our database -->
                <div class="form-group">
                    <label>Permission Level:</label>
                    <?php if(isset($permission_error) && $permission_error != ''){ ?>
                        <h3 class='text-danger'><?php echo $permission_error; ?></h3>
                    <?php } ?>
                    <select class="form-control" name="permission_id">
                    <?php foreach ($permissions as $userType) : ?>
                        <option value="<?php echo $userType['typeID']; ?>">
                            <?php echo $userType['typeName']; ?>
                        </option>
                    <?php endforeach; ?>
                    </select><br>
                </div>

                <!-- start of the email/username section -->
                <div class="form-group">

                    <label for="code">Username/Email:</label>

                    <?php if(isset($email_error) && $email_error != ''){ ?>
                        <h5 class='text-danger'><?= $email_error; ?></h3>
                    <?php } ?>

                    <input class="form-control" type="email" name="email" id="email"
                    value="<?= htmlspecialchars($email); ?>"><br>
                </div>

                <!-- start of the first name section -->
                <div class="form-group">
                    <label for="name">First Name:</label>
                    <?php if(isset($firstname_error) && $firstname_error != ''){ ?>
                        <h5 class='text-danger'><?= $firstname_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="text" name="first_name" id="first_name"
                    value="<?= htmlspecialchars($first_name); ?>"><br>
                </div>

                <!-- start of the Last Name section -->
                <div class="form-group">
                    <label for="name">Last Name:</label>
                    <?php if(isset($lastname_error) && $lastname_error != ''){ ?>
                        <h5 class='text-danger'><?= $lastname_error; ?></h3>
                    <?php } ?>
                    <input class="form-control" type="text" name="last_name" id="last_name"
                    value="<?= htmlspecialchars($last_name); ?>"><br>
                </div>

                <!-- start of the Password section -->
                <div class="form-group">

                    <label for="password">Password:</label>

                    <?php if(isset($password_error) && $password_error != ''){ ?>
                        <h5 class='text-danger'><?= $password_error; ?></h3>
                    <?php } ?>

                    <input class="form-control" type="password" name="user_password" id="user_password"
                    value=""><br>
                </div>

                <!-- start of the Confirm Password section -->
                <div class="form-group">

                    <label for="confirm_password">Confirm Password:</label>

                    <?php if(isset($confirm_password_error) && $confirm_password_error != ''){ ?>
                        <h5 class='text-danger'><?= $confirm_password_error; ?></h3>
                    <?php } ?>

                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" value=""><br>
                </div>

                <!-- Submit button for the form -->
                <label>&nbsp;</label>
                <input class="btn btn-primary" type="submit" value="Add User">
                <a class="btn btn-danger" href="../index.php" role="button">Go Back</a>
                <?php if(isset($add_return_value) && $add_return_value != ''){ ?>
                    <h5 class='text-primary'><?= $add_return_value; ?></h3>
                <?php } ?>
                <br>
                <br>
            </form>
            
        </main>
    </div>

</body>
</html>