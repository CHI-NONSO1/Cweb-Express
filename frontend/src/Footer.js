import axios from "axios";
import React, { useEffect, useState } from "react";
import styled from "styled-components";
//import TrackOrder from "./Customers/TrackOrder";
import "./footer_style.css";
import Icon from "./Icon";

import { Polyline } from "react-leaflet";
import { MapContainer, TileLayer, Marker, Popup } from "react-leaflet";

export default function Footer() {
  const [tracking_id, setTracking_id] = useState("");
  const [customerTrac, setCustomerTrac] = useState(false);
  const [customerDisplayOrder, setCustomerDisplayOrder] = useState(false);
  const [order, setOrder] = useState("");
  const [dispatchLati, setDispatchLati] = useState(0);
  const [dispatchLongi, setDispatchLongi] = useState(0);
  const [distance, setDistance] = useState();
  const [arrivalTime, setArrivalTime] = useState(0);
  const [destinationLati, setDestinationLati] = useState(0);
  const [destinationLongi, setDestinationLongi] = useState(0);
  const [movingDispatchLati, setMovingDispatchLati] = useState(0);
  const [movingDispatchLongi, setMovingDispatchLongi] = useState(0);
  const [movingDistance, setMovingDistance] = useState();
  const [arrivalMovingTime, setArrivalMovingTime] = useState(0);

  const getOrder = async (e, tracking_id) => {
    e.preventDefault();
    try {
      const res = await axios.post(
        `http://localhost:8000/api/oneorder/`,

        {
          tracking_id,
        },
        {
          headers: {
            "Access-Control-Allow-Origin": "http://localhost:3000/",
          },
        }
      );
      setOrder(res.data.order);
      console.log(res.data);
    } catch (error) {
      console.log(error.response.data);
    }
  };
  function openThis() {
    console.log("yes You can Open it");
  }
  useEffect(() => {
    const tracker = JSON.parse(localStorage.getItem("tracker"));
    if (tracker) {
      setDistance(tracker.distan.Distance);
      setArrivalTime(tracker.distan.Time);
      setDispatchLati(tracker.lat);
      setDispatchLongi(tracker.long);
    }
  }, []);

  useEffect(() => {
    const movingTracker = JSON.parse(localStorage.getItem("movingTracker"));
    console.log(movingTracker);
    if (movingTracker) {
      setMovingDistance(movingTracker.movingDistance.Distance);
      setArrivalMovingTime(movingTracker.movingDistance.Time);
      setMovingDispatchLati(movingTracker.movingLat);
      setMovingDispatchLongi(movingTracker.movingLong);
    }
  }, []);

  useEffect(() => {
    const Destination = JSON.parse(localStorage.getItem("customerDestination"));
    console.log(Destination);
    if (Destination) {
      setDestinationLati(Destination.buyerlati);
      setDestinationLongi(Destination.buyerlongi);
    }
  }, []);

  const dispatchPoint = [dispatchLati, dispatchLongi];
  const destinationPoint = [destinationLati, destinationLongi];

  let movingDispatchPoint;
  if (movingDispatchLati === 0) {
    movingDispatchPoint = [dispatchLati, dispatchLongi];
  } else {
    movingDispatchPoint = [movingDispatchLati, movingDispatchLongi];
  }

  const polyline = [
    [dispatchLati, dispatchLongi],
    [destinationLati, destinationLongi],
  ];
  const blueOptions = { color: "navy" };

  const movingPolyline = [
    [movingDispatchLati, movingDispatchLongi],
    [destinationLati, destinationLongi],
  ];

  const movingBlueOptions = { color: "transparent" };
  console.log(movingDispatchPoint);
  return (
    <div>
      <div className="site_policy">
        <div className="fb_connect">
          <Icon
            className="social_icon"
            icon="facebook"
            size={20}
            color="white"
          />
        </div>
        <div className="twitter_connect">
          <Icon className="social_icon" icon="twitter" size={20} color="blue" />
        </div>
        <div className="whatsapp_connect">
          <a href="https://wa.me/message/Q5U5MFFUW6NVO1">
            <Icon
              className="social_icon"
              icon="whatsapp1"
              size={20}
              color="blue"
            />
          </a>
        </div>
        <DisplayTrackingOrder show={customerDisplayOrder}>
          <div
            className="closedisplay"
            onClick={() => {
              setCustomerDisplayOrder(false);
            }}
          >
            <Icon icon="close" size={20} color="white" />
          </div>
          {!order ? (
            "Loading . . . "
          ) : (
            <div className="scroll__table">
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
                <tbody>
                  <tr key={order.orderid} onFocus={openThis}>
                    <td>{order.fullname}</td>
                    <td>{order.phoneno}</td>
                    <td>{order.email}</td>
                    <td>{order.address}</td>
                    <td>{order.tracking_id}</td>
                    <td>{order.product_name}</td>
                    <td>{order.quantity}</td>
                    <td>
                      {" "}
                      <span className="naira">N</span>
                      {order.price}
                    </td>
                    <td>{order.total_qty}</td>
                    <td>{order.total_price}</td>
                    <td>{order.created_at}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          )}
          <div className="watcher__box--container">
            <div className="tracker__box">
              <MapContainer
                center={[dispatchLati, dispatchLongi]}
                zoom={1}
                scrollWheelZoom={false}
                style={{
                  width: "100%",
                  maxWidth: "100%",
                  minWidth: "0%",
                  height: "100%",
                  minHeight: "0%",
                  maxHeight: "100%",
                }}
              >
                <TileLayer
                  attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                  url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                />
                <Marker position={dispatchPoint}>
                  <Popup>Here is Your Starting Point!!</Popup>
                </Marker>

                <Marker position={movingDispatchPoint}>
                  <Popup>Rider</Popup>
                </Marker>

                <Marker position={destinationPoint}>
                  <Popup>Here is Your Destination!!</Popup>
                </Marker>

                <Polyline
                  pathOptions={movingBlueOptions}
                  positions={movingPolyline}
                >
                  <Popup>Distance {movingDistance}KM!!</Popup>
                </Polyline>
                <Polyline pathOptions={blueOptions} positions={polyline}>
                  <Popup>Distance {distance}KM!!</Popup>
                </Polyline>
              </MapContainer>
            </div>
            <div className="watcher__box">
              <div className="starting__point">
                <div>
                  <span>Distance:</span>
                  {distance}
                  <span>KM</span>
                </div>
                <div>
                  <span>Arrives in :</span>
                  {arrivalTime}
                  <span>Mins</span>
                </div>
              </div>
              <div className="moving__direction">
                <div>
                  <span>Distance:</span>
                  {movingDistance}
                  <span>KM</span>
                </div>
                <div>
                  <span>Arrives in :</span>
                  {arrivalMovingTime}
                  <span>Mins</span>
                </div>
              </div>
            </div>
          </div>
        </DisplayTrackingOrder>
        <button
          onClick={() => {
            setCustomerTrac(true);
          }}
        >
          Track Order
        </button>
        {/* <TrackOrder /> */}
        <CustomerOrder show={customerTrac}>
          <div className="customer__order--tracking">
            <form method="POST" encType="multipart/form-data">
              <div className="order--tracking-flex">
                <input
                  value={tracking_id}
                  onChange={(e) => setTracking_id(e.target.value)}
                  placeholder="Enter Your Order ID"
                  className="track__input"
                />
                <button
                  onClick={(e) => {
                    getOrder(e, tracking_id);
                    setCustomerDisplayOrder(true);
                    setCustomerTrac(false);
                  }}
                  className="order--tracking-btn"
                >
                  Send
                </button>
              </div>
            </form>
          </div>
        </CustomerOrder>
      </div>
    </div>
  );
}
const CustomerOrder = styled.div`
  width: 20%;
  height: 60%;
  background: blue;
  transition: all 0.3s linear;
  z-index: 30;
  position: absolute;
  bottom: 10%;
  right: 2%;
  display: flex;
  align-items: center;
  justify-content: space-around;
  transform: ${(props) => (props.show ? "translateX(0)" : "translateX(120%)")};
  @media (max-width: 820px) {
    width: 75%;
    height: 75%;
  }
`;
const DisplayTrackingOrder = styled.div`
  width: 90%;
  height: 400px;
  background: blue;
  transition: all 0.3s linear;
  z-index: 30;
  position: absolute;
  bottom: 100%;
  right: 5%;
  display: flex;
  align-items: center;
  justify-content: space-around;
  border: 0.2rem #ddd solid;
  transform: ${(props) => (props.show ? "translateY(0)" : "translateY(150%)")};
  @media (max-width: 820px) {
    width: 90%;
    height: 500px;
    overflow-y: scroll;
    overflow-x: hidden;
  }
`;
