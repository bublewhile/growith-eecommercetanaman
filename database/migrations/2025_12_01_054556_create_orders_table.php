<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->decimal('shipping_fee', 12, 2)->default(0);
            $table->string('status')->default('process');
            $table->foreignId('promo_id')->nullable()->constrained()->onDelete('set null');
            $table->string('size')->nullable();
            $table->string('pot_material')->nullable();
            $table->string('pot_color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
