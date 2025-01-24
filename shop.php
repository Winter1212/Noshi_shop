<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>

<?php

//categories
$categories = $conn->query("SELECT * FROM categories");
$categories->execute();

$allCaltegories = $categories->fetchAll(PDO::FETCH_OBJ);

//most wated products
$mostProducts = $conn->query("SELECT * FROM products WHERE status = 1");
$mostProducts->execute();

$allmostProducts = $mostProducts->fetchAll(PDO::FETCH_OBJ);

//vigies
$vigies = $conn->query("SELECT * FROM products WHERE status = 1 AND category_id = 1");
$vigies->execute();

$allVigies = $vigies->fetchAll(PDO::FETCH_OBJ);

//meats
$meats = $conn->query("SELECT * FROM products WHERE status = 1 AND category_id = 2");
$meats->execute();

$allMeats = $meats->fetchAll(PDO::FETCH_OBJ);


//fishes
$fishes = $conn->query("SELECT * FROM products WHERE status = 1 AND category_id = 5");
$fishes->execute();

$allFishes = $fishes->fetchAll(PDO::FETCH_OBJ);

//fruits
$fruits = $conn->query("SELECT * FROM products WHERE status = 1 AND category_id = 6");
$fruits->execute();

$allFruits = $fruits->fetchAll(PDO::FETCH_OBJ);

//frozens
$frozens = $conn->query("SELECT * FROM products WHERE status = 1 AND category_id = 7");
$frozens->execute();

$allFrozens = $frozens->fetchAll(PDO::FETCH_OBJ);


?>
<div id="page-content" class="page-content">
    <div class="banner">
        <div class="jumbotron jumbotron-bg text-center rounded-0"
            style="background-image: url('assets/img/bg-header.jpg');">
            <div class="container">
                <h1 class="pt-5">
                    Shopping Page
                </h1>
                <p class="lead">
                    Save time and leave the groceries to us.
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="shop-categories owl-carousel mt-5">
                    <?php foreach ($allCaltegories as $category): ?>
                        <div class="item">
                            <a href="shop.php">
                                <div class="media d-flex align-items-center justify-content-center">
                                    <span class="d-flex mr-2"><i class="sb-<?php echo $category->icon; ?>"></i></span>
                                    <div class="media-body">
                                        <h5><?php echo $category->name; ?></h5>
                                        <p><?php echo substr($category->description, 1, 40); ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <section id="most-wanted">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Most Wanted</h2>
                    <div class="product-carousel owl-carousel">
                        <?php foreach ($allmostProducts as $mostProduct): ?>
                            <div class="item" style="display: flex; flex-direction: column; flex: 1 0 30%; margin: 10px;">
                                <div class="card card-product" style="display: flex; flex-direction: column; height: 100%;">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo $mostProduct->exp_date; ?>
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo htmlspecialchars($mostProduct->image); ?>"
                                            alt="Card image" class="card-img-top"
                                            style="object-fit: cover; width: 100%; height: 200px;">
                                    </div>
                                    <div class="card-body"
                                        style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
                                        <h4 class="card-title">
                                            <a
                                                href="detail-product.html"><?php echo htmlspecialchars($mostProduct->name); ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <span class="reguler"><?php echo number_format($mostProduct->price, 2); ?>
                                                $</span>
                                        </div>
                                        <a href="detail-product.html" class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="vegetables" class="gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Vegetables</h2>
                    <div class="product-carousel owl-carousel">
                        <?php foreach ($allVigies as $allVigie): ?>
                            <div class="item" style="display: flex; flex-direction: column; flex: 1 0 30%; margin: 10px;">
                                <div class="card card-product" style="display: flex; flex-direction: column; height: 100%;">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo $allVigie->exp_date; ?>
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo htmlspecialchars($allVigie->image); ?>"
                                            alt="Card image" class="card-img-top"
                                            style="object-fit: cover; width: 100%; height: 200px;">
                                    </div>
                                    <div class="card-body"
                                        style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
                                        <h4 class="card-title">
                                            <a
                                                href="detail-product.html"><?php echo htmlspecialchars($allVigie->name); ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <span class="reguler"><?php echo number_format($allVigie->price, 2); ?> $</span>
                                        </div>
                                        <a href="<?php echo APPURL; ?>/products/detail-product.php?id=<?php echo $allVigie->id; ?>"
                                            class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="meats">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Meats</h2>
                    <div class="product-carousel owl-carousel">
                        <?php foreach ($allMeats as $allMeat): ?>
                            <div class="item" style="display: flex; flex-direction: column; flex: 1 0 30%; margin: 10px;">
                                <div class="card card-product" style="display: flex; flex-direction: column; height: 100%;">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo $allMeat->exp_date; ?>
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo htmlspecialchars($allMeat->image); ?>"
                                            alt="Card image" class="card-img-top"
                                            style="object-fit: cover; width: 100%; height: 200px;">
                                    </div>
                                    <div class="card-body"
                                        style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
                                        <h4 class="card-title">
                                            <a
                                                href="detail-product.html"><?php echo htmlspecialchars($allMeat->name); ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <span class="reguler"><?php echo number_format($allMeat->price, 2); ?> $</span>
                                        </div>
                                        <a href="<?php echo APPURL; ?>/products/detail-product.php?id=<?php echo $allMeat->id; ?>"
                                            class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                            </div>


                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fishes" class="gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Fishes</h2>
                    <div class="product-carousel owl-carousel">
                        <?php foreach ($allFishes as $allFish): ?>
                            <div class="item" style="display: flex; flex-direction: column; flex: 1 0 30%; margin: 10px;">
                                <div class="card card-product" style="display: flex; flex-direction: column; height: 100%;">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo $allFish->exp_date; ?>
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo htmlspecialchars($allFish->image); ?>"
                                            alt="Card image" class="card-img-top"
                                            style="object-fit: cover; width: 100%; height: 200px;">
                                    </div>
                                    <div class="card-body"
                                        style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
                                        <h4 class="card-title">
                                            <a
                                                href="detail-product.html"><?php echo htmlspecialchars($allFish->name); ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <span class="reguler"><?php echo number_format($allFish->price, 2); ?> $</span>
                                        </div>
                                        <a href="<?php echo APPURL; ?>/products/detail-product.php?id=<?php echo $allFish->id; ?>"
                                            class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                            </div>


                        <?php endforeach; ?>


                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="fruits">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Fruits</h2>
                    <div class="product-carousel owl-carousel">
                    <?php foreach ($allFruits as $allFruit): ?>
                            <div class="item" style="display: flex; flex-direction: column; flex: 1 0 30%; margin: 10px;">
                                <div class="card card-product" style="display: flex; flex-direction: column; height: 100%;">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo  $allFruit->exp_date; ?>
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo htmlspecialchars( $allFruit->image); ?>"
                                            alt="Card image" class="card-img-top"
                                            style="object-fit: cover; width: 100%; height: 200px;">
                                    </div>
                                    <div class="card-body"
                                        style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
                                        <h4 class="card-title">
                                            <a
                                                href="detail-product.html"><?php echo htmlspecialchars( $allFruit->name); ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <span class="reguler"><?php echo number_format( $allFruit->price, 2); ?> $</span>
                                        </div>
                                        <a href="<?php echo APPURL; ?>/products/detail-product.php?id=<?php echo  $allFruit->id; ?>"
                                            class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                            </div>


                        <?php endforeach; ?>
                              
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="frozen">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">FROZEN FOODS</h2>
                    <div class="product-carousel owl-carousel">
                    <?php foreach ($allFrozens as $allFrozen): ?>
                            <div class="item" style="display: flex; flex-direction: column; flex: 1 0 30%; margin: 10px;">
                                <div class="card card-product" style="display: flex; flex-direction: column; height: 100%;">
                                    <div class="card-ribbon">
                                        <div class="card-ribbon-container right">
                                            <span class="ribbon ribbon-primary">SPECIAL</span>
                                        </div>
                                    </div>
                                    <div class="card-badge">
                                        <div class="card-badge-container left">
                                            <span class="badge badge-default">
                                                Until <?php echo  $allFrozen->exp_date; ?>
                                            </span>
                                        </div>
                                        <img src="assets/img/<?php echo htmlspecialchars( $allFrozen->image); ?>"
                                            alt="Card image" class="card-img-top"
                                            style="object-fit: cover; width: 100%; height: 200px;">
                                    </div>
                                    <div class="card-body"
                                        style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 200px;">
                                        <h4 class="card-title">
                                            <a
                                                href="detail-product.html"><?php echo htmlspecialchars( $allFrozen->name); ?></a>
                                        </h4>
                                        <div class="card-price">
                                            <span class="reguler"><?php echo number_format( $allFrozen->price, 2); ?> $</span>
                                        </div>
                                        <a href="<?php echo APPURL; ?>/products/detail-product.php?id=<?php echo  $allFrozen->id; ?>"
                                            class="btn btn-block btn-primary">
                                            Add to Cart
                                        </a>
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
</div><?php require "includes/footer.php"; ?>