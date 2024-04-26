<x-app-layout title="UserAddEditDelete">
    <div class="mb-sm-5 mx-sm-5 pt-5 col-sm-8">
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
                                <select class="form-select text-truncate border rounded-1" name="position_id">
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

       
    </div>

    @push('scripts')
        @vite(['resources/js/screens/user/userEdit.js'], 'build')
    @endpush

</x-app-layout>
