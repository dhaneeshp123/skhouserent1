<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\TenantRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    public function listing()
    {
        $tenants = DB::table("tenant")
                    ->select("tenant.*", "property.property_name", "property.rent_calculation_start_date")
                    ->join("property", "tenant.property_id","=","property.property_id")
                    ->get();
        $properties = DB::table('property')->get();                    
        return view('tenant.list', ["tenants" => $tenants, 'properties' => $properties]);
    }
    
    public function addTenant(Request $request)
    {

       $validator = Validator::make($request->all(), [
            'fullName' => 'required:min-length',
            'property_id' => 'required',
            'balance' => 'required',
            'rent' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('dashboard')
                        ->withErrors($validator)
                        ->withInput();
        }
        $fullName = $request->input('fullName');
        $propertyId = $request->input('property_id','');
        $rent = $request->input('rent');
        $roomNumber = $request->input('roomNumber','');
        $balance = $request->input('balance');
        
        $tenantUUID = DB::table('tenant')->select(DB::raw('UUID() as id'))->first();
        $tenant = new Tenant();
        $tenant->id = $tenantUUID->id;
        $tenant->fullName = $fullName;
        $tenant->balance = $balance;
        $tenant->property_id = $propertyId !== ''? $propertyId : null;
        $tenant->roomNumber = $roomNumber !== '' ? $roomNumber :null;
        $tenant->save();
        
        $property = DB::table('property')->where('property_id','=',$propertyId)->first();
        $rent_calculation_start_date = $property->rent_calculation_start_date;
        
        $tenantRentUUID = DB::table('tenant_rent')->select(DB::raw('UUID() as id'))->first();
        $tenantRent = new TenantRent();
        $tenantRent->id = $tenantRentUUID->id;
        $tenantRent->rent_start_date = $rent_calculation_start_date;
        $tenantRent->rent_amount = $rent;
        $tenantRent->tenant_id = $tenant->id;
        $tenantRent->save();
        
       return redirect('dashboard'); 
    }
    
    public function getTenantInfo(string $tenantId)
    {
        $tenant = Tenant::where('id',$tenantId)->first();
        echo $tenant->fullName;
    }
    
}
