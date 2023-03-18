<?php
$loginPressed = filter_input(INPUT_POST, 'loginbtn');
if(isset($loginPressed)) {
    $email = filter_input(INPUT_POST, 'txtEmail');
    $password = filter_input(INPUT_POST, 'txtPassword');
    $user = login($email, $password);
    if (trim($email) == '' || trim($password) == '') {
        echo '<div> Please fill email and password </div>';
    } else{
        if($user['email'] == $email){
            $_SESSION['is_user_logged'] = true;
            $_SESSION['user_name'] = $user['Name'];
            header('location:index.php');
        } else{
            echo'<div>Invalid Email or Password</div>';
        }
    }
}
?>

<form method="post">
    <div>
        <label for="txtEmail" class="col-sm-2 col-form-label">E-Mail Address</label>
        <div class="col-sm-10">
            <input type="email" maxlength="100" required autofocus name="txtEmail" 
            id="txtEmail" placeholder="E-mail" class="form-control">
        </div>
    </div>
    <div>
        <label for="txtPassword" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" maxlength="100" required autofocus name="txtPassword" 
            id="txtPassword" placeholder="Password" class="form-control">
        </div>
    </div>
    <br>
    <input type="submit" class="btn btn-primary col-sm-2" value="Log In" name="loginbtn">
</form>
