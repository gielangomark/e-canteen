<?php

namespace Database\Seeders;

use App\Models\Canteen;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Super Admin ──
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ecanteen.test',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'balance' => 0,
            'email_verified_at' => now(),
        ]);

        // ── Menu pool per canteen ──
        $menuPool = [
            1 => [
                ['name' => 'Nasi Goreng Spesial', 'category' => 'makanan', 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar.', 'price' => 15000],
                ['name' => 'Soto Ayam', 'category' => 'makanan', 'description' => 'Soto ayam kuah bening dengan nasi.', 'price' => 13000],
                ['name' => 'Nasi Uduk Komplit', 'category' => 'makanan', 'description' => 'Nasi uduk dengan ayam goreng, tempe, dan sambal.', 'price' => 14000],
                ['name' => 'Es Teh Manis', 'category' => 'minuman', 'description' => 'Teh manis dingin yang menyegarkan.', 'price' => 5000],
                ['name' => 'Es Jeruk', 'category' => 'minuman', 'description' => 'Jeruk peras segar dengan es.', 'price' => 7000],
                ['name' => 'Risoles Mayo', 'category' => 'snack', 'description' => 'Risoles isi sayuran dan mayones.', 'price' => 5000],
            ],
            2 => [
                ['name' => 'Mi Ayam Bakso', 'category' => 'makanan', 'description' => 'Mi ayam dengan bakso sapi dan kuah kaldu.', 'price' => 12000],
                ['name' => 'Bakso Urat', 'category' => 'makanan', 'description' => 'Bakso urat jumbo dengan mie dan tahu.', 'price' => 15000],
                ['name' => 'Mi Goreng Jawa', 'category' => 'makanan', 'description' => 'Mi goreng bumbu Jawa dengan telur.', 'price' => 13000],
                ['name' => 'Susu Coklat', 'category' => 'minuman', 'description' => 'Susu coklat hangat atau dingin.', 'price' => 8000],
                ['name' => 'Es Cincau', 'category' => 'minuman', 'description' => 'Es cincau hijau dengan santan dan gula merah.', 'price' => 6000],
                ['name' => 'Dimsum Ayam', 'category' => 'snack', 'description' => 'Dimsum kukus isi ayam, 4 pcs.', 'price' => 10000],
            ],
            3 => [
                ['name' => 'Nasi Ayam Bakar', 'category' => 'makanan', 'description' => 'Ayam bakar madu dengan nasi dan lalap.', 'price' => 18000],
                ['name' => 'Salad Bowl', 'category' => 'makanan', 'description' => 'Salad sayur segar dengan dressing wijen.', 'price' => 12000],
                ['name' => 'Jus Alpukat', 'category' => 'minuman', 'description' => 'Jus alpukat segar dengan susu.', 'price' => 10000],
                ['name' => 'Jus Mangga', 'category' => 'minuman', 'description' => 'Jus mangga manis tanpa gula tambahan.', 'price' => 9000],
                ['name' => 'Infused Water', 'category' => 'minuman', 'description' => 'Air segar dengan irisan lemon dan mint.', 'price' => 5000],
                ['name' => 'Granola Bar', 'category' => 'snack', 'description' => 'Bar granola oat dengan madu dan kacang.', 'price' => 7000],
            ],
            4 => [
                ['name' => 'Nasi Campur Bali', 'category' => 'makanan', 'description' => 'Nasi campur khas Bali dengan lawar dan sate lilit.', 'price' => 17000],
                ['name' => 'Ayam Geprek', 'category' => 'makanan', 'description' => 'Ayam goreng tepung dengan sambal geprek pedas.', 'price' => 14000],
                ['name' => 'Es Kelapa Muda', 'category' => 'minuman', 'description' => 'Air kelapa muda segar dengan daging kelapa.', 'price' => 8000],
                ['name' => 'Teh Tarik', 'category' => 'minuman', 'description' => 'Teh susu khas Malaysia yang creamy.', 'price' => 7000],
                ['name' => 'Pisang Goreng Keju', 'category' => 'snack', 'description' => 'Pisang goreng dengan taburan keju.', 'price' => 6000],
                ['name' => 'Tahu Crispy', 'category' => 'snack', 'description' => 'Tahu goreng krispi dengan sambal kecap.', 'price' => 5000],
            ],
            5 => [
                ['name' => 'Nasi Pecel', 'category' => 'makanan', 'description' => 'Nasi pecel dengan sayuran dan bumbu kacang.', 'price' => 12000],
                ['name' => 'Gado-Gado', 'category' => 'makanan', 'description' => 'Sayuran rebus dengan bumbu kacang dan kerupuk.', 'price' => 13000],
                ['name' => 'Lontong Sayur', 'category' => 'makanan', 'description' => 'Lontong dengan sayur labu dan santan.', 'price' => 11000],
                ['name' => 'Es Cendol', 'category' => 'minuman', 'description' => 'Cendol dengan santan dan gula merah.', 'price' => 7000],
                ['name' => 'Wedang Jahe', 'category' => 'minuman', 'description' => 'Minuman jahe hangat dengan gula merah.', 'price' => 5000],
                ['name' => 'Kentang Goreng', 'category' => 'snack', 'description' => 'Kentang goreng crispy dengan saus.', 'price' => 8000],
            ],
            6 => [
                ['name' => 'Nasi Rendang', 'category' => 'makanan', 'description' => 'Nasi putih dengan rendang sapi empuk.', 'price' => 18000],
                ['name' => 'Sate Ayam', 'category' => 'makanan', 'description' => 'Sate ayam 10 tusuk dengan bumbu kacang.', 'price' => 15000],
                ['name' => 'Es Dawet', 'category' => 'minuman', 'description' => 'Dawet ayu dengan santan dan gula jawa.', 'price' => 6000],
                ['name' => 'Kopi Susu', 'category' => 'minuman', 'description' => 'Kopi susu gula aren kekinian.', 'price' => 10000],
                ['name' => 'Cireng Isi', 'category' => 'snack', 'description' => 'Cireng isi ayam dengan saus sambal.', 'price' => 6000],
                ['name' => 'Martabak Mini', 'category' => 'snack', 'description' => 'Martabak telur mini isi 4 pcs.', 'price' => 8000],
            ],
            7 => [
                ['name' => 'Nasi Rawon', 'category' => 'makanan', 'description' => 'Rawon daging sapi khas Jawa Timur.', 'price' => 16000],
                ['name' => 'Nasi Kuning', 'category' => 'makanan', 'description' => 'Nasi kuning komplit dengan ayam suwir.', 'price' => 13000],
                ['name' => 'Es Milo', 'category' => 'minuman', 'description' => 'Es Milo dinosaurus dengan susu.', 'price' => 8000],
                ['name' => 'Thai Tea', 'category' => 'minuman', 'description' => 'Thai tea creamy dengan boba.', 'price' => 10000],
                ['name' => 'Lumpia Semarang', 'category' => 'snack', 'description' => 'Lumpia goreng isi rebung dan udang.', 'price' => 7000],
                ['name' => 'Roti Bakar', 'category' => 'snack', 'description' => 'Roti bakar coklat keju.', 'price' => 8000],
            ],
        ];

        $descriptions = [
            1 => 'Aneka nasi, lauk pauk, dan minuman tradisional.',
            2 => 'Mi, bakso, dan aneka gorengan.',
            3 => 'Makanan sehat, jus buah, dan salad.',
            4 => 'Masakan nusantara dan minuman kekinian.',
            5 => 'Aneka masakan sayur dan jajanan pasar.',
            6 => 'Masakan Padang, sate, dan kopi.',
            7 => 'Masakan Jawa Timur dan minuman boba.',
        ];

        // ── 7 Sellers + Canteens ──
        for ($i = 1; $i <= 7; $i++) {
            $seller = User::create([
                'name' => "Seller Kantin $i",
                'email' => "seller$i@ecanteen.test",
                'password' => Hash::make('password'),
                'role' => 'seller',
                'balance' => 0,
                'email_verified_at' => now(),
            ]);

            $canteen = Canteen::create([
                'seller_id' => $seller->id,
                'name' => "Kantin $i",
                'description' => $descriptions[$i],
                'balance' => 0,
                'is_active' => true,
            ]);

            foreach ($menuPool[$i] as $item) {
                Menu::create(array_merge($item, ['canteen_id' => $canteen->id, 'is_available' => true]));
            }
        }

        // ── Student ──
        User::create([
            'name' => 'Gielang',
            'email' => 'gielang@ecanteen.test',
            'password' => Hash::make('password'),
            'role' => 'user',
            'balance' => 100000,
            'email_verified_at' => now(),
        ]);
    }
}
