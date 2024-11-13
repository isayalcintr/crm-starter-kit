@extends('layouts.auth.main')

@section('main')
    <div class="card max-w-[370px] w-full">
        <form action="#" class="card-body flex flex-col gap-5 p-10" id="reset_password_enter_email_form" method="post">
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900">
                    Your Email
                </h3>
                <span class="text-2sm text-gray-700">
       Enter your email to reset password
      </span>
            </div>
            <div class="flex flex-col gap-1">
                <label class="form-label font-normal text-gray-900">
                    Email
                </label>
                <input class="input" placeholder="email@email.com" type="text" value=""/>
            </div>
            <a class="btn btn-primary flex justify-center grow" href="html/demo1/authentication/classic/reset-password/check-email.html">
                Contoinue
                <i class="ki-filled ki-black-right">
                </i>
            </a>
        </form>
    </div>
@endsection
