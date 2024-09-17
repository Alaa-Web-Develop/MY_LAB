{{-- ============================== Modal Edit============================ --}}
<div class="modal fade" id="ModalShowBranches{{ $lab->id }}" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Lab : <span class="text-danger">{{ $lab->name }}</span>  Branches
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @forelse ($lab->branches as $branch)
                <ul>
                    <li>Branch name: {{$branch->name}}</li>
                    <li>Branch Login: {{$branch->user->name}}</li>
                    <li>Branch Phone: {{$branch->phone}}</li>
                    <li>Branch hotline: {{$branch->hotline}}</li>
                    <li>Branch email: {{$branch->email}}</li>
                    <li>Branch location: {{$branch->location}}</li>
                    <li>Branch Approval Status: <span id="status-text-{{ $branch->id }}">{{ $branch->Approval_Status }}</span></li>

                    {{-- Show the "Update Status" button only if the status is not approved --}}
                    @if($branch->Approval_Status !== 'approved')
                    <form action="{{ route('dashboard.lab_branches.updateStatus', $branch->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="Approval_Status" value="approved">
                        <button type="submit" class="btn btn-success">Approve Branch</button>
                    </form>
                    @endif

                    <hr>
                </ul>
                @empty
                    <p>No branches available.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')

<script>
    $(document).ready(function() {
        @if (session('status') === 'success')
            Swal.fire({
                icon: 'success',
                title: 'Status Updated!',
                text: 'Lab Branch status has been updated successfully.',
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endpush