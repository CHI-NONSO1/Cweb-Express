import React from "react";

export default function Search(props) {
  return (
    <div>
      {props.searchItems === []
        ? "Loading . . ."
        : props.searchItems.map((item, index) => (
            <div className="search_page_flex" key={index}>
              <div className="search_row-img" id="search_row_img">
                <a
                  className="link__wrap"
                  href={"#" + item.id}
                  onClick={() => props.getProductDteails(item.id)}
                >
                  <img
                    className="search_item_img"
                    src={`http://localhost:8000/storage/product/image/${item.image}`}
                    alt={item.title}
                  />
                </a>
              </div>
              <div className="search_row" id="search_row_name">
                <span className="search_item_name">{item.title}</span>
              </div>

              <div className="search_row" id="search_row_price">
                <span className="cart_item_price">
                  <span className="naira">N</span>
                  {item.price}
                </span>
              </div>
            </div>
          ))}
    </div>
  );
}
