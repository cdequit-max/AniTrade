<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 20)->unique();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('store_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('produce_id')->constrained('produces')->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('total', 12, 2);
            $table->string('fulfillment', 10)->default('pickup');          // pickup | delivery
            $table->string('status', 15)->default('pending');              // pending | confirmed | completed | cancelled
            $table->string('payment_status', 10)->default('unpaid');       // unpaid | paid (Cash on Pickup/Delivery)
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
