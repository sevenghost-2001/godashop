<?php

use function PHPSTORM_META\type;

class ProductController
{
    function index()
    {
        //Lấy hết danh mục đổ lên view
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->getAll();

        $productRepository = new ProductRepository();
        $conds = [];
        $sorts = [];
        $page = $_GET['page'] ?? 1;
        $item_per_page = 10;
        $category_id = $_GET['category_id'] ?? NULL;
        $categoryName = "Tất cả sản phẩm";
        if ($category_id) {
            $conds = [
                'category_id' => [
                    'type' => '=',
                    'val' => $category_id
                ]
            ];
            $category =  $categoryRepository->find($category_id);
            $categoryName = $category->getName();
        }
        $priceRange = $_GET['price-range'] ?? null;
        //500-1000
        if ($priceRange) {
            $temp = explode('-', $priceRange);
            $start = $temp[0]; //500
            $end = $temp[1]; //1000
            $conds = [
                'sale_price' => [
                    'type' => 'BETWEEN',
                    'val'  => " $start AND $end "
                ]

            ];
            //SELECT * FROM view_product WHERE sale_price BETWEEN 500000 AND 1000000
            if ($end == 'greater') {
                $conds = [
                    'sale_price' => [
                        'type' => '>=',
                        'val'  => $start
                    ]
                ];
            }
            //SELECT * FROM view_product WHERE sale_price >= 500000 
        }
        $sort = $_GET['sort'] ?? null;
        //price-desc
        if ($sort) {
            //temp chứa 2 phần tử price ,desc
            $temp = explode('-', $sort);
            $col = $temp[0];
            $order = $temp[1];
            $colMap = ['price' => 'sale_price', 'alpha' => 'name', 'created' => 'created_date'];
            $colName = $colMap[$col];

            $sorts = [$colName => $order]; //['sale_price'=>'desc']
        }
        $allProducts = $productRepository->getBy($conds, $sorts);
        //ceil() là hàm làm tròn lên
        $total_page = ceil(count($allProducts) / $item_per_page);


        $products = $productRepository->getBy($conds, $sorts, $page, $item_per_page);
        require 'view/product/index.php';
    }
    function detail()
    {
        //Lấy hết danh mục đổ lên view
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->getAll();

        $id = $_GET['id'];
        $productRepository = new ProductRepository();
        $product = $productRepository->find($id);
        $category_id = $product->getCategoryId();
        $conds = [
            'category_id' => [
                'type' => '=',
                'val'   => $product->getCategoryId()
            ],
            'id' => [
                'type' => '!=',
                'val'   => $product->getId()
            ]
        ];
        //SELECT * FROM view_product WHERE category_id = 5 AND id != 3;
        $sorts = []; //không cần quan tâm thứ tự
        $relatedProducts = $productRepository->getBy($conds, $sorts);
        require 'view/product/detail.php';
    }
}