<?php
// The amounts of products to show on each page
$num_products_on_each_page = 4;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT ?,?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of products
$total_products = $pdo->query('SELECT * FROM products')->rowCount();
?>

<?= template_header('Products') ?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?= $total_products ?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product) : ?>
            <a href="index.php?page=product&id=<?= $product['id'] ?>" class="product">
                <img src="imgs/<?= $product['img'] ?>" width="200" height="200" alt="<?= $product['name'] ?>">
                <span class="name"><?= $product['name'] ?></span>
                <span class="price">
                    &dollar;<?= $product['price'] ?>
                    <?php if ($product['rrp'] > 0) : ?>
                        <span class="rrp">&dollar;<?= $product['rrp'] ?></span>
                    <?php endif; ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="buttons">
        <?php if ($current_page > 1) : ?>
            <a href="index.php?page=products&p=<?= $current_page - 1 ?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $num_products_on_each_page) - $num_products_on_each_page + count($products)) : ?>
            <a href="index.php?page=products&p=<?= $current_page + 1 ?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>

<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>

<?= template_footer() ?>