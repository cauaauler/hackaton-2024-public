<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller
{
    public function create()
    {
        return view('serviceOrderCreate');
    }
    public function store(Request $request)
    {
       // Criar e salvar a ordem de serviço no banco de dados
       $serviceOrder = new ServiceOrder();
       $serviceOrder->causer_id = Auth::id();
       $serviceOrder->description = $request->input('descricao');
       $serviceOrder->latitude = $request->input('latitude') !== null ? $request->input('latitude') : -29.455988423201006;
       $serviceOrder->longitude = $request->input('longitude') !== null ?  $request->input('longitude') : -51.29417896270753;
       //$serviceOrder->image_src = $imagemPath;
       $serviceOrder->has_carcaca_animais = $request->input('has_carcaca_animais');
       $serviceOrder->has_agua_parada = $request->input('has_agua_parada');
       $serviceOrder->has_lixo_organico = $request->input('has_lixo_organico');
       $serviceOrder->has_produtos_quimicos = $request->input('has_produtos_quimicos');
       $serviceOrder->has_vidros = $request->input('has_vidros');
       $serviceOrder->has_materias_reciclaveis = $request->input('has_materias_reciclaveis');
       $serviceOrder->has_residuos_construcao = $request->input('has_residuos_construcao');
       $serviceOrder->score = $this->calcScore($request);
       $serviceOrder->checked = false; //////// Se usuário atual for comum falso. Se for da defesa civil, true
       $serviceOrder->collected_causer_id = null;
       $serviceOrder->save();

        return redirect()->route('dashboard')->with('message', 'Ordem de coleta criada com sucesso!');
    }
    public function calcScore(Request $request): int
    {
        $score = 0;

        $request->input('has_carcaca_animais') == '1' ? $score += 7 : null;
        $request->input('has_agua_parada') == '1' ? $score += 6 : null;
        $request->input('has_lixo_organico') == '1' ? $score += 5 : null;
        $request->input('has_produtos_quimicos') == '1' ? $score += 4 : null;
        $request->input('has_vidros') == '1' ? $score += 3 : null;
        $request->input('has_materias_reciclaveis') == '1' ? $score += 2 : null;
        $request->input('has_residuos_construcao') == '1' ? $score += 1 : null;
        return $score;
    }
    public function verificar($id)
    {
        $serviceOrder = ServiceOrder::find($id);
        $serviceOrder->checked = true;
        $serviceOrder->save();

        return redirect()->back()->with('message', 'Ordem verificada com sucesso!');
    }
    public function coletar($id)
    {
        $serviceOrder = ServiceOrder::find($id);
        $serviceOrder->collected = true;
        $serviceOrder->collected_causer_id = Auth::user()->id;
        $serviceOrder->save();

        return redirect()->back()->with('message', 'Ordem coletada com sucesso!');
    }
}
