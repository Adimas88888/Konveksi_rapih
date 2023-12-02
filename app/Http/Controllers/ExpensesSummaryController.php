<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpensesSummaryController extends Controller
{
    public function expensesSummary()
    {
      
        return view('admin.page.expenses-summary', [
            'name' => "Expenses-Summary",
            'title' => 'Admin Expenses-Summary',
    
        ]);
    }
}
