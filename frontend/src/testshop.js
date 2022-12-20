import React, { useState } from 'react'
import styled from 'styled-components'
import Icon from './Icon'
import './Shop.css'
import './search.css'
import './footer_style.css'
import { useEffect } from 'react'
import axios from 'axios'
import { Link, useParams } from 'react-router-dom'



export default function Shop() {
  const [token, setToken] = useState('');
  const [[...arrivals], setArrivals] = useState([]);
  const [[...trending], setTrending] = useState([]);

  //const [cartDetails, setCartDetails] = useState([]);
 // const [[...product], setProduct] = useState([]);

  const {biz_id} = useParams();


//const [showCartStatus,setShowCartStatus] = useState(false);
  useEffect(() => {
    const edit = localStorage.getItem('token');
    setToken(edit);
  }, []);

  useEffect(() => {
      const getNewArrivals = async (biz_id) => {
    //------------------
    try {
      const res = await axios.post(`http://localhost:8000/api/new-arrivals/`,
      
       {
        biz_id
      },
      {headers: {
      
        'Access-Control-Allow-Origin': 'http://localhost:3000/'
     }}
      ) 
    setArrivals(res.data.Prod)

    
  } catch (error) {
    if (error.data) {   
    }
  }
  //---------------------
  }

  const getTrendingItems = async (biz_id) => {
    //------------------
    try {
      const res = await axios.post(`http://localhost:8000/api/trending-items/`,
      
       {
        biz_id
      },
      {headers: {
      
        'Access-Control-Allow-Origin': 'http://localhost:3000/'
     }}
      ) 
    setTrending(res.data.Prod)
 
    
  } catch (error) {
    if (error.data) {   
    }
  }
  //---------------------
  }
  const getHomeProducts = async () => {
    //------------------
    try {
      const res = await axios.get(`http://localhost:8000/api/homeproducts/`,
      
    
      {headers: {
      
        'Access-Control-Allow-Origin': 'http://localhost:3000/'
     }}
      ) 
    //setProduct(res.data)
    const product = res.data
    const  products = product.map(item => { 
  
      const title = item.product_name;
      const price = item.price;
      const id = item.productid;
      const image = item.image;
      const category = item.category;
      return {title,price,id,image,category}
    });
    localStorage.setItem('products',JSON.stringify(products));
  
    
    
  } catch (error) {
    if (error.data) {   
    }
  }
  //---------------------
  }
  //storage(product)
  getTrendingItems(biz_id)
  getNewArrivals(biz_id)
  getHomeProducts()

  }, [biz_id])

  const deleteProduct = async (productid) => {
    await axios.post(`http://localhost:8000/api/delete-product/`,
    {
      productid
    },
    {headers: {
      'Access-Control-Allow-Origin': 'http://localhost:3000/'
  }}   
    
    );
  
    const getProducts = async (biz_id) => {
      try {
            await axios.post(`http://localhost:8000/api/new-arrivals/`,
            {
              biz_id
            },
            {headers: {
              'Access-Control-Allow-Origin': 'http://localhost:3000/'
        }}  
            
            )   
      .then(res => setArrivals(res.data.Prod))
  
    } catch (error) {
      if (error.data) {   
      }
    }
    
    }
  getProducts(biz_id)
  }
  //==================================================
useEffect(() => {
  
  const cartBtN = [...document.querySelectorAll('.add_cart')];
  for(var i = 0; i < cartBtN.length; i++){
   let BTN = cartBtN[i];
    BTN.addEventListener('click',getBTN)
  }
  
  
 async function getBTN(e){
  e.preventDefault();
    var dataId = e.target.dataset.id
    let products = JSON.parse(localStorage.getItem("products"));
   var putCart = await products.find(product => product.id === dataId);
    
    console.log(putCart);
    console.log(dataId);
  }

 
})



 

 
  return (
    <Container>
      <NavHeader>
      <div className="search_parent">
      <input className="search_input" spellCheck="false" placeholder="Search here" type="text" />
    </div>

    <div className="cart_bag"
     onClick={()=>{
      //showCart()
      //setShowCartStatus(true)
     }}>
    <Icon icon="shopping-cart" size={20} color="white" />
      <span className="cart_count">0</span>
    </div>
      </NavHeader>
    
    
      <ProductDisplay>
      <div className='search_container_parent'>

      <div className='search_heading-parent' id='search_heading'>
        <div className='close-search'>
        <Icon icon="cross" size={20} color="white" />
        </div>
        <div className='text_parent'>
          <span className='search_heading_text'>Your Search Returned </span>
        </div>
      </div>
      </div>
        {!arrivals ? (
            <div className='product_display'>
            {"Loading . . ."}
          </div>
        ):(
          <React.Fragment>
              <div className='product_header'>
      <span className='header_discription'>Power Generators</span>
   </div>

    <div className='product_display_container'>
   
      {arrivals === [] ?
        
        <div className='product_display'>
          {"Loading . . ."}
        </div>
       
    
    :  arrivals.map((arr,index) =>(
      <div className='product_display-flex' key={index}>
    <div className='product__display' >
      <div className='product_image_parent' >
      <img className='product_img' src= {`http://localhost:8000/storage/product/image/${arr.image}`} alt='productimage' />
          <button className='add_cart' data-id = {arr.productid}
           onClick={(e)=>{
           // getProduct(arr.productid)
           // getBagButtons(arr.productid)
           // setShowCartStatus(true)
          }}
          >Add To Bag</button>
          <span className='product_discription'>{arr.product_name}</span>
          <span className='product_price'><span className = 'naira'>N</span>{arr.price}</span>

          <div>
          {token?(
            <>
          <span>
          <Link 
          to={`/dashboard/product/${arr.productid}`} 
          className="btn_edit">Edit</Link>
          </span>
          <span>
          <button onClick={ () => deleteProduct(arr.productid) } 
          className="btn_del">Del</button>
          </span>
          </>

          ):( null)
        
        }
          </div>
          </div>
          <div className='id_parent' >
          <span className='product_id'>{arr.productid}</span>
          </div>
      
  </div>
      </div>
     

  ))}
  
  
  </div>
  {/* ============================== */}
  <div className="pagination">
  <div className="page_flex">
    <div className="first_parent">
      <div className="first">
      <Icon icon="cheveron-left" size={20} color="white" />
      </div>
    </div>
    <div className="next_parent">
      <div className="next">
      <Icon icon="cheveron-left" size={20} color="white" />
      </div>
    </div>
    <div className="previous_parent">
      <div className="previous">
      <Icon icon="cheveron-right" size={20} color="white" />
      </div>
    </div>
    <div className="last_parent">
      <div className="last">
      <Icon icon="cheveron-right" size={20} color="white" />
      </div>
    </div>
  </div>
</div>
  {/* ============================== */}
          </React.Fragment>
        )}
        {/* ===============Trending Items================ */}

        {!trending ? (
            <div className='product_display'>
            {"Loading . . ."}
          </div>
        ):(
          <React.Fragment>
              <div className='product_header'>
      <span className='header_discription'>Trending Items</span>
   </div>

    <div className='product_display_container'>
   
      {trending === [] ?
        
        <div className='product_display'>
          {"Loading . . ."}
        </div>
       
    
    :  trending.map((arr,index) =>(
      <div className='product_display-flex' key={index}>
    <div className='product__display' >
      <div className='product_image_parent' >
      <img className='product_img' src= {`http://localhost:8000/storage/product/image/${arr.image}`} alt='productimage' />
          <button className='add_cart' data-id = {arr.productid}
          onClick={()=>{
           // getBagButtons()
          }}
          
          >Add To Bag</button>
          <span className='product_discription'>{arr.product_name}</span>
          <span className='product_price'><span className = 'naira'>N</span>{arr.price}</span>

          <div>
          {token?(
            <>
          <span>
          <Link 
          to={`/dashboard/product/${arr.productid}`} 
          className="btn_edit">Edit</Link>
          </span>
          <span>
          <button onClick={ () => deleteProduct(arr.productid) } 
          className="btn_del">Del</button>
          </span>
          </>

          ):( null)
        
        }
          </div>
          </div>
          <div className='id_parent' >
          <span className='product_id'>{arr.productid}</span>
          </div>
      
  </div>
      </div>
     

  ))}
  
  
  </div>
  {/* ============================== */}
  <div className="pagination">
  <div className="page_flex">
    <div className="first_parent">
      <div className="first">
      <Icon icon="cheveron-left" size={20} color="white" />
      </div>
    </div>
    <div className="next_parent">
      <div className="next">
      <Icon icon="cheveron-left" size={20} color="white" />
      </div>
    </div>
    <div className="previous_parent">
      <div className="previous">
      <Icon icon="cheveron-right" size={20} color="white" />
      </div>
    </div>
    <div className="last_parent">
      <div className="last">
      <Icon icon="cheveron-right" size={20} color="white" />
      </div>
    </div>
  </div>
</div>
  {/* ============================== */}
          </React.Fragment>
        )}



{/* --------------------------------------- */}

      </ProductDisplay>
      
      <FooterMain>
    <div className="site_policy">
      <div className="connect_parent">
        <span className="connect">connect with us</span>
      </div>
      <div className="site_policy_social-parent">
        <div className="fb_connect">
          <Icon  className='social_icon' icon="facebook" size={20} color="white" />
        </div>
        <div className="twitter_connect">
          <Icon  className='social_icon' icon="twitter" size={20} color="blue" />
        </div>
        <div className="whatsapp_connect">
          <a href="https://wa.me/message/Q5U5MFFUW6NVO1">
            <Icon  className='social_icon' icon="whatsapp1" size={20} color="blue" />
          </a>
        </div>
      </div>
    </div>
      </FooterMain>
    </Container>
  )
}

const Container = styled.div`
width:100%;
height:100%;
position:absolute;
top:0;
left:0;
bottom:0;
right:0;
overflow-x:hidden;
overflow-y:hidden;
background:navy;

`
const NavHeader = styled.div`
display: flex;
flex-direction: row;
align-items: center;
justify-content: space-around;
width:100%; 
height: 10%; 
padding: 1%;
color:white; 
position:sticky;
top:0;
z-index:1;
background-image: linear-gradient( to right bottom,  rgba(76, 0, 130, 0.5),rgba(100, 0, 0, 0.5));

`

const ProductDisplay = styled.div`
width:100%; 
height: 100%; 
background:navy;
overflow-x:hidden;
overflow-y:scroll;
`

const FooterMain = styled.div`

`


