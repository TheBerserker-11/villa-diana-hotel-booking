<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaController extends Controller
{
    public function __invoke(Request $request): BinaryFileResponse
    {
        $path = ltrim((string) $request->query('path', ''), '/\\');

        abort_if($path === '', 404);
        abort_if(Str::contains($path, ['../', '..\\']), 404);
        abort_unless(Storage::disk('public')->exists($path), 404);

        return response()->file(Storage::disk('public')->path($path), [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
