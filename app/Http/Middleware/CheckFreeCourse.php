<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\tb_quiz as Quiz;

class CheckFreeCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subCourseId = $request->route('id_sub_course');

        // Cek apakah sub course terpilih memang free
        $subCourse = Quiz::where('id_sub_course', $subCourseId)
            ->where('is_berbayar', 0)
            ->first();

        if (!$subCourse) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke materi pada sub course ini. Harap Menyelesaikan Pembayaran!');
        }

        return $next($request);
    }
}
