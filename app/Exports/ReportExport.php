<?php

namespace App\Exports;

use App\Invoice;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    public function view(): View
    {
        $datas = Order::where('payment_status', 'Paid')
            // ->where('date', 'like', '%' . $this->search . '%')
            ->select('date', DB::raw('count(*) as customer_count'), DB::raw('sum(total_price) as total_payment'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        return view('exports.report', [
            'datas' => $datas,
            'total' => $datas->sum('total_payment'),
        ]);
    }
}
