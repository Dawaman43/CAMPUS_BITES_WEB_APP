const foodItems = [
    { id: 1, name: 'ጨጨብሳ', fee: 100 },
    { id: 2, name: 'እንቁላል ፍርፍር', fee: 80 },
    { id: 3, name: 'ፍርፍር', fee: 90 },
    { id: 4, name: 'ጎመን', fee: 60 },
    { id: 5, name: 'ቀይ ስር', fee: 60 },
    { id: 6, name: 'ሥጋ', fee: 120 },
    { id: 7, name: 'በአይነት', fee: 90 },
    { id: 8, name: 'ሸክላ ጥብስ', fee: 150 },
    { id: 9, name: 'ሽሮ', fee: 70 },
    { id: 10, name: 'ቲማቲም', fee: 60 },
    { id: 11, name: 'ሙሉ ፍርፍር', fee: 110 },
  ];
  
  const foodList = document.getElementById('food-list');
  const selectedItems = document.getElementById('selected-items');
  const totalFee = document.getElementById('total-fee');
  const unselectBtn = document.getElementById('unselect-btn');
  const placeOrderBtn = document.getElementById('place-order-btn');
  
  let selectedFood = [];
  
  function renderFoodItems() {
    foodItems.forEach(item => {
      const foodDiv = document.createElement('div');
      foodDiv.className = 'food-item';
      foodDiv.innerHTML = `
        <span>${item.name}</span>
        <input type="checkbox" data-id="${item.id}" data-fee="${item.fee}">
      `;
      foodList.appendChild(foodDiv);
    });
  
    foodList.addEventListener('change', handleSelection);
  }
  
  function handleSelection(e) {
    const checkbox = e.target;
    const id = parseInt(checkbox.dataset.id);
    
    if (checkbox.checked) {
      selectedFood.push(id);
    } else {
      selectedFood = selectedFood.filter(f => f !== id);
    }
    updateSummary();
  }
  
  function updateSummary() {
    const names = selectedFood.map(id => {
      const food = foodItems.find(f => f.id === id);
      return food?.name;
    }).join(", ");
  
    const total = selectedFood.reduce((sum, id) => {
      const food = foodItems.find(f => f.id === id);
      return sum + (food?.fee || 0);
    }, 0);
  
    selectedItems.textContent = names || "No items selected";
    totalFee.textContent = `Estimated Total: ${total} ብር`;
  }
  
  unselectBtn.addEventListener('click', () => {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => cb.checked = false);
    selectedFood = [];
    updateSummary();
  });
  
  placeOrderBtn.addEventListener('click', () => {
    const dormBlock = document.getElementById('dorm').value;
    const roomNumber = document.getElementById('room').value;
  
    if (!dormBlock || !roomNumber || selectedFood.length === 0) {
      alert("Please complete all fields and select at least one item.");
      return;
    }
  
    alert(`Order placed!\nDorm: ${dormBlock}\nRoom: ${roomNumber}`);
  });
  
  renderFoodItems();
  