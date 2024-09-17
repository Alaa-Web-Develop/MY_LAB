@extends('layouts.mainLayout')
@section('title', 'History Transactions')

@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card p-3">

            {{-- <div>
                <a href="{{route('dashboard.points.transfer.requests')}}" class="btn btn-success">Display Doctors Transfer Request</a>
            </div> --}}
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead style="background-color: rgba(255, 255, 0, 0.375);">
                        <tr>
                           <th>Doctor Name</th>
                          
                           <th>Earned Points</th>
                           <th>Discounts Points</th>
                           <th>Transferred Points</th>

                           <th>Net Total Points</th>

                           <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>



                        @foreach ( $doctors as $doctor )
                            
                        
                            <tr>
                                <td style="font-weight: 800">{{$doctor['name']}}</td>
                                

                                <td style="font-weight: 800">{{$doctor['total_points_earned']}}</td>
                                <td style="font-weight: 800">{{$doctor['total_points_redeemed']}}</td>

                                <td style="font-weight: 800">{{$doctor['total_points_transferred']}}</td>

                                {{-- <td> $doctor['pointsTransactions']
                                    @if($doctor->pointsTransactions->count() > 0)
                                        <button class="btn btn-info" data-toggle="modal" data-target="#doctorTransactionsModal{{ $doctor->id }}">
                                            Show Transactions
                                        </button>
                                    @else
                                        <span>No Transactions</span>
                                    @endif
                                </td> --}}

                                <td style="font-weight: 800">{{$doctor['total_points']}}</td>

                                <td>
                                    @if($doctor['pointsTransactions']->count() > 0)
                                    <button class="btn btn-info" onclick="showDoctorTransactions({{ $doctor['id'] }}, '{{$doctor['name']}}')">
                                        Show Transactions
                                    </button>
                                @else
                                    <span>No Transactions</span>
                                @endif



                            </tr>

                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                          
                            <th></th>
                            <th></th>
                            <th></th>
                         
                        </tr>

                    </tfoot>

                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Modal -->

<div id="doctorTransactionsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="doctorTransactionsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:40%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doctorTransactionsModalLabel"><span id="doctorName" class="text-danger"></span> - Transactions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      <div class="modal-body">
    <table class="table table-bordered">
        <thead style="background-color:#6EC8BB;">
            <tr>
                <th>Request Date</th>
                <th>Points</th>
                <th>Money</th>
                <th>Type</th>
                <th>Transfer Date</th>
            </tr>
        </thead>
        <tbody id="transactionsContainer"></tbody>
    </table>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showDoctorTransactions(doctorId, doctorName) {
    console.log('Doctor ID:', doctorId);
    console.log('Doctor Name:', doctorName);
    
    // Clear previous transactions
    $('#transactionsContainer').empty();
    $('#doctorName').text(doctorName);

    // Fetch transactions for the selected doctor
    let transactions = @json($doctors->pluck('pointsTransactions', 'id'));

    // Check if transactions exist for the doctorId
    if (transactions[doctorId] && transactions[doctorId].length > 0) {
        transactions[doctorId].forEach(function(transaction) {
            let type = transaction.type ? transaction.type.charAt(0).toUpperCase() + transaction.type.slice(1) : 'N/A';
            let points = transaction.points ? transaction.points : '';
            let money = transaction.type === 'transferred' ? points : '';
            let requestDate = transaction.created_at ? new Date(transaction.created_at).toISOString().slice(0, 10) : '';
            let transferDate = transaction.type === 'transferred' ? requestDate : '';

            $('#transactionsContainer').append(`
                <tr>
                    <td>${requestDate}</td>
                    <td>${points}</td>
                    <td>${money}</td>
                    <td>${type}</td>
                    <td>${transferDate}</td>
                </tr>
            `);
        });
    } else {
        $('#transactionsContainer').append('<tr><td colspan="5">No transactions found</td></tr>');
    }

    // Show the modal
    $('#doctorTransactionsModal').modal('show');
}

</script>

    
@endpush