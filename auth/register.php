<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
$error_message = ''; // Variable to store error messages

if (isset($_POST['submit'])) {
    // Check if any input is empty
    if (empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['username'])) {
        $error_message = 'One or more inputs are empty';
    } else {
        if ($_POST['password'] === $_POST['confirm_password']) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Use password hashing for security
            $username = $_POST['username'];
            $image = 'user.png'; // Hardcoded value for the image

            try {
                // Assuming $conn is your PDO connection
                $insert = $conn->prepare("INSERT INTO users (fullname, email, username, mypassword, image) VALUES (:fullname, :email, :username, :mypassword, :image)");

                // Bind parameters
                $insert->bindParam(':fullname', $fullname);
                $insert->bindParam(':email', $email);
                $insert->bindParam(':username', $username);
                $insert->bindParam(':mypassword', $password);
                $insert->bindParam(':image', $image);

                // Execute the query and check the result
                if ($insert->execute()) {
                    
                    // Redirect to login page after successful registration
                    // header("Location:".APPURL."/login.php");
                    echo "<script> window.location.href='login.php'; </script>";
                    echo "<script> alert('Register have been successfully!');</script>";
                    exit;
                } else {
                    $error_message = 'Error: Could not register user';
                }
            } catch (PDOException $e) {
                $error_message = 'Error: ' . $e->getMessage();
            }
        } else {
            $error_message = 'Password does not match!';
        }
    }
}
?>






<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">
                    Register Page
                </h1>
                <p class="lead">
                    Save time and leave the groceries to us.
                </p>

                <div class="card card-login mb-5">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="register.php">
                            <div class="form-group row mt-3">
                                <div class="col-md-12">
                                    <input class="form-control" name="fullname" type="text" required="" placeholder="Full Name" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <div class="col-md-12">
                                    <input class="form-control" name="email" type="email" required="" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                                </div>
                            </div>
                            
                            <div class="form-group row mt-3">
                                <div class="col-md-12">
                                    <input class="form-control" name="username" type="text" required="" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input class="form-control" name="password" type="password" required="" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input class="form-control" name="confirm_password" type="password" required="" placeholder="Confirm Password">
                                </div>
                            </div>

                            <?php if ($error_message): ?>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <span style="color: red;"><?php echo $error_message; ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="form-group row text-center mt-4">
                                <div class="col-md-12">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block text-uppercase">Register</button>
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
