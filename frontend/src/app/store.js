import { configureStore } from "@reduxjs/toolkit";
//import counterReducer from "../features/counter/counterSlice";
import { cartReducer } from "../features/products/cartSlice";
import productReducer from "../features/products/productsSlice";
import { trackerReducer } from "../features/products/trackerSlice";
import storage from "redux-persist/lib/storage";
import {
  persistStore,
  persistReducer,
  FLUSH,
  REHYDRATE,
  PAUSE,
  PERSIST,
  PURGE,
  REGISTER,
} from "redux-persist";

const persistConfig = {
  key: "cartItem",
  storage,
};
const productConfig = {
  key: "product",
  storage,
};

const trackerConfig = {
  key: "tracker",
  storage,
};

const persistedReducer = persistReducer(
  persistConfig,
  cartReducer,
  productConfig,
  productReducer,
  trackerConfig,
  trackerReducer
);

const prodReducer = persistReducer(productConfig, productReducer);

export const store = configureStore({
  // reducer: {
  //   product: productReducer,

  // },
  // reducer: {
  //   persistedReducer,
  //   product: productReducer,
  // },
  reducer: persistedReducer,
  prodReducer,
  trackerReducer,
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware({
      serializableCheck: {
        ignoredActions: [FLUSH, REHYDRATE, PAUSE, PERSIST, PURGE, REGISTER],
      },
    }),
});
export const persistor = persistStore(store);
