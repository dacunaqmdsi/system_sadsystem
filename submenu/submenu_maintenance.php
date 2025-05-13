<?php include('../includes/init.php'); ?>
<div class="main-container">
	<div class="section-title">Manage Items</div>
	<div align="right"><button onclick="ajax_fn('pages/maintenance','main_content');">Back</button></div>

	<table width="100%" style="border: none; border-collapse: collapse;">
		<tr style="border: none;" class="users-table-info">
			<td align="center" style="border: none; width: 14.28%;">
				<span style="cursor:pointer; font-weight: bold;" onclick="ajax_fn('submenu/category','tmp_content');">Category</span>
			</td>
			<td align="center" style="border: none; width: 14.28%;">
				<span style="cursor:pointer; font-weight: bold;" onclick="ajax_fn('submenu/subcategory','tmp_content');">Sub Category</span>
			</td>
			<td align="center" style="border: none; width: 14.28%;">
				<span style="cursor:pointer; font-weight: bold;" onclick="ajax_fn('submenu/sizes','tmp_content');">Sizes</span>
			</td>
			<td align="center" style="border: none; width: 14.28%;">
				<span style="cursor:pointer; font-weight: bold;" onclick="ajax_fn('submenu/madefrom','tmp_content');">Made From</span>
			</td>
			<td align="center" style="border: none; width: 14.28%;">
				<span style="cursor:pointer; font-weight: bold;" onclick="ajax_fn('submenu/cooperative','tmp_content');">Cooperative</span>
			</td>
			<td align="center" style="border: none; width: 14.28%;">
				<span style="cursor:pointer; font-weight: bold;" onclick="ajax_fn('submenu/storage','tmp_content');">Storage Location</span>
			</td>
			<td align="center" style="border: none; width: 14.28%;">
				<span style="cursor:pointer; font-weight: bold;" onclick="ajax_fn('submenu/unit','tmp_content');">Unit</span>
			</td>
		</tr>
	</table>

	<br>

	<div id="tmp_content">
		<?php include('../submenu/category.php');  ?>
	</div>

</div>





<style>
	body {
		font-family: Arial, sans-serif;
		background-color: #f7f3e8;
		margin: 0;
		padding: 30px;
	}

	h2 {
		color: #333;
		margin-bottom: 20px;
	}

	.main-container {
		background-color: #fff;
		padding: 20px 30px;
		border-radius: 8px;
		box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		border: 1px solid #ddd;
	}

	.section-title {
		font-weight: bold;
		font-size: 18px;
		margin-bottom: 20px;
	}

	.inner-box {
		background-color: white;
		border: 1px solid #d5d5d5;
		border-radius: 8px;
		padding: 20px;
		max-width: 250px;
	}

	.inner-box-title {
		font-size: 14px;
		color: #4a4a4a;
		margin-bottom: 15px;
	}

	.button {
		display: block;
		width: 100%;
		margin-bottom: 10px;
		padding: 10px 0;
		background-color: #8B6B4A;
		color: white;
		border: none;
		border-radius: 4px;
		font-weight: bold;
		cursor: pointer;
		transition: background 0.3s ease;
	}

	.button:hover {
		background-color: #755b3b;
	}
</style>