<?php

namespace App\Exports;

use App\Models\Api\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExpenseExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $user_expense = Expense::where('user_id', auth()->user()->id)->get();

        return $user_expense;
    }
}
