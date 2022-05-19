<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{

    private $total_balance = 0;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->input('search');
        $expenses = Expense::query()
            ->where('employee_name', 'LIKE', '%' . $search . '%')
            ->orWhere('department', 'LIKE', '%' . $search . '%')
            ->orWhere('department', 'LIKE', '%' . $search . '%')
            ->orWhere('project_no', 'LIKE', '%' . $search . '%')
            ->orWhere('description', 'LIKE', '%' . $search . '%')
            ->orWhere('amount', 'LIKE', '%' . $search . '%')
            ->orWhere('currency', 'LIKE', '%' . $search . '%')
            ->orWhere('expense_type', 'LIKE', '%' . $search . '%')
            ->orWhere('transaction_type', 'LIKE', '%' . $search . '%')
            ->where('user_id', auth()->user()->id)
            ->get();


        if ($expenses->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'No records found',
                'status_code' => Response::HTTP_NOT_FOUND
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Records found',
                'status_code' => Response::HTTP_FOUND,
                'data' => $expenses
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // header("Access-Control-Allow-Origin: *");
        $request->validate([
            'employee_name' => 'required',
            'department' => 'required',
            'project_no' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'currency' => 'required',
            'expense_type' => 'required',
            'transaction_type' => 'required',
            'receipt_photo' => 'required|mimes:jpg,jpeg,png,gif,svg',
            'date_issued' => 'required|date'
        ]);

        //get the balance
        $previous_balance = DB::table('expenses')->latest()->first()->total_balance;

        if ($request->transaction_type == "Money In") {
            $this->total_balance = $previous_balance + $request->amount;
        } else {
            $this->total_balance = $previous_balance - $request->amount;
        }


        // image upload
        $file_name = time() . '_' . $request->receipt_photo->getClientOriginalName();
        $file_path = $request->file('receipt_photo')->storePubliclyAs('images', $file_name, 'public');

        $expense = Expense::create([
            'user_id' => auth()->user()->id,
            'employee_name' => auth()->user()->name,
            'department' => $request->department,
            'project_no' => $request->project_no,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'expense_type' => $request->expense_type,
            'transaction_type' => $request->transaction_type,
            'total_balance' => $this->total_balance,
            'receipt_photo_name' => time() . '_' . $request->receipt_photo->getClientOriginalName(),
            'receipt_photo_path' => 'storage/' . $file_path,
            'date_issued' => $request->date_issued
        ]);

        // dd(["Previous balance: ", $previous_balance, 'Requested Amount: ', $request->amount, "Total Balance: ", $this->total_balance]);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'status_code' => Response::HTTP_REQUEST_TIMEOUT
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Expense successfully created!',
                'status_code' => Response::HTTP_CREATED,
                'data' => $expense
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::where('user_id', auth()->user()->id)->find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'No record found',
                'status_code' => Response::HTTP_NOT_FOUND
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Record found!',
                'status_code' => Response::HTTP_FOUND,
                'data' => $expense
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense  = Expense::where('user_id', auth()->user()->id)->find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'No record found',
                'status_code' => Response::HTTP_NOT_FOUND
            ]);
        } else {
            if (!($expense->update($request->all()))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong try again',
                    'status_code' => Response::HTTP_REQUEST_TIMEOUT,

                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Expense updated successfully!!',
                    'status_code' => Response::HTTP_OK,
                    'data' => $expense
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::where('user_id', auth()->user()->id)->find($id);

        if (!$expense) {
            return response()->json([
                'success' => false,
                'message' => 'No record found',
                'status_code' => Response::HTTP_NOT_FOUND
            ]);
        } else {
            if (!($expense->delete())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong try again',
                    'status_code' => Response::HTTP_REQUEST_TIMEOUT,
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Expense deleted successfully',
                    'status_code' => Response::HTTP_OK,
                ]);
            }
        }

        // dd($expense);
    }

    public function getLatestBalance()
    {
        $total_balance = DB::table('expenses')->latest()->first()->total_balance;
        $currency = DB::table('expenses')->latest()->first()->currency;
        
        return response()->json([
            'success' => true,
            'data' => $total_balance
        ]);

        // dd($total_balance);
    }

    public function create(){
        dd('This is my create method!!');
    }
}
