<html>
<head>

<style>
#payu-payment-form button[type=submit] {
    border: 0px;
    height: 35px;
    width: 140px;
    background: url('http://static.payu.com/pl/standard/partners/buttons/payu_account_button_long_03.png');
    background-repeat: no-repeat;
    cursor: pointer;
}
</style>
</head>
<body>






<br>
<br>
<form method="post" action="https://secure.payu.com/api/v2_1/orders">
    <input type="hidden" name="continueUrl" value="http://shop.url/continue">
    <input type="hidden" name="currencyCode" value="PLN">
    <input type="hidden" name="customerIp" value="123.123.123.123">
    <input type="hidden" name="description" value="Order description">
    <input type="hidden" name="merchantPosId" value="145227">
    <input type="hidden" name="notifyUrl" value="http://shop.url/notify">
    <input type="hidden" name="products[0].name" value="Product 1">
    <input type="hidden" name="products[0].quantity" value="1">
    <input type="hidden" name="products[0].unitPrice" value="1000">
    <input type="hidden" name="totalAmount" value="1000">
    <input type="hidden" name="OpenPayu-Signature" value="sender=145227;algorithm=SHA-256;signature=bc94a8026d6032b5e216be112a5fb7544e66e23e68d44b4283ff495bdb3983a8">
    <button type="submit" formtarget="_blank" >Pay with PayU</button><br><br><button id="pay-button" style="border: 0px; height: 50px; width: 313px; background: url('http://static.payu.com/pl/standard/partners/buttons/payu_account_button_long_03.png') no-repeat; cursor: pointer;"></button>
</form >






</body>
</html>