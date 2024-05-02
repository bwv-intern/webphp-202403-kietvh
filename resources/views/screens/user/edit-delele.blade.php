<x-app-layout title="UserAddEditDelete">
    <div class="mb-sm-5 mx-sm-5 pt-5 col-sm-8">
        {{-- @if ($errors->any())
        <x-alert :messages="$errors->all()" type="danger" />
    @endif --}}
            {{-- FORM UPDATE --}}
            <form action="{{ route('admin.handleEdit',$user->id) }}" method="POST" name="formEditUser"
                id="formEditUser">
                @method('put')
                @csrf
                <div class="row pt-2">
                    <div class="col-sm-6 ">
                        <div class="input-group" style="">
                            <label class=" col-6">
                                ID
                            </label>
                            <div class="col-sm-6">
                                {{-- select2 --}}
                                <input type="hidden" value="{{ $user->id}}" name="id" id="id">
                                {{ $user->id }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 ">
                        <x-forms.text-group label="User Name" name="name" :isRequired="true" :value="old('name') ?? $user->name" />
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-6 ">
                        <x-forms.text-group label="Email" id="email" name="email" :isRequired="true"
                            :value="old('email') ?? $user->email" />

                    </div>
                    <div class="col-sm-6">
                        <div class="input-group" style="">
                            <label class="input-required col-6">
                                Group
                            </label>
                            <div class="col-sm-6">
                                {{-- select2 --}}
                                <select class="form-select text-truncate border rounded-1 " name="group_id">
                                    @php
                                        $selected = old('group_id') ?? $user->group_id;
                                    @endphp
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}"@if ($selected == $group->id) selected @endif>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-6 ">
                        <x-forms.text-group label="Started Date" id="started_date" name="started_date"
                            :isRequired="true" :value="old('started_date') ?? $user->started_date->format('d/m/Y')" />

                    </div>
                    <div class="col-sm-6">
                        <div class="input-group" style="">
                            <label class="input-required col-6">
                                Position
                            </label>

                            @php

                                $positions = [
                                    '0' => 'Director',
                                    '1' => 'Group Leader',
                                    '2' => 'Leader',
                                    '3' => 'Member',
                                ];
                                $selected = old('position_id') ?? $user->position_id;

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
                            :value="old('password')" />

                    </div>
                    <div class="col-sm-6">
                        <x-forms.text-group type="password" label="Password Confirmation" id="repassword"
                            name="repassword" : :value="old('repassword')" />
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
                            style="width: 100px;" data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal"></x-button.userlist>
                        {{-- <a class="btn btn-secondary  text-truncate" href="/admin/user/delete/{{$user->id}}"
                            style="width: 100px;" id="deleteButton">Delete</a> --}}

                        <x-button.userlist label="Cancel" class="btn btn-secondary  text-truncate" type="button"
                            style="width: 100px;" id="cancelButton"></x-button.userlist>
                    </div>
                </div>

            </form>

       
    </div>
<!-- Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/user/delete/{{$user->id}}" method="get" 
                name="" id="">
                このユーザーを削除してもいいですか？
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
    @push('scripts')
        @vite(['resources/js/screens/user/userEdit.js'], 'build')
    @endpush

</x-app-layout>
