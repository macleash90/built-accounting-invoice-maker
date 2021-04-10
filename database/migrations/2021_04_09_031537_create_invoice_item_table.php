<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("invoice_id");
            $table->bigInteger("item_qty");
            $table->string('item_name');
            $table->bigInteger("item_id");
            $table->double("item_price_per_unit")->default(0.00);
            $table->double("sub_total_price")->default(0.00); //final price per item after rate applied or 
            $table->date("invoice_date")->nullable();
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
        Schema::dropIfExists('invoice_item');
    }
}
