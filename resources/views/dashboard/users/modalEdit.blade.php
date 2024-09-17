{{-- ============================== Modal Edit============================ --}}

<div class="modal fade" id="UserEdit{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabeledituser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabeledituser">Edit User : {{ $user->name }}
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


            <form class="form-horizontal" action="{{ route('dashboard.users.update', $user->id) }}" method="post">
                @csrf
                @method('put')



                <div class="modal-body">
                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">User Name</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" value="{{$user->name}}" name="name" placeholder="enter user name">
                        </div>
                    </div>

                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">User Email</label>
                        </div>
                        <div class="col-9">
                            <input type="email" class="form-control" value="{{$user->email}}" name="email" placeholder="enter user email">
                        </div>
                    </div>

                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">User Password</label>
                        </div>
                        <div class="col-9">
                            <input type="text" class="form-control" name="password">
                        </div>
                    </div>



                    <div class="form-row" style="align-items: baseline;margin-bottom:10px">
                        <div class="col-3">
                            <label for="">User Role</label>
                        </div>
                        <div class="col-9">
                            <select name="type" class="form-control">
                                <option value="admin" @selected($user->type == 'admin')>admin</option>
                                {{-- <option value="lab" @selected($user->type == 'lab')>lab</option> --}}
                            </select>
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
