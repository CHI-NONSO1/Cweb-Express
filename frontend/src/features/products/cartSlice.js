import { createSlice } from "@reduxjs/toolkit";

const initialState = {
  cartItem: [],
  status: "In Cart",
};

const cartSlice = createSlice({
  name: "cartItem",
  initialState,
  reducers: {
    addToCart: (state, action) => {
      const stateArray = state.cartItem;
      const itemInCart = Array.from(stateArray).find(
        (item) => item.id === action.payload.id
      );
      if (itemInCart) {
        itemInCart.quantity++;
      } else {
        state.cartItem.push({ ...action.payload, quantity: 1 });
      }
    },
    incrementQuantity: (state, action) => {
      const item = state.cartItem.find((item) => item.id === action.payload);
      item.quantity++;
    },
    decrementQuantity: (state, action) => {
      const item = state.cartItem.find((item) => item.id === action.payload);
      if (item.quantity === 1) {
        item.quantity = 1;
      } else {
        item.quantity--;
      }
    },
    removeItem: (state, action) => {
      const removeItem = state.cartItem.filter(
        (item) => item.id !== action.payload
      );
      state.cartItem = removeItem;
    },
    clearItem: (state, action) => {
      state.cartItem = [];
    },
  },
});
export const selectAllCartItems = (state) => state.cart.cartItem;
export const {
  addToCart,
  incrementQuantity,
  decrementQuantity,
  removeItem,
  clearItem,
} = cartSlice.actions;

export const cartReducer = cartSlice.reducer;
