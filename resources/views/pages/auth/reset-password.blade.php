@extends('layouts.auth.main')

@section('main')
    <div class="card max-w-[370px] w-full">
        <form action="#" class="card-body flex flex-col gap-5 p-10" id="reset_password_change_password_form" method="post">
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900">
                    Reset Password
                </h3>
                <span class="text-2sm text-gray-700">
       Enter your new password
      </span>
            </div>
            <div class="flex flex-col gap-1">
                <label class="form-label text-gray-900">
                    New Password
                </label>
                <label class="input" data-toggle-password="true">
                    <input name="user_new_password" placeholder="Enter a new password" type="password" value=""/>
                    <div class="btn btn-icon" data-toggle-password-trigger="true">
                        <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden">
                        </i>
                        <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block">
                        </i>
                    </div>
                </label>
            </div>
            <div class="flex flex-col gap-1">
                <label class="form-label font-normal text-gray-900">
                    Confirm New Password
                </label>
                <label class="input" data-toggle-password="true">
                    <input name="user_confirm_password" placeholder="Re-enter a new Password" type="password" value=""/>
                    <div class="btn btn-icon" data-toggle-password-trigger="true">
                        <i class="ki-filled ki-eye text-gray-500 toggle-password-active:hidden">
                        </i>
                        <i class="ki-filled ki-eye-slash text-gray-500 hidden toggle-password-active:block">
                        </i>
                    </div>
                </label>
            </div>
            <button class="btn btn-primary flex justify-center grow">
                Submit
            </button>
        </form>
    </div>
@endsection
