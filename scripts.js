// Po načítaní celého dokumentu sa spustí nasledujúca funkcia
document.addEventListener("DOMContentLoaded", function() {
    console.log("JavaScript is working!");
    // Volá funkciu, ktorá aktualizuje zobrazenie košíka
    updateCartDisplay();
});

// Inicializácia prázdneho košíka
let cart = [];

// Funkcia na pridanie položky do košíka
function addToCart(id, name, price) {
    // Pridá nový objekt s vlastnosťami id, name a price do poľa cart
    cart.push({id, name, price});
    // Aktualizuje zobrazenie košíka
    updateCartDisplay();
}

// Funkcia na odstránenie položky z košíka
function removeFromCart(id) {
    // Filtruje pole cart a odstráni položky, ktoré majú rovnaké id
    cart = cart.filter(item => item.id !== id);
    // Aktualizuje zobrazenie košíka
    updateCartDisplay();
}

// Funkcia na aktualizáciu zobrazenia košíka
function updateCartDisplay() {
    // Získa element s id 'cart'
    const cartDiv = document.getElementById('cart');
    // Vyprázdni obsah elementu
    cartDiv.innerHTML = '';
    // Ak je košík prázdny, zobrazí správu
    if (cart.length === 0) {
        cartDiv.innerHTML = '<p>No items in the cart.</p>';
    } else {
        // Inicializácia celkovej sumy
        let total = 0;
        // Prechádza všetky položky v košíku
        cart.forEach(item => {
            // Vytvorí nový div pre každú položku v košíku
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('cart-item');
            // Nastaví obsah divu na názov a cenu položky a pridá tlačidlo na odstránenie
            itemDiv.innerHTML = `
                <p>${item.name} - $${item.price.toFixed(2)}</p>
                <button onclick="removeFromCart(${item.id})">Remove</button>
            `;
            // Pridá div položky do košíka
            cartDiv.appendChild(itemDiv);
            // Pripočíta cenu položky k celkovej sume
            total += item.price;
        });
        // Vytvorí nový div pre celkovú sumu
        const totalDiv = document.createElement('div');
        totalDiv.classList.add('cart-total');
        // Nastaví obsah divu na celkovú sumu
        totalDiv.innerHTML = `<p>Total: $${total.toFixed(2)}</p>`;
        // Pridá div s celkovou sumou do košíka
        cartDiv.appendChild(totalDiv);
    }
}
