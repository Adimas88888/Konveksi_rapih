<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ExpensesSummaryController;
use App\Http\Controllers\IncomeSummaryController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\productController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'member'], function () {
    Route::get('/', [Controller::class, 'index'])->name('Home');
    Route::get('/checkOut', [Controller::class, 'keranjang'])->name('keranjang');
    Route::get('/shop', [Controller::class, 'shop'])->name('shop');
    Route::get('/contact', [Controller::class, 'contact'])->name('contact');

    Route::POST('/storePelanggan', [UserController::class, 'storePelanggan'])->name('storePelanggan');
    Route::POST('/login_pelanggan', [UserController::class, 'loginProses'])->name('loginproses.pelanggan');
    Route::GET('/logout_pelanggan', [UserController::class, 'logout'])->name('logout.pelanggan');

    Route::get('/cek-ongkir/provinsi', [OngkirController::class, 'provinces'])->name('rajaongkir.provinsi');
    Route::get('/cek-ongkir/kota', [OngkirController::class, 'cities'])->name('rajaongkir.kota');
    Route::get('/cek-ongkir/ongkos', [OngkirController::class, 'cost'])->name('rajaongkir.cost');

    Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
    Route::POST('/addTocart', [TransaksiController::class, 'addTocart'])->name('addTocart');
    Route::DELETE('/delete/detailtransaksi/{id}', [TransaksiController::class, 'deleteDataDetail'])->name('deleteDataDetail');

    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::POST('/checkout/proses/{id}', [CheckoutController::class, 'prosesCheckout'])->name('checkout.product');
    Route::POST('/checkout/prosesPembayaran', [CheckoutController::class, 'prosesPembayaran'])->name('checkout.bayar');
    Route::get('/checkOut/{id}', [CheckoutController::class, 'bayar'])->name('keranjang.bayar');

});

// routes/web.php

// Route::get('admin/reset-password', [ResetPasswordController::class, 'reset'])->name('reset-password');
// Route::post('admin/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset-password.submit');
// Route::POST('/admin/loginProses', [Controller::class, 'loginProses'])->name('loginProses');
// Route::get('/admin/logout', [Controller::class, 'logout'])->name('logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/incomesummary', [IncomeSummaryController::class, 'incomesummary'])->name('incomesummary');
    Route::get('/admin/expensessummary', [ExpensesSummaryController::class, 'expensessummary'])->name('expensessummary');

    Route::get('/admin/dashboard', [Controller::class, 'admin'])->name('admin');
    Route::get('/admin/user_management', [Controller::class, 'userManagement'])->name('user_management');
    Route::get('/admin/admin_management', [AdminController::class, 'adminManagement'])->name('admin_management');
    Route::get('/admin/product', [Controller::class, 'product'])->name('product');
    Route::get('/admin/report', [Controller::class, 'report'])->name('report');
    Route::get('/admin/report/excel', [Controller::class, 'reportExcel'])->name('report.excel');

    Route::get('/admin/chart', [UserController::class, 'chart'])->name('chart');
    Route::get('/admin/chart2', [UserController::class, 'chart2'])->name('chart2');

    Route::GET('/admin/user_management/addModalUser', [UserController::class, 'addmodalUser'])->name('addModal.user');
    Route::POST('/admin/user_management/addData', [UserController::class, 'store'])->name('addDataUser');
    Route::GET('/admin/user_management/editUser/{id}', [UserController::class, 'show'])->name('showDataUser');
    Route::put('/admin/user_management/updateDataUser/{id}', [UserController::class, 'update'])->name('updateDataUser');
    Route::DELETE('/admin/user_management/deleteUser/{id}', [UserController::class, 'destroy'])->name('destroyDataUser');

    Route::GET('/admin/admin_management/addModalAdmin', [AdminController::class, 'addmodaladmin'])->name('addModal.admin');
    Route::POST('/admin/admin_management/addData', [AdminController::class, 'store'])->name('addDataAdmin');
    Route::GET('/admin/admin_management/editAdmin/{id}', [AdminController::class, 'show'])->name('showDataAdmin');
    Route::put('/admin/admin_management/updateDataAdmin/{id}', [AdminController::class, 'update'])->name('updateDataAdmin');
    Route::DELETE('/admin/admin_management/deleteAdmin/{id}', [AdminController::class, 'destroy'])->name('destroyDataAdmin');

    
    Route::get('/admin/addModal', [productController::class, 'addmodal'])->name('addModal');
    Route::POST('/admin/addData', [productController::class, 'store'])->name('addData');
    Route::GET('/admin/editModel/{id}', [productController::class, 'show'])->name('editModal');
    Route::PUT('/admin/updateData/{id}', [productController::class, 'update'])->name('updateData');
    Route::DELETE('/admin/deleteData/{id}', [productController::class, 'destroy'])->name('deleteData');

    Route::get('/filter-data', [productController::class, 'filterData'])->name('filterData');
    Route::get('/filter-data2', [UserController::class, 'filterData2'])->name('filterData2');
    Route::post('/filter-data3', [ReportController::class, 'filterData3'])->name('filterData3');
    Route::DELETE('/admin/deleteTransaksi/{id}', [ReportController::class, 'destroy'])->name('deleteTransaksi');
    Route::get('admin/download-pdf', [ReportController::class, 'downloadPDF']);
    Route::get('admin/view-pdf', [ReportController::class, 'viewPDF']);
});

require __DIR__.'/auth.php';
