<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
require_once "layouts/config.php";

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password, isvalid, is_admin FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $isvalid, $isadmin);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION['clock_in'] = isset($_SESSION['clock_in']) && $_SESSION['clock_in'] == 1 ? 1 : 0;
                            header("location: index.php");
                        } else {
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<?php include 'layouts/main.php'; ?>

<head>
    <title>Login | Admin Panel</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>
    <style>
        body {
            background: linear-gradient(to right,rgb(184, 186, 196),rgb(125, 98, 153));
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container img {
            width: 80px;
            margin-bottom: 10px;
        }

        .login-container h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-control {
            border-radius: 30px;
            padding: 10px 15px;
            font-size: 16px;
        }

        .btn-primary {
            background: #667eea;
            border: none;
            border-radius: 30px;
            padding: 12px;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #564caf;
        }

        .form-floating-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #aaa;
        }

        .text-danger {
            font-size: 14px;
        }

        .auth-pass-inputgroup {
            position: relative;
        }

        .auth-pass-inputgroup button {
            border: none;
            background: transparent;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="assets/images/logo-sm.svg" alt="Logo">
        <h3>Welcome Back!</h3>
        <p class="text-muted">Sign in to continue.</p>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-floating form-floating-custom mb-4">
                <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>" name="username" placeholder="Enter User Name">
                <span class="text-danger"><?php echo $username_err; ?></span>
            </div>

            <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                <button type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                <span class="text-danger"><?php echo $password_err; ?></span>
            </div>

            <!-- <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="remember-check">
                <label class="form-check-label" for="remember-check">Remember me</label>
            </div> -->

            <button class="btn btn-primary w-100" type="submit">Log In</button>
        </form>

        <p class="mt-4 text-muted mb-0">© <?php echo date('Y'); ?> Admin Panel. Made with <i class="mdi mdi-heart text-danger"></i> by Rahat It Solution</p>
    </div>

    <script>
        document.getElementById("password-addon").addEventListener("click", function () {
            let passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        });
    </script>
</body>
