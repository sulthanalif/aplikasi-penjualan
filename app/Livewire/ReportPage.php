<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Exports\ReportExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportPage extends Component
{
    public $search = '';

    public function clearSearch()
    {
        $this->search = '';
    }

    public function export()
    {
        return Excel::download(new ReportExport, 'report.xlsx');
    }

    public function render()
    {
        $datas = Order::where('payment_status', 'Paid')
            ->where('date', 'like', '%' . $this->search . '%')
            ->select('date', DB::raw('count(*) as customer_count'), DB::raw('sum(total_price) as total_payment'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->paginate(5);
        return view('livewire.report-page', compact('datas'));
    }
}

