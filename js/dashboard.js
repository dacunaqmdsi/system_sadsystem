// Initialize sales orders array if not exists
if (typeof salesOrders === 'undefined') {
  window.salesOrders = [];
}

// Dashboard Functions
function updateDashboard() {
  const dateFilter = document.getElementById('dashboardDateFilter')?.value;
  const startDate = document.getElementById('dashboardStartDate')?.value;
  const endDate = document.getElementById('dashboardEndDate')?.value;
  
  // Update metrics
  updateMetrics(dateFilter, startDate, endDate);
  
  // Update charts
  updateSalesOverview(dateFilter, startDate, endDate);
  updateCategoryChart(dateFilter, startDate, endDate);
  
  // Update tables
  updateRecentOrders(dateFilter, startDate, endDate);
  updateTopProducts(dateFilter, startDate, endDate);
}

function updateMetrics(dateFilter, startDate, endDate) {
  // Calculate total sales for the period
  let totalSales = calculateTotalSales(dateFilter, startDate, endDate);
  const totalSalesElement = document.getElementById('totalSalesValue');
  if (totalSalesElement) {
    totalSalesElement.textContent = totalSales.toFixed(2);
  }
  
  // Calculate total orders
  let totalOrders = calculateTotalOrders(dateFilter, startDate, endDate);
  const totalOrdersElement = document.getElementById('totalOrdersValue');
  if (totalOrdersElement) {
    totalOrdersElement.textContent = totalOrders;
  }
  
  // Get low stock items
  let lowStockCount = getLowStockCount();
  const lowStockElement = document.getElementById('lowStockValue');
  if (lowStockElement) {
    lowStockElement.textContent = lowStockCount;
  }
}

function updateSalesChart(period) {
  // Remove active class from all buttons
  document.querySelectorAll('.chart-filter-btn').forEach(btn => {
    btn.classList.remove('active');
  });
  
  // Add active class to clicked button
  event.target.classList.add('active');
  
  // Update chart based on period
  const ctx = document.getElementById('salesOverviewChart');
  if (!ctx) return;

  const data = getSalesData(period);
  
  if (window.salesChart) {
    window.salesChart.destroy();
  }
  
  window.salesChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: data.labels,
      datasets: [{
        label: 'Sales',
        data: data.values,
        borderColor: '#8b7355',
        backgroundColor: 'rgba(139, 115, 85, 0.1)',
        borderWidth: 2,
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          mode: 'index',
          intersect: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: '#d4c9b8'
          },
          ticks: {
            callback: function(value) {
              return '₱' + value.toLocaleString();
            }
          }
        },
        x: {
          grid: {
            color: '#d4c9b8'
          }
        }
      }
    }
  });
}

function updateCategoryChart(dateFilter, startDate, endDate) {
  const ctx = document.getElementById('categoryChart');
  if (!ctx) return;

  const data = getCategoryData(dateFilter, startDate, endDate);
  
  if (window.categoryChart) {
    window.categoryChart.destroy();
  }
  
  window.categoryChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: data.labels,
      datasets: [{
        data: data.values,
        backgroundColor: [
          '#8b7355',
          '#a08b6e',
          '#b5a287',
          '#cbb8a0',
          '#e1ceb9'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            boxWidth: 12,
            padding: 15
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.raw || 0;
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const percentage = Math.round((value / total) * 100);
              return `${label}: ₱${value.toLocaleString()} (${percentage}%)`;
            }
          }
        }
      }
    }
  });
}

function calculateTotalSales(dateFilter, startDate, endDate) {
  if (!salesOrders) return 0;
  return salesOrders.reduce((sum, order) => {
    if (isOrderInDateRange(order, dateFilter, startDate, endDate)) {
      return sum + order.total;
    }
    return sum;
  }, 0);
}

function calculateTotalOrders(dateFilter, startDate, endDate) {
  if (!salesOrders) return 0;
  return salesOrders.filter(order => 
    isOrderInDateRange(order, dateFilter, startDate, endDate)
  ).length;
}

function getLowStockCount() {
  if (!inventoryData) {
    return 0;
  }
  return inventoryData.filter(item => item.quantityAvailable <= item.reorderThreshold).length;
}

function isOrderInDateRange(order, dateFilter, startDate, endDate) {
  const orderDate = new Date(order.date);
  const today = new Date();
  
  switch(dateFilter) {
    case 'today':
      return orderDate.toDateString() === today.toDateString();
    case 'week':
      const weekAgo = new Date(today.setDate(today.getDate() - 7));
      return orderDate >= weekAgo;
    case 'month':
      const monthAgo = new Date(today.setMonth(today.getMonth() - 1));
      return orderDate >= monthAgo;
    case 'year':
      const yearAgo = new Date(today.setFullYear(today.getFullYear() - 1));
      return orderDate >= yearAgo;
    default:
      if (startDate && endDate) {
        return orderDate >= new Date(startDate) && orderDate <= new Date(endDate);
      }
      return true;
  }
}

function getSalesData(period) {
  const labels = [];
  const values = [];
  const today = new Date();
  
  switch(period) {
    case 'weekly':
      // Get last 7 days
      for (let i = 6; i >= 0; i--) {
        const date = new Date(today);
        date.setDate(date.getDate() - i);
        labels.push(date.toLocaleDateString('en-US', { weekday: 'short' }));
        values.push(calculateDailySales(date));
      }
      break;
    case 'monthly':
      // Get last 30 days by week
      for (let i = 4; i >= 0; i--) {
        const date = new Date(today);
        date.setDate(date.getDate() - (i * 7));
        labels.push(`Week ${4-i}`);
        values.push(calculateWeeklySales(date));
      }
      break;
    case 'yearly':
      // Get last 12 months
      for (let i = 11; i >= 0; i--) {
        const date = new Date(today);
        date.setMonth(date.getMonth() - i);
        labels.push(date.toLocaleDateString('en-US', { month: 'short' }));
        values.push(calculateMonthlySales(date));
      }
      break;
  }
  
  return { labels, values };
}

function calculateDailySales(date) {
  return salesOrders.reduce((sum, order) => {
    const orderDate = new Date(order.date);
    if (orderDate.toDateString() === date.toDateString()) {
      return sum + order.total;
    }
    return sum;
  }, 0);
}

function calculateWeeklySales(startDate) {
  const endDate = new Date(startDate);
  endDate.setDate(endDate.getDate() + 7);
  
  return salesOrders.reduce((sum, order) => {
    const orderDate = new Date(order.date);
    if (orderDate >= startDate && orderDate < endDate) {
      return sum + order.total;
    }
    return sum;
  }, 0);
}

function calculateMonthlySales(date) {
  return salesOrders.reduce((sum, order) => {
    const orderDate = new Date(order.date);
    if (orderDate.getMonth() === date.getMonth() && 
        orderDate.getFullYear() === date.getFullYear()) {
      return sum + order.total;
    }
    return sum;
  }, 0);
}

function getCategoryData(dateFilter, startDate, endDate) {
  const categoryTotals = {};
  
  salesOrders.forEach(order => {
    if (isOrderInDateRange(order, dateFilter, startDate, endDate)) {
      if (!categoryTotals[order.category]) {
        categoryTotals[order.category] = 0;
      }
      categoryTotals[order.category] += order.total;
    }
  });
  
  return {
    labels: Object.keys(categoryTotals),
    values: Object.values(categoryTotals)
  };
}

function updateRecentOrders(dateFilter, startDate, endDate) {
  const tbody = document.getElementById('recentOrdersBody');
  tbody.innerHTML = '';
  
  // Get filtered and sorted orders
  const filteredOrders = salesOrders
    .filter(order => isOrderInDateRange(order, dateFilter, startDate, endDate))
    .sort((a, b) => new Date(b.date) - new Date(a.date))
    .slice(0, 5); // Show only last 5 orders
    
  filteredOrders.forEach(order => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${order.code}</td>
      <td>${new Date(order.date).toLocaleDateString()}</td>
      <td>${order.quantity}</td>
      <td>₱${order.total.toFixed(2)}</td>
      <td>Completed</td>
    `;
    tbody.appendChild(tr);
  });
}

function updateTopProducts(dateFilter, startDate, endDate) {
  const tbody = document.getElementById('topProductsBody');
  tbody.innerHTML = '';
  
  // Calculate product sales
  const productSales = {};
  salesOrders
    .filter(order => isOrderInDateRange(order, dateFilter, startDate, endDate))
    .forEach(order => {
      if (!productSales[order.code]) {
        productSales[order.code] = {
          category: order.category,
          unitsSold: 0,
          revenue: 0
        };
      }
      productSales[order.code].unitsSold += order.quantity;
      productSales[order.code].revenue += order.total;
    });
    
  // Convert to array and sort by revenue
  const topProducts = Object.entries(productSales)
    .map(([code, data]) => ({code, ...data}))
    .sort((a, b) => b.revenue - a.revenue)
    .slice(0, 5); // Show top 5 products
    
  topProducts.forEach(product => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${product.code}</td>
      <td>${product.category}</td>
      <td>${product.unitsSold}</td>
      <td>₱${product.revenue.toFixed(2)}</td>
    `;
    tbody.appendChild(tr);
  });
} 