@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('auth.email_verification_title') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('auth.email_verification_link_message') }}
                            </div>
                        @endif

                        {{ __('auth.email_verification_check_yours') }}
                        {{ __('auth.email_verification_did_not_receive') }},
                        <a href="{{ route('verification.resend') }}">
                            {{ __('auth.email_verification_send_another_link') }}
                        </a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
