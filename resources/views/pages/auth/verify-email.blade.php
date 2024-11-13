@extends('layouts.auth.main')

@section('main')
    <div class="card max-w-[440px] w-full">
        <div class="card-body p-10">
            <div class="flex justify-center py-10">
                <img alt="image" class="dark:hidden max-h-[130px]" src="assets/media/illustrations/30.svg"/>
                <img alt="image" class="light:hidden max-h-[130px]" src="assets/media/illustrations/30-dark.svg"/>
            </div>
            <h3 class="text-lg font-medium text-gray-900 text-center mb-3">
                Check your email
            </h3>
            <div class="text-2sm text-center text-gray-700 mb-7.5">
                Please click the link sent to your email
                <a class="text-2sm text-gray-800 font-medium hover:text-primary-active" href="#">
                    bob@reui.io
                </a>
                <br/>
                to reset your password. Thank you
            </div>
            <div class="flex justify-center mb-5">
                <a class="btn btn-primary flex justify-center" href="html/demo1/authentication/classic/reset-password/change-password.html">
                    Skip for now
                </a>
            </div>
            <div class="flex items-center justify-center gap-1">
                  <span class="text-xs text-gray-600">
                   Didn’t receive an email?
                  </span>
                <a class="text-xs font-medium link" href="html/demo1/authentication/classic/reset-password/enter-email.html">
                    Resend
                </a>
            </div>
        </div>
    </div>
@endsection
