import React from "react";
import { Route, Routes } from "react-router-dom";
//import { Counter } from './features/counter/Counter';
import "./App.css";
import Admin from "./Components/AdminArea/Admin";
import Cweb from "./Cweb";
import Login from "./Login/Login";
import Register from "./Register/Register";
import Shop from "./features/products/Shop";
//import Shop from './Shop';

function App() {
  return (
    <div className="App">
      <Routes>
        <Route path="/" element={<Cweb />} />
        <Route path="/register" element={<Register />} />
        <Route path="/login" element={<Login />} />
        <Route path="/dashboard" element={<Admin />} />
        {/* <Route exact path="/:firstname/:biz_id"  element={<Shop/ >} /> */}
        <Route exact path="/:firstname/:biz_id" element={<Shop />} />

        <Route path="/dashboard/product/:productid" element={<Admin />} />
      </Routes>
    </div>
  );
}

export default App;
