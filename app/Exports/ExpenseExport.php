<?php

namespace App\Exports;

use App\Models\Api\Expense;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExpenseExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $expense;
public function __construct(){
    $this->expense = Expense::where('user_id', auth()->user()->id)->get();
}

    public function collection()
    {
        $user_expense = Expense::where('user_id', auth()->user()->id)->get([
            'employee_name',
            'department',
            'project_no',
            'description',
            'currency',
            'amount',
            'expense_type',
            'transaction_type',
            'updated_at'
        ]);

        return $user_expense;
    }

    //customize the columns
    public function headings(): array
    {
        return [
            'Employee Name',
            'Department',
            'Project Number',
            'Description',
            'Currency',
            'Amount',
            'Expense Type',
            'Transaction Type',
            'Time'
        ];
    }

    //style the first row as bold text
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

    //create a row total balance at the end
    public function map($expense): array
    {
        $expense = DB::table('expenses')->where('user_id', auth()->user()->id)->get('total_balance');

        return [
            [
                'TOTAL BALANCE',
                $expense
            ],

        ];
    }

}
