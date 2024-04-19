<x-app-layout title="User List">
    <div class="p-sm-5 col-sm-8">
        <form action="{{ route('admin.searchUserList') }}" method="post" name="formSearch" id="formSearch">
            @csrf
            <div class="row">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="User Name" name="name" :value="$paramSession['name'] ?? old('name')" />
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="Started Date From" id="started_date_from" name="started_date_from"
                        :value="$paramSession['started_date_from'] ?? old('started_date_from')" />
                       
                </div>
                <div class="col-sm-6">
                    <x-forms.text-group label="Started Date To" id="started_date_to" name="started_date_to"
                        :value="$paramSession['started_date_to'] ?? old('started_date_to')" />
                </div>
            </div>
            <div class="row d-flex justify-content-end">
                <div class="col-md-6 gap-5">
                    <x-button.userlist label="Clear" class="btn btn-secondary m-1 text-truncate" type="button"
                        style="width: 150px;" id="btnClear" name="btnClear"></x-button.userlist>
                    <x-button.userlist label="Search" class="btn btn-secondary m-1 text-truncate"
                        style="width: 150px;" id="btnSearch" name="btnSearch"></x-button.userlist>
                </div>
            </div>
        </form>
        @if (isset($users) && count($users) > 0)
            <div class="d-flex row justify-content-between align-item-center">
                {{ $users->links('common.pagination') }}
            </div>
            <div class="row mt-5">
                <div class="col-sm-10">
                    <table class="table table-bordered table-responsive-md">
                        <thead>
                            <tr>
                                <th class="fw-normal">User Name</th>
                                <th class="fw-normal">Email</th>
                                <th class="fw-normal">Group Name</th>
                                <th class="fw-normal">Started Date</th>
                                <th class="fw-normal">Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="" class="text-decoration-underline"> User Name </a>
                                </td>
                                <td>
                                    @if (Auth::user()->position_id == 0)
                                        <a href="" class="text-decoration-underline"> Email </a>
                                    @else
                                        Email
                                    @endif
                                </td>
                                <td>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</td>
                                <td>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</td>
                                <td>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        @endif
        
        @if (Auth::user()->position_id == 0)
            <x-button.userlist label="New" class="btn btn-secondary m-1 text-truncate" type="button"
                style="width: 150px;" id="btnNew" name="btnNew"></x-button.userlist>
            @if (isset($user) && count($user) > 0)
                <x-button.userlist label="Export CSV" class="btn btn-secondary m-1 text-truncate"
                    style="width: 150px;" id="btnExport" name="btnExport"></x-button.userlist>
            @endif
        @endif

    </div>

    @push('scripts')
        @vite(['resources/js/screens/user/userList.js'], 'build')
    @endpush
</x-app-layout>
