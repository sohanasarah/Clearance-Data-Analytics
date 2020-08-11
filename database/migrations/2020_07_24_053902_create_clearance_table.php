<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClearanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clearance', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('calendar_id')->constrained('calendar');
            $table->foreignId('calendar_id')
                ->constrained('calendar')
                ->onDelete('cascade');
            $table->string('measure',48);
            //$table->unsignedBigInteger('item_id')->constrained('items');
            $table->foreignId('item_id')
                ->constrained('items')
                ->onDelete('cascade');
            $table->decimal('figure',10,2);
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
        Schema::dropIfExists('clearance');
    }
}
