<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}


if(isset($_POST['buy'])){
    $to = "imranlokmic99@gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $subject = "Buy Request";
    $subject2 = "Buy Request";
	foreach ($_SESSION["cart_item"] as $item){
		$code = $item["code"];
		$quant = $item["quantity"];
		$stringquant = strval($quant);
	}
    $message = $code . " " .$stringquant;
    $message2 = "Thank you for your request, we will contact you shortly ";

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    }


?>
<html>

<head>

	<!--META TAGS-->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#000000">
	<!--SEO (WIP)-->
	<meta name="robots" content="all">
	<meta name="googlebot" content="all">
	<!--END OF SEO-->
	<meta name="description" content="Webshop for XYZ">

	<!--OTHER-->
	<title>Web Shop</title>

	<!--LINKS-->
	<link rel="stylesheet" href="css/style2.css">
	<link rel="icon" sizes="192x192" href="img/icon.png">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Orbitron" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!--SCRIPTS-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
	<!--LOADING PAGE-->
	<div id="loading">
		<img id="loading-image" src="img/load.gif" alt="Loading..." />
	</div>

	<div id="shopping-cart">
		<div class="txt-heading">Shopping Cart</div>

		<a id="btnEmpty" href="store.php?action=empty">Empty Cart</a>
		<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>
		<form method="post" action="">
		<table class="tbl-cart" cellpadding="10" cellspacing="1">
			<tbody>
				<tr>
					<th style="text-align:left;">Name</th>
					<th style="text-align:left;">Code</th>
					<th style="text-align:right;" width="5%">Quantity</th>
					<th style="text-align:right;" width="10%">Unit Price</th>
					<th style="text-align:right;" width="10%">Price</th>
					<th style="text-align:center;" width="5%">Remove</th>
				</tr>
				<?php		
    				foreach ($_SESSION["cart_item"] as $item){
        			$item_price = $item["quantity"]*$item["price"];
				?>
				<tr>
					<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?>
					</td>
					<td><?php echo $item["code"]; ?></td>
					<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
					<td style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
					<td style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
					<td style="text-align:center;"><a href="store.php?action=remove&code=<?php echo $item["code"]; ?>"
							class="btnRemoveAction"><img src="img\icon-delete.png" style="max-height:30px" alt="Remove Item" /></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

				<tr>
					<td colspan="2" align="right">Total:</td>
					<td align="right"><?php echo $total_quantity; ?></td>
					<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong>
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="1" style="text-align:center;">Email:</td>
					<td colspan="5" style="text-align:center;"><input type="email" id="email" name="email" required></td>
				</tr>
				<tr>	
					<td colspan="6" style="text-align:center;"><input type="submit" name="buy" value="BUY"></td>
				</tr>
			</tbody>
		</table>
		<?php
} else {
?>
		<div class="no-records">Your Cart is Empty</div>
		<?php 
}
?>
	</form>
	</div>


	<div id="product-grid">
		<div class="txt-heading">Products </div>
		<div class="prodtitle">HOODIES <i style="font-size:24px" class="fa" onclick="expandH()">&#xf065;</i></div>
		<?php
				$product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE id<10 ORDER BY id ASC");
				if (!empty($product_array)) { 
				foreach($product_array as $key=>$value){
			?>
		<div class="product-item hoodies">
			<form method="post" action="store.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
				<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"
						style="max-height:150px"></div>
				<div class="product-tile-footer">
					<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
					<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
					<br>
					<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
				</div>
			</form>
		</div>
		<?php
		}
	}
	?>
	<div class="prodtitle">JACKETS <i style="font-size:24px" class="fa" onclick="expandJ()">&#xf065;</i></div>
	<?php
				$product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE id>10 AND id<16 ORDER BY id ASC");
				if (!empty($product_array)) { 
				foreach($product_array as $key=>$value){
			?>
		<div class="product-item jackets" >
			<form method="post" action="store.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
				<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"
						style="max-height:150px"></div>
				<div class="product-tile-footer">
					<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
					<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
					<br>
					<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
				</div>
			</form>
		</div>
		<?php
		}
	}
	?>
	<div class="prodtitle">SNEAKERS <i style="font-size:24px" class="fa" onclick="expandS()">&#xf065;</i></div>
	<?php
				$product_array = $db_handle->runQuery("SELECT * FROM tblproduct WHERE id>16 ORDER BY id ASC");
				if (!empty($product_array)) { 
				foreach($product_array as $key=>$value){
			?>
		<div class="product-item sneakers" >
			<form method="post" action="store.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
				<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"
						style="max-height:150px"></div>
				<div class="product-tile-footer">
					<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
					<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
					<br>
					<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
				</div>
			</form>
		</div>
		<?php
		}
	}
	?>
	
	</div>


	<script>
		//LOADING SCRIPT
		$(window).on('load', function () {
			$("#loading").hide();
		});

		//SHOP

		//$(".hoodies:last").css("margin-right","100%")


		function expandH() {
			$(".hoodies").toggle();
		}

		function expandJ() {
			$(".jackets").toggle();
		}

		function expandS() {
			$(".sneakers").toggle();
		}
	</script>


</body>

</html>