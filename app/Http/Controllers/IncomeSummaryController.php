<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncomeSummaryController extends Controller
{
    public function incomesummary()
    {
    
        return view('admin.page.income-summary', [
            'name' => "Income-Summary",
            'title' => 'Admin Income-Summary',
        ]);
    }
}
