<x-login-layout title="Login">
    <div class="row m-5 px-sm-5">
        <div class="col-sm-3">
            @if ($errors->any())
                <x-alert :messages="$errors->all()" type="danger" />
            @endif
            <form method="post" action="{{ route('auth.handleLogin') }}" id="login-form">
                @csrf
                <div class="form-group">
                    <x-forms.label for="email" label="Email" :isRequired="true" />
                    <x-forms.text name="email" label="Email" idSelector="email" placeholder="" :value="old('email')" />
                </div>
                <div class="form-group">
                    <x-forms.label for="password" label="Password" :isRequired="true" />
                    <x-forms.text type="password" name="password" label="Password" idSelector="password" placeholder=""
                        :value="old('password')" />
                </div>
                <div class="row">
                    <div class="col-12">
                        <x-button.base type="submit" label="Login" />
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/screens/auth/login.js'], 'build')
    @endpush
</x-login-layout>
