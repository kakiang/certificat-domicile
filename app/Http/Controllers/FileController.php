<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download($filePath)
    {
        $user = Auth::user();
        if (!Auth::check() || !($user->is_admin || ($user->habitant->user_id === $user->id))) {
            abort(403, 'Unauthorized action.');
        }

        if (str_contains($filePath, '..') || str_starts_with($filePath, '/')) {
            abort(403, 'Unauthorized download attempt.');
        }

        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->download($filePath);
        }

        abort(404, "File not found");
    }

    public function view($filePath)
    {
        // $filePath = urldecode($filePath);

        $user = Auth::user();
        if (!Auth::check() || !($user->is_admin || ($user->habitant->user_id === $user->id))) {
            abort(403, 'Unauthorized action.');
        }

        if (str_contains($filePath, '..') || str_starts_with($filePath, '/')) {
            abort(403, 'Unauthorized download attempt.');
        }

        if (Storage::disk('local')->exists($filePath)) {
            $path = Storage::disk('local')->path($filePath);
            return response()->file($path);
        }

        abort(404, "File not found");
    }
}
