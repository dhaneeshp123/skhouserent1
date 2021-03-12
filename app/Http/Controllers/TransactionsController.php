<?php


namespace App\Http\Controllers;


use App\Models\Tenant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{

    public function listing()
    {
        $transactions = DB::table('transaction')
                            ->join('tenant','transaction.tenant_id','=', 'tenant.id')
                            ->join('property','tenant.property_id','=','property.property_id')
                            ->select('transaction.*','tenant.fullName','property.property_name')->orderBy('transactionDate','desc')
                            ->get();
        return view("transaction.list", ['transactions' => $transactions]);
    }


    public function newTransaction()
    {
        $tenants = Tenant::all();
        $transactions = DB::table("transaction")
            ->select('transaction.*','tenant.fullName')
            ->join('tenant','transaction.tenant_id','=','tenant.id')
            ->orderBy("transactionDate","desc")->skip(0)->take(10)->get();
        return view("transaction.add" , ["transactions" => $transactions,'tenants' => $tenants]);
    }

    public function postTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transactionDate' => 'required',
            'tenant_id' => 'required',
            'amount' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect('transactions/add')
                        ->withErrors($validator)
                        ->withInput();
        }
        $transactionDate = $request->input('transactionDate');
        $tenantId = $request->input('tenant_id');
        $amount = $request->input('amount');
        $tran = DB::table('transaction')->select(DB::raw('UUID() as uniqueId'))->first();
        $transaction = new Transaction();
        $transaction->id = $tran->uniqueId;
        $transaction->transactionDate = $transactionDate;
        $transaction->tenant_id = $tenantId;
        $transaction->amount = $amount;
        $transaction->save();

        return redirect('transactions/add');
    }


    protected function calculateRentForTenant(Tenant $tenant, bool $displayMessage = false)
    {
        $existingBalance = $tenant->balance;
            $tenantRents = DB::select("select * from tenant_rent where tenant_id = :id order by rent_start_date asc",
                ["id" => $tenant->id]);
            foreach ($tenantRents as $tenantRent) {
                if(is_null($tenantRent->rent_end_date)) {
                    $rent_end_date = date("Y-m-d");
                } else {
                    $rent_end_date = $tenantRent->rent_end_date;
                }
              //  echo "Rent end date : $rent_end_date<br />";
                $months = DB::select("SELECT TIMESTAMPDIFF(MONTH,:startDate,:endDate) as monthsDiff",
                    ["startDate" => $tenantRent->rent_start_date, "endDate" => $rent_end_date]);

                $monthsDiff = (int)$months[0]->monthsDiff;
                if ($tenant->property_id !== '8f072814-63d7-11eb-bcaf-7c10db1cf784') {
                    $monthsDiff -= 1;
                }
                //echo "months difference between $tenantRent->rent_start_date and $rent_end_date : $monthsDiff<br />";
                $rentForTheseMonths = ($monthsDiff + 1) * $tenantRent->rent_amount;
                //echo "rent for the period $monthsDiff is : $rentForTheseMonths<br/>";
                $existingBalance += $rentForTheseMonths;
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


    public function calculate()
    {
        $tenants = Tenant::all();
        foreach ($tenants as $tenant){
            $this->calculateRentForTenant($tenant);
        }
        
        DB::table('rent_calculation')->insert(['last_time' => date('Y-m-d H:i:s')]);
        return redirect('dashboard');
    }
}
