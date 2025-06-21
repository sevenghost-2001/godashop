Dự án Godashop – Website bán quần áo thời trang
Mô tả chung:
Godashop là một hệ thống thương mại điện tử cơ bản dùng PHP thuần (kết hợp với một chút JavaScript) để bán quần áo thời trang, bao gồm cả giao diện người dùng (frontend) và giao diện quản trị (admin/backend).

Công nghệ & Kiến trúc
Ngôn ngữ & Framework: PHP (kết hợp Hack), sử dụng composer cho quản lý thư viện; cấu trúc theo mô hình MVC đơn giản. 
Cơ sở dữ liệu: MySQL; file godashop.sql chứa cấu trúc bảng và dữ liệu mẫu.
Frontend: HTML, CSS, JavaScript cơ bản (site folder), có giao diện cho người dùng đặt hàng và xem sản phẩm.
Backend/Admin: Có phần quản trị (admin folder) cho phép quản lý sản phẩm, đơn hàng, người dùng.
Tính năng tải lên ảnh: Thư mục upload xử lý upload hình ảnh sản phẩm, gắn với module service.
Kết nối DB: Dùng file connectDB.php, config.php để cấu hình kết nối, và bootstrap.php để khởi tạo hệ thống. 

Tính năng nổi bật
Quản lý sản phẩm: Thêm, sửa, xóa sản phẩm, upload ảnh, gắn giá, mô tả.
Giỏ hàng & Thanh toán: Người dùng có thể chọn sản phẩm vào giỏ, xem tổng tiền và đặt hàng.
Quản trị hệ thống: Admin xem danh sách đơn hàng, quản lý sản phẩm, user.
Cấu trúc rõ ràng: Module tách biệt—model, service, controller, view—giúp dễ mở rộng và bảo trì.
Tối ưu tái sử dụng: vendor dùng để cài các thư viện hỗ trợ, dễ mở rộng bằng composer.

Vai trò & Đóng góp của bạn
Thiết kế và triển khai cấu trúc MVC cho cả frontend và backend.(Chủ yếu là xử lý hiển thị bên front-end)
Xây dựng tính năng upload ảnh sản phẩm và tích hợp xử lý an toàn file.
Viết script SQL để khởi tạo database và dữ liệu mẫu (godashop.sql).
Phát triển chức năng giỏ hàng và quản lý đơn hàng.
Tối ưu kết nối database, cấu hình connectDB, config.php để đảm bảo ổn định & bảo mật.
Áp dụng composer để quản lý thư viện, chuẩn hóa cấu trúc code.
