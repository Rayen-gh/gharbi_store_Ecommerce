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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
$table->string('title');
$table->text('description');
$table->integer('quantity')->default(0); // add default if needed
$table->decimal('price', 15, 2);
$table->json('images')->nullable(); // replaces string 'image'
$table->unsignedBigInteger('category_id')->nullable();
$table->string('category_name')->nullable();
$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
$table->timestamps();

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
