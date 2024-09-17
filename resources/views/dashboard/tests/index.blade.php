@extends('layouts.mainLayout')
@section('title', 'Test ')


@section('content')

    <!-- Main content -->

    <div class="col">
        <div class="card">
            <div class="card-header">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAdd"><i
                        class="bi bi-plus-square-dotted mx-1"></i> Create New Test</a>

            </div>



            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                    <thead style="background-color: rgba(255, 255, 0, 0.488);">
                        <tr>
                            <th>Test Name</th>
                            <th>Tumor</th>
                            <th>Details</th>
                            {{-- <th>Available Branches</th> --}}
                            <th>Status</th>

                            {{-- <th>Has Courier?</th> <!-- New column for Has Courier -->
                            <th>Courier Name</th> <!-- New column for Courier Name --> --}}
                            <th>Test Questions</th>

                            <th>Created at</th>

                            <th>Actions</th>

                            {{-- <th>Edit</th>
                            <th>Delete</th> --}}
                        </tr>
                    </thead>
                    <tbody>



                        @forelse ($tests as $test)
                            <tr>
                                <td>{{ $test->name }}</td>
                                <td>{{ $test->tumor_name }}</td>
                                <td>{{ $test->details }}</td>

                                {{-- <td>
                                     <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalShowInfo{{$test->id}}"><i class="bi bi-info-circle"></i></a>
                                </td> --}}

                                <td class="font-bold text-{{ $test->status == 'valid' ? 'success' : 'danger' }}"">
                                    {{ $test->status }}</td>


                                {{-- <td>
                                    <span class="p-2 badge-{{ $test->has_courier ? 'success' : 'danger' }}">
                                        {{ $test->has_courier ? 'Yes' : 'No' }}
                                    </span>

                                </td> <!-- Display Yes/No for Has Courier -->
                                <td>{{ $test->courier->name ?? '' }}</td>
                                <!-- Display courier name or N/A if no courier assigned--}}

                                <td>

                                    <!-- Button to trigger modal for questions -->
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#questionsModal{{ $test->id }}">
                                        View Questions
                                    </button>

                                    <!-- Modal to display questions -->
                                    <div class="modal fade" id="questionsModal{{ $test->id }}" tabindex="-1"
                                        aria-labelledby="questionsModalLabel{{ $test->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="questionsModalLabel{{ $test->id }}">
                                                        Test Questions for <span class="text-danger">{{ $test->name }}</span></h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Loop through the test questions and display them -->
                                                    @php
                                                    $questions = json_decode($test->questions, true); // Manually decode JSON if not using relationships
                                                    //dd($questions);
                                                @endphp
                                        
                                                @if ($questions && count($questions) > 0)
                                                    @foreach ($questions as $question)
                                                        <div class="mb-3" style="text-align: left;">
                                                            <strong >Question:</strong><span style="border: 1px solid rgba(9, 11, 4, 0.94);color:blue;padding:5px;">{{ $question['text'] }}</span> 
                                                            <ul style="list-style: none">
                                                                @foreach ($question['options'] as $option)
                                                                    <li>{{ $option }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                @else
                                                    <p>No questions available for this test.</p>
                                                @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>

                                <td>{{ date('d/m/Y H:i A', strtotime($test->created_at)) }}</td>

                                <td>
                                    <div class="d-flex">
                                        <div style="margin-right: 5px;">
                                            <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                data-target="#ModalEdit{{ $test->id }}"><i
                                                    class="bi bi-pencil-square "></i>
                                                Edit</a>
                                        </div>
                                        <div>
                                            <form id="myform" action="{{ route('dashboard.tests.destroy', $test->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button form="myform" type="submit"
                                                    class="btn btn-outline-danger btn-sm show_confirm">
                                                    <i class="bi bi-trash"></i> Delete</button>

                                            </form>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                            @include('dashboard.tests.modalEdit', $test)
                            {{-- @include('dashboard.tests.modalShowInfo', $test) --}}


                        @empty
                        @endforelse

                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            {{-- <th></th> --}}
                            {{-- <th></th>
                            <th></th> --}}

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

    {{-- ============================== Modal Add============================ --}}

    <!-- Modal -->
    <div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="exampleModalLabe3" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabe3">Add Test</h5>
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


                <form class="form-horizontal" action="{{ route('dashboard.tests.store') }}" method="post">
                    @csrf




                    <div class="modal-body">
                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Test Name</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="name" placeholder="enter test name">
                            </div>
                        </div>


                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Tumor</label>
                            </div>
                            <div class="col-9">
                                <select name="tumor_id" class="form-control">

                                    @foreach ($tumors as $tumor)
                                        <option value="{{ $tumor->id }}">{{ $tumor->name }}</option>
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
                                    <option value="valid">valid</option>
                                    <option value="invalid">invalid</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Points</label>
                            </div>
                            <div class="col-9">
                                <input type="number" min="0" class="form-control" name="points">
                            </div>
                        </div> --}}

                        <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                            <div class="col-3">
                                <label for="">Test Details</label>
                            </div>
                            <div class="col-9">
                                <textarea class="form-control" name="details" cols="30" rows="5" placeholder="Details..."></textarea>

                            </div>
                        </div>

                       

                        <span>Medical Data</span><hr>

                        {{-- Questions Section --}}

                        {{-- Dynamic Questions --}}

                        {{-- Dynamic Questions --}}
                        <div id="questions-container">
                            <div class="question-item">
                                <label>Test Questions:</label>
                                <input type="text" name="questions[0][text]" required class="form-control"
                                    placeholder="Write Question...!" style="margin-bottom: 5px;">
                                <div class="choices-container">
                                    <div class="choice-item">
                                        <input type="text" name="questions[0][options][]" required
                                            class="form-control" placeholder="Write Choice...!"
                                            style="margin-bottom: 5px;">
                                        <button type="button" class="remove-choice btn-sm btn-danger"
                                            style="margin-bottom: 5px;">Remove Choice</button>
                                    </div>
                                </div>
                                <button type="button" class="add-choice  btn-sm btn-primary"
                                    style="margin-bottom: 5px;">Add Choice</button>
                            </div>
                        </div>

                        <button type="button" id="add-question" class="btn-sm btn-success">Add Another Question</button>
                    </div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ============================== Modal Add============================ --}}

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var questionIndex = 0;
            // Add a new question
            $('#add-question').click(function() {
                questionIndex++;

                $('#questions-container').append(`
         <div class="question-item">
                            <label>Question:</label>
                            <input type="text" name="questions[${questionIndex}][text]" required class="form-control" placeholder="Write Question...!" style="margin-bottom: 5px;">
                            <div class="choices-container">
                                <div class="choice-item">
                                    <input type="text" name="questions[${questionIndex}][options][]" required class="form-control" placeholder="Write Choice...!" style="margin-bottom: 5px;">
                                    <button type="button" class="remove-choice btn-sm btn-danger" style="margin-bottom: 5px;">Remove Choice</button>
                                </div>
                            </div>
                            <button type="button" class="add-choice btn-sm btn-primary" style="margin-bottom: 5px;">Add Choice</button>
                        </div>
    `);
            });
            // Add a new choice
            $(document).on('click', '.add-choice', function() {
                var $questionItem = $(this).closest('.question-item');
                var index = $questionItem.index();
                var $choicesContainer = $questionItem.find('.choices-container');
                var choiceIndex = $choicesContainer.children().length;

                $choicesContainer.append(`
     <div class="choice-item">
                                    <input type="text" name="questions[${index}][options][]" required class="form-control" placeholder="Write Choice...!" style="margin-bottom: 5px;">
                                    <button type="button" class="remove-choice btn-sm btn-danger" style="margin-bottom: 5px;">Remove Choice</button>
                                </div>
    `);

            });
            // Remove a choice
            $(document).on('click', '.remove-choice', function() {
                $(this).closest('.choice-item').remove();
            });
        });
    </script>

    <script type="text/javascript">
        @if (count($errors) > 0)
            $('#ModalAdd').modal('show');
        @endif
    </script>
@endpush
