<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expense = [
            [
                "id" => 1,
                "name" => "Charles Darwin",
                "department" => "Field Work",
                "project_no" => "32856",
                "description" => "Auditing of Sugar Cane Farms in Kabras",
                "amount" => "35000",
                "currency" => "KSH",
                "expense_type" => "Fuel",
                "transaction_type" => "Money Out",
                "receipt_photo" => "public/images/0P6LgSEYUN69hyH14Qi6zkVYnye8S9yBn3kT9K6H.jpg",
                "date_issued" => "2021-09-09",
                "updated_at" => Carbon::now(),
                "created_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "name" => "Jane Doe",
                "department" => "Surveying",
                "project_no" => "39999",
                "description" => "Picking ground leveling of Uhuru Highway",
                "amount" => "26100",
                "currency" => "KSH",
                "expense_type" => "Equipment Hire",
                "transaction_type" => "Money In",
                "receipt_photo" => "public/images/0P6LgSEYUN69hyH14Qi6zkVYnye8S9yBn3kT9K6H.jpg",
                "date_issued" => "2021-08-15",
                "updated_at" => Carbon::now(),
                "created_at" => Carbon::now()
            ]
        ];

        DB::table('expenses')->insert($expense);
    }
}
