<?php


namespace App\Http\Controllers;


use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{

    public function listing()
    {
        return view("transaction.list");
    }


    public function newTransaction()
    {
        return view("transaction.add");
    }

    public function calculate()
    {
        $tenants = Tenant::all();
        foreach ($tenants as $tenant){
            $existingBalance = $tenant->balance;
            $tenantRents = DB::select("select * from tenant_rent where tenant_id = :id order by rent_start_date asc",
                ["id" => $tenant->id]);
            foreach ($tenantRents as $tenantRent) {
                if(is_null($tenantRent->rent_end_date)) {
                    $rent_end_date = date("Y-m-d");
                } else {
                    $rent_end_date = $tenantRent->rent_end_date;
                }
                $months = DB::select("SELECT TIMESTAMPDIFF(MONTH,:startDate,:endDate) as monthsDiff",
                    ["startDate" => $tenantRent->rent_start_date, "endDate" => $rent_end_date]);

                $monthsDiff = (int)$months[0]->monthsDiff;
                $existingBalance += ($monthsDiff + 1) * $tenantRent->rent_amount;
                $transactions = DB::select('select * from transaction where tenant_id = :tenant_id
                        and transactionDate between :startDate and :endDate' ,
                    ["tenant_id" => $tenant->id, "startDate" => $tenantRent->rent_start_date, "endDate" => $rent_end_date]);
                foreach ($transactions as $transaction) {
                    $existingBalance -= $transaction->amount;
                }

            }
            DB::update("update tenant set current_balance = :balance where id = :id",
                ["id" => $tenant->id, "balance" => $existingBalance]);
        }
    }
}
