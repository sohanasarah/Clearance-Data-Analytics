<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('calendar_id')->constrained('calendar');
            //$table->unsignedBigInteger('manufacturer_id')->constrained('manufacturers');
            $table->foreignId('calendar_id')
                ->constrained('calendar')
                ->onDelete('cascade');
            $table->foreignId('manufacturer_id')
                ->constrained('manufacturers')
                ->onDelete('cascade');
            $table->decimal('vat_deposit',10,2);
            $table->decimal('sd_deposit',10,2);
            $table->decimal('hdsc_deposit',10,2);
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
        Schema::dropIfExists('deposits');
    }
}
