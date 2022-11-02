<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanTemplateTable extends Migration
{
    public function up()
    {
        Schema::create('plan_template', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('template_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plan_template');
    }
}
