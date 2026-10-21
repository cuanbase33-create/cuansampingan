@extends('layouts.auth')

@section('title', '2FA Verification')

@section('content')
    <div class="space-y-6">
        @if ($isSetup)
            <div class="text-center">
                <h2 class="text-xl font-semibold text-white mb-2">Setup Two-Factor Authentication</h2>
                <p class="text-sm text-gray-400 mb-4">Scan the QR code below using Google Authenticator or a compatible app.</p>
                <div class="inline-block bg-white p-2 rounded-lg mb-4">
                    {!! $qrCodeSvg !!}
                </div>
                <p class="text-xs text-gray-500 mb-2">Or enter this secret manually:</p>
                <code class="bg-navy px-2 py-1 rounded text-gold text-sm">{{ $secret }}</code>
            </div>
        @else
            <div class="text-center">
                <h2 class="text-xl font-semibold text-white mb-2">Two-Factor Authentication</h2>
                <p class="text-sm text-gray-400">Please enter the 6-digit code from your authenticator app.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.2fa') }}" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="bg-danger/20 border border-danger text-danger px-4 py-3 rounded relative" role="alert">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label for="otp" class="block text-sm font-medium text-gray-300 text-center">Authentication Code</label>
                <input id="otp" type="text" name="otp" required autofocus maxlength="6" autocomplete="one-time-code"
                    class="mt-2 block w-full px-4 py-3 bg-navy border border-gray-border rounded-md text-gray-200 text-center text-2xl tracking-widest placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-teal focus:border-transparent transition"
                    placeholder="••••••">
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal hover:bg-teal-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal focus:ring-offset-navy transition">
                    Verify Code
                </button>
            </div>
        </form>
        
        <form method="POST" action="{{ route('admin.logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-white transition">
                Cancel and Logout
            </button>
        </form>
    </div>
@endsection
