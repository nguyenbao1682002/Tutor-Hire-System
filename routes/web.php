<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminTutorController;
use App\Http\Controllers\Admin\AdminLogoutController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminPhuHuynhController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\Admin\AdminVipPackageDetailController;


Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login')->middleware('notadmin');
    Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login.submit')->middleware('notadmin');
    Route::get('logout', [AdminLogoutController::class, 'index'])->name('admin.logout')->middleware('admin');
    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('/tutor', AdminTutorController::class)->names([
            'index' => 'admin.tutor.index',
            'create' => 'admin.tutor.create',
            'store' => 'admin.tutor.store',
            'show' => 'admin.tutor.show',
            'edit' => 'admin.tutor.edit',
            'update' => 'admin.tutor.update',
            'destroy' => 'admin.tutor.destroy',
        ]);
        Route::resource('/post', AdminPostController::class)->names([
            'index' => 'admin.post.index',
            'create' => 'admin.post.create',
            'store' => 'admin.post.store',
            'show' => 'admin.post.show',
            'edit' => 'admin.post.edit',
            'update' => 'admin.post.update',
            'destroy' => 'admin.post.destroy',
        ]);
        Route::resource('/subject', AdminSubjectController::class)->names([
            'index' => 'admin.subject.index',
            'create' => 'admin.subject.create',
            'store' => 'admin.subject.store',
            'show' => 'admin.subject.show',
            'edit' => 'admin.subject.edit',
            'update' => 'admin.subject.update',
            'destroy' => 'admin.subject.destroy',
        ]);

        Route::get('phuhuynh', [AdminPhuHuynhController::class, 'index'])->name('admin.phuhuynh.index')->middleware('admin');
        Route::get('phuhuynh/{phuhuynh}/show', [AdminPhuHuynhController::class, 'show'])->name('admin.phuhuynh.show')->middleware('admin');
        Route::post('phuhuynh/{phuhuynh}/balance', [AdminPhuHuynhController::class, 'balance'])->name('admin.phuhuynh.balance')->middleware('admin');
        Route::get('phuhuynh/{phuhuynh}/block', [AdminPhuHuynhController::class, 'block'])->name('admin.phuhuynh.block')->middleware('admin');
        
        Route::get('review', [AdminReviewController::class, 'index'])->name('admin.review.index')->middleware('admin');
        Route::delete('review/{review}/destroy', [AdminReviewController::class, 'destroy'])->name('admin.review.destroy')->middleware('admin');
        
        Route::get('comment', [AdminCommentController::class, 'index'])->name('admin.comment.index')->middleware('admin');
        Route::delete('comment/{comment}/destroy', [AdminCommentController::class, 'destroy'])->name('admin.comment.destroy')->middleware('admin');
    
        Route::resource('/vip', AdminVipPackageDetailController::class)->names([
            'index' => 'admin.vip.index',
            'create' => 'admin.vip.create',
            'store' => 'admin.vip.store',
            'show' => 'admin.vip.show',
            'edit' => 'admin.vip.edit',
            'update' => 'admin.vip.update',
            'destroy' => 'admin.vip.destroy',
        ]);

        Route::get('/vip/register/{id}', [AdminVipPackageDetailController::class, 'register'])->name('admin.vip.register')->middleware('admin');

        Route::get('transaction', [AdminTransactionController::class, 'index'])->name('admin.transaction.index')->middleware('admin');

        
        Route::get('/deposit', [AdminDepositController::class, 'index'])->name('admin.deposit.index')->middleware('admin');
        Route::post('/deposit', [AdminDepositController::class, 'pay'])->name('admin.deposit.pay')->middleware('admin');
        Route::get('/deposit/vnpay-return', [AdminDepositController::class, 'vnpayReturn'])->name('admin.deposit.vnpayReturn')->middleware('admin');

        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit')->middleware('admin');
        Route::post('/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update')->middleware('admin');
        Route::post('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('admin.profile.changePassword')->middleware('admin');
    });
});


use App\Http\Controllers\Web\WebHomeController;
use App\Http\Controllers\Web\WebPostController;
use App\Http\Controllers\Web\WebSubjectController;
use App\Http\Controllers\Web\WebTutorController;
use App\Http\Controllers\Web\WebAuthController;
use App\Http\Controllers\Web\WebPhuHuynhController;
use App\Http\Controllers\Web\WebCommentController;
use App\Http\Controllers\Web\WebVipPackageDetailController;
use App\Http\Controllers\Web\WebReviewController;


Route::get('/', [WebHomeController::class, 'index'])->name('web.home.index');

Route::get('/bai-viet/{slug}', [WebPostController::class, 'show'])->name('web.post.show');

Route::get('/mon-hoc/{slug}', [WebSubjectController::class, 'show'])->name('web.subject.show');

Route::get('/gia-su/{id}', [WebTutorController::class, 'show'])->name('web.giasu.show');

Route::get('/gia-su', [WebPostController::class, 'index'])->name('web.giasu.index');

Route::post('/gia-su/so-dien-thoai', [WebTutorController::class, 'phone'])->name('web.giasu.phone');

Route::get('/dang-nhap', action: [WebAuthController::class, 'login'])->name('web.auth.login')->middleware('notAuth');

Route::post('/dang-nhap', action: [WebAuthController::class, 'submitLogin'])->name('web.auth.login.submit')->middleware('notAuth');

Route::get('/dang-xuat', action: [WebAuthController::class, 'logout'])->name('web.auth.logout');

Route::get('/phu-huynh/dang-ky', action: [WebAuthController::class, 'parentRegister'])->name('web.auth.parentRegister')->middleware('notAuth');

Route::post('/phu-huynh/dang-ky', action: [WebAuthController::class, 'parentRegisterSubmit'])->name('web.auth.parentRegister.submit')->middleware('notAuth');

Route::get('/phu-huynh', action: [WebPhuHuynhController::class, 'show'])->name('web.phuhuynh.show');

Route::get('/phu-huynh/nap-tien', [WebPhuHuynhController::class, 'pay'])->name('web.phuhuynh.pay');

Route::post('/phu-huynh/nap-tien', [WebPhuHuynhController::class, 'payCheck'])->name('web.phuhuynh.payCheck');

Route::post('/phu-huynh/cap-nhat', [WebPhuHuynhController::class, 'update'])->name('web.phuhuynh.update');

Route::get('/checkVnpay', [WebPhuHuynhController::class, 'checkVnpay'])->name('web.phuhuynh.checkVnpay');

Route::get('/dang-ky', action: [WebAuthController::class, 'tutorRegister'])->name('web.auth.tutorRegister')->middleware('notAuth');

Route::post('/dang-ky', action: [WebAuthController::class, 'tutorRegisterSubmit'])->name('web.auth.tutorRegister.submit')->middleware('notAuth');

Route::post('/binh-luan', action: [WebCommentController::class, 'post'])->name('web.comment.post');

Route::get('/goi-vip', action: [WebVipPackageDetailController::class, 'show'])->name('web.vip.show');

Route::get('/goi-vip/{id}', action: [WebVipPackageDetailController::class, 'register'])->name('web.vip.register');

Route::post('/danh-gia', action: [WebReviewController::class, 'post'])->name('web.review.post');


































Route::get('/api/province', function () {
    // Gửi yêu cầu đến API bên ngoài
    $response = Http::get('https://vapi.vnappmob.com/api/v2/province');
    
    // Kiểm tra nếu có lỗi khi gọi API
    if ($response->failed()) {
        return response()->json([
            'error' => 'Unable to fetch data from external API',
        ], 500);
    }

    // Trả về dữ liệu JSON từ API
    return $response->json();
});

Route::get('/api/district/{provinceId}', function ($provinceId) {
    $response = Http::get("https://vapi.vnappmob.com/api/v2/province/district/{$provinceId}");
    return $response->json();
});

Route::get('/api/ward/{districtId}', function ($districtId) {
    $response = Http::get("https://vapi.vnappmob.com/api/v2/province/ward/{$districtId}");
    return $response->json();
});



