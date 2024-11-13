@extends('layouts.auth.main')

@section('main')
    <div class="card max-w-[370px] w-full">
        <form action="#" class="card-body flex flex-col gap-5 p-10" id="login_form" method="post">
            @csrf
            <div class="text-center mb-2.5">
                <h3 class="text-lg font-medium text-gray-900 leading-none mb-2.5">
                    Crm Giriş
                </h3>
{{--                <div class="flex items-center justify-center font-medium">--}}
{{--                   <span class="text-2sm text-gray-700 me-1.5">--}}
{{--                    Need an account?--}}
{{--                   </span>--}}
{{--                    <a class="text-2sm link" href="html/demo1/authentication/classic/sign-up.html">--}}
{{--                        Sign up--}}
{{--                    </a>--}}
{{--                </div>--}}
            </div>
{{--            <div class="grid grid-cols-2 gap-2.5">--}}
{{--                <a class="btn btn-light btn-sm justify-center" href="#">--}}
{{--                    <img alt="" class="size-3.5 shrink-0" src="assets/media/brand-logos/google.svg"/>--}}
{{--                    Use Google--}}
{{--                </a>--}}
{{--                <a class="btn btn-light btn-sm justify-center" href="#">--}}
{{--                    <img alt="" class="size-3.5 shrink-0 dark:hidden" src="assets/media/brand-logos/apple-black.svg"/>--}}
{{--                    <img alt="" class="size-3.5 shrink-0 light:hidden" src="assets/media/brand-logos/apple-white.svg"/>--}}
{{--                    Use Apple--}}
{{--                </a>--}}
{{--            </div>--}}
            <div class="flex items-center gap-2">
              <span class="border-t border-gray-200 w-full">
              </span>
                <span class="text-2xs text-gray-500 font-medium uppercase">
               CRM
               </span>
                <span class="border-t border-gray-200 w-full">
          </span>
            </div>
            <div class="flex flex-col gap-1">
                <label class="form-label font-normal text-gray-900">
                    e-Posta
                </label>
                <input class="input" placeholder="email@email.com" name="email" type="text" value=""/>
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between gap-1">
                    <label class="form-label font-normal text-gray-900">
                        Şifre
                    </label>
{{--                    <a class="text-2sm link shrink-0" href="html/demo1/authentication/classic/reset-password/enter-email.html">--}}
{{--                        Forgot Password?--}}
{{--                    </a>--}}
                </div>
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
            <label class="checkbox-group">
                <input class="checkbox checkbox-sm" name="remember_me" type="checkbox" value="1"/>
                <span class="checkbox-label">
                Beni Hatırla
            </span>
            </label>
            <button class="btn btn-primary flex justify-center grow">
                Giriş Yap
            </button>
        </form>
    </div>
@endsection
@section('customJs')
    @vite('resources/js/pages/auth/login.js')
@endsection
