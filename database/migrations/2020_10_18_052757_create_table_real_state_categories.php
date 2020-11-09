<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRealStateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_state_categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('real_state_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('real_state_id')->references('id')->on('real_states');
            $table->foreign('category_id')->references('id')->on('categories');

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
        Schema::dropIfExists('real_state_categories');
    }
}
