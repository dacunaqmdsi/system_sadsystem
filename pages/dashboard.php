<?php include('../includes/init.php'); is_blocked(); ?>

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
            <div class="metric-value">₱<span id="totalSalesValue">
                    <?php echo Number(GetValue('select SUM(qty * price) from tblsales_details ')); ?>
                </span></div>
            <!-- <div class="metric-trend">↑ 12% from last period</div> -->
        </div>
        <div class="metric-card">
            <h3>Low Stock Items</h3>
            <div class="metric-value"><span id="lowStockValue">
                    <?php echo GetValue('select count(*) from tblinventory '); ?>
                </span></div>
            <!-- <div class="metric-trend">Requires attention</div> -->
        </div>
        <div class="metric-card">
            <h3>Total Products</h3>
            <div class="metric-value"><span id="totalOrdersValue">
                    <?php echo GetValue('select count(*) from tblinventory '); ?>
                </span></div>
            <!-- <div class="metric-trend">↑ 8% from last period</div> -->
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
            <h3>Category</h3>
            <div class="scrollable-table">
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody id="recentOrdersBody">
                        <?php
                        $rs = mysqli_query($db_connection, 'SELECT categoryid, category FROM tblcategory');
                        while ($rw = mysqli_fetch_array($rs)) {
                            echo '<tr><td>' . htmlspecialchars($rw['category']) . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
                        <?php
                        $query = "
                            SELECT 
                            s.order_id,
                            s.created_at,
                            GROUP_CONCAT(i.product_name SEPARATOR ', ') AS items,
                            SUM(d.qty * d.price) AS total
                            FROM tblsales s
                            JOIN tblsales_details d ON s.sales_id = d.sales_id
                            JOIN tblinventory i ON d.inventory_id = i.inventory_id
                            GROUP BY s.order_id, s.created_at
                            ORDER BY s.created_at DESC
                        ";
                        $rs = mysqli_query($db_connection, $query);

                        while ($rw = mysqli_fetch_assoc($rs)) {
                            echo '<tr>
                                <td>' . htmlspecialchars($rw['order_id']) . '</td>
                                <td>' . htmlspecialchars($rw['created_at']) . '</td>
                                <td>' . htmlspecialchars($rw['items']) . '</td>
                                <td>' . number_format($rw['total'], 2) . '</td>
                                <td>DONE</td>
                            </tr>';
                        }
                        ?>
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
                            <!-- <th>Units Sold</th>
                            <th>Revenue</th> -->
                        </tr>
                    </thead>
                    <tbody id="topProductsBody">
                        <?php
                        // Initialize the query
                        $query = "
                            SELECT 
                                i.product_id,
                                i.product_name,
                                i.color,
                                c.category,
                                sc.subcategory,
                                s.size,
                                mf.madefrom,
                                coop.cooperative,
                                i.qty_available,
                                i.reorder_threshold,
                                st.storage,
                                i.cost_price,
                                i.retail_price,
                                u.unit,
                                i.current_stock,
                                i.new_stock,
                                i.total_stock,
                                i.inventory_id
                            FROM tblinventory i
                            LEFT JOIN tblcategory c ON i.categoryid = c.categoryid
                            LEFT JOIN tblsubcategory sc ON i.subcategoryid = sc.subcategoryid
                            LEFT JOIN tblsizes s ON i.sizesid = s.sizesid
                            LEFT JOIN tblmadefrom mf ON i.madefromid = mf.madefromid
                            LEFT JOIN tblcooperative coop ON i.cooperativeid = coop.cooperativeid
                            LEFT JOIN tblstorage st ON i.storageid = st.storageid
                            LEFT JOIN tblunit u ON i.unitid = u.unitid
                        ";

                        // Add ordering and limit to the query
                        $query .= ' ORDER BY i.product_name ASC LIMIT 0,2';

                        // Execute the query
                        $result = mysqli_query($db_connection, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                            <td>" . htmlspecialchars($row['product_name']) . "</td>
                            <td>" . htmlspecialchars($row['category']) . "</td>
                        </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .scrollable-table {
        max-height: 360px;
        /* adjust as needed */
        overflow-y: auto;
        border: 1px solid #ddd;
    }

    .scrollable-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .scrollable-table th,
    .scrollable-table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }
</style>