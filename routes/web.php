<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\BusinessController;


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

Route::middleware('system_admin')->group(function () {
   Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'system_admin'])->name('dashboard');
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
   Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('user.form');
   Route::get('/user/create', [\App\Http\Controllers\UserController::class, 'create'])->name('user.register');
   Route::post('/user/store', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store');
   Route::get('/contact', [\App\Http\Controllers\SendEmailController::class, 'index'])->name('contact');
   Route::post('/contact/send', [\App\Http\Controllers\SendEmailController::class, 'send'])->name('contact');
   Route::get('/admin/users', [\App\Http\Controllers\UserController::class, 'view']);
   Route::get('/admin/users/list', [\App\Http\Controllers\UserController::class, 'viewall'])->name('admin.users');

   Route::get('/positions', [\App\Http\Controllers\RoleController::class, 'index'])->name('positions.index');
   Route::get('/positions/create', [\App\Http\Controllers\RoleController::class, 'create'])->name('positions.create');
   Route::post('/positions/store', [\App\Http\Controllers\RoleController::class, 'store'])->name('positions.store');
   Route::get('/positions/{id}/edit', [\App\Http\Controllers\RoleController::class, 'edit'])->name('positions.edit');
   Route::put('/positions/{id}/update', [\App\Http\Controllers\RoleController::class, 'update'])->name('positions.update');
   Route::delete('/positions/{id}/delete', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('positions.destroy');

   Route::get('/businesses', [BusinessController::class, 'index'])->name('business.form');
   Route::post('/businesses/create', [BusinessController::class, 'storeBusiness'])->name('business-setup');
   Route::get('/businesses/view', [\App\Http\Controllers\UserController::class, 'view']);
   Route::get('/businesses/all', [\App\Http\Controllers\UserController::class, 'viewall'])->name('manage-businesses');
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
