<?php

namespace App\Http\Controllers;

use App\Models\tb_courses as Course;
use App\Models\tb_sub_courses as Sub;
use App\Models\tb_quiz as Quiz;
use App\Models\tb_tryout as Tryout;
use App\Models\tb_final_exam as Exam;
use App\Models\tb_user_purchase as UserPurchase;
use App\Models\tb_paket_terpilih as PaketTerpilih;
use App\Models\tb_paket as Paket;
use App\Models\tb_users as User;
use App\Models\tb_user_attempt_quiz as UserAttemptQuiz;
use App\Models\tb_user_attempt_tryout as UserAttemptTryout;
use App\Models\tb_user_attempt_exam as UserAttemptExam;
use Session;
use Carbon\Carbon;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('created_at', 'asc')->get();
        return view('main.main', [
            'courses' => $courses,
        ]);
    }
    public function about()
    {
        return view('main.about');
    }
    public function courses()
    {
        return view('main.courses');
    }
    public function detailCourses($id)
    {
        $detailCourse = Course::find($id);
        $subCourses = $detailCourse->subCourses;
        return view('main.detail-courses', [
            'detailCourse' => $detailCourse,
            'subCourses' => $subCourses
        ]);
    }
    public function MyCourses()
    {
        $myCourses = UserPurchase::where('id_user', Session::get('id'))->where('is_sudah_bayar', 'Paid')->get();
        $subCourses = [];
        foreach ($myCourses as $course) {
            $subCourse = Sub::find($course->id_sub_terbayar);
            if ($subCourse) {
                $subCourses[] = $subCourse;
            }
        }
        return view('main.mycourses', [
            'subCourses' => $subCourses
        ]);
    }
    public function detailSubCourse($id)
    {
        $userId = Session::get('id');
        $userPurchase = UserPurchase::where('id_user', $userId)
            ->where('id_sub_terbayar', $id)
            ->where('is_sudah_bayar', 'Paid')
            ->first();
        $subCourse = Sub::find($id);
        $quiz = $subCourse->Quiz->where('is_berbayar', 1);
        $tryout = $subCourse->tryout;
        $exam = $subCourse->exam;
        $quizFree = $subCourse->Quiz->where('is_berbayar', 0);
        $userPaidThisSubCourse = UserPurchase::where('id_sub_terbayar', $id)->where('is_sudah_bayar', 'Paid')->count();
        return view('main.detail-subcourse', [
            'subCourse' => $subCourse,
            'quiz' => $quiz,
            'tryout' => $tryout,
            'exam' => $exam,
            'quizFree' => $quizFree,
            'userPurchase' => $userPurchase,
            'userPaidThisSubCourse' => $userPaidThisSubCourse
        ]);
    }
    public function getSubCourseContent($id_quiz, $id_sub_course)
    {
        $quiz = Quiz::find($id_quiz);
        $paket = NULL;
        $jumlah_soal = 0;
        if ($quiz) {
            if ($quiz->id_paket) {
                $paket = Paket::find($quiz->id_paket);
                $jumlah_soal = PaketTerpilih::where('id_paket', $quiz->id_paket)->count();
            }
        }
        $isUserAttempt = UserAttemptQuiz::where('id_quiz', $id_quiz)
            ->where('id_user', Session::get('id'))
            ->whereNotNull('end')
            ->first();

        if($quiz->posisi==1){
            return view('main.category-content', [
                'quiz' => $quiz,
                'jumlah_soal' => $jumlah_soal,
                'isUserAttempt' => $isUserAttempt,
            ]);
        }else{
            $previousQuiz = $quiz->posisi - 1;
            $getQuizByPosition = Quiz::where('id_sub_course', $id_sub_course)->where('posisi', $previousQuiz)->first();
            $CheckUserCompletePreviousQuiz = UserAttemptQuiz::where('id_quiz', $getQuizByPosition->id)
                ->where('id_user', Session::get('id'))
                ->where('is_complete', 1)
                ->first();
            if($CheckUserCompletePreviousQuiz==NULL){
                return redirect()->back()->with('error', "Mohon selesaikan Materi ( $getQuizByPosition->nama_quiz ) Untuk Dapat Melanjutkan ke Materi Selanjutnya!");
            }else{
                return view('main.category-content', [
                    'quiz' => $quiz,
                    'jumlah_soal' => $jumlah_soal,
                    'isUserAttempt' => $isUserAttempt,
                ]);
            }
        }
        
    }
    public function getSubCourseTryout($id_tryout, $id_sub_course){
        $tryout = Tryout::find($id_tryout);
        $paket_tryout = Paket::find($tryout->id_paket);
        $jumlah_soal_tryout = PaketTerpilih::where('id_paket', $tryout->id_paket)->count();
        $isUserAttemptTryout = UserAttemptTryout::where('id_tryout', $id_tryout)
            ->where('id_user', Session::get('id'))
            ->whereNotNull('end')
            ->first();
        return view('main.tryout-content', [
            'tryout' => $tryout,
            'jumlah_soal_tryout' => $jumlah_soal_tryout,
            'isUserAttemptTryout' => $isUserAttemptTryout,
        ]);
    }
    public function getSubCourseExam($id_exam, $id_sub_course){
        $exam = Exam::find($id_exam);
        $paket_exam = Paket::find($exam->id_paket);
        $jumlah_soal_exam = PaketTerpilih::where('id_paket', $exam->id_paket)->count();
        $isUserAttemptExam = UserAttemptExam::where('id_exam', $id_exam)
            ->where('id_user', Session::get('id'))
            ->whereNotNull('end')
            ->first();
        return view('main.exam-content', [
            'exam' => $exam,
            'jumlah_soal_exam' => $jumlah_soal_exam,
            'isUserAttemptExam' => $isUserAttemptExam,
        ]);
    }
    public function rateSubCourseContent(Request $req, $id_sub_course)
    {
        $req->validate(['rate' => 'required']);
        $subCourse = Sub::find($id_sub_course);
        $rating = new \willvincent\Rateable\Rating;
        $rating->rating = $req->rate;
        $rating->user_id = Session::get('id');
        $rating->id_sub_course = $id_sub_course;
        Sub::where('id', $id_sub_course)->update([
            'rating' => $req->rate,
            'number_of_review' => $subCourse->usersRated(),
        ]);
        $subCourse->ratings()->save($rating);
        return redirect()->back()->with('success', 'Rating Send Successfully!');
    }
    public function buySubCourse(Request $request, $id_sub_course)
    {
        $detailSub = Sub::find($id_sub_course);
        $dataUser = User::find(Session::get('id'));
        return view('main.checkout-subcourse', [
            'detailSub' => $detailSub,
            'dataUser' => $dataUser
        ]);
    }
    public function confirmSubCourse(Request $request, $id_sub_course)
    {
        $request->validate([
            'sub_course' => 'required',
            'pricing' => 'required',
            'id_user' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ]);
        $makeInvoice = UserPurchase::create([
            'id_user' => $request->id_user,
            'id_sub_terbayar' => $id_sub_course,
            'is_sudah_bayar' => 'Unpaid',
        ]);
        if (!$makeInvoice) {
            return redirect()->back()->with('error', 'Gagal Membuat Invoice');
        }
        $detailSub = Sub::find($id_sub_course);
        $dataUser = User::find(Session::get('id'));

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.midtrans_server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $makeInvoice->id,
                'sub_course' => $detailSub->sub_course,
                'gross_amount' => (int) ($detailSub['pricing']),
            ),
            'customer_details' => array(
                'first_name' => $dataUser->first_name,
                'last_name' => $dataUser->last_name,
                'email' => $dataUser->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('main.invoice-subcourse', [
            'detailSub' => $detailSub,
            'makeInvoice' => $makeInvoice,
            'dataUser' => $dataUser,
            'snapToken' => $snapToken,
        ])->with('success', '1 Langkah Lagi, Tekan Pay Now untuk melakukan pembayaran!');
    }

    public function Invoice($id_sub_course, $order_id)
    {
        $sub = Sub::find($id_sub_course);
        $order = UserPurchase::find($order_id);
        $dataUser = User::find(Session::get('id'));
        $formattedDate = Carbon::parse($order['created_at'])->format('d, M Y');
        $order->update(['is_sudah_bayar' => 'Paid']);
        return view('main.printed-invoice', [
            'sub' => $sub,
            'order' => $order,
            'dataUser' => $dataUser,
            'formattedDate' => $formattedDate,
        ]);
    }


    // INI FUNGSI DENGAN WEB HOOK ===================================================================================
    // SYARAT: WEB HARUS ONLINE SEHINGGA MIDTRANS BISA MENGIRIMKAN STATUS KE SINI. ROUTE->BACA PADA ROUTE
    // public function paySubCourse(Request $request, $id_sub_course)
    // {
    //     $serverKey = config('midtrans.midtrans_server_key');
    //     $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
    //     if ($hashed == $request->signature_key) {
    //         if ($request->transaction_status == 'capture') {
    //             $order = UserPurchase::find($request->order_id);
    //             $order->update(['is_sudah_bayar', 'Paid']);
    //         }
    //     }
    // }
}
