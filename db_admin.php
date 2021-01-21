<?php

// This function will query the firstName and lastName using the provided $email, fetch the values of firstName and lastName and return them
function get_users_name($email){
    global $db;
    $query = 'SELECT firstName, lastName FROM administrators
              WHERE emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    $fname = $row['firstName'];
    $lname = $row['lastName'];
    return $fname." ".$lname;
}

// This function will query the permission level that the user is currently running.
function get_user_type($email){
    global $db;
    $query = 'SELECT UT.typeName FROM usertypes UT RIGHT OUTER JOIN administrators AD
              ON UT.typeID = AD.typeID
              WHERE AD.emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    $typeName = $row['typeName'];
    return $typeName;
}

// This function will query the permission level that the user is currently running.
function get_type_id($email){
    global $db;
    $query = 'SELECT UT.typeID FROM usertypes UT RIGHT OUTER JOIN administrators AD
              ON UT.typeID = AD.typeID
              WHERE AD.emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    $typeID = $row['typeID'];
    return $typeID;
}

// This function will query the password using the provided $email, fetch the values of password and verify the values match the stores hash code in the database, returning either true or false
function is_valid_admin_login($email, $user_password) {
    global $db;
    $query = 'SELECT password FROM administrators
              WHERE emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    $hash = $row['password'];
    return password_verify($user_password, $hash);
}

// This function will query all columns from the database with the provided $email, if the rowCount() comes back more than 0 the return will be true, and if not it will be false.
function email_exists($email){
    global $db;
    $query =
        'SELECT * FROM administrators
         WHERE emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();   
    return $statement->rowCount() > 0;
}

// This function will normalize the email before proceeding, ensuring if the user had capslock on that it wouldnt matter. Then if the email_exists() method returned TRUE we will throw an error.
// If it came back FALSE we will set a $hash variable to convert our password into a password hash. Then we will query the database to INSERT our data into their respective columns, and return a 
// success message
function add_admin($email, $user_password, $first_name, $last_name, $typeID) {

    $email = strtolower($email);

    if(email_exists($email) == true){
        $return_message = "Email already exists. User not created.";
    } else {
        global $db;
        $hash = password_hash($user_password, PASSWORD_DEFAULT);
        $query =
            'INSERT INTO administrators (emailAddress, password, firstName, lastName, typeID)
             VALUES (:email, :password, :firstname, :lastname, :typeid)';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':firstname', $first_name);
        $statement->bindValue(':lastname', $last_name);
        $statement->bindValue(':typeid', $typeID);
        $statement->execute();
        $statement->closeCursor();

        $return_message = "User was successfully created.";
    }

    return $return_message;
}

?>