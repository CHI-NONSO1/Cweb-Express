const descriptionBox = document.querySelector(".DetailsDescription");
const closeDescriptionBox = document.querySelector(".close__details");
const cartBox = document.querySelector(".ShowCart");
const closeCartBox = document.querySelector(".CloseCart");
const searchBox = document.querySelector(".SearchWrap");
const closeSearchBox = document.querySelector(".CloseSearchBox");
const addToCartBTNDOM = [...document.querySelectorAll(".add__cart--btn")];
const searchBar = document.querySelector(".search_input");
const openDetailBox = [...document.querySelectorAll(".image__wrap")];
const cartPrice = [...document.querySelectorAll(".cart__price")];
const cartBag = document.querySelector(".CartBag");
const shoppingTokenInput = document.querySelector(".shopping_token");
const BagTag = document.querySelector(".shoppingTag");
// =====================Detail Box=============================
closeDescriptionBox.addEventListener("click", closeBox);
function closeBox() {
    descriptionBox.setAttribute(
        "style",
        `
  transform:translateX(120%);
  `
    );
}
for (let i = 0; i < openDetailBox.length; i++) {
    var detailBox = openDetailBox[i];
    detailBox.addEventListener("click", openViewMore);
}

function openViewMore() {
    descriptionBox.setAttribute(
        "style",
        `
        display:block;
        transform:translateX(0%);
  `
    );
}
// =====================Cart Box=============================
// for (let i = 0; i < cartPrice.length; i++) {
//   var price = cartPrice[i];
//   detailBox.addEventListener("click", openViewMore);
// }
for (let i = 0; i < addToCartBTNDOM.length; i++) {
    var cartBoxDOM = addToCartBTNDOM[i];
    cartBoxDOM.addEventListener("click", generataShoppingToken);
}

async function generataShoppingToken(e) {
    const shopping_token = Math.floor(Math.random() * 1000000000 + 1);
    e.target.value = shopping_token;
    localStorage.setItem("shoppingTag", JSON.stringify(e.target.value));
}
document.addEventListener("DOMContentLoaded", () => {
    const BagTagg = document.querySelector(".shoppingTag");
    const cartTag = JSON.parse(localStorage.getItem("shoppingTag"));
    BagTagg.value = cartTag;
    console.log(BagTagg.value);
});

closeCartBox.addEventListener("click", closeCart);
function closeCart() {
    cartBox.setAttribute(
        "style",
        `
  transform:translateX(120%);
  `
    );
}

cartBag.addEventListener("click", openCartOverlay);

function openCartOverlay() {
    cartBox.setAttribute(
        "style",
        `
    display:block;
    transform:translateX(0%);
`
    );
}

class CartItems {
    async getCartItem() {
        try {
            let res = await fetch(`http://localhost:8000/express/${productid}`);
            console.log(res);
        } catch (error) {
            console.log(error);
        }
    }
}
// =====================Search Box=============================
closeSearchBox.addEventListener("click", closeSearch);
function closeSearch() {
    searchBox.setAttribute(
        "style",
        `
  transform:translateY(-150%);
  `
    );
}

searchBar.addEventListener("keydown", openSearch);
function openSearch() {
    searchBox.setAttribute(
        "style",
        `
        display:block;
        transform:translateY(0%);
  `
    );
}
