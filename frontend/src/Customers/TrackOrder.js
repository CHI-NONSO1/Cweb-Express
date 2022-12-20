import axios from "axios";
import React, { useState } from "react";
import "./trackOrder.css";

export default function TrackOrder() {
  const [tracking_id, setTracking_id] = useState("");
  const [order, setOrder] = useState("");
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
  //   import "leaflet/dist/leaflet.css";
  // import { Polyline } from "react-leaflet";
  // import { MapContainer, TileLayer, Marker, Popup } from "react-leaflet";
  //import { useMap } from "react-leaflet/hooks";
  //import * as L from "leaflet";
  //   <MapContainer
  //   center={[dispatchLati, dispatchLongi]}
  //   zoom={8}
  //   scrollWheelZoom={false}
  //   style={{
  //     width: "100%",
  //     maxWidth: "100%",
  //     height: "100%",
  //     minHeight: "100%",
  //   }}
  // >
  //   <TileLayer
  //     attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  //     url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
  //   />
  //   <Marker position={[dispatchLati, dispatchLongi]}>
  //     <Popup>Here is Your Starting Point!!</Popup>
  //   </Marker>
  //   <Marker position={[destinationLati, destinationLongi]}>
  //     <Popup>Here is Your Destination!!</Popup>
  //   </Marker>
  // </MapContainer>

  console.log(order);
  console.log(tracking_id);
  return (
    <div>
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
              }}
              className="order--tracking-btn"
            >
              Send
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
