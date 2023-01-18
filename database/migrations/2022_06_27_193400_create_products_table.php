<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('club_id')->nullable();
            $table->string('name')->nullable();
            $table->string('amount')->nullable();
            $table->boolean('door_access')->default(1);
            $table->integer('grace_period')->nullable();
            $table->boolean('payment_type')->default(1);
            $table->integer('reoccuring_day')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
