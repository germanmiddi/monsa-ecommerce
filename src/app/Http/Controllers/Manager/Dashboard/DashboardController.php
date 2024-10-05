<?php

namespace App\Http\Controllers\Manager\Dashboard;

// use App\Models\Persona;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Manager\Entidad;
use App\Models\Manager\Tramite;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Client;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $current_month = Carbon::now()->month;
        $current_year = Carbon::now()->year;

        $clients = Client::whereMonth('created_at', $current_month)
                        ->whereYear('created_at', $current_year)
                        ->count();

        $orders = Order::whereMonth('created_at', $current_month)
            ->whereYear('created_at', $current_year)
            ->get();

        $pending_orders = $orders->where('status', 1)->count();
        $processing_orders = $orders->where('status', 3)->count();
        $delivered_orders = $orders->where('status', 4)->count();

        $total_orders = $orders->count();
        $total_sales = $orders->sum('total');

        return Inertia::render('Manager/Dashboard/Index', [
                            'pending_orders' => $pending_orders,
                            'processing_orders' => $processing_orders,
                            'delivered_orders' => $delivered_orders,
                            'total_orders' => $total_orders,
                            'total_sales' => $total_sales,
                            'clients' => $clients,
                        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function getstatistics(){

    //     $tramites = Tramite::select('dependencia_id', DB::raw('COUNT(*) as count'))
    //         ->groupBy('dependencia_id')
    //         ->get();
    //     $entidades = Entidad::count();
    //     $data['tramites'] = $tramites;
    //     $data['entidades'] = $entidades;
    //     return ($data);
    // }


}

