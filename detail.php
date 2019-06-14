
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" type="text/css" href="css.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" scr="js/"></script>
    <script>
        function addhover(obj){
            $("#addchart").css('background','url(images/add_hover.png)');
        }
        function removehover(obj){
            $("#addchart").css('background','url(images/add.png)')
        }
    </script>

</head>

<body style="margin-left: 20px;">
<header style="font-size: 22px; color: #797979; margin: 10px 0 10px 0;">Product Detail</header>

    <?php
    session_start();
    /** @var type $product_id */

    $db = mysqli_connect("rerun.it.uts.edu.au", "potiro", "pcXZb(kL", "poti");

    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
      }

    $product_id=$_GET['product_id'];
    
    $query = "select * from products where product_id=$product_id";

    $result = mysqli_query($db , $query);

    if ($result) {

    ?>

    <?php
    $row = mysqli_fetch_array($result);
    ?>

    <table  border="0" rules=none cellspacing=0>
        <tr class="table1_m">
            <th class="table1_th">Product Name</th>
            <td  class="table1_tr">
                <p id="productn"><?php echo $row["product_name"]; ?></p>
            </td>
        </tr>
        <tr class="table1_m">
            <th class="table1_th2">Price</th>
            <td class="table1_td2">
                <p class="table1_dollar">$</p>
                <p class="table1_prize" id="prize"><?php echo $row["unit_price"]; ?></p>
            </td>
        </tr>
    </table>
    <table border="0" rules=none cellspacing=0 style="margin-top: 10px;">
        <tr class="h30">
            <th class="table2_th">Product ID</th>
            <td class="table2_return" id="idd"><?php echo $row["product_id"]; ?></td>
        </tr>
        <tr class="h30">
            <th class="table2_th">Unit Quantity</th>
            <td class="table2_return" id="unitquantity"><?php echo $row["unit_quantity"]; ?></td>
        </tr>
        <tr class="h30">
            <th  class="table2_th" style="color: #81b542">In stock</th>
            <td class="table2_return" id="instock"><?php echo $row["in_stock"]; ?></td>
        </tr>
        <tr class="h30">
            <th  class="table2_th">Quantity</th>
            <td class="table2_return"><input type="text" class="enter_no" id="quantity"></td>
        </tr>
    </table>
    <a >
        <input type="submit" id="addchart" style="margin-top:16px; background:url(images/add.png) no-repeat; width: 206px; height: 36px; border: none;" value="" onmouseout="removehover(this)" onmouseover="addhover(this)" onclick="addProducts(this)">
    </a>

    <?php
    print "</table>\n";
    }
    else
    {
        echo "<div align='center'>";
        echo "<img src='images/open.png' style='width: 179px; height: 170px; padding-top: 50px;' >";
        echo "<p style='font-size: 16px; color: #4d4d4d ; padding-top: 16px;'>Please select the item you need.</p>";
        echo "</div>";
    }

    mysqli_close($db);


        echo "<script type=\"text/javascript\">";
        echo "function addProducts() {";
        echo "var quantity = document.getElementById(\"quantity\").value;";
        echo "var link = \"shopping-cart.php?operation=add&product_id=".$product_id."&quantity=\""."+quantity".";";
        echo "if(Number(quantity)>0) {";
        echo "window.parent.shopping_cart.location.href=link;";
        echo "} else {";
        echo "alert(\"Please enter a valid quantity.\");";
        echo "}";
        echo "}";
        echo "</script>";
    ?>

</body>
</html>
<!--1st assignment-->

