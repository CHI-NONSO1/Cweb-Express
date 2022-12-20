import React, { useState } from "react";
import styled from "styled-components";
import "./Shop.css";
import "./search.css";
import CartTable from "../../cart/cartStore";
import "../../footer_style.css";
import { useEffect } from "react";
import axios from "axios";
import { Link, useParams } from "react-router-dom";
import { ShoppingCart } from "@mui/icons-material";

import { useSelector, useDispatch } from "react-redux";
import { setProduct } from "./productsSlice";
import { addToCart } from "./cartSlice";
import Icon from "../../Icon";
import Cart from "../../cart/Cart";
import Search from "./Search";
import Details from "./Details";
import Footer from "../../Footer";

export default function Shop() {
  const [token, setToken] = useState("");
  const [[...products], setProducts] = useState([]);
  const [[...searchItems], setSearchItems] = useState([]);
  const [details, setDetails] = useState();
  const [price, setPrice] = useState("");
  const [category, setCategory] = useState("");
  const [searchQuery, setSearchQuery] = useState("");

  const dispatch = useDispatch();
  const cart = useSelector((state) => state.cartItem);

  const { biz_id } = useParams();

  const [showCartStatus, setShowCartStatus] = useState(false);
  const [showSearchStatus, setShowSearchStatus] = useState(false);
  const [isOpen, setIsOpen] = useState(false);
  useEffect(() => {
    const edit = localStorage.getItem("token");
    setToken(edit);
  }, []);

  const cartInBag = new CartTable(null, null);

  localStorage.setItem("products", JSON.stringify(products));
  useEffect(() => {
    const sortProductsByCategory = async (category) => {
      //   //------------------
      try {
        const res = await axios.post(
          `http://localhost:8000/api/category/`,

          {
            biz_id,
            category,
          },
          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        );
        const filterByCat = res.data.Pro;
        const products = filterByCat.map((item) => {
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
    };
    //   //---------------------
    sortProductsByCategory(category);
  }, [biz_id, category]);

  useEffect(() => {
    const sortProductsByPrice = async (price) => {
      //   //------------------
      try {
        const res = await axios.post(
          `http://localhost:8000/api/price/`,

          {
            biz_id,
            price,
          },
          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        );
        const filterByPrice = res.data.Pro;
        const products = filterByPrice.map((item) => {
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
    };
    //   //---------------------

    sortProductsByPrice(price);
  }, [biz_id, price]);

  useEffect(() => {
    const searchProducts = async (searchQuery) => {
      //   //------------------
      try {
        const res = await axios.post(
          `http://localhost:8000/api/search-products/`,

          {
            biz_id,
            searchQuery,
          },
          {
            headers: {
              "Access-Control-Allow-Origin": "http://localhost:3000/",
            },
          }
        );
        const searchResults = res.data.Pro;
        const productsOutCome = searchResults.map((item) => {
          const title = item.product_name;
          const price = item.price;
          const id = item.productid;
          const image = item.image;
          const category = item.category;

          return { title, price, id, image, category };
        });
        setSearchItems(productsOutCome);
      } catch (error) {
        if (error.data) {
        }
      }
    };

    //   //---------------------

    searchProducts(searchQuery);
  }, [biz_id, searchQuery]);

  useEffect(() => {
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
        dispatch(setProduct(product));
      } catch (error) {
        if (error.data) {
        }
      }
      //---------------------
    };

    getHomeProducts();
  }, [biz_id, dispatch]);

  var toCart = {};

  const getProductById = async (productid, e) => {
    let cartProduct = products.find((product) => product.id === productid);

    const id = cartProduct.id;
    const title = cartProduct.title;
    const price = cartProduct.price;
    const image = cartProduct.image;
    const category = cartProduct.category;
    const quantity = 0;
    toCart = { id, title, price, image, category, quantity };
  };

  const getProductDteails = async (productid) => {
    let detailProduct = products.find((product) => product.id === productid);
    setDetails(detailProduct);
    setIsOpen(true);
  };

  const allProducts = products.length;

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

    const getProducts = async () => {
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
        dispatch(setProduct(product));
      } catch (error) {
        if (error.data) {
        }
      }
      //---------------------
    };
    getProducts();
  };
  //==================================================

  const closeModal = () => {
    setIsOpen(false);
  };

  const getTotalQuantity = () => {
    let totQTY = 0;
    //let totPrice = 0;
    cart.forEach((item) => {
      totQTY += item.quantity;
      //totPrice += totQTY * item.price;
    });

    return totQTY;
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
            onChange={(e) => {
              setSearchQuery(e.target.value);
              setShowSearchStatus(true);
            }}
          />
        </div>

        <CartBag
          onClick={() => {
            setShowCartStatus(true);
          }}
        >
          <ShoppingCart id="cartIcon" />
          <CartCount>{getTotalQuantity() || 0}</CartCount>
        </CartBag>
      </NavHeader>
      <FilterProduct>
        <div className="filter">
          <div className="filter-result">{allProducts} Products</div>
          <div className="filter-sort">
            {" "}
            <select
              // value={category}
              onChange={(e) => setCategory(e.target.value)}
            >
              <option value="">Filter By Category</option>
              <option value="New Arrivals">New Arrivals</option>
              <option value="Trending Items">Trending Items</option>
              <option value="Featured Items">Featured Items</option>
              <option value="Top Deals">Top Deals</option>
            </select>
          </div>
          <div className="filter-size">
            {" "}
            <select
              // value={price}
              onChange={(e) => setPrice(e.target.value)}
            >
              <option value="">Filter By Price</option>
              <option value="5000">0-5000</option>
              <option value="10000">5000-10000</option>
              <option value="20000">10000-20000</option>
              <option value="30000">20000-30000</option>
              <option value="40000">30000-40000</option>
              <option value="50000">40000-50000</option>
              <option value="60000">60000-70000</option>
              <option value="70000">70000-80000</option>
              <option value="80000">80000-90000</option>
              <option value="90000">90000-100000</option>
              <option value="100000">100k</option>
            </select>
          </div>
        </div>
      </FilterProduct>

      <ProductDisplay>
        <div className="product__wrap">
          {products === []
            ? "loading . . ."
            : products.map((shop, index) => (
                <div className="product_display_container" key={index}>
                  <div className="">
                    <div className="image__wrap">
                      <a
                        className="link__wrap"
                        href={"#" + shop.id}
                        onClick={() => {
                          getProductDteails(shop.id);
                          setIsOpen(true);
                        }}
                      >
                        <img
                          className="product_img"
                          src={`http://localhost:8000/storage/product/image/${shop.image}`}
                          alt={shop.title}
                        />
                      </a>
                    </div>
                    <div className="product_discription">{shop.title}</div>
                    <div className="items__price">
                      <span className="currency__sign">N</span>
                      {shop.price}
                    </div>
                    <div className="items__cate">{shop.category}</div>

                    <button
                      className="add__cart--btn"
                      onClick={(e) => {
                        getProductById(shop.id, e);
                        dispatch(addToCart(toCart));
                        setShowCartStatus(true);
                        cartInBag.insert(shop.title, toCart);
                      }}
                    >
                      Add to Cart
                    </button>

                    {/* ==================Admin================== */}
                    <div className="admin__log-area">
                      {token ? (
                        <>
                          <span>
                            <Link
                              to={`/dashboard/product/${shop.productid}`}
                              className="btn_edit"
                            >
                              Edit
                            </Link>
                          </span>
                          <span>
                            <button
                              onClick={() => deleteProduct(shop.productid)}
                              className="btn_del"
                            >
                              Del
                            </button>
                          </span>
                        </>
                      ) : null}
                    </div>
                  </div>
                </div>
              ))}
        </div>
      </ProductDisplay>
      {/* ======= */}
      <DetailsDescription show={isOpen}>
        <div className="close__details" onClick={closeModal}>
          <Icon icon="close" size={20} color="white" />
        </div>
        <Details details={details} />
      </DetailsDescription>

      {/* ========== */}

      {/* --------------------------------------- */}

      <ShowCart show={showCartStatus}>
        <CloseCart
          onClick={() => {
            setShowCartStatus(false);
          }}
        >
          <Icon icon="close" size={20} color="white" />
        </CloseCart>
        <Cart cart={cart} />
      </ShowCart>
      <SearchWrap show={showSearchStatus}>
        <CloseSearchBox
          onClick={() => {
            setShowSearchStatus(false);
          }}
        >
          <Icon icon="close" size={20} color="white" />
        </CloseSearchBox>
        <Search searchItems={searchItems} />
      </SearchWrap>

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
  overflow-y: hidden;
`;
const ShowCart = styled.div`
  width: 40%;
  height: 80%;
  transition: all 0.3s linear;
  z-index: 30;
  position: absolute;
  top: 10%;
  right: 0;
  overflow-x: hidden;
  overflow-y: scroll;
  background: navy;
  transform: ${(props) => (props.show ? "translateX(0)" : "translateX(120%)")};
  @media (max-width: 820px) {
    width: 90%;
  }
`;
const CartBag = styled.div`
  width: 4%;
  height: 100%;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
`;

const CartCount = styled.button`
  position: absolute;
  top: 0;
  right: 28%;
  width: 30%;
  height: 50%;
  border-radius: 10%;
  background-color: orangered;
  color: #fff;
  padding: 0%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 50%;
  @media (max-width: 820px) {
    width: 85%;
    height: 30%;
    position: absolute;
    top: 19%;
    right: 10%;
  }
`;
const CloseCart = styled.div`
  width: 10%;
  height: 10%;
  transition: all 0.3s linear;
  z-index: 300;
  position: absolute;
  top: 0%;
  right: 85%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
`;

const FilterProduct = styled.div`
  width: 95%;
  height: 5%;
  display: flex;
  justify-content: space-between;
  border: 0.5rem;
  margin: 0 auto;

  div {
    flex: 1;
  }
  @media (max-width: 820px) {
    width: 65%;
    margin-left: -1%;
  }
`;
const SearchWrap = styled.div`
  position: fixed;
  top: 10%;
  left: -8.8%;
  right: 5%;
  width: 62%;
  height: 80%;
  background: rgba(76, 0, 130, 0.9);
  margin: 0 auto;
  overflow-y: scroll;
  overflow-x: hidden;
  z-index: 3;
  transition: transform 1s linear;
  transform: ${(props) =>
    props.show ? "translateY(0)" : "translateY(-3000px)"};
  @media (max-width: 820px) {
    position: fixed;
    top: 10%;
    left: -3%;
    right: 5%;
    width: 85%;
    height: 50%;
    margin: 0 auto;
  }
`;
const CloseSearchBox = styled.div`
  z-index: 4;
`;

const DetailsDescription = styled.div`
  width: 90%;
  height: 90%;
  position: absolute;
  top: 10%;
  left: 5%;
  bottom: 20%;
  right: 5%;
  background: rgba(7, 30, 255);
  z-index: 100;
  border: 0.3rem #dedede solid;
  transform: ${(props) =>
    props.show ? "translateY(0)" : "translateY(3000px)"};
`;
const FooterMain = styled.div``;
