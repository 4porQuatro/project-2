<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 20);
            $table->boolean('active')->default(true);
            $table->float('discount_value')->default(0);
            $table->float('percentage_discount')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $permissions_seeder = new \Database\Seeders\PermissionSeeder('voucher', 'Vouchers');
        $permissions_seeder->run();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions_seeder = new \Database\Seeders\PermissionSeeder('voucher', 'Vouchers');
        $permissions_seeder->delete();
        Schema::dropIfExists('attributes');
    }
}
