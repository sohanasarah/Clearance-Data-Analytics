<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand_name',48);
            $table->string('short_name',24);
            //$table->unsignedBigInteger('segment_id')->constrained('segments');
            //$table->unsignedBigInteger('manufacturer_id')->constrained('manufacturers');
            $table->foreignId('segment_id')
                ->constrained('segments')
                ->onDelete('cascade');
            $table->foreignId('manufacturer_id')
                ->constrained('manufacturers')
                ->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('brands');
    }
}
