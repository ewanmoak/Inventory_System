// Select the borrowed items list element
const borrowedItemsList = document.getElementById('borrowed-items-list');

// Check if the element exists
if (borrowedItemsList) {

  // Add functionality to handle "no items" message
  const noItemsMessage = borrowedItemsList.querySelector('.no-items-message');
  if (noItemsMessage) {
    noItemsMessage.classList.add('info'); // Add an "info" class for styling
  }

  // Add functionality for sorting borrowed items (requires server-side logic)
  borrowedItemsList.addEventListener('click', (event) => {
    if (event.target.classList.contains('item-name')) {
      const sortOrder = event.target.dataset.sortOrder || 'asc'; // Get sort order from data attribute (default asc)
      const sortField = 'tool_name'; // Assuming sorting by tool name (replace with actual field)
      sortBorrowedItems(sortOrder, sortField);
    }
  });

  // Function to handle sorting borrowed items (requires server-side logic)
  function sortBorrowedItems(sortOrder, sortField) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `sort_borrowed_items.php?sort_order=${sortOrder}&sort_field=${sortField}`);
    xhr.onload = function() {
      if (xhr.status === 200) {
        borrowedItemsList.innerHTML = xhr.responseText;
        console.log('Borrowed items list updated with sorted data');
      } else {
        console.error('Error fetching sorted data:', xhr.statusText);
      }
    };
    xhr.onerror = function() {
      console.error('Error sending AJAX request for sorting');
    };
    xhr.send();
  }

  // Add functionality for filtering borrowed items (requires server-side logic)
  const filterSelect = document.getElementById('filter-by-category'); // Replace with your filter element ID
if (filterSelect) {
  filterSelect.addEventListener('change', (event) => {
    const selectedCategory = event.target.value;
    filterBorrowedItems(selectedCategory);
  });
}
  // (Optional) Implement a select element or other UI controls for filtering options
  const filterSelect = document.getElementById('filter-by-category'); // Replace with your filter element ID
  if (filterSelect) {
    filterSelect.addEventListener('change', (event) => {
      const selectedCategory = event.target.value;
      filterBorrowedItems(selectedCategory);
    });
  }

  // Function to handle filtering borrowed items (requires server-side logic)
  function filterBorrowedItems(selectedCategory) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `filter_borrowed_items.php?category=${selectedCategory}`);
    xhr.onload = function() {
      if (xhr.status === 200) {
        borrowedItemsList.innerHTML = xhr.responseText;
        console.log('Borrowed items list updated with filtered data');
      } else {
        console.error('Error fetching filtered data:', xhr.statusText);
      }
    };
    xhr.onerror = function() {
      console.error('Error sending AJAX request for filtering');
    };
    xhr.send();
  }
}

function handleError(message, details = '') {
  console.error(message, details);
  // Replace with your error handling script logic
  alert(`Error: ${message}`); // Basic alert for demonstration
}
