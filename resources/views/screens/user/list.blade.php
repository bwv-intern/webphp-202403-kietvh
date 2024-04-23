<x-app-layout title="User List">
    <div class="mb-sm-5 mx-sm-5 pt-5 col-sm-8">
        <form action="{{ route('admin.searchUserList') }}" method="post" name="formSearch" id="formSearch">
            @csrf
            <div class="row pt-2">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="User Name" name="name" :value="$searchParams['name'] ?? old('name')" />
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="Started Date From" id="started_date_from" name="started_date_from"
                        :value="$searchParams['started_date_from'] ?? old('started_date_from')" />

                </div>
                <div class="col-sm-6">
                    <x-forms.text-group label="Started Date To" id="started_date_to" name="started_date_to"
                        :value="$searchParams['started_date_to'] ?? old('started_date_to')" />
                </div>
            </div>
            <div class="row d-flex">
                <div class="col-sm-5 gap-5 mr-md-4 d-sm-none d-md-block">
                </div>
                <div class="col-sm-6 gap-5 ml-md-3 ml-sm-0">
                    <x-button.userlist label="Clear" class="btn btn-secondary m-1 text-truncate" type="button"
                        style="width: 100px;" id="btnClear" name="btnClear"></x-button.userlist>
                    <x-button.userlist label="Search" class="btn btn-secondary m-1 text-truncate" style="width: 100px;"
                        id="btnSearch"></x-button.userlist>
                </div>
            </div>

        </form>
        @if (isset($users))
            @if (count($users) > 0)
                <div class="row d-flex mt-2 justify-content-center">

                    <div class="col-sm-12 gap-5 ml-md-2 ml-sm-0">
                        {{ $users->links('common.pagination') }}
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-10">
                        <table class="table table-bordered table-responsive-sm custom-table">
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
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.edit', ['id' => $user->id]) }}"
                                                class="text-decoration-underline "> {{ $user->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if (Auth::user()->position_id == 0)
                                                <a class="text-decoration-underline ">
                                                    {{ $user->email }}
                                                </a>
                                            @else
                                                {{ $user->email }}
                                            @endif
                                        </td>
                                        <td class="">{{ $user->group->name ?? '' }}</td>
                                        <td class="">
                                            {{ $user->started_date != null ? $user->started_date->format('d/m/Y') : '' }}
                                        </td>
                                        <td class="">{{ $user->getPosition() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            @else
                <div class="row mt-5">
                    <div class="col-sm-10">
                        <span class="mx-1">
                            No User Found
                        </span>
                    </div>
                </div>
            @endif

        @endif

        @if (Auth::user()->position_id == 0)
        <div class="row d-block">
            <div class="col">
                <x-button.userlist label="New" class="btn btn-secondary m-1 text-truncate" type="button" style="width: 100px;" id="btnNew" name="btnNew"></x-button.userlist>
                @if (isset($users) && count($users) > 0)
                    <form action="{{ route('admin.userExport') }}" method="post" style="display: inline;">
                        @csrf
                        <x-button.userlist label="Export CSV" class="btn btn-secondary m-1 text-truncate" style="width: 100px;" id="btnExport" name="btnExport"></x-button.userlist>
                    </form>
                @endif
            </div>
        </div>
    @endif



    </div>

    @push('scripts')
        @vite(['resources/js/screens/user/userList.js'], 'build')
    @endpush
</x-app-layout>
