import axios from "axios";
import React, { forwardRef, useEffect, useState } from "react";
import "./checkout.css";
import { useSelector } from "react-redux";
import { useParams } from "react-router-dom";
import { useRef } from "react";
import ReactToPrint, { PrintContextConsumer } from "react-to-print";
import { clearItem } from "../features/products/cartSlice";
import { useDispatch } from "react-redux";

export default function Checkout(props) {
  const [fullname, setFullname] = useState("");
  const [email, setEmail] = useState("");
  const [phoneno, setPhoneno] = useState("");
  const [address, setAddress] = useState("");
  const [product_name, setProduct_name] = useState("");
  const [quantity, setQuantity] = useState("");
  const [price, setPrice] = useState("");
  const [total_price, setTotal_price] = useState("");
  const [total_qty, setTotal_qty] = useState("");
  const [created_at, setCreated_at] = useState("");
  const [tracking_id, setTracking_id] = useState();
  const [msg, setMsg] = useState("");
  const [sent, setSent] = useState([]);

  const dispatch = useDispatch();
  let ref = useRef();
  const { biz_id } = useParams();
  const cart = useSelector((state) => state.cartItem);

  useEffect(() => {
    setTracking_id(Math.floor(Math.random() * 1000000000 + 1));
  }, []);

  const getTotal = () => {
    let totalQuantity = 0;
    let totalPrice = 0;

    cart.forEach((item) => {
      totalQuantity += item.quantity;
      totalPrice += item.price * item.quantity;
    });

    return {
      totalPrice,
      totalQuantity,
    };
  };
  console.log(fullname);
  const ComponentToPrint = forwardRef((props, ref) => {
    return (
      <div ref={ref}>
        <div>
          <div>
            <span>Name:</span>
            {fullname}
          </div>
          <div>
            <span>Order Id:</span>
            {tracking_id}
          </div>
          <div>Item Name:{product_name}</div>
          <div>
            <span>Quantity: </span>
            {quantity}
          </div>
          <div>
            <span>Price: </span>
            <span className="naira">N</span>
            {price}
          </div>
          <div>
            <span>Total Quantity:</span>
            {total_qty}
          </div>
          <div>
            <span>Total Price: </span>
            <span className="naira">N</span>
            {total_price}
          </div>
          <div>
            <span>Date:</span>
            {created_at}
          </div>
        </div>
      </div>
    );
  });

  const handleSubmit = async (e, cart) => {
    // prevent the form from refreshing the whole page
    e.preventDefault();
    const total_price = getTotal().totalPrice;
    const total_qty = getTotal().totalQuantity;

    //-----------------

    const product_name = [];
    const product_id = [];
    const category = [];
    const quantity = [];
    const price = [];
    const image = [];
    cart.map((item) => product_name.push(item.title));
    cart.map((item) => product_id.push(item.id));
    cart.map((item) => category.push(item.category));
    cart.map((item) => quantity.push(item.quantity));
    cart.map((item) => price.push(item.price));
    cart.map((item) => image.push(item.image));

    const formData = new FormData();

    formData.append("fullname", fullname);
    formData.append("address", address);
    formData.append("email", email);
    formData.append("phoneno", phoneno);
    formData.append("tracking_id", tracking_id);
    formData.append("total_price", total_price);
    formData.append("total_qty", total_qty);
    formData.append("biz_id", biz_id);
    formData.append("product_name", product_name);
    formData.append("product_id", product_id);
    formData.append("category", category);
    formData.append("quantity", quantity);
    formData.append("price", price);
    formData.append("image", image);

    try {
      await axios
        .post(
          "http://localhost:8000/api/checkout",

          formData,
          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        )
        .then((res) => {
          setSent([res.data.checkout]);
          setFullname(res.data.checkout.fullname);
          setTracking_id(res.data.checkout.tracking_id);
          setProduct_name(res.data.checkout.product_name);
          setQuantity(res.data.checkout.quantity);
          setPrice(res.data.checkout.price);
          setTotal_price(res.data.checkout.total_price);
          setTotal_qty(res.data.checkout.total_qty);
          setCreated_at(res.data.checkout.created_at);
          setFullname("");
          setPhoneno("");
          setEmail("");
          setAddress("");
        });
    } catch (error) {
      if (error.response) {
        setMsg(error.response.data.msg);
      }
    }
    //----------------
  };

  function clearEntry() {
    setFullname("");
    setPhoneno("");
    setEmail("");
    setAddress("");
  }
  console.log(sent);
  return (
    <div className="checkout__wrap--flex">
      {product_name ? (
        <div className="form-group">
          <div className="h2parent">Your Order Details</div>
          <ReactToPrint content={() => ref.current}>
            <PrintContextConsumer>
              {({ handlePrint }) => (
                <button
                  onClick={() => {
                    handlePrint();
                  }}
                >
                  Print!
                </button>
              )}
            </PrintContextConsumer>
          </ReactToPrint>
          <ComponentToPrint ref={ref} />
        </div>
      ) : (
        <React.Fragment>
          <div className="h2parent">Enter Your details</div>
          <form encType="multipart/form-data" method="post">
            <div className="form-group-parent2">
              <div className="form-group">
                <p className="has-text-centered">{msg}</p>
              </div>
              <div className="input_parent">
                <input
                  type="text"
                  id="firstname"
                  name="firstname"
                  placeholder="Full Name"
                  className="form-control"
                  value={fullname}
                  onChange={(e) => setFullname(e.target.value)}
                />
                <label htmlFor="firstname" className="labText">
                  Full Name
                </label>
              </div>
              <div className="help_parent">
                <span className="help-block"></span>
              </div>
            </div>

            <div className="form-group-parent2">
              <div className="input_parent">
                <input
                  type="phoneno"
                  name="phoneno"
                  id="phoneno"
                  placeholder="Phone Number"
                  className="form-control"
                  value={phoneno}
                  onChange={(e) => setPhoneno(e.target.value)}
                />
                <label htmlFor="phoneno" className="labText">
                  Phone Number
                </label>
              </div>
              <div className="help_parent">
                <span className="help-block"></span>
              </div>
            </div>

            <div className="form-group-parent2">
              <div className="input_parent">
                <input
                  type="email"
                  name="email"
                  id="email"
                  placeholder="Email"
                  className="form-control"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                />
                <label htmlFor="email" className="labText">
                  Email
                </label>
              </div>
              <div className="help_parent">
                <span className="help-block"></span>
              </div>
            </div>

            <div className="form-group-parent2">
              <div className="input_parent">
                <input
                  type="address"
                  name="address"
                  id="address"
                  placeholder="Your Address"
                  className="form-control"
                  value={address}
                  onChange={(e) => setAddress(e.target.value)}
                />
                <label htmlFor="address" className="labText">
                  Your Address
                </label>
              </div>
              <div className="help_parent">
                <span className="help-block"></span>
              </div>
            </div>

            <div className="checkout__submit-parent">
              <input
                type="submit"
                className="checkout_submit"
                onClick={(e) => {
                  handleSubmit(e, cart);
                  dispatch(clearItem());
                }}
                value="Order"
              />

              <input
                type="reset"
                className="checkout__btn--reset"
                onClick={(e) => clearEntry(e)}
                value="Cance"
              />
            </div>
          </form>
        </React.Fragment>
      )}
    </div>
  );
}
