const submitBTN = document.querySelector(".checkout_submit");

const trackIdInput = document.querySelector(".tracking_id");
submitBTN.addEventListener("click", generateId);

function generateId() {
    const tracking_id = Math.floor(Math.random() * 1000000000 + 1);
    trackIdInput.value = tracking_id;
}
