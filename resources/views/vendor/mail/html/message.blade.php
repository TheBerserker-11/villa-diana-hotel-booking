<x-mail::layout>
    @php
        $logoPath = public_path('img/logo/logo.png');
        $logoBase64 = null;

        if (file_exists($logoPath)) {
            $mime = function_exists('mime_content_type') ? mime_content_type($logoPath) : 'image/png';
            $data = base64_encode(file_get_contents($logoPath));
            $logoBase64 = "data:{$mime};base64,{$data}";
        }
    @endphp

    <x-slot:header>
        <x-mail::header :url="config('app.url')" style="padding: 20px 0; text-align:center;">
            <div style="text-align:center;">
                @if($logoBase64)
                    <img
                        src="{{ $logoBase64 }}"
                        alt="Villa Diana Hotel"
                        style="height:60px; width:auto; display:block; margin:0 auto 10px;"
                    >
                @endif

                <h2 style="margin:0; color:#0F172B;">Villa Diana Hotel</h2>

                <p style="margin:6px 0 0; color:#6B7280; font-size:13px;">
                    Booking &amp; Reservation Updates
                </p>
            </div>
        </x-mail::header>
    </x-slot:header>

    {{ $slot }}

    @isset($subcopy)
        <x-slot:subcopy>
            <x-mail::subcopy>
                {{ $subcopy }}
            </x-mail::subcopy>
        </x-slot:subcopy>
    @endisset

    <x-slot:footer>
        <x-mail::footer>
            © {{ date('Y') }} Villa Diana Hotel. All rights reserved.
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>
