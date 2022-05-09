<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;

    public $table = 'expenses';

    protected $fillable = ['employee_name', 'description', 'department', 'project_no', 'amount', 'currency', 'expense_type', 'transaction_type', 'receipt_photo_name', 'receipt_photo_path', 'date_issued'];


    //relationships

}
