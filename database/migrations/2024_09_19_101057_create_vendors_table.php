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
        Schema::create('vendors', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name');
            $table->string('telephone');
            $table->string('business_field');
            $table->string('npwp');
            $table->text('address');
            $table->string('website');
            $table->text('description');
            $table->enum('status', ['opened', 'review', 'reject', 'accepted'])->defaultValue('opened');;

            $table->foreignUuid('reviewer_id')->nullable()->references('id')->on('users');
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
