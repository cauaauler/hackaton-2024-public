<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Buscar todas as ordens de serviço
        $serviceOrders = ServiceOrder::where('collected', 0)->orderBy('score', 'asc')->get();
        $hasOrderPending = ServiceOrder::where('collected', 0)->count();
        // Passar as ordens de serviço para a view
        return view('dashboard',[
            'serviceOrders' => $serviceOrders,
            'hasOrderPending' => $hasOrderPending,
        ]);
    }
}
