
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add new Transaction
        </h2>
    </x-slot>
    <script type="text/javascript" src="<?= asset('js/jQuery/jquery-3.5.1.slim.min.js') ?>"></script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
