<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Content extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content', function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->integer('cid')->comment('栏目id')->default('0');
            $table->string('title',255)->comment('标题');
            $table->text('content')->comment('内容'); 
            $table->string('image', 255)->nullable()->comment('图片');
            $table->tinyInteger('status')->comment('状态默认1')->default('1');
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
        //
    }
}
