<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Grocery Store</title>
    <link rel="stylesheet" type="text/css" href="css.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" scr="js/"></script>
</head>
<title>Title</title>
<link rel="stylesheet" type="text/css" href="css.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" scr="js/"></script>
<script>
    function clearCart() {
        if(confirm("Do you want to clear your shopping cart?")) {
            window.parent.shopping_cart.location.href="shopping-cart.php?operation=clear";
        }
    }

    function deleteCart() {
        if(confirm("Do you want to delete the selected items?")) {
            document.forms.cartform.submit();
        }
    }

    function addhover(obj){
        $("#checkout").css('background-color','#d94200');
    }
    function removehover(obj){
        $("#checkout").css('background-color','#e35e00')
    }

    function checkquan(check)
    {
        if (check == 0  || !(check))
        {
            window.alert("Your shopping cart is empty, please select something!");

            return false;

        }
        else
        {
            window.parent.nav.location.href="Order.php";
            return true;

        }
    }

</script>
<body style="margin-left: 20px;">
<?php
function getProduct($id, $quantity) {
    $con = mysql_connect("rerun", "potiro", "pcXZb(kL");
    if(!$con) {
        echo "Failed to Connect to the Server. Please have a try later.";
    }
    mysql_select_db("poti", $con);


    $result = mysql_query("select * from products where product_id=$id");
    if($row = mysql_fetch_array($result)) {
        $product_name = $row["product_name"];
        $unit_price = $row["unit_price"];
        $unit_quantity = $row["unit_quantity"];
        $in_stock = $row["in_stock"];
    }

    mysql_close($con);

    $array = array(
        array(
            "product_id" => $id,
            "product_name" => $product_name,
            "unit_price" => $unit_price,
            "unit_quantity" => $unit_quantity,
            "in_stock" => $in_stock,
            "quantity" => $quantity,
        )
    );

    return $array;
}

session_start();
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$operation = $_GET['operation'];
$product_id = $_GET['product_id'];
$quantity = $_GET['quantity'];

if($operation == "add") {
    $array = getProduct($product_id, $quantity);
    $flag = false;

    if($quantity <= $array[0]['in_stock']) {
        for($i=0; $i<count($_SESSION['cart']); $i++) {
            if($_SESSION['cart'][$i]['product_id'] == $product_id) {
                $flag = true;
                if(($_SESSION['cart'][$i]['quantity'] + $quantity) <= $_SESSION['cart'][$i]['in_stock']) {
                    $_SESSION['cart'][$i]['quantity'] = $_SESSION['cart'][$i]['quantity'] + $quantity;
                } else {
                    echo "<script language=\"javascript\">alert(\"There isn't enough product in stock.\");</script>";
                }
            }
        }

        if(!$flag) {
            $_SESSION['cart'] = array_merge($_SESSION['cart'], $array);
        }
    } else {
        echo "<script language=\"javascript\">alert(\"There isn't enough product in stock.\");</script>";
    }

} else if($operation == "delete") {
    $temp = array();

    for($i=0; $i<count($_SESSION['cart']); $i++) {
        $pid = $_SESSION['cart'][$i]['product_id'];
        if($_POST[$pid]=="on") {
            $temp = array_merge($temp, array($i));
        }
    }


    for($i=0; $i<count($temp); $i++) {
        unset($_SESSION['cart'][$temp[$i]]);
    }
    $_SESSION['cart'] = array_merge($_SESSION['cart']);
}
else if($operation == "clear") {
    unset($_SESSION['cart']);
}

else if($operation == "checkout") {
}

?>
<header style="font-size: 22px; color: #797979; margin: 10px 0 10px 0;">Product Detail</header>
<form name="cartform" method="post" action="shopping-cart.php?operation=delete">
    <table border="0" rules=none cellspacing=0 style="border-bottom:#b5b5b5 1px solid; width: 640px;">
        <tr style="height: 20px;">
            <td style="width: 3%;border-bottom: #b5b5b5 1px solid;"></td>
            <td style="width: 20%;" class="cart_header">Product Name</td>
            <td style="width: 17%;" class="cart_header">Unit Price</td>
            <td style="width: 15%;" class="cart_header">Unit Quantity</td>
            <td style="width: 30%;" class="cart_header">Required Quantity</td>
            <td style="width: 25%;" class="cart_header">Total Cost</td>
        </tr>

        <?php
        for($i=0; $i<count($_SESSION['cart']); $i++) {
            ?>

            <tr>
                <th>
                    <p></p>
                 </th>
                <th class="cart_cont"><?php echo $_SESSION['cart'][$i]['product_name']; ?></th>
                <th class="cart_cont" style="font-weight: bold;">
                    <?php echo "$".$_SESSION['cart'][$i]['unit_price']; ?>
                </th>
                <th class="cart_cont" ><?php echo $_SESSION['cart'][$i]['unit_quantity']; ?></th>
                <th class="cart_cont"><?php echo $_SESSION['cart'][$i]['quantity']; ?></th>
                <th class="cart_cont" style="font-weight: bold;color: #e36500; font-size: 16px;">$
                    <?php echo $_SESSION['cart'][$i]['unit_price']*$_SESSION['cart'][$i]['quantity'];?>
                </th>
            </tr>
            <?php
        }
        ?>
    </table>
</form>
<table border="0" rules=none cellspacing=0 style="width: 640px;" >
    <tr style="height: 40px;">
        <td style="font-size: 16px; color: #7d7d7d; text-align: right; width: 60%; padding-top: 30px;">Subtotal:
            <p style="display: inline; color: #e36500; font-size: 16px;">&nbsp;&nbsp;$
            <p style="display: inline; color: #e36500; font-size: 26px;">
                <?php
                $subtotal = 0;
                for($i=0; $i<count($_SESSION['cart']); $i++) {
                    $subtotal = $subtotal + $_SESSION['cart'][$i]['quantity']*$_SESSION['cart'][$i]['unit_price'];
                }
                echo $subtotal;
                ?>
            </p>
            </p>
            <p style="font-size: 14px;">Number of Products:
                <?php
                echo count($_SESSION['cart']);
                $item_amount = 0;
                for($i=0; $i<count($_SESSION['cart']); $i++) {
                    $item_amount = $item_amount + $_SESSION['cart'][$i]['quantity'];
                }


                ?>


            </p>
        </td>
    </tr>
</table>
<?php
print "<form action=\"Checkout.php\"  method=\"post\" target=\"detail\" >";
print "<input type=\"submit\" id=\"checkout\" name=\"submit\" class=\"button_checkout\" value=\"Checkout\" onmouseout=\"removehover(this)\" onmouseover=\"addhover(this)\" onClick=\"return checkquan(".$item_amount.")\">";
print "</form>";
?>
</body>
</html>
<!--This is the first Assignment of IP - Coding by 12482004 Jinwei Li & 13001870 Jianni Hu-->
