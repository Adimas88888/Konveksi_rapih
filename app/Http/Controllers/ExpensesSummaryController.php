<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\Http\Request;

class ExpensesSummaryController extends Controller
{
    public function expensesSummary()
    {
        $allTrx = transaksi::where('status', 'paid')->get();

        return view('admin.page.expenses-summary', [
            'name' => "Expenses-Summary",
            'title' => 'Admin Expenses-Summary',
            'allTrx' => $allTrx,
        ]);
    }
}
