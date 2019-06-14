<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
        "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Online Grocery Store</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
<div id="email" align="center">
    <?php
    session_start();

    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $address = $_POST['address'];
    $suburb = $_POST['suburb'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $postcode = $_POST['postcode'];
    $email = $_POST['email'];

    $subject = "Your Online Grocery Store order confirmation";
    $cart_content = "";
    $subtotal = 0;

    for($i=0; $i<count($_SESSION['cart']); $i++) {
        $subtotal = $subtotal + $_SESSION['cart'][$i]['quantity']*$_SESSION['cart'][$i]['unit_price'];
    }

    for($i=0; $i<count($_SESSION['cart']); $i++) {
        $cart_content .= "<tr>"
            ."<td>".$_SESSION['cart'][$i]['product_name']."</td>"
            ."<td>$".$_SESSION['cart'][$i]['unit_price']."</td>"
            ."<td>".$_SESSION['cart'][$i]['unit_quantity']."</td>"
            ."<td>".$_SESSION['cart'][$i]['quantity']."</td>"
            ."<td>$".$_SESSION['cart'][$i]['quantity']*$_SESSION['cart'][$i]['unit_price']."</td>"
            ."</tr>";
    }
    $cart_content .= "<tr><td colspan=\"3\">Number of Products: </td><td colspan=\"3\">".count($_SESSION['cart'])."</td></tr>";
    $cart_content .= "<tr><td colspan=\"3\">Subtotal: </td><td colspan=\"3\">$".$subtotal."</td></tr>";

    $message = "
            <html>
                <head>
                    <title>Your Online Grocery Store order confirmation</title>
                </head>
                <body>
                    <p>Hi $firstName ,</p>
                    <p>Thanks for your order,</p>
                    <p>Your contact details are:</p>
                    <table border=\"1\">
                        <tr>
                            <td>Name</td>
                            <td>$firstName $lastName</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>$address</td>
                        </tr>
                        <tr>
                            <td>Suburb</td>
                            <td>$suburb</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>$state</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>$country</td>
                        </tr>
                        <tr>
                            <td>Post Code</td>
                            <td>$postcode</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>$email</td>
                        </tr>
                    </table>
                    <p>Your order information is: </p>
                    <table border=\"1\">
                        <tr>
                            <td>Product Name</td>
                            <td>Unit Price</td>
                            <td>Unit Quantity</td>
                            <td>Required Quantity</td>
                            <td>Total Cost</td>
                        </tr>
        ".$cart_content."
                    </table>
                    <p>Designed by Jinwei Li & Jianni Hu</p>
                </body>
            </html>
        ";
    $from = "hujianni@gmail.com";
    $headers = "MIME-Version: 1.0"."\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
    $headers .= "From: $from"."\r\n";

    $flag = mail($email, $subject, $message, $headers);

    if($flag == true) {
        echo "<img src='images/success.png' style='width: 80px; height: 80px; padding-top: 50px;' >";
        echo "<p style='font-size: 18px; color: #81b542; font-weight: bold; padding-top: 10px;'>Thanks for your order $firstName!</p>";
        echo "<p style='font-size: 14px; color: #7d7d7d; padding-top: 4px;'>The detail of your order has been emailed to you.</p>";
    } else {
        echo "<img src='images/fail.png' style='width: 80px; height: 80px; padding-top: 50px;' >";
        echo "<p style='font-size: 18px; color: #e35e00; font-weight: bold; padding-top: 10px;'>Sorry, $firstName! We failed to send an email to you!</p>";
        echo "<p style='font-size: 14px; color: #7d7d7d; padding-top: 4px;'>Please have a try later. </p>";
    }

    ?>
</div>
</body>
</html>