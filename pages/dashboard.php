<?php include('includes/init.php'); ?>
<div class="module" id="dashboardModule">
    <h2>Dashboard</h2>

    <!-- Dashboard Filters -->
    <div class="dashboard-filter">
        <select id="dashboardDateFilter" onchange="updateDashboard()">
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
            <option value="year">This Year</option>
            <option value="custom">Custom Range</option>
        </select>
        <input type="date" id="dashboardStartDate" onchange="updateDashboard()">
        <input type="date" id="dashboardEndDate" onchange="updateDashboard()">
    </div>

    <!-- Metrics Grid -->
    <div class="metrics-grid">
        <div class="metric-card">
            <h3>Total Sales</h3>
            <div class="metric-value">₱<span id="totalSalesValue">0.00</span></div>
            <div class="metric-trend">↑ 12% from last period</div>
        </div>
        <div class="metric-card">
            <h3>Total Orders</h3>
            <div class="metric-value"><span id="totalOrdersValue">0</span></div>
            <div class="metric-trend">↑ 8% from last period</div>
        </div>
        <div class="metric-card">
            <h3>Low Stock Items</h3>
            <div class="metric-value"><span id="lowStockValue">0</span></div>
            <div class="metric-trend">Requires attention</div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="charts-grid">
        <div class="chart-card">
            <h3>Sales Overview</h3>
            <div class="chart-filters">
                <button class="chart-filter-btn active" onclick="updateSalesChart('weekly')">Weekly</button>
                <button class="chart-filter-btn" onclick="updateSalesChart('monthly')">Monthly</button>
                <button class="chart-filter-btn" onclick="updateSalesChart('yearly')">Yearly</button>
            </div>
            <canvas id="salesOverviewChart"></canvas>
        </div>
        <div class="chart-card">
            <h3>Category Distribution</h3>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="bottom-grid">
        <div class="data-card">
            <h3>Recent Orders</h3>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="recentOrdersBody">
                        <!-- Recent orders will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="data-card">
            <h3>Top Products</h3>
            <div class="data-table">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Units Sold</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody id="topProductsBody">
                        <!-- Top products will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>