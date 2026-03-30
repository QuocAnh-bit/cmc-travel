<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HotelRoomSeeder extends Seeder
{
    public function run()
    {
        // Xóa dữ liệu cũ để tránh trùng lặp nếu bạn chạy lại lệnh seed
        // Room::truncate(); 
        // Hotel::truncate();

        $data = [
            [
                'name' => 'CMC Grand Plaza Ha Noi',
                'address' => 'Trần Duy Hưng, Cầu Giấy, Hà Nội',
                'phone' => '024 3555 111',
                'rooms' => [
                    ['name' => 'Superior City View', 'price' => 1200000, 'img' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304'],
                    ['name' => 'Executive Suite', 'price' => 3500000, 'img' => 'https://images.unsplash.com/photo-1590490360182-c33d59735310'],
                ]
            ],
            [
                'name' => 'CMC Boutique Sapa',
                'address' => 'Fansipan, Thị xã Sa Pa, Lào Cai',
                'phone' => '0214 666 888',
                'rooms' => [
                    ['name' => 'Mountain View Room', 'price' => 950000, 'img' => 'https://images.unsplash.com/photo-1544124499-58912cbddaad'],
                    ['name' => 'Cloudy Terrace Room', 'price' => 1500000, 'img' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a'],
                ]
            ],
            [
                'name' => 'CMC Ha Long Bay Resort',
                'address' => 'Bãi Cháy, TP. Hạ Long, Quảng Ninh',
                'phone' => '0203 222 333',
                'rooms' => [
                    ['name' => 'Ocean Deluxe', 'price' => 2100000, 'img' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4'],
                ]
            ],
            [
                'name' => 'CMC Emerald Hue',
                'address' => 'Lê Lợi, TP. Huế, Thừa Thiên Huế',
                'phone' => '0234 555 777',
                'rooms' => [
                    ['name' => 'Imperial Room', 'price' => 800000, 'img' => 'https://images.unsplash.com/photo-1595576508898-0ad5c879a061'],
                ]
            ],
            [
                'name' => 'CMC Riverside Da Nang',
                'address' => 'Bạch Đằng, Quận Hải Châu, Đà Nẵng',
                'phone' => '0236 444 999',
                'rooms' => [
                    ['name' => 'River View Suite', 'price' => 1850000, 'img' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39'],
                ]
            ],
            [
                'name' => 'CMC Beach Front Nha Trang',
                'address' => 'Trần Phú, TP. Nha Trang, Khánh Hòa',
                'phone' => '0258 777 111',
                'rooms' => [
                    ['name' => 'Premier Ocean', 'price' => 2800000, 'img' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d'],
                ]
            ],
            [
                'name' => 'CMC Pine Hill Da Lat',
                'address' => 'Phù Đổng Thiên Vương, TP. Đà Lạt',
                'phone' => '0263 333 555',
                'rooms' => [
                    ['name' => 'Garden View Cabin', 'price' => 700000, 'img' => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c'],
                ]
            ],
            [
                'name' => 'CMC Saigon Signature',
                'address' => 'Đồng Khởi, Quận 1, TP. HCM',
                'phone' => '028 2222 4444',
                'rooms' => [
                    ['name' => 'Business King Room', 'price' => 4500000, 'img' => 'https://images.unsplash.com/photo-1591088398332-8a77d399e843'],
                ]
            ],
            [
                'name' => 'CMC Can Tho River',
                'address' => 'Ninh Kiều, TP. Cần Thơ',
                'phone' => '0292 888 999',
                'rooms' => [
                    ['name' => 'Mekong Suite', 'price' => 1100000, 'img' => 'https://images.unsplash.com/photo-1560185127-6ed189bf02f4'],
                ]
            ],
            [
                'name' => 'CMC Phu Quoc Pearl',
                'address' => 'Bãi Trường, Dương Tơ, Phú Quốc',
                'phone' => '0297 555 444',
                'rooms' => [
                    ['name' => 'Sunset Villa', 'price' => 5500000, 'img' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2'],
                ]
            ],
            
        ];

        foreach ($data as $item) {
            $hotel = Hotel::create([
                'name' => $item['name'],
                'address' => $item['address'],
                'phone' => $item['phone'],
            ]);

            foreach ($item['rooms'] as $r) {
                Room::create([
                    'hotel_id' => $hotel->id,
                    'name' => $r['name'],
                    'price' => $r['price'],
                    'image' => $r['img'], // Lưu trực tiếp URL ảnh
                    'description' => 'Trải nghiệm dịch vụ đẳng cấp 5 sao tại ' . $item['name'],
                    'amenities' => ['Wifi', 'TV', 'Điều hòa', 'Minibar'],
                    'status' => 'available',
                    'is_featured' => rand(0, 1),
                ]);
            }
        }
    }
}