<?php

class ContactController
{
    //Hiển thị giao diện trang liên hệ
    function form()
    {
        require 'view/contact/form.php';
    }
    //gởi mail đến chủ cửa hàng
    function sendEmail()
    {
        $emailService = new EmailService();
        $to = SHOP_OWNER;
        $subject = "Godashop: Khách hàng liên hệ";
        $name = $_POST['fullname'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $messenger = $_POST['content'];
        $reply = $email;
        $content = "
            Xin chào chủ shop,<br>
            Dưới đây là thông tin khách hàng liên hệ: <br>
            Tên: $name<br>
            SDT: $mobile<br>
            Email: $email<br>
            Nội dung:$messenger<br>
            Sent From :godashop.com
        ";
        $emailService->send($to, $subject, $content, $reply);
    }
};