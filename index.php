<?php
$servername = "localhost";
$username = "root"; // používateľské meno pre prístup k databáze
$password = ""; // heslo pre prístup k databáze
$dbname = "bakery_db"; // Názov databázy, ktoru chceme pripojiť

// Vytvorenie nového pripojenia pomocou new mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola pripojenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inicializácia premennej $search
$search = '';
if (isset($_POST['search'])) {
    // Ak je formulárové pole 'search' nastavené (existuje v POST požiadavke), priraď jeho hodnotu do premennej $search
    $search = $_POST['search'];
}

// Vytvorenie SQL dotazu na vyhľadanie pekárenských produktov podľa názvu
// Použitie LIKE na hľadanie názvov, ktoré obsahujú hodnotu v premennej $search
$sql = "SELECT id, name, description, price, image_url FROM bakery_items WHERE name LIKE '%$search%'";

// Spustenie SQL dotazu a uloženie výsledku do premennej $result
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
</head>
<body>
<header>
    <h1 class="bakery-font">Vitajte v mojej pekárni</h1>
</header>

<section class="bakery-info">
    <h2>O našej pekárni</h2>
    <p>Vitajte v našej pekárni, kde už viac ako 20 rokov podávame čerstvé pečivo pre našu komunitu. Naším poslaním je poskytovať vysokokvalitné, chutné a čerstvo upečené jedlá, ktoré vám rozjasnia deň. Používame len tie najlepšie ingrediencie a tradičné techniky pečenia, aby sme zaistili, že každé sústo bude potešením.</p>
    <p>Ponúkame rôzne druhy chleba, pečiva, koláčov a pod. Či už sa u nás zastavíte na rannú kávu a croissant alebo si vyberiete tortu na špeciálnu príležitosť, sme tu, aby sme vás obslúžili s úsmevom.</p>

    <h3>Naša misia</h3>
    <p>Prinášať radosť našim zákazníkom prostredníctvom chutného pečiva vyrobeného s láskou a starostlivosťou.</p>

    <h3>Special Offers</h3>
    <p>Pozrite si naše denné špeciálne a sezónne ponuky! Nepremeškajte naše špeciálne zľavy na hromadné objednávky a slávnostné pochúťky.</p>
</section>

<section class="bakery-info">
    <h3>Customer Reviews</h3>
    <p>"Najlepšia pekáreň v meste! Pečivo je vždy čerstvé a personál je neuveriteľne priateľský." - Jane D.</p>
    <p>"Milujem ich kváskový chlieb. Je to základ v našej domácnosti!" - John S.</p>
</section>

<section class="bakery-info">
    <h3>Kontaktujte nás</h3>
    <p>Adresa: 123 Bakery Street, Sweet Town, CA 12345</p>
    <p>Telefonne číslo: (123) 456-7890</p>
    <p>E-mail: contact@ourbakery.com</p>
</section>

<section class="search-section">
    <form method="POST" action="index.php">
        <input type="text" name="search" placeholder="Vyhladať produkt..." value="<?php echo $search; ?>">
        <button type="submit">Hladať</button>
    </form>
</section>
<h2 style="text-align: ce">Naše produkty</h2>
<section class="bakery-items">
    <?php
    // kontrola, či dotaz vrátil nejaké riadky
    if ($result->num_rows > 0) {
        // Prechádzanie všetkých riadkov výsledku dotazu
        while($row = $result->fetch_assoc()) {
            // Začiatok containeru pre jeden produkt
            echo '<div class="bakery-item">';
            // Vloženie obrázka produktu s atribútmi src a alt
            echo '<img src="' . $row["image_url"] . '" alt="' . $row["name"] . '">';
            // Vloženie názvu produktu
            echo '<h3>' . $row["name"] . '</h3>';
            // Vloženie popisu produktu
            echo '<p>' . $row["description"] . '</p>';
            // Vloženie ceny produktu
            echo '<p>Price: $' . $row["price"] . '</p>';
            // Vloženie tlačidla pre pridanie do košíka s JavaScript funkciou addToCart
            echo '<button onclick="addToCart(' . $row["id"] . ', \'' . $row["name"] . '\', ' . $row["price"] . ')">Add to Cart</button>';
            // Koniec containeru pre jeden produkt
            echo '</div>';
        }
    } else {
        // Ak dotaz nevrátil žiadne riadky, zobrazí sa správa "No items found."
        echo "No items found.";
    }
    // Zatvorenie pripojenia k databáze
    $conn->close();
    ?>
</section>

<section class="shopping-cart">
    <h2 class="bakery-font">Shopping Cart</h2>
    <div id="cart">
        <p>No items in the cart.</p>
    </div>
</section>

<script src="scripts.js"></script>
</body>
</html>
