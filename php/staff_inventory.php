<?php
include 'staff_sidebarMenu.php';
include 'connect.php';
session_start();


// Fetch inventory data
$sql = 'SELECT * FROM inventory';
$result = mysqli_query($connection, $sql);

// Handle edit, update, add and delete actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['update'])) {

		$_editId = $_POST['editItemId'];
		$_editItemName = $_POST['item_Name'];
		$_editItemPrice = $_POST['item_Price'];
		$_editItemQuantity = $_POST['item_Quantity'];
		$_editItemImageName = $_POST['editItemImageName'];

		// check if there is a new image uploaded or not
		if ($_FILES["item_Image"]["name"] != "") {
			$_editItemImageName = $_FILES["item_Image"]["name"];

			// Store the new image inside the images folder
			$targetDir = "../images/";
			$fileName = basename($_FILES["item_Image"]["name"]);
			$targetFilePath = $targetDir . $fileName;
			$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
			move_uploaded_file($_FILES["item_Image"]["tmp_name"], $targetFilePath);
		}


		$updateSql = "UPDATE inventory SET name = '$_editItemName', image = '$_editItemImageName', price = '$_editItemPrice', quantity = '$_editItemQuantity' WHERE inventoryID = '$_editId'";
		if (!mysqli_query($connection, $updateSql)) {
			echo ("Error description: " . mysqli_error($connection));
		}

		// Redirect back to the same page to refresh and display the updated details
		header("Location: " . $_SERVER['PHP_SELF']);
		exit();
	} elseif (isset($_POST['delete'])) {
		$deleteId = $_POST['deleteId'];

		// Display a confirmation message before deleting 
		echo "
            <script>
            var result = confirm('Are you sure you want to delete this item?');
            if (result) {
                  
				window.location.href = 'staff_deleteItem.php?id=$deleteId';
				
				
            }
            </script>
        ";
	} elseif (isset($_POST['add'])) {
		$itemName = $_POST['itemName'];
		$itemImage = $_FILES["itemImage"]["name"];
		$itemPrice = $_POST['itemPrice'];
		$itemQuantity = $_POST['itemQuantity'];

		// Store the image inside the images folder
		$targetDir = "../images/";
		$fileName = basename($_FILES["itemImage"]["name"]);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
		move_uploaded_file($_FILES["itemImage"]["tmp_name"], $targetFilePath);

		// Insert the new item into the database
		$insertSql = "INSERT INTO inventory (name, image, price, quantity) VALUES ('$itemName', '$itemImage', '$itemPrice', '$itemQuantity')";
		mysqli_query($connection, $insertSql);

		// Redirect back to the same page to refresh and display the new item
		header("Location: " . $_SERVER['PHP_SELF']);
		exit();
	}
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
	<script src="https://kit.fontawesome.com/1b607b98d1.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<title>Inventory</title>
	<link rel="stylesheet" href="../css/staffSidebarMenu.css">
	<link rel="stylesheet" href="../css/staffInventory.css">

</head>

<body>
	<div class="main-content">
		<div class="container">
			<h1 style="color:black">Inventory</h1><br>

			<!-- button to add new item into the inventory -->
			<button id="addButton" name="edit" class="add-button"><i class="fa-solid fa-plus"></i> Add New Item</button><br><br><br>

			<!-- Add new item form -->
			<div id="myPopup" class="popup">
				<div class="popup-content">
					<h1>
						Add New Item
					</h1>
					<form method="POST" enctype="multipart/form-data">
						<label for="itemName">Name</label><br>
						<input type="text" id="itemName" name="itemName" required><br><br>

						<label for="itemImage">Upload Image</label>
						<input type="file" id="itemImage" name="itemImage" required><br><br>

						<label for="itemPrice">Price</label><br>
						<input type="text" id="itemPrice" name="itemPrice" required><br><br>

						<label for="itemQuantity">Quantity</label><br>
						<input type="number" id="itemQuantity" name="itemQuantity" min="1" required><br><br>

						<button type="submit" id="confirmAdd" name="add" class="add-button">Add Item</button>
					</form>
					<button id="closePopup">
						Cancel
					</button>
				</div>
			</div>

			<!-- edit item details form -->
			<div id="myPopup2" class="popup2">
				<div class="popup-content2">
					<h1>
						Edit Item Details
					</h1>

					<form method="POST" enctype="multipart/form-data">

						<label for="item_Name">Name</label><br>
						<input type="text" id="item_Name" name="item_Name"><br><br>

						<label for="item_Image">Upload Image</label>
						<input type="file" id="item_Image" name="item_Image"><br><br>

						<label for="item_Price">Price</label><br>
						<input type="text" id="item_Price" name="item_Price"><br><br>

						<label for="item_Quantity">Quantity</label><br>
						<input type="number" id="item_Quantity" name="item_Quantity" min="1"><br><br>

						<input type="hidden" id="item_Id" name="editItemId">
						<input type="hidden" id="item_ImageName" name="editItemImageName">

						<button type="submit" id="confirmUpdate" name="update" class="add-button">Update Item Details</button>
					</form>
					<button onclick="removePopupForm()" id="closePopup2">
						Cancel
					</button>
				</div>
			</div>

			<!-- display inventory -->
			<table>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Image</th>
					<th>Quantity</th>
					<th>Action</th>
				</tr>
				<?php while ($row = mysqli_fetch_assoc($result)) : ?>
					<tr>
						<td><?php echo $row['inventoryID']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td>
							<img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="width: 100px; height: 100px;">
						</td>
						<td>

							<?php echo $row['quantity']; ?>

						</td>
						<td>

							<input type="hidden" id="inv_id<?php echo $row['inventoryID']; ?>" name="inv_id" value="<?php echo $row['inventoryID']; ?>">
							<input type="hidden" id="inv_name<?php echo $row['inventoryID']; ?>" name="inv_name" value="<?php echo $row['name']; ?>">
							<input type="hidden" id="inv_image<?php echo $row['inventoryID']; ?>" name="inv_image" value="<?php echo $row['image']; ?>">
							<input type="hidden" id="inv_price<?php echo $row['inventoryID']; ?>" name="inv_price" value="<?php echo $row['price']; ?>">
							<input type="hidden" id="inv_quantity<?php echo $row['inventoryID']; ?>" name="inv_quantity" value="<?php echo $row['quantity']; ?>">
							<button onclick="setItemDetails(this.id)" id="<?php echo $row['inventoryID']; ?>" name="edit" class="blue-button"><i class="fas fa-edit"></i> Edit</button>

							<form method="post" id="deleteForm">
								<input type="hidden" name="deleteId" value="<?php echo $row['inventoryID']; ?>">
								<button type="submit" name="delete" class="red-button"><i class="fas fa-trash"></i> Delete</button>
							</form>
						</td>
					</tr>
				<?php endwhile; ?>

			</table>
		</div>
	</div>

	<script>
		addButton.addEventListener("click", function() {
			myPopup.classList.add("show");
		});
		closePopup.addEventListener("click", function() {
			myPopup.classList.remove("show");
		});
		window.addEventListener("click", function(event) {
			if (event.target == myPopup) {
				myPopup.classList.remove("show");
			}
		});
	</script>



	<script>
		function showPopupForm() {

			myPopup2.classList.add('show2');
		}

		function setItemDetails(buttonId) {

			var invent_name = document.getElementById("inv_name" + buttonId).value;
			var invent_image = document.getElementById("inv_image" + buttonId).value;
			var invent_price = document.getElementById("inv_price" + buttonId).value;
			var invent_quantity = document.getElementById("inv_quantity" + buttonId).value;


			document.getElementById("item_Name").value = invent_name;
			document.getElementById("item_Price").value = invent_price;
			document.getElementById("item_Quantity").value = invent_quantity;
			document.getElementById("item_Id").value = buttonId;
			document.getElementById("item_ImageName").value = invent_image;

			showPopupForm();
		}

		function removePopupForm() {
			myPopup2.classList.remove("show2");
		}
	</script>

</body>

</html>