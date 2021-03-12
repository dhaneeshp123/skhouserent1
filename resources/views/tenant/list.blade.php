<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<script type="text/javascript">
    function calculate() {
        alert("calculate ");
        window.location='{{route('calculateTransaction')}}';
        return false;
    }
</script>
<link href="<?= asset('css/form.css')  ?>" rel="stylesheet">
    <div class=" max-w-full py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Tenants
                    <div style="width: 100%; text-align: right">
                        <a href="#" onclick="return calculate()">
                            <input type="button" value="Calculate" style="width: 120px; cursor: pointer; width:120px; height:30px;background-color:grey; color:white" onclick=""/>
                        </a>
                        <a href="{{route('transactions')}}" >
                            <input type="button" value="Transactions" style='float:left;width:130px;height:30px; background-color:grey; color:white'>
                        </a>
                        <br /><br />
                        <!--
                        <form method="POST" action="<?= route('addTenant') ?>">
                            @csrf
                            <table style="float:left;width:100%" cellpadding="10">
                                <tr>
                                    <td>
                                        <select name="property_id" id="propery_id">
                                            <option value="">Select Property</option>
                                            @foreach($properties as $property)
                                                <option value="{{$property->property_id}}">{{$property->property_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="roomNumber" id="roomNumber" placeholder="Room Number" style="float:left;width:130px">
                                    </td>
                                    <td>
                                        <input type="text" name="fullName" id="fullName" placeholder="Full Name">
                                    </td>
                                    <td>
                                        <input type="text" name="rent" id="rent" placeholder="Rent Amount" style="float:left;width:130px">
                                    </td>
                                    <td>
                                        <input type="text" name="balance" id="balance" placeholder="Balance" style="float:left;width:130px">
                                    </td>

                                    <td>
                                        <input type="submit"  value="Add Tenant" style="float:left;width:130px; height:30px">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align:left; color:red">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </form> -->
                        <br /><br />
                    </div>
                        <table width="100%" border="1" style="border: 1px solid" cellspacing="10" id="tenantList">
                        <thead>
                            <tr>
                                <th style="text-align: left" class="one">Property</th>
                                <th style="text-align: left" class="one">Room Number</th>
                                <th style="text-align: left">Name</th>
                                <th style="text-align: left" class="one">Balance Date</th>
                                <th style="text-align: right">Balance</th>
                                <th style="text-align: right">Balance to be paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tenants as $tenant)
                                <tr style='border:1px solid'>
                                    <td style="text-align: left"  class="one">{{$tenant->property_name}}</td>
                                    <td style="text-align: left"  class="one">{{$tenant->roomNumber}}</td>
                                    <td style="text-align: left">{{$tenant->fullName}}</td>
                                    <td style="text-align: left" class="one">{{date('d-m-Y',strtotime($tenant->rent_calculation_start_date))}}</td>
                                    <td style="text-align: right">{{$tenant->balance}}</td>
                                    <td style="text-align: right">{{$tenant->current_balance}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript'>
    $(document).ready(function() {
        $('#tenantList').DataTable();
    });
    </script>
</x-app-layout>
