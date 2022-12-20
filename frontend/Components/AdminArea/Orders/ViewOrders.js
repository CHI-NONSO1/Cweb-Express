import React, { forwardRef, useEffect, useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import "./viewOrder.css";
import styled from "styled-components";
import { useRef } from "react";

import ReactToPrint, { PrintContextConsumer } from "react-to-print";
import Icon from "../../../Icon";

export default function ViewOrders() {
  const [orders, setOrders] = useState([]);
  const [openMore, setOpenMore] = useState([]);
  const [biz_id, setBiz_id] = useState("");
  const [resAtion, setResAction] = useState("");
  const [product_name, setProduct_name] = useState("");
  const [fullname, setFullname] = useState("");
  const [phoneno, setPhoneno] = useState("");
  const [email, setEmail] = useState("");
  const [address, setAddress] = useState("");
  const [tracking_id, setTracking_id] = useState("");
  const [image, setImage] = useState("");

  const [product_id, setProduct_id] = useState("");
  const [category, setCategory] = useState("");
  const [quantity, setQuantity] = useState("");
  const [price, setPrice] = useState("");
  const [total_price, setTotal_price] = useState("");
  const [total_qty, setTotal_qty] = useState("");
  const [description, setDescription] = useState("");
  const [biz_name, setBiz_name] = useState("");
  const [orderid, setOrderid] = useState("");

  const [showdetail, setShowdetail] = useState(false);

  const history = useNavigate();
  let ref = useRef();

  useEffect(() => {
    const token = JSON.parse(localStorage.getItem("token"));

    const refreshToken = async (token) => {
      try {
        const response = await axios.get("http://localhost:8000/api/profile/", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setBiz_id(response.data.biz_id);
      } catch (error) {
        if (error.response) {
          console.log(error.response.data);
          history("/login");
        }
      }
    };

    refreshToken(token);
  }, [history]);

  useEffect(() => {
    const getOrders = async () => {
      //------------------
      try {
        const res = await axios.post(`http://localhost:8000/api/allcheckout/`, {
          headers: {
            "Access-Control-Allow-Origin": "http://localhost:3000/",
          },
        });
        setOrders(res.data);
        console.log(res.data);
      } catch (error) {
        if (error.data) {
        }
      }
      //---------------------
    };

    getOrders();
  }, [biz_id]);
  function opendetails(checkoutid) {
    const showall = orders.filter((item) => item.checkoutid === checkoutid);
    setOpenMore(showall);
    setShowdetail(true);
  }
  const ComponentToPrint = forwardRef((props, ref) => {
    return (
      <div ref={ref}>
        {openMore === []
          ? "Loading . . ."
          : openMore.map((item, index) => (
              <div key={index}>
                <div>{item.fullname}</div>
                <div>{item.phoneno}</div>
                <div>{item.email}</div>
                <div>{item.address}</div>
                <div>{item.tracking_id}</div>
                <div>{item.product_name}</div>
                <div>{item.quantity}</div>
                <div>
                  <span className="naira">N</span>
                  {item.price}
                </div>
                <div>{item.total_qty}</div>
                <div>{item.total_price}</div>
                <div>{item.created_at}</div>
                <div>
                  <span>Name:</span>___________________________________
                </div>
                <div>
                  <span>Sign:</span>_________________
                </div>
                <div>
                  <span>Date:</span>_________________
                </div>
              </div>
            ))}
      </div>
    );
  });

  const processCheckout = async (checkoutid) => {
    let check = orders.filter((item) => item.checkoutid === checkoutid);

    check.map((item) => setProduct_name(item.product_name));
    check.map((item) => setProduct_id(item.product_id));
    check.map((item) => setCategory(item.category));
    check.map((item) => setQuantity(item.quantity));
    check.map((item) => setPrice(item.price));
    check.map((item) => setImage(item.image));

    check.map((item) => setFullname(item.fullname));
    check.map((item) => setPhoneno(item.phoneno));
    check.map((item) => setAddress(item.address));
    check.map((item) => setEmail(item.email));
    check.map((item) => setTracking_id(item.tracking_id));
    check.map((item) => setTotal_price(item.total_price));
    check.map((item) => setTotal_qty(item.total_qty));
    check.map((item) => setDescription(item.description));
    check.map((item) => setBiz_name(item.biz_name));
    check.map((item) => setOrderid(item.checkoutid));
    try {
      const res = await axios.post(
        `http://localhost:8000/api/add-processed-order`,
        {
          checkoutid,
          fullname,
          phoneno,
          email,
          address,
          tracking_id,
          image,
          product_name,
          product_id,
          category,
          quantity,
          price,
          total_price,
          total_qty,
          description,
          biz_name,
          orderid,
        },
        {
          headers: {
            "Access-Control-Allow-Origin": "http://localhost:3000/",
          },
        }
      );
      setResAction(res.data.msg);
      console.log(res.data.msg);
    } catch (error) {
      if (error.data) {
        setResAction(error.response.data);
        console.log(error.response);
      }
    }
    const getOrders = async () => {
      //------------------
      try {
        const res = await axios.post(`http://localhost:8000/api/allcheckout/`, {
          headers: {
            "Access-Control-Allow-Origin": "http://localhost:3000/",
          },
        });
        setOrders(res.data);
      } catch (error) {
        if (error.data) {
        }
      }
      //---------------------
    };

    getOrders();
  };
  console.log(fullname);
  return (
    <>
      <div> {resAtion}</div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Phone No</th>
            <th>Email</th>
            <th>Address</th>
            <th>Order Id</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total Quantity</th>
            <th>Total Price</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        {orders !== []
          ? orders.map((item, index) => (
              <React.Fragment key={index}>
                <tbody>
                  <tr>
                    <td onClick={() => opendetails(item.checkoutid)}>
                      {item.fullname}
                    </td>
                    <td>{item.phoneno}</td>
                    <td>{item.email}</td>
                    <td>{item.address}</td>
                    <td>{item.tracking_id}</td>
                    <td>{item.product_name}</td>
                    <td>{item.quantity}</td>
                    <td>
                      {" "}
                      <span className="naira">N</span>
                      {item.price}
                    </td>
                    <td>{item.total_qty}</td>
                    <td>{item.total_price}</td>
                    <td>{item.created_at}</td>

                    <td>
                      <button
                        onClick={() => {
                          processCheckout(item.checkoutid);
                        }}
                        className="btn_del"
                      >
                        Del
                      </button>
                    </td>
                  </tr>
                </tbody>
              </React.Fragment>
            ))
          : "Loading . . ."}
      </table>
      <ShowDetails show={showdetail}>
        <div>
          <div
            className="close--show"
            onClick={() => {
              setShowdetail(false);
            }}
          >
            <Icon icon="close" size={20} color="red" />
          </div>
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
      </ShowDetails>
    </>
  );
}

const ShowDetails = styled.div`
  width: 75%;
  height: 70%;
  margin-left: 10%;
  background: #dedede;
  transition: all 0.3s linear;
  z-index: 30;
  position: absolute;
  top: 0%;
  border-radius: 4px;
  border: 0.1rem #ddd solid;
  transform: ${(props) => (props.show ? "translateX(0)" : "translateX(-150%)")};
  @media (max-width: 820px) {
    width: 100%;
    height: 90%;
  }
`;
