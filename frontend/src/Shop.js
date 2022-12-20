import React, { useState } from "react";
import styled from "styled-components";
import Icon from "./Icon";
import "./Shop.css";
import "./footer_style.css";
import { useEffect } from "react";
import axios from "axios";
import { Link, useParams } from "react-router-dom";
import { ShoppingCart } from "@mui/icons-material";
import Item from "./Components/CartItems/Item";
import { useSelector } from "react-redux";
import Footer from "./Footer";

export default function Shop() {
  const [token, setToken] = useState("");
  const [[...arrivals], setArrivals] = useState([]);
  const [[...trending], setTrending] = useState([]);
  const [[...products], setProducts] = useState([]);

  //const [cartDetails, setCartDetails] = useState([]);
  // const [[...product], setProduct] = useState([]);

  const { biz_id } = useParams();
  const cart = useSelector((state) => (state.cart ? state.cart : []));

  //const [showCartStatus,setShowCartStatus] = useState(false);
  useEffect(() => {
    const edit = localStorage.getItem("token");
    setToken(edit);
  }, []);

  useEffect(() => {
    const getNewArrivals = async (biz_id) => {
      //------------------
      try {
        const res = await axios.post(
          `http://localhost:8000/api/new-arrivals/`,

          {
            biz_id,
          },
          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        );
        setArrivals(res.data.Prod);
      } catch (error) {
        if (error.data) {
        }
      }
      //---------------------
    };

    const getTrendingItems = async (biz_id) => {
      //------------------
      try {
        const res = await axios.post(
          `http://localhost:8000/api/trending-items/`,

          {
            biz_id,
          },
          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        );
        setTrending(res.data.Prod);
      } catch (error) {
        if (error.data) {
        }
      }
      //---------------------
    };
    const getHomeProducts = async () => {
      //------------------
      try {
        const res = await axios.get(
          `http://localhost:8000/api/homeproducts/`,

          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        );
        //setProduct(res.data)
        const product = res.data;
        const products = product.map((item) => {
          const title = item.product_name;
          const price = item.price;
          const id = item.productid;
          const image = item.image;
          const category = item.category;
          return { title, price, id, image, category };
        });
        setProducts(products);
      } catch (error) {
        if (error.data) {
        }
      }
      //---------------------
    };
    //storage(product)
    getTrendingItems(biz_id);
    getNewArrivals(biz_id);
    getHomeProducts();
  }, [biz_id]);

  const deleteProduct = async (productid) => {
    await axios.post(
      `http://localhost:8000/api/delete-product/`,
      {
        productid,
      },
      {
        headers: {
          "Access-Control-Allow-Origin": "http://localhost:3000/",
        },
      }
    );

    const getProducts = async (biz_id) => {
      try {
        await axios
          .post(
            `http://localhost:8000/api/new-arrivals/`,
            {
              biz_id,
            },
            {
              headers: {
                "Access-Control-Allow-Origin": "http://localhost:3000/",
              },
            }
          )
          .then((res) => setArrivals(res.data.Prod));
      } catch (error) {
        if (error.data) {
        }
      }
    };
    getProducts(biz_id);
  };
  //==================================================
  const getTotalQuantity = () => {
    let total = 0;
    cart.forEach((item) => {
      total += item.quantity;
    });
    return total;
  };

  return (
    <Container>
      <NavHeader>
        <div className="search_parent">
          <input
            className="search_input"
            spellCheck="false"
            placeholder="Search here"
            type="text"
          />
        </div>

        <div className="cart_bag">
          <ShoppingCart id="cartIcon" />
          <p>{getTotalQuantity() || 0}</p>
        </div>
      </NavHeader>

      <ProductDisplay>
        {!products
          ? "Loading . . . "
          : products.map((shop) => (
              <div className="home" key={shop.id}>
                <div className="home__container">
                  <div className="home__row">
                    <Item
                      id={shop.id}
                      title={shop.title}
                      price={shop.price}
                      image={shop.image}
                    />
                  </div>
                </div>
              </div>
            ))}
        {/* --------------------------------------- */}
      </ProductDisplay>

      <FooterMain>
        <Footer />
      </FooterMain>
    </Container>
  );
}

const Container = styled.div`
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  overflow-x: hidden;
  overflow-y: hidden;
  background: navy;
`;
const NavHeader = styled.div`
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-around;
  width: 100%;
  height: 10%;
  padding: 1%;
  color: white;
  position: sticky;
  top: 0;
  z-index: 1;
  background-image: linear-gradient(
    to right bottom,
    rgba(76, 0, 130, 0.5),
    rgba(100, 0, 0, 0.5)
  );
`;

const ProductDisplay = styled.div`
  width: 100%;
  height: 100%;
  background: navy;
  overflow-x: hidden;
  overflow-y: scroll;
`;

const FooterMain = styled.div``;
