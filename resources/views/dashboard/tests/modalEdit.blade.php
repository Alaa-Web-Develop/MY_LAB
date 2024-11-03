{{-- ============================== Modal Edit============================ --}}

<div class="modal fade" id="ModalEdit{{$test->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Test : {{ $test->name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Errors======================== --}}
            @if ($errors->any())
                <div class="text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- Errors======================== --}}


            <form class="form-horizontal" action="{{ route('dashboard.tests.update', $test->id) }}" method="post">
                @csrf
                @method('put')



                <div class="modal-body">
                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">Test Name</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="name" value="{{ $test->name }}">
                        </div>
                    </div>

                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">Diagnose</label>
                        </div>
                        <div class="col-9">
                            <select name="diagnose_id" class="form-control">
                                <option>choose...</option>
                                @foreach ($diagnoses as $diagnose)
                                    <option value="{{ $diagnose->id }}" @selected($test->diagnose_id == $diagnose->id)>{{ $diagnose->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

             


                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">Status</label>
                        </div>
                        <div class="col-9">
                            <select name="status" class="form-control">
                                <option value="valid" @selected($test->status == 'valid')>valid
                                </option>
                                <option value="invalid" @selected($test->status == 'invalid')>invalid
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">Points</label>
                        </div>
                        <div class="col-9">
                            <input type="number" class="form-control" min="0" value="{{ $test->points}}" name="points" placeholder="enter doctor point">
                        </div>
                    </div> --}}


                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">Test Details</label>
                        </div>
                        <div class="col-9">
                            <textarea class="form-control" name="details" cols="30" rows="5" placeholder="Details...">{{ $test->details }}</textarea>

                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================== Modal Edit============================ --}}
