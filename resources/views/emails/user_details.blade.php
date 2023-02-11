@component('mail::message')
# Hello From PSBC

Welcome to PSBC Family.

Your Account password is {{$info}}

Please Visit <a href="https://iampsbc.com/login">https://iampsbc.com/login</a> to login.

Enter your Email Address and the given password to login.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
