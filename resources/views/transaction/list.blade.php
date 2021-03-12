
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transactions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div style="width: 100%; text-align: right">
                        <a href="<?= route('addTransactions') ?>" style="width:180px; height:20px; border:1px; background-color:grey; color:white; padding:5px">
                            Add Transaction
                        </a>
                        <br /><br />

                        <table style="width: 100%; border: 1px solid" id='transactionTable'>
                            <thead>
                                <tr>
                                    <th style="text-align: left">Property</th>
                                    <th style="text-align: left">Date</th>
                                    <th style="text-align: left">Tenant</th>
                                    <th style="text-align: left">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($transactions as $transaction) : ?>
                                    <tr>
                                    <td style="text-align: left"><?= $transaction->property_name ?></td>
                                    <td style="text-align: left"><?= date('d-M-Y',strtotime($transaction->transactionDate)) ?></td>
                                    <td style="text-align: left"><?= $transaction->fullName ?></td>
                                    <td style="text-align: left"><?= $transaction->amount ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#transactionTable').DataTable();
    </script>
</x-app-layout>
