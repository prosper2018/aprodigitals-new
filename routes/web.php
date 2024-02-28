<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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

Route::middleware(['system_admin', 'ensureOtpVerified'])->group(function () {
   Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
   Route::get('registration', [LoginController::class, 'registration'])->name('register-user');
   Route::post('custom-registration', [LoginController::class, 'customRegistration'])->name('register.custom');
   Route::get('/profile', [DashboardController::class, 'profile']);

   Route::get('/blog', [\App\Http\Controllers\BlogPostController::class, 'index']);
   Route::get('/blog/{blogPost}/page_{page}', [\App\Http\Controllers\BlogPostController::class, 'show']);
   Route::get('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'show_by_category'])->name('blog.category');
   Route::get('/admin/blog', [\App\Http\Controllers\BlogPostController::class, 'view']);
   Route::get('/admin/blog/list', [\App\Http\Controllers\BlogPostController::class, 'viewall'])->name('admin.blog');
   Route::post('/blog/apply', [\App\Http\Controllers\BlogPostController::class, 'applyAction'])->name('blog.apply');
   Route::post('/blog/views', [\App\Http\Controllers\BlogPostController::class, 'postViews'])->name('blog.views');
   Route::get('/blog/create/post', [\App\Http\Controllers\BlogPostController::class, 'create'])->name('blog.create');

   Route::get('/admin/comments', [\App\Http\Controllers\CommentsController::class, 'index']);
   Route::get('/admin/comments/viewall', [\App\Http\Controllers\CommentsController::class, 'viewall'])->name('admin.comments');
   Route::post('/admin/comments', [\App\Http\Controllers\CommentsController::class, 'store'])->name("comments.store");
   Route::post('/admin/comments/delete', [\App\Http\Controllers\CommentsController::class, 'delete'])->name('admin.comments.delete');
   Route::delete('/admin/{comments}', [\App\Http\Controllers\CommentsController::class, 'destroy']);
   Route::post('/admin/comments/apply', [\App\Http\Controllers\CommentsController::class, 'applyAction'])->name('comment.apply');

   Route::get('/admin/categories', [\App\Http\Controllers\CategoriesController::class, 'index']);
   Route::post('/admin/categories', [\App\Http\Controllers\CategoriesController::class, 'store'])->name('categories.store');
   Route::get('/admin/categories/viewall', [\App\Http\Controllers\CategoriesController::class, 'viewall'])->name('admin.categories');
   Route::get('/admin/{categories}/categories', [\App\Http\Controllers\CategoriesController::class, 'edit'])->name('admin.categories.edit');
   Route::put('/admin/categories', [\App\Http\Controllers\CategoriesController::class, 'update'])->name('admin.categories.update');
   Route::post('/admin/categories/delete', [\App\Http\Controllers\CategoriesController::class, 'delete'])->name('admin.categories.delete');
   Route::delete('/admin/{categories}', [\App\Http\Controllers\CategoriesController::class, 'destroy']); //deletes post from the database
   Route::post('/admin/categories/apply', [\App\Http\Controllers\CategoriesController::class, 'applyAction'])->name('category.apply');

   Route::get('/user', [UserController::class, 'index'])->name('user.form');
   Route::get('/user/create', [UserController::class, 'create'])->name('user.register');
   Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
   Route::get('/admin/users/list', [UserController::class, 'viewall'])->name('admin.users');
   Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); //shows edit form
   Route::get('/admin/users/{user}/profile-view', [UserController::class, 'viewProfile'])->name('users.profile'); //shows edit form
   Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('users.update');
   Route::post('/import-users', [UserController::class, 'import'])->name('import.users');
   Route::get('/admin/users-upload', [UserController::class, 'bulkUploadForm'])->name('user.upload-form');
   Route::get('/users-template', function () {
      $pathToFile = public_path('templates/users_data_template.xlsx'); // Adjust the path and filename as needed
      return response()->download($pathToFile, 'users_data_template.xlsx');
  })->name('users.template');
  


   Route::get('/positions', [RoleController::class, 'index'])->name('positions.index');
   Route::get('/positions/create', [RoleController::class, 'create'])->name('positions.create');
   Route::post('/positions/store', [RoleController::class, 'store'])->name('positions.store');
   Route::get('/positions/{id}/edit', [RoleController::class, 'edit'])->name('positions.edit');
   Route::put('/positions/{id}/update', [RoleController::class, 'update'])->name('positions.update');
   Route::delete('/positions/{id}/delete', [RoleController::class, 'destroy'])->name('positions.destroy');

   Route::get('/businesses', [BusinessController::class, 'index'])->name('business.form');
   Route::post('/businesses/create', [BusinessController::class, 'storeBusiness'])->name('business-setup');
   Route::get('/businesses/view', [BusinessController::class, 'view']);
   Route::get('/manage/businesses', [BusinessController::class, 'view'])->name('manage-businesses');
   Route::get('/businesses/all', [BusinessController::class, 'viewAllBusiness'])->name('businesses-list');
   Route::get('/businesses/{business}/edit', [BusinessController::class, 'edit'])->name('businesses.edit'); //shows edit form
   Route::put('/businesses/{id}', [BusinessController::class, 'update'])->name('businesses.update');
   Route::post('/businesses/delete', [BusinessController::class, 'delete'])->name('businesses.delete');
});


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('signout', [LoginController::class, 'signOut'])->name('signout');
Route::post('custom-login', [LoginController::class, 'signIn'])->name('login.custom');
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password-reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
Route::get('pwd-chng-on-logon', [LoginController::class, 'changePasswordOnLogon'])->name('password.pwd-chng-on-logon');
Route::post('pwd-chng-on-logon', [LoginController::class, 'changePassword'])->name('password.change');
Route::get('/get-position/{department}', [RoleController::class, 'getPositions'])->name('get.roles');
Route::get('/account-validation', [UserController::class, 'validateAccountNumber'])->name('api.account_validation');
Route::get('/verify/{token}', [UserController::class, 'verify'])->name('verify');
Route::get('/resend-activation', [LoginController::class, 'resendMail'])->name('resend.activation.form');
Route::post('/resend-activation-mail', [LoginController::class, 'resendActivationMail'])->name('resend.activation.mail');
Route::get('/otp-verification', [LoginController::class, 'otpForm'])->name('otp.verify.form');
Route::post('/otp-verify', [LoginController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/contact', [\App\Http\Controllers\SendEmailController::class, 'index'])->name('contact');
Route::post('/contact/send', [\App\Http\Controllers\SendEmailController::class, 'send'])->name('contact.email');


Route::get('/', function () {
   return view('index');
});

Route::get('/about', function () {
   return view('about');
});


Route::post('/blog/create/post', [\App\Http\Controllers\BlogPostController::class, 'store']); //saves the created post to the databse
Route::get('/blog/{blogPost}/edit', [\App\Http\Controllers\BlogPostController::class, 'edit'])->name('blog.edit');; //shows edit post form
Route::put('/blog/{blogPost}/edit', [\App\Http\Controllers\BlogPostController::class, 'update']); //commits edited post to the database 
Route::put('/blog/edit', [\App\Http\Controllers\BlogPostController::class, 'update'])->name('admin.blog.edit'); //commits edited post to the database 
Route::post('/blog/delete', [\App\Http\Controllers\BlogPostController::class, 'delete'])->name('admin.blog.delete'); //deletes post from the database
Route::delete('/blog/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'destroy']); //deletes post from the database


Route::get('/services', function () {
   return view('services');
});

Route::get('/portfolio', function () {
   return view('portfolio-details');
});

Route::get('/inner-page', function () {
   return view('inner-page');
});

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/home', [\App\Http\Controllers\HomeController::class, 'admin'])->name('admin.home');
// Route::get('admin/home', [\App\Http\Controllers\HomeController::class, 'admin'])->name('admin.home')->middleware('admin');
