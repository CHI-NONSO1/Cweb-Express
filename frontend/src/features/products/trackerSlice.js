import { createSlice } from "@reduxjs/toolkit";

const initialState = {
  tracking: [],
  status: "idle",
};

const trackerSlice = createSlice({
  name: "tracking",
  initialState,
  reducers: {
    addToTracker: (state, action) => {
      state.tracking.push( ...action.payload);
    },
    clearTracker: (state, action) => {
      state.tracking = [];
    },
  },
});
export const selectAllTracking = (state) => state.tracker.tracking;
export const {
  addToTracker,
  clearTracker,
} = trackerSlice.actions;

export const trackerReducer = trackerSlice.reducer;
