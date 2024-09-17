{{--   
                              {{-- Modal show================================= --}}
<!-- Modal -->
@if ($doctor['pointsTransactions']->count() > 0)

    <div class="modal fade" id="ShowTrans{{ $doctor['id'] }}" tabindex="-1" role="dialog"
        aria-labelledby="doctorTransactionsModalLabel{{ $doctor['id'] }}" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctorTransactionsModalLabel{{ $doctor['id'] }}">Transactions for
                        <span class="text-danger">{{ $doctor['name'] }}</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="text-center" style="display: flex;list-style:none;justify-content:space-between;background-color:beige;padding:5px">
                        <li>Type</li>
                        <li>Points</li>
                        <li>Money</li>
                        <li>Date</li>
                    </ul>
                    <hr>
                    {{-- <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Points</th>
                                  
                                    <th>Money</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody> --}}
                    @foreach ($doctor['pointsTransactions'] as $transaction)
                        {{-- <tr>
                            <td>{{ ucfirst($transaction->type) }}</td>
                            <td>{{ $transaction->points }}</td>
                            <td>{{ $transaction->money }}</td>
                            <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                        </tr> --}}
                        <ul class="text-center"  style="display: flex;list-style:none;justify-content:space-between">
                            <li style="text-left">{{ ucfirst($transaction->type) }}</li>
                            <li style="text-left">{{ $transaction->points }}</li>
                            <li style="text-left">{{ $transaction->money }}</li>
                            <li style="text-left">{{ $transaction->created_at->format('Y-m-d') }}</li>
                        </ul>
                    <hr>

                    @endforeach
                    {{-- </tbody>
                    </table> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
{{-- End Modal show=================================  --}}
