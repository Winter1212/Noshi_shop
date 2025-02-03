<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>

<?php
// Securely fetch user's cart items
$user_id = $_SESSION['user_id'];
$products = $conn->prepare("SELECT * FROM cart WHERE user_id = :user_id");
$products->execute(['user_id' => $user_id]);
$allProducts = $products->fetchAll(PDO::FETCH_OBJ);
?>

<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0"
            style="background-image: url('<?php echo APPURL; ?>/assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">Your Cart</h1>
                <p class="lead">Save time and leave the groceries to us.</p>
            </div>
        </div>
    </div>

    <section id="cart">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="10%"></th>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Update</th>
                                    <th>Subtotal</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($allProducts)) : ?>
                                    <?php foreach ($allProducts as $product): ?>
                                        <tr data-id="<?php echo $product->id; ?>">
                                            <td>
                                                <img src="<?php echo APPURL; ?>/assets/img/<?php echo $product->pro_image; ?>"
                                                    style="width: 60px; height: 60px; object-fit: contain;">
                                            </td>
                                            <td><?php echo htmlspecialchars($product->pro_name); ?><br>
                                                <small>1000g</small>
                                            </td>
                                            <td class="pro_price">$ <?php echo number_format($product->pro_price, 2); ?></td>
                                            <td>
                                                <input class="pro_qty form-control" type="number" min="1"
                                                    value="<?php echo $product->pro_qty; ?>" name="vertical-spin">
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-update">UPDATE</button>
                                            </td>
                                            <td class="total_price">
                                                <?php echo number_format($product->pro_price * $product->pro_qty, 2) . "$"; ?>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" class="text-danger btn-delete"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7">
                                            <div class="alert alert-success bg-success text-white text-center">
                                                There are no products in the cart yet.
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col">
                    <a href="<?php echo APPURL; ?>/shop.php" class="btn btn-default">Continue Shopping</a>
                </div>

                <div class="col text-right">
                    <div class="clearfix"></div>
                    <h6 class="mt-3">Total: <span id="cart-total"></span></h6>
                    <a href="checkout.html" class="btn btn-lg btn-primary">Checkout <i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php require "../includes/footer.php"; ?>

<script>
$(document).ready(function () {
    // Prevent inputting invalid quantity
    $(".pro_qty").on("change", function () {
        var value = parseInt($(this).val());
        if (isNaN(value) || value < 1) {
            $(this).val(1);
        }
    });

    // Update subtotal on quantity change
    $(".pro_qty").mouseup(function () {
    var $el = $(this).closest('tr');

    var pro_amount = $el.find(".pro_qty").val();
    var pro_price = $el.find(".pro_price").text().replace("$", ""); // Remove $ for calculations

    var total = (pro_amount * parseFloat(pro_price)).toFixed(2);
    
    $el.find(".total_price").html("$" + total); // Ensure $ is displayed

    updateCartTotal(); // Update total cart price
});


    // Handle update button click
    // $(".btn-update").on("click", function () {
    //     var $row = $(this).closest("tr");
    //     var id = $row.data("id");
    //     var pro_amount = parseInt($row.find(".pro_qty").val()) || 1;

    //     $.ajax({
    //         type: "POST",
    //         url: "update-item.php",
    //         data: { id: id, pro_amount: pro_amount },
    //         success: function () {
    //             alert("Cart updated successfully!");
    //             updateCartTotal();
    //         },
    //         error: function () {
    //             alert("Error updating cart.");
    //         }
    //     });
    // });

    // Handle delete button click
    // $(".btn-delete").on("click", function () {
    //     var $row = $(this).closest("tr");
    //     var id = $row.data("id");

    //     if (confirm("Are you sure you want to remove this item?")) {
    //         $.ajax({
    //             type: "POST",
    //             url: "delete-item.php",
    //             data: { id: id },
    //             success: function () {
    //                 $row.remove();
    //                 updateCartTotal();
    //             },
    //             error: function () {
    //                 alert("Error removing item.");
    //             }
    //         });
    //     }
    // });

    //Function to update total cart value
    function updateCartTotal() {
    var total = $(".total_price")
        .map(function () {
            return parseFloat($(this).text().replace("$", "").trim()) || 0;
        })
        .get()
        .reduce((sum, price) => sum + price, 0);

    $("#cart-total").text("$ " + total.toFixed(2));
}


    updateCartTotal();
});
</script>
