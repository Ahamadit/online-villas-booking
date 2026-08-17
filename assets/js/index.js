document.addEventListener("DOMContentLoaded", function() {
  const guestSelect = document.getElementById("guest");
  const villasSelect = document.getElementById("villas");
  const checkinInput = document.getElementById("checkin");
  const checkoutInput = document.getElementById("checkout");
  const additionalFields = document.getElementById("additionalFields");
  const submitBtnContainer = document.getElementById("submitBtnContainer");

  // Function to check if all required fields are filled
  function checkFields() {
    if (
      guestSelect.value !== "" &&
      villasSelect.value !== "" &&
      checkinInput.value !== "" &&
      checkoutInput.value !== ""
    ) {
      additionalFields.classList.remove("hidden");
      submitBtnContainer.classList.remove("hidden");
    } else {
      additionalFields.classList.add("hidden");
      submitBtnContainer.classList.add("hidden");
    }
  }

  // Add event listeners to all required fields
  guestSelect.addEventListener("change", checkFields);
  villasSelect.addEventListener("change", checkFields);
  checkinInput.addEventListener("change", checkFields);
  checkoutInput.addEventListener("change", checkFields);
});
