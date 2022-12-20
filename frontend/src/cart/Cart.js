import React, { useState } from "react";
//import CartTable from "./cartStore";
import "./cart.css";
import Icon from "../Icon";
import { useSelector } from "react-redux";
import styled from "styled-components";
import Checkout from "./Checkout";
import {
  incrementQuantity,
  decrementQuantity,
  removeItem,
} from "../features/products/cartSlice";
import { useDispatch } from "react-redux";

export default function Cart(props) {
  const dispatch = useDispatch();
  const cart = useSelector((state) => state.cartItem);
  const [showCheckout, setShowCheckout] = useState(false);
  const getTotal = () => {
    let totalQuantity = 0;
    let totalPrice = 0;
    cart.forEach((item) => {
      totalQuantity += item.quantity;
      totalPrice += item.price * item.quantity;
    });

    return { totalPrice, totalQuantity };
  };
  //const table = new CartTable();

  return (
    <div className="cart__left">
      <div>
        <h3 className="cart__header">Your Cart</h3>
        {cart?.map((item, index) => (
          <React.Fragment key={index}>
            <div className="cart__flex">
              <div className="cart__img--wrap">
                <img
                  className="cart__item--img"
                  src={`http://localhost:8000/storage/product/image/${item.image}`}
                  alt={item.title}
                />
              </div>
              <div className="cart__title">{item.title}</div>

              <div className="cart__qty">
                <div
                  className="decrease_item"
                  onClick={() => {
                    dispatch(decrementQuantity(item.id));
                  }}
                >
                  <Icon icon="cheveron-down" size={20} color="red" />
                </div>
                {item.quantity}
                <div
                  className="increase_item"
                  onClick={() => {
                    dispatch(incrementQuantity(item.id));
                  }}
                >
                  <Icon icon="cheveron-up" size={20} color="green" />
                </div>
              </div>
              <div>
                <span className="naira">N</span>
                {item.price}
              </div>
              <button
                className="remove__item"
                onClick={() => {
                  dispatch(removeItem(item.id));
                }}
              >
                Remove
              </button>
            </div>
          </React.Fragment>
        ))}
      </div>

      {cart.length > 0 ? (
        <div className="cart__total">
          <span>
            Total:{""}
            {""} ({getTotal().totalQuantity} Items)
          </span>
          <span>
            <strong className="naira">N</strong>
            <span>{getTotal().totalPrice}</span>
          </span>
        </div>
      ) : null}

      <div className="checkout__btn--wrap">
        {cart.length > 0 ? (
          <button
            className="check__out--btn"
            onClick={() => {
              setShowCheckout(true);
            }}
          >
            Check Out
          </button>
        ) : null}
      </div>

      <CheckOut show={showCheckout}>
        <Checkout cart={cart} />
      </CheckOut>
    </div>
  );
}

const CheckOut = styled.div`
  width: 90%;
  height: 40%;
  transition: all 0.3s linear;
  z-index: 30;
  margin-top: 4%;
  margin-left: 4%;
  margin-right: 2%;
  margin-bottom: 4%;
  overflow-x: hidden;
  overflow-y: hidden;
  background: indego;
  transform: ${(props) => (props.show ? "translateX(0)" : "translateX(120%)")};
`;
