<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<script type="text/javascript">
    function calculate() {
        alert("calculate ");
    }
</script>
    <div class=" max-w-full py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Tenants
                    <div style="width: 100%; text-align: right">
                        <a href="#" onclick="calculate()">
                            <input type="button" value="calculate" style="width: 120px; cursor: pointer" />
                        </a>
                        <br /><br />
                    </div>
                        <table width="100%" border="1" style="border: 1px solid" cellspacing="10">
                        <thead>
                            <tr>
                                <th style="text-align: left">Name</th>
                                <th style="text-align: left">Room Number</th>
                                <th style="text-align: left">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tenants as $tenant)
                                <tr>
                                    <td style="text-align: left">{{$tenant->fullName}}</td>
                                    <td style="text-align: left">{{$tenant->roomNumber}}</td>
                                    <td style="text-align: left">{{$tenant->current_balance}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
