import axios from "axios";
import React from "react";
import { useEffect } from "react";
import { useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import "./Product.css";

export default function Product() {
  const [product_name, setProduct_name] = useState("");
  const [firstname, setFirstname] = useState("");
  const [price, setPrice] = useState("");
  const [quantity, setQuantity] = useState("");
  const [category, setCategory] = useState(" ");
  const [image, setImage] = useState("");
  const [imageup, setImageup] = useState("");
  const [description, setDescription] = useState();
  const [imageprev, setImageprev] = useState();
  const [feature_image, setFeature_image] = useState();
  const [user_id, setUser_id] = useState("");
  const [biz_name, setBiz_name] = useState("");
  const [add, setAdded] = useState("");
  const [msg, setMsg] = useState("");

  const history = useNavigate();

  const { productid } = useParams();

  const changeCategory = (newCategory) => {
    setCategory(newCategory);
  };

  useEffect(() => {
    const token = JSON.parse(localStorage.getItem("token"));

    const refreshToken = async (token) => {
      try {
        const response = await axios.get("http://localhost:8000/api/profile/", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setUser_id(response.data.biz_id);
        setBiz_name(response.data.biz_name);
        setFirstname(response.data.firstname);
      } catch (error) {
        if (error.response) {
          console.log(error.response.data);
          history("/login");
        }
      }
    };

    refreshToken(token);
  }, [history]);

  function handleChange(e) {
    setImageprev(URL.createObjectURL(e.target.files[0]));
    setImage(e.target.files[0]);
  }

  const handleSubmit = async (e) => {
    // prevent the form from refreshing the whole page
    e.preventDefault();
    //-----------------
    const formData = new FormData();
    formData.append("product_name", product_name);
    formData.append("price", price);
    formData.append("quantity", quantity);
    formData.append("category", category);
    formData.append("image", image);
    formData.append("feature_image", feature_image);
    formData.append("biz_name", biz_name);
    formData.append("user_id", user_id);
    formData.append("description", description);

    try {
      await axios
        .post("http://localhost:8000/api/add-product", formData, {
          headers: {
            "Access-Control-Allow-Origin": "http://localhost:3000/",
          },
        })
        .then((res) => {
          setProduct_name("");
          setPrice("");
          setQuantity("");
          setCategory("");
          setDescription("");
          setBiz_name("");
          setImage();
          setFeature_image();
          setImageprev();

          setAdded(res.data.msg);
        });
    } catch (error) {
      if (error.response) {
        setMsg(error.response.data.msg);
      }
    }
    //----------------
  };

  const updateProduct = async (e) => {
    // prevent the form from refreshing the whole page
    e.preventDefault();
    //-----------------
    const formData = new FormData();
    formData.append("productid", productid);
    formData.append("product_name", product_name);
    formData.append("price", price);
    formData.append("quantity", quantity);
    formData.append("category", category);
    formData.append("image", image);
    formData.append("feature_image", feature_image);
    formData.append("biz_name", biz_name);
    formData.append("user_id", user_id);
    formData.append("description", description);

    try {
      await axios
        .post("http://localhost:8000/api/update-product", formData, {
          headers: {
            "Access-Control-Allow-Origin": "http://localhost:3000/",
          },
        })
        .then((result) => {});
    } catch (error) {
      if (error.response) {
        setMsg(error.response.data.msg);
      }
    }
    //----------------
    history(`/${firstname}/${user_id}`);
  };

  useEffect(() => {
    const getProductById = async (productid) => {
      //----------------
      try {
        const res = await axios.post(
          `http://localhost:8000/api/one-product`,
          {
            productid,
          },
          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        );

        setProduct_name(res.data.pro.product_name);
        setPrice(res.data.pro.price);
        setCategory(res.data.pro.category);
        setQuantity(res.data.pro.quantity);
        setDescription(res.data.pro.description);
        setImageup(res.data.pro.image);
        setFeature_image(res.data.pro.feature_image);
        console.log(res.data.pro);
      } catch (error) {
        if (error.data) {
        }
      }

      //-------------
    };

    getProductById(productid);
  }, [productid]);

  function clearEntry() {
    setProduct_name("");
    setPrice("");
    setQuantity("");
    setCategory("");
    setDescription("");
    setBiz_name("");
    setImage();
    setFeature_image();
    setImageprev();
  }
  //6c4849d7054d66eb438a7e26867a6390
  return (
    <div className="product__wrap">
      <form method="POST" encType="multipart/form-data">
        <div className="add__product-container">
          <div className="hdparent">
            <h2 className="product__header">Add Product</h2>
          </div>
          <div className="form-group ">{msg}</div>
          <div className="form-group ">{add}</div>
          <div className="form-group-parent2">
            <div className="form-group "></div>

            <div className="input_parent">
              <input
                type="text"
                id="product_name"
                name="product_name"
                placeholder="Product Name"
                className="product_name"
                value={product_name}
                onChange={(e) => setProduct_name(e.target.value)}
              />
              <label htmlFor="product_name" className="lab-Text">
                Product Name
              </label>
            </div>
            <div className="help_parent">
              <span className="help-block"></span>
            </div>
          </div>

          <div className="form-group-parent2">
            <div className="form-group "></div>

            <div className="input_parent">
              <input
                min={1}
                type="number"
                id="price"
                name="price"
                placeholder="Product Price"
                className="form__control-num"
                value={price}
                onChange={(e) => setPrice(e.target.value)}
              />
              <label htmlFor="price" className="labText-num">
                Product Price
              </label>
            </div>
            <div className="help_parent">
              <span className="help-block"></span>
            </div>
          </div>

          <div className="form-group-parent2">
            <div className="form-group "></div>

            <div className="input_parent">
              <input
                min={1}
                type="number"
                id="quantity"
                name="quantity"
                placeholder="Product Quantity"
                className="form__control-num"
                value={quantity}
                onChange={(e) => setQuantity(e.target.value)}
              />
              <label htmlFor="quantity" className="labText-num">
                Product Quantity
              </label>
            </div>
            <div className="help_parent">
              <span className="help-block"></span>
            </div>
          </div>

          <div className="form-group-parent1">
            <div className="input_parent">
              <select
                className="select__category"
                value={category}
                onChange={(event) => changeCategory(event.target.value)}
              >
                {productid ? (
                  <option value="">{category}</option>
                ) : (
                  <option value="">Select Category</option>
                )}

                <option value="New Arrivals">New Arrivals</option>
                <option value="Trending Items">Trending Items</option>
                <option value="Featured Items">Featured Items</option>
                <option value="Top Deals">Top Deals</option>
              </select>
            </div>

            <div className="help_parent">
              <span className="help-block"></span>
            </div>
          </div>

          <div className="form-group-parent1">
            <div className="form-group "></div>
            <div className="description__parent">
              <textarea
                name="description"
                form="description"
                id="description"
                required
                placeholder="Product Description"
                value={description}
                onChange={(e) => setDescription(e.target.value)}
              ></textarea>
              <label htmlFor="description" className="form__label">
                Product Description
              </label>
            </div>
            <div className="help_parent">
              <span className="help-block"></span>
            </div>
          </div>

          <div className="form__group--parent--file">
            <div className="fileBtn__parent">
              <input type="file" name="file" onChange={handleChange} />
            </div>
            <div className="img__holder">
              <img
                className="img__cont"
                alt="avatarimg"
                src={imageprev}
                id="profileDisplay"
              />
            </div>

            {productid ? (
              <div className="img__holder">
                <img
                  className="img__cont"
                  alt="avatarimg"
                  src={`http://localhost:8000/storage/product/image/${imageup}`}
                />
              </div>
            ) : null}
          </div>

          <div className="form-group-submit-parent">
            {productid ? (
              <input
                type="submit"
                className="btn__submit"
                onClick={(e) => updateProduct(e)}
                value="Update"
              />
            ) : (
              <input
                type="submit"
                className="btn__submit"
                onClick={(e) => handleSubmit(e)}
                value="Post"
              />
            )}

            <input
              type="reset"
              className="btn-reset"
              onClick={(e) => clearEntry(e)}
              value="Reset"
            />
          </div>
        </div>
      </form>
    </div>
  );
}
