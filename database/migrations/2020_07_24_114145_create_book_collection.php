<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_collection', function (Blueprint $table) {

            $table->bigInteger('book_id')->unsigned();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->bigInteger('collection_id')->unsigned();
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
            $table->primary(['book_id', 'collection_id']);
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
        Schema::dropIfExists('book_collection');
    }
}
