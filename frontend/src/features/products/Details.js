import React from "react";
import "./details.css";
import { useDispatch } from "react-redux";
import { addToCart } from "./cartSlice";

export default function Details(props) {
  //const [isOpen, setIsOpen] = useState(true);
  const dispatch = useDispatch();

  const products = JSON.parse(localStorage.getItem("products"));
  var toCart = {};

  const getProductById = async (productid) => {
    let cartProduct = Array.from(products).find(
      (product) => product.id === productid
    );

    const id = cartProduct.id;
    const title = cartProduct.title;
    const price = cartProduct.price;
    const image = cartProduct.image;
    const category = cartProduct.category;
    const quantity = 0;
    toCart = { id, title, price, image, category, quantity };
  };

  // const closeModal = () => {
  //   setIsOpen(false);
  // };

  return (
    <div className="details__container">
      {props.details && (
        <div className="details_wrap">
          <div className="product-details" key={props.details.id}>
            <img
              className="product__details--img"
              src={`http://localhost:8000/storage/product/image/${props.details.image}`}
              alt={props.details.title}
            ></img>
            <div className="product-details-description">
              <p>
                <strong>{props.details.title}</strong>
              </p>
              <p>{props.details.description}</p>

              <div>
                <span className="currency__sign">N</span>
                {props.details.price}
              </div>
              <div className="detail__addcart">
                <button
                  className="detail__addcart--btn"
                  onClick={() => {
                    getProductById(props.details.id);
                    dispatch(addToCart(toCart));
                    // closeModal();
                    //setShowCartStatus(true);
                    //setIsOpen(false);
                  }}
                >
                  Add To Cart
                </button>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
