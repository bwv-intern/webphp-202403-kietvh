<x-app-layout title="User List">
    <div class="mb-sm-5 mx-sm-5 pt-5 col-sm-8">
        <form action="{{ route('admin.handleAdd') }}" method="post" name="" id="">
            <div class="row pt-2">
                <div class="col-sm-6 ">
                    <div class="input-group" style="">
                        <label class=" col-6">
                            ID
                        </label>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <x-forms.text-group label="User Name" name="name" :isRequired="true" />
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="Email" id="email" name="email" :isRequired="true" />

                </div>
                <div class="col-sm-6">
                    <div class="input-group" style="">
                        <label class="input-required col-6">
                            Group
                        </label>
                        <div class="col-sm-6">
                            <select class="form-select text-truncate border rounded-1" >
                                <option value="-1"></option>
                                @foreach ($groups as $group )
                                <option value="{{$group->id}}">{{$group->name}}</option>
                                @endforeach
                                </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="Started Date" id="started_date" name="started_date" :isRequired="true" />

                </div>
                <div class="col-sm-6">
                    <div class="input-group" style="">
                        <label class="input-required col-6">
                            Position
                        </label>
                        <div class="col-sm-6">
                            <select class="form-select text-truncate border rounded-1" name="positon_id" >
                                <option value="-1"></option>
                                <option value="0">General Director</option>
                                <option value="1">Department Leader</option>
                                <option value="2">Team Leader</option>
                                <option value="3">Team Member</option>
                                </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="Password" id="password" name="password" :isRequired="true" />

                </div>
                <div class="col-sm-6">
                    <x-forms.text-group label="Password Confirmation" id="passwordc" name="passwordc"
                        :isRequired="true" />
                </div>
            </div>

            <div class="row ">
                <div class="col-sm-9  d-flex justify-content-between">
                    <x-button.userlist label="Register" class="btn btn-secondary  text-truncate" type="button"
                        style="width: 100px;" id="registerButton" name="registerButton"></x-button.userlist>

                    <x-button.userlist label="Update" class="btn btn-secondary  text-truncate" type="button"
                        style="width: 100px;" id="updateButton" name="updateButton"></x-button.userlist>

                    <x-button.userlist label="Delete" class="btn btn-secondary  text-truncate" type="button"
                        style="width: 100px;" id="deleteButton"></x-button.userlist>

                    <x-button.userlist label="Cancel" class="btn btn-secondary  text-truncate" type="button"
                        style="width: 100px;" id="cancelButton"></x-button.userlist>
                </div>
            </div>

        </form>

    </div>

    @push('scripts')
        @vite(['resources/js/screens/user/userList.js'], 'build')
    @endpush
</x-app-layout>
