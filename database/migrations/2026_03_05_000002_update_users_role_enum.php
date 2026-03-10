<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change role enum to include super_admin and seller
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'seller', 'user') NOT NULL DEFAULT 'user'");

        // Migrate existing admin users to super_admin
        DB::table('users')->where('role', 'admin')->update(['role' => 'super_admin']);

        // Now remove old admin value
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'seller', 'user') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'seller', 'user') NOT NULL DEFAULT 'user'");
        DB::table('users')->where('role', 'super_admin')->update(['role' => 'admin']);
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
    }
};
