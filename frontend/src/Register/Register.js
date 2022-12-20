import React from "react";
import "./register.css"
import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

import { Link } from "react-router-dom";



function Register() {
  const [firstname, setFirstname] = useState("");
  const [lastname, setLastname] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [phoneno, setPhoneno] = useState("");
  const [register, setRegister] = useState(false);
  const [imageprev, setImageprev] = useState();
  const [image, setImage] = useState();
  const history = useNavigate();
  const [msg, setMsg] = useState('');
  const [userurl, setUserurl] = useState('');
  const [biz_name, setBiz_name] = useState('');

  
  function handleChange(e) { 
  setImageprev(URL.createObjectURL(e.target.files[0]));
  setImage(e.target.files[0]);
  }

  const handleSubmit = async (e) => {
    // prevent the form from refreshing the whole page
    e.preventDefault();
    //-----------------
    const formData = new FormData()
    formData.append('firstname', firstname)
    formData.append('lastname', lastname)
    formData.append('password', password)
    formData.append('email', email)
    formData.append('image', image)
    formData.append('phoneno', phoneno)
    formData.append('biz_name', biz_name)
    try{
      await axios.post('http://localhost:8000/api/register',
      formData,
      {headers: {
    
         'Access-Control-Allow-Origin': 'http://localhost:3000/'
     }},
      
      
         
        
    ).then((result) => {
      
      setUserurl(result.data.user.biz_id);
      console.log(result.data.user.biz_id);
      console.log(userurl);
      setRegister(true)
      if(result){
        
        history("/login");
      }
    })
    
    }catch (error)  {
      if (error.response) {
        setMsg(error.response.data.msg);
    }
    }
    //----------------

  }
  function clearEntry(){
    setFirstname('')
    setLastname('')
    setPhoneno('')
    setPassword('')
    setEmail('')
    setBiz_name('')
    setImage()
    setImageprev()
  }
  
  return (

    <><div className="wrapper_flexB">
      <div className="h2parent">
        <h2 className="login_header">Sign Up</h2>
      </div>
      <div className="paraparent">
        <p className="para_details">Please fill this form to create an account.</p>
      </div>
      <form encType="multipart/form-data"  method="post">
      
        <div className="form-group-parent2">
        <div className="form-group"><p className="has-text-centered">{msg}</p></div>
          <div className="input_parent">
            <input
              type="text"
              id="firstname"
              name="firstname"
              placeholder="First Name"
              className="form-control"
              value={firstname}
              onChange={(e) => setFirstname(e.target.value)} 
              />
            <label htmlFor="firstname" className="labText">First Name</label>
          </div>
          <div className="help_parent"><span className="help-block"></span></div>
        </div>

        <div className="form-group-parent2">
          <div className="input_parent">
            <input
              type="text"
              id="lastname"
              name="lastname"
              placeholder="Last Name"
              className="form-control"
              value={lastname}
              onChange={(e) => setLastname(e.target.value)}
              />
            <label htmlFor="lastname" className="labText">Last Name</label>
          </div>
          <div className="help_parent"><span className="help-block"></span></div>
        </div>

        <div className="form-group-parent2">
          <div className="input_parent">
            <input
              type="password"
              id="password"
              name="password"
              autoComplete="none"
              placeholder="Password"
              className="form-control"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
               />
            <label htmlFor="password" className="labText">Password</label>
          </div>
          <div className="help_parent"> <span className="help-block"></span></div>
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
            <label htmlFor="phoneno" className="labText">Phone Number</label>
          </div>
          <div className="help_parent"><span className="help-block"></span></div>
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
            <label htmlFor="email" className="labText">Email</label>
          </div>
          <div className="help_parent"><span className="help-block"></span></div>
        </div>

        
        <div className="form-group-parent2">
          <div className="input_parent">
            <input
              type="text"
              name="biz_name"
              id="biz_name"
              placeholder="Bussiness Name"
              className="form-control"
              value={biz_name}
              onChange={(e) => setBiz_name(e.target.value)}
              />
            <label htmlFor="biz_name" className="labText">Bussiness Name</label>
          </div>
          <div className="help_parent"><span className="help-block"></span></div>
        </div>

  <div className="form__group--parent--file">
  <div className="fileBtn__parent">
    <input  type="file" name='file' onChange={handleChange} /> 
 
    </div>

    <div className="img__parent">
    <img
    className="img__content"
    alt='avatarimg' 
    src={imageprev}
    id="profileDisplay" />
    
    </div>
  </div>

        <div className="form__group--submit-parent">
          
            <input type="submit" className="btn__submit" onClick={(e) => handleSubmit(e)} value="Register" />

            <input type="reset" className="btn-reset" onClick={(e) => clearEntry(e)}  value="Reset" />
          
        </div>
        <div className="link_parent">
          <p className="reg_para">Already have an account?<Link to="/login" className="reg_link">Login</Link></p>
        </div>
          {/* display success message */}
          {register ? (
            <p className="text-success">You Are Registered Successfully</p>
          ) : (
            <p className="text-danger">You Are Not Registered</p>
          )}
      </form>
    </div>

       </>
  );
}

export default Register
