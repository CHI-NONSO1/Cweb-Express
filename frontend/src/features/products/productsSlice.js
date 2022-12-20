import { createSlice } from "@reduxjs/toolkit";

const initialState = {
  products: [],
  status: "idle",
};

const productSlice = createSlice({
  name: "product",
  initialState,
  reducers: {
    setProduct: (state, action) => {
      state.products = action.payload;
    },
  },
});

export const { setProduct } = productSlice.actions;

export const selectAllProducts = (state) => state.product.products;
console.log(selectAllProducts);
export const productsStatus = (state) => state.product.status;

export default productSlice.reducer;
