<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\product_categories;
use App\Models\Role;
use App\Models\stores;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Role::create(
            [
                'name' => 'Administrator',
            ],
        );
        role::create(
            [
                'name' => 'operatorForklift',
            ],
        );

        User::create([
            "name" => "Qhurma",
            "email" => "Qhurma@gmail.com",
            "phone_number" => "085733296961",
            "password" =>  bcrypt('12345'),
            "address" =>  [
               [ "Address1"=> ["id_province" => 13,
                "id_city" => 15,
                "street" => "Jl. Pasar Kembang 3"]],
               [ "Address2"=> ["id_province" => 14,
                "id_city" => 16,
                "street" => "Jl. Pasar Kembang 2"]],
               
            ],
            "role" => 1,
        ]);

        stores::create([
            "user_id" => 1,
            "name" => "Dummy Store",
            "status" => 1,
            "address" =>  [
                "id_province" => 13,
                "id_city" => 15,
                "street" => "Jl. Pasar Kembang 1"
            ],
            // "address" => $array,
            // "role" => 1,
        ]);        
        
        product_categories::create([
            "category_name" => "Sofa",
            "status" => 1,
            "category_url_picture" => [
                "url_picture" => "https://checkitout.com"
            ]
        ]);

        Product::create([
            "store_id" => 1,
            "category_id" => 1,
            "name" => " Cherry Blossom",
            "description" => "Kursi Cherry Blossom",
            "price" => 1000000,
            "varian" => [
                "varian_1" => [
                    "id_product_varian" => "CherryB1",
                    "product_varian" => "Blossom",
                    "stock" => 2,
                    "image_link" => "https://imageLink1.com",
                    "ar_link" => "https://arProductLink1.com"
                ],
                "varian_2" => [
                    "id_product_varian" => "CherryB2",
                    "product_varian" => "White Bone",
                    "stock" => 2,
                    "image_link" => "https://imageLink2.com",
                    "ar_link" => "https://arProductLink2.com"
                ]
            ],   
        ]);

        Product::create([
            "store_id" => 1,
            "category_id" => 1,
            "name" => "Kizumane",
            "description" => "Kursi Kizumane",
            "price" => 1000000,
            "varian" => [
                "varian_1" => [
                    "id_product_varian" => "Kizumane1",
                    "product_varian" => "Red Blood",
                    "stock" => 2,
                    "image_link" => "https://imageLink3.com",
                    "ar_link" => "https://arProductLink3.com"
                ],
                "varian_2" => [
                    "id_product_varian" => "Kizumane2",
                    "product_varian" => "Pink",
                    "stock" => 2,
                    "image_link" => "https://imageLink4.com",
                    "ar_link" => "https://arProductLink4.com"
                ]
            ],   
        ]);

        Product::create([
            "store_id" => 1,
            "category_id" => 1,
            "name" => "Rangoku",
            "description" => "Kursi Kizumane",
            "price" => 1000000,
            "varian" => [
                "varian_1" => [
                    "id_product_varian" => "Rangoku1",
                    "product_varian" => "Red Blood",
                    "stock" => 2,
                    "image_link" => "https://imageLink6.com",
                    "ar_link" => "https://arProductLink6.com"
                ],
                "varian_2" => [
                    "id_product_varian" => "Rangoku2",
                    "product_varian" => "Pink",
                    "stock" => 2,
                    "image_link" => "https://imageLink7.com",
                    "ar_link" => "https://arProductLink7.com"
                ]
            ],   
        ]);
    }
}
