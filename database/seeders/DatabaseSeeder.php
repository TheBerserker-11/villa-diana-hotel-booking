<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RoomType;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Password@1'),
            'is_admin' => 1
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('Password@1'),
            'is_admin' => 0
        ]);

        $superior        = RoomType::create(['name' => 'Superior']);
        $deluxe          = RoomType::create(['name' => 'Deluxe']);
        $family          = RoomType::create(['name' => 'Family']);
        $balconyDeluxe   = RoomType::create(['name' => 'Balcony Deluxe']);
        $doubleDeluxe    = RoomType::create(['name' => 'Double Deluxe']);
        $executive       = RoomType::create(['name' => 'Executive']);
        $vip             = RoomType::create(['name' => 'VIP']);
        $treeHouse       = RoomType::create(['name' => 'Tree House']);
        $vipDoubleDeluxe = RoomType::create(['name' => 'VIP Double Deluxe']);
        $dormitory       = RoomType::create(['name' => 'Dormitory']);

        $rooms = [
            [
                'desc' => 'If you’re in town for business, the Superior Room has been specially designed...',
                'bed_type' => 1,
                'room_type_id' => $superior->id,
                'total_room' => 1,
                'no_beds' => 1,
                'price' => 2095,
                'image' => 'superior.jpg',
                'kuula_link' => 'https://kuula.co/share/collection/7DwH7?logo=0&info=0&fs=1&vr=1&sd=1&initload=0&thumbs=1'
            ],
            [
                'desc' => 'The quiet, spacious room features a Deluxe queen sized bed for a good night’s rest...',
                'bed_type' => 1,
                'room_type_id' => $deluxe->id,
                'total_room' => 1,
                'no_beds' => 1,
                'price' => 2495,
                'image' => 'singledeluxe.jpg',
                'kuula_link' => 'https://kuula.co/share/collection/7DwHk?logo=0&info=0&fs=1&vr=1&sd=1&initload=0&thumbs=1'
            ],
            [
                'desc' => 'The fun & relaxed atmosphere of the Family Room makes it the perfect getaway...',
                'bed_type' => 2,
                'room_type_id' => $family->id,
                'total_room' => 1,
                'no_beds' => 4,
                'price' => 4495,
                'image' => 'famroom.jpg',
                'kuula_link' => 'https://kuula.co/share/collection/7DwHF?logo=0&info=0&fs=1&vr=1&sd=1&initload=0&thumbs=1'
            ],
            [
                'desc' => 'Decorated in pastel colors with a balcony overlooking the poolside...',
                'bed_type' => 2,
                'room_type_id' => $balconyDeluxe->id,
                'total_room' => 1,
                'no_beds' => 2,
                'price' => 2995,
                'image' => 'doubledeluxebalcony.jpg',
                'kuula_link' => 'https://kuula.co/share/collection/7DwHJ?logo=0&info=0&fs=1&vr=1&sd=1&initload=0&thumbs=1'
            ],
            [
                'desc' => 'Decorated in pastel colors, this charming double deluxe room creates a soothing ambiance...',
                'bed_type' => 2,
                'room_type_id' => $doubleDeluxe->id,
                'total_room' => 1,
                'no_beds' => 2,
                'price' => 2995,
                'image' => 'doubledeluxe.jpg',
                'kuula_link' => null
            ],
            [
                'desc' => 'Combining luxury and comfort, the Executive room is the perfect escape...',
                'bed_type' => 1,
                'room_type_id' => $executive->id,
                'total_room' => 1,
                'no_beds' => 1,
                'price' => 3595,
                'image' => 'executive.jpg',
                'kuula_link' => null
            ],
            [
                'desc' => 'Decorated with exquisite taste, the VIP room is the perfect suite...',
                'bed_type' => 1,
                'room_type_id' => $vip->id,
                'total_room' => 1,
                'no_beds' => 1,
                'price' => 2995,
                'image' => 'vip.jpg',
                'kuula_link' => null
            ],
            [
                'desc' => 'Perfect for Nature Lovers! Fulfill your dream to be Tarzan or Jane...',
                'bed_type' => 1,
                'room_type_id' => $treeHouse->id,
                'total_room' => 1,
                'no_beds' => 1,
                'price' => 1495,
                'image' => 'treeh.jpg',
                'kuula_link' => null
            ],
            [
                'desc' => 'The VIP Double Deluxe Room provides extra space your family needs...',
                'bed_type' => 2,
                'room_type_id' => $vipDoubleDeluxe->id,
                'total_room' => 1,
                'no_beds' => 2,
                'price' => 3395,
                'image' => 'vipdouble.jpg',
                'kuula_link' => null
            ],
            [
                'desc' => 'The Cabin sleeps up to 16-20 guests, offers 2 private bathrooms, Double Deck...',
                'bed_type' => 3,
                'room_type_id' => $dormitory->id,
                'total_room' => 1,
                'no_beds' => 20,
                'price' => 16500,
                'image' => 'cabin.jpg',
                'kuula_link' => null
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
