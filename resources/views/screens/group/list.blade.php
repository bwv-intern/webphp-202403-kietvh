<x-app-layout title="Group List">
    <div class="mb-sm-5 mx-sm-5 pt-5 col-sm-8">
        @if (session('error'))
            <div class="alert alert-danger text-white p-1">
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success text-white p-1">
                <span>{{ session('success') }}</span>
            </div>
        @endif
    </div>
    <div class="col-sm-12">

        @if (count($groups) > 0)
            <div class="row d-flex my-2">
                <div class=" d-flex justify-content-end">
                    {{ $groups->links('common.pagination') }}
                </div>
            </div>
        @endif
        <div class="row mt-5">
            <div class="col">
                <table class="table table-bordered table-responsive-sm grouplist-table">
                    <thead>
                        <tr>
                            <th class="fw-normal text-center">ID</th>
                            <th class="fw-normal text-center">Group Name</th>
                            <th class="fw-normal text-center">Group Note</th>
                            <th class="fw-normal text-center">Group Leader</th>
                            <th class="fw-normal text-center">Floor Number</th>
                            <th class="fw-normal text-center">Created Date</th>
                            <th class="fw-normal text-center">Updated Date</th>
                            <th class="fw-normal text-center">Deleted Date</th>
                        </tr>
                    </thead>
                    @if (count($groups) > 0)
                        <tbody>
                            @foreach ($groups as $group)
                            
                              
                            
                                <tr>
                                    <td>{{ $group->id }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->note }}</td>
                                    <td>{{ $group->leader->name ?? '' }}</td>
                                    <td>{{ $group->group_floor_number }}</td>
                                    <td>{{ $group->created_date->format('d/m/Y') ?? ''}}</td>
                                    <td>{{ $group->updated_date->format('d/m/Y') ?? ''}}</td>
                                    <td>
                                      {{  $group->deleted_date ? $group->deleted_date->format('d/m/Y') : ''}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @elseif ($messageNotFound != '')
                        <div class="row mt-5 mx-1">
                            <div class="col-sm-12 h-25 w-100 py-3 d-flex justify-content-center align-items-center">
                                <span class="mx-1 text-gray">
                                    <h4> {{ $messageNotFound }}</h4>
                                </span>
                            </div>
                        </div>
                    @endif
                </table>
            </div>
        </div>

        <div class="col-sm-8">
                <div class="row d-block">
                    <div class="col">
                        <x-button.base type="button" label="Import" class="btn btn-secondary m-1" data-bs-toggle="modal"
                        data-bs-target="#importCSVModal"></x-button.base>
                    </div>
                </div>
        </div>
    </div>

    <div class="modal fade" id="importCSVModal" tabindex="-1" aria-labelledby="importCSVModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importCSVModalLabel">Import CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.import') }}" method="post" enctype="multipart/form-data"
                    name="formImportCSV" id="formImportCSV">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Choose your CSV File</label>
                            <input class="form-control" type="file" id="csvFile" name="csvFile">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/screens/group/groupList.js'], 'build')
    @endpush
</x-app-layout>
