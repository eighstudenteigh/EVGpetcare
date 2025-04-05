<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PageController, LoginController, ProfileController,
    DashboardController, AppointmentController, ServiceController, PetController, InquiryController, GuestServiceController,
    AboutController,
};

use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClosedDaysController;
use App\Http\Controllers\Admin\CRUDServiceController;
use App\Http\Controllers\Admin\AdminPetController;
use App\Http\Controllers\Admin\AdminPetTypeController;
use App\Http\Controllers\Auth\EmailVerificationController;





//  Public Pages (No Middleware)
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/verify-email/{id}', [EmailVerificationController::class, 'verify'])->name('verify.email');
   
//services
    Route::get('/services', [GuestServiceController::class, 'index'])->name('services');
    Route::get('/services/all', [GuestServiceController::class, 'getAllServices']);
    Route::get('/services/by-animal', [GuestServiceController::class, 'getServicesByAnimal']);
    Route::get('/about-us', [AboutController::class, 'index'])->name('about.us');

//inquiry
    Route::get('/inquiry', [InquiryController::class, 'create'])->name('customer.inquiry');
    Route::post('/inquiry', [InquiryController::class, 'store'])->name('customer.inquiry.store');
    

    Route::get('/appointments', [PageController::class, 'appointments'])->name('appointments');
    Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Authentication Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
         });

// Logout route
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'redirectToDashboard'])->name('dashboard');

        // Profile Routes - available to all authenticated users
        Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');

        Route::get('/admin/closed-days', [ClosedDaysController::class, 'index'])->name('admin.closed-days.index');    
    });

    // Customer Routes
    Route::middleware(['role:customer'])->group(function () {
        Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    //pets    
        Route::get('/pets', [PetController::class, 'index'])->name('customer.pets.index');
        Route::get('/pets/create', [PetController::class, 'create'])->name('customer.pets.create');
        Route::post('/pets/store', [PetController::class, 'store'])->name('customer.pets.store');
        Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('customer.pets.edit');
        Route::put('/pets/{pet}/update', [PetController::class, 'update'])->name('customer.pets.update');
        Route::delete('/pets/{pet}/delete', [PetController::class, 'destroy'])->name('customer.pets.destroy');
    
    //appointments
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('customer.appointments.index');
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('customer.appointments.create');
        Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('customer.appointments.store');
        Route::delete('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('customer.appointments.cancel');

        Route::get('/appointments/availability', [AppointmentController::class, 'getAvailability'])->name('customer.appointments.availability');
        Route::get('/appointments/closed-days', [AdminDashboardController::class, 'getClosedDays']);
    });

    // Admin Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/update-max-appointments', [AdminDashboardController::class, 'updateMaxAppointments'])->name('admin.updateMaxAppointments');
        
        //appointments
        Route::get('/admin/appointments', [AdminAppointmentController::class, 'index'])->name('admin.appointments');
        Route::get('/admin/approved', [AdminAppointmentController::class, 'approved'])->name('admin.appointments.approved');
        Route::get('/admin/appointments/rejected', [AdminAppointmentController::class, 'rejected'])->name('admin.appointments.rejected');
        Route::get('/admin/appointments/all', [AdminAppointmentController::class, 'all'])->name('admin.appointments.all');

        //customers
        Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/admin/customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
        Route::post('/admin/customers', [CustomerController::class, 'store'])->name('admin.customers.store'); 
        Route::get('/admin/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
        Route::put('/admin/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
        Route::delete('/admin/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy'); 

        //Pets
        Route::get('/admin/pets', [AdminPetController::class, 'index'])->name('admin.pets.index'); 
        Route::put('/admin/pets/{pet}', [AdminPetController::class, 'update'])->name('admin.pets.update'); 
        Route::delete('/admin/pets/{pet}', [AdminPetController::class, 'destroy'])->name('admin.pets.destroy');
        
        //PetType
        Route::prefix('admin/pet-types')->name('admin.pet-types.')->group(function () {
            Route::post('/', [AdminPetTypeController::class, 'store'])->name('store');
            Route::put('/{petType}', [AdminPetTypeController::class, 'update'])->name('update');
            Route::delete('/{petType}', [AdminPetTypeController::class, 'destroy'])->name('destroy'); 
        });
        
        //inquiry
        Route::get('/admin/inquiries', [InquiryController::class, 'index'])->name('admin.inquiries');
        Route::post('/admin/inquiries/{id}/read', [InquiryController::class, 'markAsRead'])->name('admin.inquiries.read');

        Route::delete('/admin/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('admin.inquiries.delete');

        //closed-days
        Route::post('/admin/closed-days', [ClosedDaysController::class, 'store'])->name('admin.closed-days.store');
        Route::delete('/admin/closed-days/{date}', [ClosedDaysController::class, 'destroy'])->name('admin.closed-days.destroy');
        

        // Settings Routes
            Route::get('/admin/settings', [ClosedDaysController::class, 'settings'])->name('admin.settings');
            Route::post('/admin/settings/max-appointments', [ClosedDaysController::class, 'updateMaxAppointments'])->name('admin.settings.maxAppointments');
            
        //admins   
            Route::get('/admin', [AdminController::class, 'index'])->name('admins.index');
            Route::get('/admin/create', [AdminController::class, 'create'])->name('admins.create');
            Route::post('/admin/store', [AdminController::class, 'store'])->name('admins.store');
            Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');

        
        //services
            Route::get('/admin/services', [AdminServiceController::class, 'index'])->name('admin.services.index');
            Route::get('/admin/services/create', [AdminServiceController::class, 'create'])->name('admin.services.create');
            Route::post('/admin/services/store', [AdminServiceController::class, 'store'])->name('admin.services.store');
            Route::put('/admin/services/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');  
            Route::delete('/admin/services/{service}', [AdminServiceController::class, 'destroy'])->name('admin.services.delete');  
            

            Route::post('/admin/appointments/{appointment}/approve', [AdminAppointmentController::class, 'approve'])->name('admin.appointments.approve');
            Route::post('/admin/appointments/{appointment}/reject', [AdminAppointmentController::class, 'reject'])->name('admin.appointments.reject');
        });
});

require __DIR__.'/auth.php';