<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOrder;
use App\Models\User;
class RankingController extends Controller
{
    public function index()
    {
        $so = ServiceOrder::whereNotNull('collected_causer_id')->with('collectedCauser')->get()->groupBy('collected_causer_id');
        return view('ranking', compact('so'));
    }
}
