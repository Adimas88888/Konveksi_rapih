<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\Http\Request;

class IncomeSummaryController extends Controller
{
    public function incomesummary()
    {
        $allTrx = transaksi::where('status', 'unpaid')
        ->get();

        return view('admin.page.income-summary', [
            'name' => "Income-Summary",
            'title' => 'Admin Income-Summary',
            'allTrx' => $allTrx,
        ]);
    }
}
