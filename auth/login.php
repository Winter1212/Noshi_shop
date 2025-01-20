<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php 
$error_message = ''; // Variable to store error messages

if (isset($_POST['submit'])) {
    // Check if any input is empty
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = 'Email & Password cannot be empty!';
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            // Use a prepared statement to prevent SQL injection
            $login = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $login->bindParam(':email', $email, PDO::PARAM_STR);
            $login->execute();

            // Fetch user data
            $fetch = $login->fetch(PDO::FETCH_ASSOC);

            if ($fetch && $login->rowCount() > 0) {
                // Verify the password
                if (password_verify($password, $fetch['mypassword'])) {
                    // Successful login
                    // Redirect to the dashboard or another page
                    header("Location: " . APPURL . "/dashboard.php");
                    exit;
                } else {
                    $error_message = 'Incorrect password. Please try again!';
                }
            } else {
                $error_message = 'No account found with this email address!';
            }
        } catch (PDOException $e) {
            $error_message = 'Error: ' . $e->getMessage();
        }
    }
}
?>

<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">Login Page</h1>
                <p class="lead">Save time and leave the groceries to us.</p>

                <div class="card card-login mb-5">
                    <div class="card-body">
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form class="form-horizontal" method="POST" action="login.php">
                            <div class="form-group row mt-3">
                                <div class="col-md-12">
                                    <input class="form-control" name="email" type="email" required placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input class="form-control" name="password" type="password" required placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group row text-center mt-4">
                                <div class="col-md-12">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block text-uppercase">Log In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "../includes/footer.php"; ?>
