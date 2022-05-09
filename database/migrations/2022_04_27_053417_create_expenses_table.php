<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('department');
            $table->double('project_no');
            $table->string('description');
            $table->integer('amount');
            $table->string('currency');
            $table->string('expense_type');
            $table->string('transaction_type');
            $table->text('receipt_photo_name')->default("")->nullable();
            $table->text('receipt_photo_path')->default("")->nullable();
            $table->date('date_issued');

            // $table->softDeletes();
            $table->timestamps();

            //relationship with users table
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};
