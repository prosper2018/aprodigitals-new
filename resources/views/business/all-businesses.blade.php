    <div class="card">
        <div class="card-header">
            <h1 class="text-bold">All Registered Businesses</h1>
            <div class="float-end"><button wire:click="create()" class="btn btn-info">Add Business</button></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="p-4 col-md-1">

                    <select class="form-control p-2" wire:model='pagelength'>
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <!-- <option value="all">All</option> -->
                    </select>
                </div>
                <div class="p-4 col-md-7"></div>
                <div class="p-4 col-md-4 float-end">
                    <input type="text" class="form-control" placeholder="Search" wire:model="search" />
                </div>
            </div>

            <table id="all-businesses" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Logo</th>
                        <th>Address</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if($businesses->count() > 0)
                    @foreach($businesses as $business)
                    <tr>
                        <td>{{ $business->business_name }}</td>
                        <td><img src="{{ asset($business->logo) }}" width="50px" height="50px"></td>
                        <td>{{ $business->address }}</td>
                        <td>{{ $business->created_at }}</td>
                        <td><button wire:click="edit({{ $business->id }})" class="btn btn-info">View</button>
                            <button wire:click="edit({{ $business->id }})" class="btn btn-warning">Edit</button>
                            <button wire:click="alertConfirm({{ $business->id }})" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="text-center">No matching result was found!</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>

                </tfoot>
            </table>
            <div class="float-end">{{ $businesses->links() }}</div>
        </div>

    </div>