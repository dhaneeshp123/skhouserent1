<?php


namespace App\Http\Controllers;


use App\Models\Tenant;

class DashboardController extends Controller
{

    public function listing()
    {
        return view('tenant.list', ["tenants" => Tenant::all()]);
    }
}
