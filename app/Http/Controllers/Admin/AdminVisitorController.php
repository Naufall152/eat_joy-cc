<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminVisitorController extends Controller
{
    public function index()
    {
        // 14 hari terakhir (group by tanggal)
        $rows = DB::table('visitor_logs')
            ->selectRaw('visited_date as d, COUNT(*) as total')
            ->where('visited_date', '>=', now()->subDays(14)->toDateString())
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        $labels = $rows->pluck('d');
        $values = $rows->pluck('total');

        return view('admin.visitors.index', compact('labels', 'values'));
    }
}
