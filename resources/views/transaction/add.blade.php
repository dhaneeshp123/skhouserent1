
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add new Transaction
        </h2>
    </x-slot>
    <script type="text/javascript" src="<?= asset('js/jQuery/jquery-3.5.1.slim.min.js') ?>"></script>
    <link href="<?= asset('css/datepicker.min.css')  ?>" rel="stylesheet">
    <link href="<?= asset('css/form.css')  ?>" rel="stylesheet">
    <script type="text/javascript" src="<?= asset('js/datepicker.min.js') ?>"></script>
    <script type="text/javascript">
        $(function(){
            $('[data-toggle="datepicker"]').datepicker({
                format:'yyyy-mm-dd'
            });    
        });
        
        function validateForm(thisForm)
        {
            let transactionDate = $('#transactionDate').val();
            let tenantId = $('#tenant_id').val();
            let amount = $('#amount').val();
            $('#addBtn').hide();
            let formError = false;
            $('.error').each(function(index){
               $(this).hide(); 
            });
            if(transactionDate === "") {
                formError = true;
                $('#transactionDate_Error').show();
            } else if(isNaN(amount) || amount === '') {
                formError = true;
                $('#amount_Error').show();
            } else if(tenantId === '') {
                formError = true;
                $('#tenant_id_Error').show();
            }
            
            if(formError) {
                $('#addBtn').show();
            } else {
                $('#addTransactionForm').submit();
            }
            console.log('transactionDate:' + transactionDate + ', tenant_id: ' + tenantId + ' , amount: ' + amount);
        }
    </script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="<?= route('storeTransaction',[]) ?>" method='POST' id='addTransactionForm' name='addTransactionForm'>
                        @csrf
                    <table cellpadding=10>
                        <tr class="max-size">
                            <td class="max-size">
                                <input type="text" data-toggle="datepicker" readonly="readonly" placeholder="Date" name="transactionDate" id="transactionDate">
                                <br />
                                
                            </td>
                            <td class="max-size">
                                <select name="tenant_id" id="tenant_id">
                                    <option value="">Select Tenant</option>
                                    <?php foreach($tenants as $tenant) : ?>
                                        <option value="<?= $tenant->id ?>"><?= $tenant->fullName ?></option>
                                    <?php endforeach; ?>
                                </select> 
                                <br />
                                
                            </td>
                            <td class="max-size">
                                <input type="text" name="amount" id="amount" placeholder="amount">
                                <br />
                                
                            </td>
                            <td class="max-size">
                                <input type="button" value="Add" style="width:150px;height:40px; background-color:grey; color: white " onclick='return validateForm(this)' id="addBtn">
                                
                            </td>
                        </tr>
                        <tr  class="max-size">
                            <td>
                                    <span id="transactionDate_Error" style="display:none" class="error">Choose date</span>
                                
                            </td>
                            <td>
                                <span id="tenant_id_Error" style="display:none" class="error">Select Tenant</span>
                            </td>
                            <td>
                               <span id="amount_Error" style="display:none" class="error">Enter amount</span> 
                            </td>
                            <td>&nbsp;
                            
                            </td>
                        </tr>
                    </table>
                    </form>
                    <br /><br />
                    <div style="width: 100%; text-align: left">
                            last 10 Transactions
                        <br /><br />
                        <table style="width: 100%; border: 1px solid">
                            <thead>
                            <tr>
                                <th style="text-align: left">Date</th>
                                <th style="text-align: left">Tenant</th>
                                <th style="text-align: left">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($transactions as $transaction) : ?>
                                <tr>
                                    <td><?= $transaction->transactionDate ?></td>
                                    <td>{{$transaction->fullName}}</td>
                                    <td><?= $transaction->amount ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
