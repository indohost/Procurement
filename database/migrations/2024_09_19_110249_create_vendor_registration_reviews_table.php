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
        Schema::create('vendor_registration_reviews', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->text('comment');

            $table->foreignUuid('reviewer_id')->references('id')->on('users');
            $table->foreignUuid('vendor_id')->references('id')->on('vendors');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_registration_reviews');
    }
};
