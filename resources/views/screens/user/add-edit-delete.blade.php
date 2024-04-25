<x-app-layout title="UserAddEditDelete">
    <div class="mb-sm-5 mx-sm-5 pt-5 col-sm-8">
        @if (!isset($user) || $user == null)
            {{-- FORM INSERT --}}
            <form action="{{ route('admin.handleAdd') }}" method="post" name="formAddUser" id="formAddUser">
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
                                {{-- select2 --}}
                                <select class="form-select text-truncate border rounded-1 ">
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-6 ">
                        <x-forms.text-group label="Started Date" id="started_date" name="started_date"
                            :isRequired="true" />

                    </div>
                    <div class="col-sm-6">
                        <div class="input-group" style="">
                            <label class="input-required col-6">
                                Position
                            </label>
                            <div class="col-sm-6">
                                <select class="form-select text-truncate border rounded-1" name="positon_id">
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
                        <x-forms.text-group type="password" label="Password" id="password" name="password"
                            :isRequired="true" />

                    </div>
                    <div class="col-sm-6">
                        <x-forms.text-group type="password" label="Password Confirmation" id="repassword"
                            name="repassword" :isRequired="true" />
                    </div>
                </div>

                <div class="row ">
                    <div class="col-sm-9  d-flex justify-content-between">
                        <x-button.userlist label="Register" class="btn btn-secondary  text-truncate" type="submit"
                            style="width: 100px;" id="registerButton" name="registerButton"></x-button.userlist>

                        <x-button.userlist label="Update" class="btn btn-secondary d-none text-truncate" type="button"
                            style="width: 100px;" id="updateButton" name="updateButton"></x-button.userlist>

                        <x-button.userlist label="Delete" class="btn btn-secondary d-none  text-truncate" type="button"
                            style="width: 100px;" id="deleteButton"></x-button.userlist>

                        <x-button.userlist label="Cancel" class="btn btn-secondary  text-truncate" type="button"
                            style="width: 100px;" id="cancelButton"></x-button.userlist>
                    </div>
                </div>

            </form>
        @else
            {{-- FORM UPDATE --}}
            <form action="{{ route('admin.handleEdit', ['id' => $user->id]) }}" method="post" name="formEditUser"
                id="formEditUser">
                @csrf
                @method('put')
                <div class="row pt-2">
                    <div class="col-sm-6 ">
                        <div class="input-group" style="">
                            <label class=" col-6">
                                ID
                            </label>
                            <div class="col-sm-6">
                                {{-- select2 --}}
                                {{ $user->id }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <x-forms.text-group label="User Name" name="name" :isRequired="true" :value="$user->name" />
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-6 ">
                        <x-forms.text-group label="Email" id="email" name="email" :isRequired="true"
                            :value="$user->email" />

                    </div>
                    <div class="col-sm-6">
                        <div class="input-group" style="">
                            <label class="input-required col-6">
                                Group
                            </label>
                            <div class="col-sm-6">
                                {{-- select2 --}}
                                <select class="form-select text-truncate border rounded-1 ">
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}"@if ($user->group_id == $group->id) selected @endif>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-6 ">
                        <x-forms.text-group label="Started Date" id="started_date" name="started_date"
                            :isRequired="true" :value="$user->started_date->format('d/m/Y')" />

                    </div>
                    <div class="col-sm-6">
                        <div class="input-group" style="">
                            <label class="input-required col-6">
                                Position
                            </label>

                            @php

                                $positions = [
                                    '0' => 'General Director',
                                    '1' => 'Department Leader',
                                    '2' => 'Team Leader',
                                    '3' => 'Team Member',
                                ];
                                $selected = $user->position_id;

                            @endphp
                            <div class="col-sm-6">
                                <select class="form-select text-truncate border rounded-1" name="positon_id">
                                    @foreach ($positions as $positionValue => $positionLabel)
                                        <option value="{{ $positionValue }}"{{ $positionValue == $selected ? 'selected' : '' }}>{{ $positionLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-6 ">
                        <x-forms.text-group type="password" label="Password" id="password" name="password"
                            :isRequired="true" />

                    </div>
                    <div class="col-sm-6">
                        <x-forms.text-group type="password" label="Password Confirmation" id="repassword"
                            name="repassword" :isRequired="true" />
                    </div>
                </div>

                <div class="row ">
                    <div class="col-sm-9  d-flex justify-content-between">
                        <x-button.userlist label="Register" class="btn btn-secondary d-none text-truncate"
                            type="submit" style="width: 100px;" id="registerButton"
                            name="registerButton"></x-button.userlist>

                        <x-button.userlist label="Update" class="btn btn-secondary  text-truncate" type="button"
                            type="submit" style="width: 100px;" id="updateButton"
                            name="updateButton"></x-button.userlist>

                        <x-button.userlist label="Delete" class="btn btn-secondary  text-truncate" type="button"
                            style="width: 100px;" id="deleteButton"></x-button.userlist>

                        <x-button.userlist label="Cancel" class="btn btn-secondary  text-truncate" type="button"
                            style="width: 100px;" id="cancelButton"></x-button.userlist>
                    </div>
                </div>

            </form>

        @endif
    </div>

    @push('scripts')
        @vite([isset($user) ? 'resources/js/screens/user/userEdit.js' : 'resources/js/screens/user/userAdd.js'], 'build')
    @endpush

</x-app-layout>
