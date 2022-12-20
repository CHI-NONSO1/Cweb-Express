import React, { useState } from "react";
import "./Login.css";
import { Link } from "react-router-dom";
import axios from "axios";
import { useNavigate } from "react-router-dom";
//import PropTypes from 'prop-types'

export default function Login({ setToken }) {
  const [email, setEmail] = useState();
  const [password, setPassword] = useState();
  const [msg, setMsg] = useState("");
  const history = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios
        .post(
          "http://localhost:8000/api/login",

          {
            email: email,
            password: password,
          },
          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        )
        .then((result) => {
          localStorage.setItem(
            "token",
            JSON.stringify(result.data.access_token)
          );

          if (result) {
            history("/dashboard");
          }
        });
    } catch (error) {
      if (error.response) {
        setMsg(error.response.data.message);
      }
    }
  };

  return (
    <div className="wrapper_flex">
      <div className="h2parent">
        <h2 className="login_header">Login</h2>
      </div>
      <div className="paraparent">
        <p className="para_details"></p>
      </div>
      <form method="post" onSubmit={handleSubmit}>
        <div className="form-group-parent2">
          <div className="form-group">
            <p className="has-text-centered">{msg}</p>
          </div>

          <div className="input1_parent">
            <input
              type="text"
              id="email"
              placeholder="Email"
              onChange={(e) => setEmail(e.target.value)}
              name="accountname"
              className="form-control"
            />
            <label htmlFor="email" className="labText">
              Email
            </label>
          </div>
          <div className="help_parent">
            {" "}
            <span className="help-block"></span>
          </div>
        </div>

        <div className="form-group-parent2">
          <div className="form-group"></div>

          <div className="input_parent">
            <input
              type="password"
              id="password"
              placeholder="Password"
              onChange={(e) => setPassword(e.target.value)}
              autoComplete="none"
              name="password"
              className="form-control"
            />
            <label htmlFor="password" className="labText">
              Password
            </label>
          </div>
          <div className="help_parent">
            {" "}
            <span className="help-block"></span>
          </div>
        </div>

        <div className="form-group-submit-parent">
          <input type="submit" className="btn_submit" value="Login" />
        </div>

        <div className="link_parent">
          <p className="reg_para">
            Don't have an account?
            <Link to="/register" className="reg_link">
              Register
            </Link>
          </p>
        </div>
      </form>
    </div>
  );
}

// Login.propTypes = {
//   setToken: PropTypes.func.isRequired
// }
