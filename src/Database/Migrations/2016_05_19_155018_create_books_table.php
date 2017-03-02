<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reason_id')->unsigned();
            $table->foreign('reason_id')->references('id')->on('reasons')->onDelete('cascade');
            $table->string('name');
            $table->string('author');
            $table->string('genre');
            $table->integer('stars');
            $table->date('published_year');
            $table->boolean('enabled')->default(1);
            $table->enum('status', ['setting_documents', 'waiting_confirmation', 'reviewing', 'approved']);
            $table->string('unlocking_word');
            $table->text('synopsis')->nullable();
            // campos de control para el sistema
            $table->dateTime('approved_at')->nullable();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('approved_password')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
