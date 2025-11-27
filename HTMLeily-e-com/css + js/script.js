// Menu burger pour mobile
const burger = document.getElementById('burger');
const nav = document.getElementById('nav');
burger.addEventListener('click', () => {
  nav.classList.toggle('open');
});

// Exemple de produits (remplace ou ajoute selon tes besoins)
const products = [
  {
    name: "T-shirt Performance",
    desc: "Confort ultime, matière respirante, parfait pour la salle.",
    price: "29€",
    img: "https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/4a19428a-a131-48ae-a9c6-1356db757c7e/W+NK+DF+STRIKE+SS+TOP+K.png"
  },
  {
    name: "Jogging Flex",
    desc: "Style moderne et coupe ajustée.",
    price: "45€",
    img: "https://i8.amplience.net/i/jpl/jd_721220_a?qlt=92"
  },
  {
    name: "Brassière Sport",
    desc: "Maintien et liberté de mouvement.",
    price: "35€",
    img: "https://images.napali.app/global/roxy-products/all/default/xlarge/erjkt04192_roxy,w_kvj0_frt1.jpg"
  },
  {
    name: "Short Training",
    desc: "Léger et résistant pour toutes les séances.",
    price: "25€",
    img: "https://cdn.shopify.com/s/files/1/0098/8822/files/Running2In1ShortsGSBlackB8A5I-BB2J1502_9fbdb664-23dd-451b-93fe-736f35b0d858_1200x.jpg?v=1705568113"
  }
];

// Injection des produits dans la grille
const grid = document.getElementById('products-grid');
products.forEach(product => {
  const card = document.createElement('div');
  card.className = 'product-card';
  card.innerHTML = `
    <img src="${product.img}" alt="${product.name}">
    <h3>${product.name}</h3>
    <p>${product.desc}</p>
    <div class="price">${product.price}</div>
    <button>Ajouter au panier</button>
  `;
  grid.appendChild(card);
});

// Optionnel : Formulaire de contact (empêche l’envoi réel)
document.querySelector('form').addEventListener('submit', function(e) {
  e.preventDefault();
  alert("Merci pour votre message !");
});