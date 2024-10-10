<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\Web\Home\HomeController;
use App\Http\Controllers\Web\Store\StoreController;
use App\Http\Controllers\Web\Product\ProductController;
use App\Http\Controllers\Web\Cart\CartController;
use App\Http\Controllers\Web\Checkout\CheckoutController;
use App\Http\Controllers\Web\Blog\BlogController;
use App\Http\Controllers\Web\Aboutus\AboutusController;
use App\Http\Controllers\Web\Order\OrderController;
use App\Http\Controllers\Web\Contact\ContactController;

use App\Http\Controllers\Manager\Dashboard\DashboardController;
use App\Http\Controllers\Manager\Blog\PostController;
use App\Http\Controllers\Manager\Orders\OrderController as ManagerOrderController;
use App\Http\Controllers\Manager\Clients\ClientController;
use App\Http\Controllers\Manager\Products\ProductController as ManagerProductController;
use App\Http\Controllers\Manager\Content\ContentController;
use App\Http\Controllers\Manager\Settings\SettingsController;
use App\Http\Controllers\Manager\Shipments\ShipmentController;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Settings;
use App\Http\Controllers\Manager\Import\ImportController;
use App\Http\Controllers\Web\Pages\PagesController;

/* Frontoffice */


Route::get('/',[HomeController::class, 'index'])->name('home');

Route::get('/nosotros',[AboutusController::class, 'index'])->name('aboutus');
Route::get('/contacto',[ContactController::class, 'index'])->name('contacto');

Route::get('/blog',[BlogController::class, 'list'])->name('blog.list');
Route::get('/blog/{slug}',[BlogController::class, 'single'])->name('blog.single');

Route::get('/tienda',[StoreController::class, 'index'])->name('store');
Route::get('/product/{product}',[ProductController::class, 'index'])->name('product');
Route::get('/cart',[CartController::class, 'index'])->name('cart');

Route::get('/checkout',[CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/confirmation',[CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
Route::post('/checkout/calcDelivery',[CheckoutController::class, 'calcDelivery'])->name('checkout.calcDelivery');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout_process');

Route::get('/order/detail',[OrderController::class, 'viewDetail'])->name('order.viewDetail');

Route::get('/{slug}',[PagesController::class, 'single'])->name('page'); 

Route::post('/contact/store',[ContactController::class, 'store'])->name('contact.store');
Route::post('/suscribe',[HomeController::class, 'suscribe'])->name('suscribe');


/*Backoffice */

Route::middleware(['auth'])->group(function () {
    Route::prefix('manager')->group(function () {
        Route::get('/logout', function () {
            auth()->logout();
            return redirect()->route('home'); 
        })->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/orders', [ManagerOrderController::class, 'index'])->name('orders');
        Route::get('/orders/list', [ManagerOrderController::class, 'list'])->name('orders.list');
        Route::get('/orders/{order}/detail', [ManagerOrderController::class, 'detail'])->name('orders.detail');
        Route::post('/orders/{order}/updateStatus', [ManagerOrderController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::get('/shipments/{shipment}/documentation', [ShipmentController::class, 'getDocumentation']);

        Route::get('/clients', [ClientController::class, 'index'])->name('clients');
        Route::get('/clients/list', [ClientController::class, 'list'])->name('clients.list');

        Route::get('/products', [ManagerProductController::class, 'index'])->name('products');
        Route::get('/products/list', [ManagerProductController::class, 'list'])->name('products.list');
        Route::post('/products/update/{product}', [ManagerProductController::class, 'update'])->name('products.update');
        Route::post('/products/massiveToggleActive', [ManagerProductController::class, 'massiveToggleActive'])->name('products.massiveToggleActive');

        Route::get('/novedades', [PostController::class, 'index'])->name('posts.list');
        Route::get('/novedades/create', [PostController::class, 'create'])->name('posts.create');
        Route::get('/novedades/{id}/edit',   [PostController::class, 'edit'])->name('posts.edit');
        Route::post('/novedades/store', [PostController::class, 'store'])->name('posts.store');
        Route::post('/novedades/update/{post}', [PostController::class, 'update'])->name('posts.update');
        

        Route::get('/contenido', [ContentController::class, 'index'])->name('content');

        Route::post('/contenido/update', [ContentController::class, 'updateContent'])->name('content.update');


        Route::get('/contenido/slider/list', [ContentController::class, 'list'])->name('content.slider.list');
        Route::post('/contenido/slider/store', [ContentController::class, 'sliderStore'])->name('content.slider.store');
        Route::post('/contenido/{slider}/slider', [ContentController::class, 'sliderDelete'])->name('content.slider.delete');
        Route::post('/contenido/slider/order', [ContentController::class, 'sliderOrder'])->name('content.slider.order');
        //create a route named logout to logout the user

        Route::post('/contenido/about/store', [ContentController::class, 'aboutStore'])->name('content.about.store');
        
        Route::post('/contenido/legales/store', [ContentController::class, 'legalesStore'])->name('content.legales.store');
        Route::get('/contenido/brand/list', [ContentController::class, 'brandList'])->name('content.brand.list');
        Route::post('/contenido/brand/store', [ContentController::class, 'brandStore'])->name('content.brand.store');
        Route::post('/contenido/{contentBrand}/brand', [ContentController::class, 'brandDelete'])->name('content.brand.delete');
        Route::post('/contenido/brand/order', [ContentController::class, 'brandOrder'])->name('content.brand.order');
        
        Route::get('/contenido/banner', [ContentController::class, 'banner'])->name('content.banner');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::get('/settings/family/list', [SettingsController::class, 'familyList'])->name('settings.family.list');
        Route::post('settings/family/{family}/update', [SettingsController::class, 'familyUpdate'])->name('settings.family.update');

        Route::get('settings/brand/list', [SettingsController::class, 'brandList'])->name('settings.brand.list');
        Route::post('settings/brand/update/{brand}', [SettingsController::class, 'brandUpdate'])->name('settings.brand.update');

        Route::get('settings/label/list', [SettingsController::class, 'labelList'])->name('settings.label.list');
        Route::post('settings/label/update/{label}', [SettingsController::class, 'labelUpdate'])->name('settings.label.update');
        Route::post('settings/label/store', [SettingsController::class, 'labelStore'])->name('settings.label.store');

        Route::get('settings/import', [SettingsController::class, 'importData'])->name('settings.import');
        
        Route::get('settings/various', [SettingsController::class, 'various'])->name('settings.various');
        Route::post('settings/various/update', [SettingsController::class, 'variousUpdate'])->name('settings.various.update');
       
       
        Route::get('content/{page}/{section}', [ContentController::class, 'getContent'])->name('content.get');

        Route::get('import/products',  [ImportController::class, 'import_products'])->name('import.products');
        Route::get('import/families',  [ImportController::class, 'import_families'])->name('import.families');
        Route::get('import/brands',    [ImportController::class, 'import_brands'])->name('import.brands');
        Route::get('import/atributes', [ImportController::class, 'import_atributes'])->name('import.atributes');

        Route::get('/pages/list',[PagesController::class, 'list'])->name('pages.list');
        Route::post('/pages/store',[PagesController::class, 'store'])->name('pages.store');
        Route::get('/pages/{id}',[PagesController::class, 'edit'])->name('pages.edit');

        Route::post('/pages/update',[PagesController::class, 'update'])->name('pages.update');

    });
});


