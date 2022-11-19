<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class CustomerController
{
    function show()
    {
        $email = $_SESSION['email'];
        $customerRepository = new CustomerRepository();
        $customer = $customerRepository->findEmail($email);
        //var_dump($customer);
        require 'view/customer/show.php';
    }
    function updateInfo()
    {

        $email = $_SESSION['email'];
        $customerRepository = new CustomerRepository();
        $customer = $customerRepository->findEmail($email);
        $customer->setName($_POST['fullname']);
        $customer->setMobile($_POST['mobile']);
        $current_password = $_POST['current_password'];
        $new_password = $_POST['password'];
        if ($current_password && $new_password) {
            if (!password_verify($current_password, $customer->getPassword())) {
                $_SESSION['error'] = 'Mật khẩu hiện tại không dúng';
                header('location:?c=customer&a=show');
                exit;
            }
            $encode_new_password = password_hash($new_password, PASSWORD_BCRYPT);
            $customer->setPassword($encode_new_password);
        }

        if ($customerRepository->update($customer)) {
            $_SESSION['name'] = $_POST['fullname'];
            $_SESSION['success'] = 'Đã cập nhật thông tin tài khoản';
            header('location:?c=customer&a=show');
            exit;
        }
        $_SESSION['error'] = $customerRepository->getError();
        header('location:?c=customer&a=show');
    }
    function orders()
    {
        require 'view/customer/orders.php';
    }
    function shippingDefault()
    {
        require 'view/customer/shippingDefault.php';
    }

    function notExistingEmail()
    {
        //true là hợp lệ, không lỗi (không tồn tại email)
        //false là không hợp lệ, lỗi (tồn tại email)
        $email = $_GET["email"];
        $customerRepository = new CustomerRepository();
        $customer = $customerRepository->findEmail($email);
        if (!$customer) {
            echo "true";
            return;
        }
        echo "false";
        return;
    }

    function register()
    {
        $secret = GOOGLE_RECAPTCHA_SECRET;
        $remoteIp = "127.0.0.1";
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        $gRecaptchaResponse = $_POST["g-recaptcha-response"];
        $resp = $recaptcha->setExpectedHostname(get_host_name())
            ->verify($gRecaptchaResponse, $remoteIp);

        if ($resp->isSuccess()) {
            // Verified!
            //Lưu xuống database
            $data = [];
            $data["name"] = $_POST["fullname"];
            $data["password"] = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $data["mobile"] = $_POST["mobile"];
            $data["email"] = $_POST["email"];
            $data["login_by"] = "form";
            $data["shipping_name"] = $_POST["fullname"];
            $data["shipping_mobile"] =  $_POST["mobile"];
            $data["ward_id"] = null;
            $data["is_active"] = 0;
            $data["housenumber_street"] = "";
            $customerRepository = new CustomerRepository();
            if ($customerRepository->save($data)) {

                $_SESSION["success"] = "Bạn đã tạo được tài khoản thành công. Vui lòng vào email để kích hoạt tài khoản";
                //Gởi mail để kích hoạt tài khoản
                $emailService = new EmailService();
                $to = $_POST["email"];
                $subject = "Godashop: Active Account";
                $name = $_POST["fullname"];

                $key = JWT_KEY;
                $payload = array(
                    "email" => $to,
                    "timestamp" => time()
                );

                $token = JWT::encode($payload, $key, 'HS256');

                $linkActiveAccount = get_domain_site() . "/index.php?c=customer&a=activeAccount&token=$token";
                $message = "
				Dear $name,
				Please click bellow button to active your account
				<br>
				<a href='$linkActiveAccount'>Active Account</a>
				";
                $emailService->send($to, $subject, $message);
            } else {
                $_SESSION["error"] = $customerRepository->getError();
            }
        } else {
            $_SESSION["error"] = "Xác thực recaptcha thất bại";
        }

        header("location: index.php");
    }

    function activeAccount()
    {
        $code = $_GET["token"];
        try {
            $decoded = JWT::decode($code, new Key(JWT_KEY, 'HS256'));
            $email = $decoded->email;
            $customerRepository = new CustomerRepository();
            $customer = $customerRepository->findEmail($email);
            if (!$customer) {
                $_SESSION["error"] = "Email $email không tồn tại";
                header("location: /");
            }
            $customer->setIsActive(1);
            $customerRepository->update($customer);
            $_SESSION["success"] = "Tài khoản của bạn đã được active";
            //Cho phép login luôn
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $customer->getName();
            header("location: /");
        } catch (Exception $e) {
            echo "You try hack!";
        }
    }
}