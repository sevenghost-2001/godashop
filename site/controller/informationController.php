<?php
class InformationController
{
    //chính sách đổi trả
    function ReturnPolicy()
    {
        require 'view/information/returnPolicy.php';
    }
    //chính sách thanh toán
    function PaymentPolicy()
    {
        require 'view/information/paymentPolicy.php';
    }
    //chính sách giao hàng
    function DeliveryPolicy()
    {
        require 'view/information/deliveryPolicy.php';
    }
};