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
    <div class="mx-sm-5 col-sm-10">

        @if (count($groups) > 0)
            <div class="row d-flex my-2 mx-1">
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
                            <th class="fw-normal text-center">Created Date</th>
                            <th class="fw-normal text-center">Updated Date</th>
                            <th class="fw-normal text-center">Deleted Date</th>
                        </tr>
                    </thead>
                    @if (count($groups) > 0)
                        <tbody>
                            @foreach ($groups as $groups)
                               
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



    </div>

</x-app-layout>
