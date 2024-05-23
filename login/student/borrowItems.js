


function toggleBorrowedItemsList() {
    const borrowItemBtn = document.getElementById("borrow-item-btn");
    const borrowedItemsList = document.getElementById("borrowed-items-list");
    borrowItemBtn.addEventListener("click", function() {
      borrowedItemsList.classList.toggle("show"); // Toggles visibility class
    });
  }
  
  toggleBorrowedItemsList(); // Call the function to attach the event listener



  