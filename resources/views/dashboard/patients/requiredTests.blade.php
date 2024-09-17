    {{-- ============================== Modal Required Test============================ --}}

    <!-- Modal -->
    <div class="modal fade" id="RequiredTest{{$patient->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Patient :<span> {{$patient->full_name}}</span> |Required Tests</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <ul>
                       
                         @forelse ($labOrders as $order)
                         @if ($order->patient_id == $patient->id)
                         <li>{{ $order->test_name }}</li>
                         @endif
                           
                        @empty
                        @endforelse
                    </ul>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    {{-- ==============================  Modal Required Test============================ --}}