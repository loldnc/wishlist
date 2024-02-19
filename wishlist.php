    <?php
    require "helper.php";

     if(isset($_POST['create'])){
        maken($_POST);
    } 
    if(isset($_POST['delete'])){
        $product_id = $_POST['product_id']; 
        verwijderen($product_id);
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <link rel="stylesheet" href="CSS/wensenlijst.css">
        <title>Home Page</title>
    </head>
    <body>
    <header>
        <nav>
            <ul>
                <li>
                 <a href="index.php">Home</a>
                </li>
                <li>
                 <a href="#">All Wishlist</a>
                </li>
                <li>
                    <a href="login.php">Login Register</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
    <article class="titel-product"> <h1>Create new product</h1></article> 
        <section class="formulier">
            <form method="POST">
                Naam: <input type="text" name='naam'>  
                Prijs: <input type="text" name='prijs'><br>
                Afbeelding: <input type="text" name='afbeelding'>
                Webshop: <input type="text" name='webshop'>
                <button type="submit" name="create" class="create-btn">Create</button>
            </form>
        </section>

        <section class="producten-container">
            <article class="titel">
                <h1>Products</h1>
            </article> 
            <?php foreach(showProducten() as $producten) { ?>
        <article class="column">
            <p><?= $producten[0]; ?></p>
            <p><?= $producten[1]; ?></p>
            <p><?= $producten[2]; ?></p>
            <p><?= $producten[3]; ?></p>
            <p><a href="https://www.bol.com/nl/nl/" target="_blank">bol.com</a></p>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?= $producten[0]; ?>">
                <button type="submit" name="delete" class="delete-btn">Delete</button>
            </form>
        </article>
    <?php } ?>
</section>

    <footer> <a href="">Merry christmas</a> </footer>

    </body>
    </html>
