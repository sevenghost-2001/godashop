<?php
class AuthController
{
    function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $customerRepository = new CustomerRepository();
        $customer = $customerRepository->findEmail($email);
        var_dump($customer);
        if (!$customer) {
            $_SESSION['error'] = 'Error: Email không tồn tại';
            header('location:/');
            exit;
        }
        if (!password_verify($password, $customer->getPassword())) {
            $_SESSION['error'] = 'Error: Sai mật khẩu';
            header('location:/');
            exit;
        }

        if (!$customer->getIsActive()) {
            $_SESSION['error'] = 'Error: Tài khoản chưa kích hoạt';
            header('location:/');
            exit;
        }

        //Đăng nhập thành công(Đúng email và password)
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $customer->getName();
        header('location:?c=customer&a=show');
    }

    function logout()
    {
        //Hủy session ,nghĩa là array $session sẽ  empty
        session_destroy();
        header('location:/');
    }
}