<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\Expense;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::all();

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('Creat method!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department' => 'required',
            'project_no' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'currency' => 'required',
            'expense_type' => 'required',
            'transaction_type' => 'required',
            'receipt_photo' => 'required|image|mimes:jpg,jpeg,png,gif,svg',
            'date_issued' => 'required|date'
        ]);

        $expense = Expense::create([
            'name' => $request->name,
            'department' => $request->department,
            'project_no' => $request->project_no,
            'description' => $request->description,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'expense_type' => $request->expense_type,
            'transaction_type' => $request->transaction_type,
            'receipt_photo' => $request->file('receipt_photo')->store('public/images',),
            'date_issued' => $request->date_issued
        ]);

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
        $expense = Expense::find($id);

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $expense  = Expense::find($id);

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

        // dd($expense);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);

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
}
