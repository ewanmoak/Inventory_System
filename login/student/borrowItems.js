

function borrowItem() {
  const borrowItemBtn = document.getElementById("borrow-item-btn");
  borrowItemBtn.addEventListener("click", function() {
    const toolId = /* Get the tool ID (replace with your logic) */; // Example: from a hidden input field
    const quantity = document.getElementById("quantity-input").value || 1; // Optional: quantity input field (default to 1)

    // Send AJAX request to borrow_item.php (replace with your server-side script)
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'borrow_item.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
        if (xhr.responseText === 'success') {
          console.log('Item borrowed successfully!');
          // Update the UI to reflect the borrowed item (replace with your logic)
          document.getElementById('borrowed-items-list').innerHTML += "<li>Wire Cutter (" + quantity + ")</li>";
        } else {
          console.error('Error borrowing item:', xhr.responseText);
          // Display an error message to the user (optional)
          alert('Error borrowing item. Please try again.');
        }
      } else {
        console.error('Error borrowing item:', xhr.statusText);
      }
    };

    xhr.send('tool_id='+toolId+'&quantity='+quantity);
  });
}

borrowItem(); // Call the function to attach the event listener
  