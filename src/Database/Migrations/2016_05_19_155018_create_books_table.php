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
        // resons table for test
        Schema::create('reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->timestamps();
            $table->softDeletes();
        });

        \DB::table('reasons')->insert([
            'name' => 'test',
            'code' => 'qr-125',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'deleted_at' => null,
        ]);

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
        Schema::drop('reasons');
    }
}
