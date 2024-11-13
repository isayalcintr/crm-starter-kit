@extends('layouts.auth.main')

@section('main')
    <div class="card max-w-[370px] w-full">
        <form action="#" class="card-body flex flex-col gap-5 p-10" id="register_form" method="post">
            <div class="text-center mb-2.5">
                <h3 class="text-lg font-medium text-gray-900 leading-none mb-2.5">
                    Sign up
                </h3>
                <div class="flex items-center justify-center">
       <span class="text-2sm text-gray-700 me-1.5">
        Already have an Account ?
       </span>
                    <a class="text-2sm link" href="html/demo1/authentication/classic/sign-in.html">
                        Sign In
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2.5">
                <a class="btn btn-light btn-sm justify-center" href="#">
                    <img alt="" class="size-3.5 shrink-0" src="assets/media/brand-logos/google.svg"/>
                    Use Google
                </a>
                <a class="btn btn-light btn-sm justify-center" href="#">
                    <img alt="" class="size-3.5 shrink-0 dark:hidden" src="assets/media/brand-logos/apple-black.svg"/>
                    <img alt="" class="size-3.5 shrink-0 light:hidden" src="assets/media/brand-logos/apple-white.svg"/>
                    Use Apple
                </a>
            </div>
            <div class="flex items-center gap-2">
      <span class="border-t border-gray-200 w-full">
      </span>
                <span class="text-2xs text-gray-600 uppercase">
       or
      </span>
                <span class="border-t border-gray-200 w-full">
      </span>
            </div>
            <div class="flex flex-col gap-1">
                <label class="form-label text-gray-900">
                    Name
                </label>
                <input class="input" name="name" placeholder="isayalcintr" type="text" value=""/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="form-label text-gray-900">
                    Email
                </label>
                <input class="input" name="email" placeholder="email@email.com" type="text" value=""/>
            </div>
            <div class="flex flex-col gap-1">
                <label class="form-label font-normal text-gray-900">
                    Password
                </label>
                <div  class="flex flex-row" data-toggle-password="true">
                    <div class="flex-1">
                        <input class="input" name="password" placeholder="Enter Password" type="password" value=""/>
                    </div>
                    <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                        <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden">
                        </i>
                        <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block">
                        </i>
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-1">
                <label class="form-label font-normal text-gray-900">
                    Confirm Password
                </label>
                <div  class="flex flex-row" data-toggle-password="true">
                    <div class="flex-1">
                        <input class="input" name="password_confirmation" placeholder="Enter Password" type="password" value=""/>
                    </div>
                    <button class="btn btn-icon" data-toggle-password-trigger="true" type="button">
                        <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden">
                        </i>
                        <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block">
                        </i>
                    </button>
                </div>
            </div>
            <label class="checkbox-group">
                <input class="checkbox checkbox-sm" name="check" type="checkbox" value="1"/>
                <span class="checkbox-label">
       I accept
       <a class="text-2sm link" href="#">
        Terms & Conditions
       </a>
      </span>
            </label>
            <button class="btn btn-primary flex justify-center grow">
                Sign up
            </button>
        </form>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/auth/register.js')
@endsection
