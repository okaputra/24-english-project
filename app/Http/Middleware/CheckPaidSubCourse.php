<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\tb_user_purchase as UserPurchase;
use Session;

class CheckPaidSubCourse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subCourseId = $request->route('id_sub_course');
        $userId = Session::get('id');

        // Cek apakah user memiliki pembelian untuk sub course yang diminta
        $userPurchase = UserPurchase::where('id_user', $userId)
            ->where('id_sub_terbayar', $subCourseId)
            ->where('is_sudah_bayar', 'Paid')
            ->first();

        if ($userPurchase) {
            return redirect()->back()->with('info', 'Payment Pada Sub Course Ini Telah Dilakukan!');
        }

        return $next($request);
    }
}
