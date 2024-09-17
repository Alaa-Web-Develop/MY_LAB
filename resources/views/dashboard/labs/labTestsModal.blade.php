  {{-- <!-- Modal -->
  <div class="modal fade" id="labTestsModal{{ $lab->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel45" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel45">Tests for {{ $lab->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <table>
                    <thead>
                        <tr>
                            <th>Test Name</th>
                            <th>Price</th>
                            <th>Points</th>
                            <th>Discount Points</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lab->tests as $test)
                        <tr>
                            <td>{{ $test->name }}</td>
                            <td>{{ $test->pivot->price }}</td>
                            <td>{{ $test->pivot->points }}</td>
                            <td>{{ $test->pivot->discount_points }}</td>
                            <td>{{ $test->pivot->notes }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> --}}

                {{-- <div id="testsAccordion">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                          <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Test 1
                          </button>
                        </h5>
                      </div>
                  
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#testsAccordion">
                        <div class="card-body">
                          <p><strong>Test Name:</strong> Blood Test</p>
                          <p><strong>Price:</strong> $100</p>
                          <p><strong>Points:</strong> 10</p>
                          <!-- More details -->
                        </div>
                      </div>
                    </div>
                    <!-- Repeat for other tests -->
                  </div> --}}

            {{-- </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}


{{-- 

Notice loop with pivot=======================

@foreach($lab->tests as $test)
<tr>
    <td>{{ $test->name }}</td>
    <td>{{ $test->pivot->price }}</td> 

Notice loop with pivot=======================
    
    --}}