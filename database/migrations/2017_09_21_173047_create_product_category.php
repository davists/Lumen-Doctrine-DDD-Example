<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category', function (Blueprint $table) {

            $table->increments('id');

            $table->addColumn('integer', 'category_id', ['unsigned' => true, 'length' => 10]);
            $table->index('category_id');

            $table->foreign('category_id')
                ->references('id')
                ->on('category')
                ->onDelete('no action')
                ->onUpdate('no action');


            $table->addColumn('integer', 'product_id', ['unsigned' => true, 'length' => 10]);
            $table->index('product_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('no action')
                ->onUpdate('no action');

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
        Schema::dropIfExists('product_category');
    }
}
