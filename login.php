<?php

session_start();
include 'common/sql/dataSqlMarriage.php';
include 'common/functions_file.php';

$error_heading = "Error";
$error_message = "";

if (isset($_POST['login-button']) && $_POST['login-button'] === 'login-user') {
    if (isset($_POST['login-input-email']) && isset($_POST['login-input-password'])) {

        $db_connection = openCon();

        $filtered_email = filter_var($_POST['login-input-email'], FILTER_SANITIZE_EMAIL);
        $login_email = inputCheck($db_connection, $filtered_email);

        $password_pattern = "/^[A-Z]{1}[A-Za-z0-9]{7,}$/";
        preg_match($password_pattern, $_POST['login-input-password'], $pattern_match);

        if (count($pattern_match) > 0) {
            if ($pattern_match[0] === $_POST['login-input-password']) {

                $login_password = inputCheck($db_connection, $_POST['login-input-password']);

                $user_login = "SELECT * FROM userAccounts WHERE (userEmail = '$login_email')";
                $result_set = $db_connection->query($user_login);

                if ($result_set->num_rows < 1) {
                    $error_message = "User not Found.";
                } else {
                    $user_found = $result_set->fetch_array();

                    $user_birthday = date('d-m-Y', strtotime($user_found['birthday']));
                    $user_country = $user_found['country'];
                    $password_salt = $login_email . $user_birthday;

                    $hashed_password = hash('sha512', $login_password . $password_salt);

                    if ($hashed_password !== $user_found['password']) {
                        $error_message = "Email and/or Password mismatch.";
                    } else {
                        $user_email = $user_found['userEmail'];
                        $_SESSION['winlott-valid-name'] = $user_email;

                        if (isset($_POST['remember-check']) && $_POST['remember-check'] === 'remember-me') {
                            $hours = time() + 3600 * 24 * 7;
                            setcookie('winlott-user', $user_email, $hours);
                            setcookie('remember-me', true, $hours);
                        }

                        if (isset($_SESSION['redirected-from'])) {
                            redirectTo(0.1, $_SESSION['redirected-from']);
                            $_SESSION['redirected-from'] = "";
                        } else {
                            redirectTo(0.1, 'photoFrame.php');
                        }

                    }
                }
            }
        } else {
            $error_message = "Invalid email or password";
        }
        closeCon($db_connection);
    }
}

if (isset($error_message) && !empty($error_message)) {
    dialog_modal($error_heading, $error_message);
}

?>

<!DOCTYPE html>
<html lang="en">

<?php
include 'common/header.html';
?>

<body>

<?php
include 'common/navbar.php';
?>

<div class="container outermost-div px-3 px-sm-5">
    <div class="card">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-6 d-none d-lg-flex">
                    <div class="flex-grow-1 bg-login-image"></div>
                </div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h4 class="text-dark mb-4">Sign In</h4>
                        </div>
                        <form class="user" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <input class="form-control form-control-user" type="email" id="login-input-email"
                                       aria-describedby="emailHelp" placeholder="Email Address"
                                       name="login-input-email">
                            </div>
                            <div class="form-group">
                                <input class="form-control form-control-user" type="password" id="login-input-password"
                                       placeholder="Password" name="login-input-password">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <div class="form-check">
                                        <input class="custom-control-input" type="checkbox" id="remember-check"
                                               name="remember-check" value="remember-me"">
                                        <label class="custom-control-label" for="remember-check">Remember Me</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block text-white btn-user" name="login-button"
                                    type="submit" value="login-user">Login
                            </button>
                            <hr>
                        </form>
                        <div class="text-center"><a class="small" href="/contact.php">Forgot Password?</a></div>
                        <div class="text-center"><a class="small" href="/register.php">Create an Account</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'common/footer.html';
?>
<script src="/js/login.js"></script>

</body>

</html>