<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('company_id');
            $table->string('name');
            $table->decimal('price',8,2);
            $table->string('image');
            $table->string('description')->nullable();
            $table->tinyInteger('active')->default(1);

            $table->string('ncm')->nullable();
            $table->string('sku')->nullable();
            $table->string('upc')->nullable();
            $table->string('model')->nullable();

            $table->string('weight')->nullable();
            $table->string('length')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
