<?php
require "../includes/header.php";
require "../config/config.php";

if (isset($_POST["submit"])) {
    try {
        // Retrieve POST data
        $pro_id = $_POST["pro_id"];
        $pro_title = $_POST["pro_title"];
        $pro_image = $_POST["pro_image"];
        $pro_price = $_POST["pro_price"];
        $pro_qty = $_POST["pro_qty"];
        $user_id = $_POST["user_id"];

        // Calculate subtotal
        $pro_subtotal = $pro_qty * $pro_price;

        // Prepare SQL query
        $insert = $conn->prepare("
            INSERT INTO cart (pro_id, pro_name, pro_image, pro_price, pro_qty, pro_subtotal, user_id)
            VALUES (:pro_id, :pro_title, :pro_image, :pro_price, :pro_qty, :pro_subtotal, :user_id)
        ");

        // Execute the query with parameter binding
        $insert->execute([
            ":pro_id" => $pro_id,
            ":pro_title" => $pro_title,
            ":pro_image" => $pro_image,
            ":pro_price" => $pro_price,
            ":pro_qty" => $pro_qty,
            ":pro_subtotal" => $pro_subtotal, // New field
            ":user_id" => $user_id,
        ]);

        echo "Product added to cart successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $select = $conn->prepare("SELECT * FROM products WHERE status = 1 AND id = :id");
    $select->execute([':id' => $id]);
    $product = $select->fetch(PDO::FETCH_OBJ);

    // Related products query
    $relateProducts = $conn->prepare("SELECT * FROM products WHERE status = 1 AND category_id = :category_id AND id != :id");
    $relateProducts->execute([':category_id' => $product->category_id, ':id' => $id]);
    $allrelateProducts = $relateProducts->fetchAll(PDO::FETCH_OBJ);

    // Validate if product already in cart
    if (isset($_SESSION['user_id'])) {
        $validate = $conn->prepare("SELECT * FROM cart WHERE pro_id = :id AND user_id = :user_id");
        $validate->execute([':id' => $id, ':user_id' => $_SESSION['user_id']]);
    }
}
?>

<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0"
            style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5"><?php echo htmlspecialchars($product->name); ?></h1>
                <p class="lead">Save time and leave the groceries to us.</p>
            </div>
        </div>
    </div>

    <div class="product-detail">
        <div class="container">
            <div class="row">
                <!-- Product Image Section -->
                <div class="col-sm-6">
                    <div class="slider-zoom" style="position: relative; z-index: -1000;">
                        <a href="<?php echo APPURL; ?>/assets/img/<?php echo $product->image; ?>" class="cloud-zoom"
                            id="cloudZoom">
                            <img alt="Detail Zoom Thumbs Image"
                                src="<?php echo APPURL; ?>/assets/img/<?php echo $product->image; ?>"
                                style="width: 300px; height: 300px; object-fit: contain; display: block; margin: 0 auto;">
                        </a>
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="col-sm-6">
                    <p><strong>Overview</strong><br><?php echo htmlspecialchars($product->description); ?></p>
                    <div class="row">
                        <div class="col-sm-6">
                            <p><strong>Price</strong> (/Pack)<br><span
                                    class="price"><?php echo number_format($product->price, 2); ?> $</span></p>
                        </div>
                    </div>

                    <p class="mb-1"><strong>Quantity</strong></p>

                    <!-- Form Section -->
                    <form method="POST" id="form-data">
                        <input type="hidden" name="pro_title" value="<?php echo $product->name; ?>">
                        <input type="hidden" name="pro_image" value="<?php echo $product->image; ?>">
                        <input type="hidden" name="pro_price" value="<?php echo $product->price; ?>">
                        <input type="hidden" name="user_id"
                            value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; ?>">

                        <input type="hidden" name="pro_id" value="<?php echo $product->id; ?>">
                        <input type="hidden" name="pro_subtotal" id="pro_subtotal" value="">
                        <div class="row mb-3">
                            <div class="col-sm-5">
                                <input class="form-control" type="number" min="1" value="1" name="pro_qty"
                                    placeholder="Quantity">
                            </div>
                            <div class="col-sm-6 align-self-center">
                                <span class="pt-1 d-inline-block">Pack (1000 gram)</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <?php if (isset($_SESSION['username'])): ?>
                                    <button name="submit" type="submit" class="btn-insert mt-3 btn btn-primary btn-lg" <?php echo ($validate && $validate->rowCount() > 0) ? 'disabled' : ''; ?>>
                                        <i class="fa fa-shopping-basket"></i>
                                        <?php echo ($validate && $validate->rowCount() > 0) ? 'Added to Cart' : 'Add to Cart'; ?>
                                    </button>
                                <?php else: ?>
                                    <div class="alert alert-success bg-success text-white text-center">
                                        Log in to buy this product or add to cart.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section id="related-product">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Related Products</h2>
                    <div class="product-carousel owl-carousel">
                        <?php foreach ($allrelateProducts as $relateProduct): ?>
                            <div class="item" style="display: flex; flex-direction: column; flex: 1 0 30%; margin: 10px;">
                                <div class="card card-product" style="display: flex; flex-direction: column; height: 100%;">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">FRESH</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">Until
                                                <?php echo $relateProduct->exp_date; ?></span>
                                            <span class="badge badge-primary">20% OFF</span>
                                        </div>
                                        <img src="<?php echo APPURL; ?>/assets/img/<?php echo htmlspecialchars($relateProduct->image); ?>"
                                            alt="Card image" class="card-img-top"
                                            style="object-fit: cover; width: 100%; height: 200px;">
                                    </div>
                                    <div class="card-body"
                                        style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
                                        <h4 class="card-title"><a
                                                href="detail-product.php?id=<?php echo $relateProduct->id; ?>"><?php echo htmlspecialchars($relateProduct->name); ?></a>
                                        </h4>
                                        <div class="card-price"><span
                                                class="reguler"><?php echo number_format($relateProduct->price, 2); ?>
                                                $</span></div>
                                        <a href="detail-product.php?id=<?php echo $relateProduct->id; ?>"
                                            class="btn btn-block btn-primary">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require "../includes/footer.php"; ?>

<script>
    $(document).ready(function () {
        // Prevent zero in quantity input
        $(".form-control").keyup(function () {
            var value = $(this).val();
            if (value < 1) {
                $(this).val(1);
            }
        });

        // Ajax form submission
        $(".btn-insert").on("click", function (e) {
            e.preventDefault();

            var form_data = $("#form-data").serialize() + '&submit=submit';

            $.ajax({
                url: "detail-product.php?id=<?php echo $id; ?>",
                method: "POST",
                data: form_data,
                success: function () {
                    alert("Product added to cart");
                    $(".btn-insert").html("<i class='fa fa-shopping-basket'></i> Added to Cart").prop("disabled", true);
                }
            });
        });
    });
</script>