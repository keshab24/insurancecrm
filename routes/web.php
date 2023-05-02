<?php

use app\Models\product;
use App\Models\SumAssured;
use App\Models\BonusRateEP;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImelifeController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\SumAssuredController;
use App\Http\Controllers\BonusRateEPController;
use App\Http\Controllers\LoadingChargeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::group(['namespace' => 'Auth'], function () {
    Route::get('/admin', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('auth.login');
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'adduser'])->name('user.register');
});
Route::middleware('auth')->group(function () {
    Route::get('full-calender', [App\Http\Controllers\FullCalenderController::class, 'index'])->name('admin.calender.event');
    Route::get('full-calender-meeting', [App\Http\Controllers\FullCalenderController::class, 'meeting'])->name('admin.calender.meeting');
    Route::get('discountList', [App\Http\Controllers\SumAssuredController::class, 'index'])->name('admin.discount.list');
    Route::get('discountCreate', [App\Http\Controllers\SumAssuredController::class, 'create'])->name('admin.discount.create');
    Route::post('discountCreate', [App\Http\Controllers\SumAssuredController::class, 'store'])->name('admin.discount.store');
    Route::get('discountEdit/{id}', [App\Http\Controllers\SumAssuredController::class, 'edit'])->name('admin.discount.edit');
    Route::post('discountEdit/{id}', [App\Http\Controllers\SumAssuredController::class, 'update'])->name('admin.discount.update');
    Route::get('discountList/{id}', [App\Http\Controllers\SumAssuredController::class, 'destroy'])->name('admin.discount.destroy');
    Route::post('discountList/{id}', [App\Http\Controllers\SumAssuredController::class, 'destroy'])->name('admin.discount.delete');
    Route::get('bonusList', [App\Http\Controllers\BonusRateEPController::class, 'index'])->name('admin.bonus.list');
    Route::get('bonusCreate', [App\Http\Controllers\BonusRateEPController::class, 'create'])->name('admin.bonus.create');
    Route::post('bonusCreate', [App\Http\Controllers\BonusRateEPController::class, 'store'])->name('admin.bonus.store');
    Route::get('bonusEdit/{id}', [App\Http\Controllers\BonusRateEPController::class, 'edit'])->name('admin.bonus.edit');
    Route::post('bonusEdit/{id}', [App\Http\Controllers\BonusRateEPController::class, 'update'])->name('admin.bonus.update');
    Route::get('bonusList/{id}', [App\Http\Controllers\BonusRateEPController::class, 'destroy'])->name('admin.bonus.destroy');
    Route::post('bonusList/{id}', [App\Http\Controllers\BonusRateEPController::class, 'destroy'])->name('admin.bonus.delete');
    Route::post('full-calender/action', [App\Http\Controllers\FullCalenderController::class, 'action']);
    Route::post('full-calender-meeting/action', [App\Http\Controllers\FullCalenderController::class, 'actionmeet']);
    Route::get('premium/child/create', [App\Http\Controllers\PremiumController::class, 'child'])->name('premium.child.create');
    Route::post('premium/child', [App\Http\Controllers\PremiumController::class, 'childpost'])->name('premium.child.store');
    Route::get('premium/child/jeevan', [App\Http\Controllers\PremiumController::class, 'childvidya'])->name('premium.child.jeevan');
    Route::post('premium/child/jeevanvidya', [App\Http\Controllers\PremiumController::class, 'childjeevanvidya'])->name('premium.child.jeevan.vidya');

    Route::get('productList', [App\Http\Controllers\ProductController::class, 'index'])->name('admin.product.list');
    Route::get('productCreate', [App\Http\Controllers\ProductController::class, 'create'])->name('admin.product.create');
    Route::post('productCreate', [App\Http\Controllers\ProductController::class, 'store'])->name('admin.product.store');
    Route::get('productEdit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('admin.product.edit');
    Route::post('productEdit/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('admin.product.update');
    Route::get('productList/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::post('productList/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('admin.product.delete');
    Route::patch('product-update-status', [App\Http\Controllers\ProductController::class, 'updateProductStatus'])->name('admin.product.status');

    Route::patch('company-update-status', [App\Http\Controllers\CompaniesController::class, 'updateCompanyStatus'])->name('admin.company.status');


    Route::get('get/featureList', [App\Http\Controllers\LifeCalculatorController::class, 'findFeature'])->name('admin.get.feature.list');

//get all selected plans
Route::get('/selected/plans',[App\Http\Controllers\PlanselectedController::class, 'index'])->name('selected.plans');

    Route::get('featureList', [App\Http\Controllers\FeatureController::class, 'index'])->name('admin.feature.list');
    Route::get('featureList', [App\Http\Controllers\FeatureController::class, 'index'])->name('admin.feature.list');
    Route::get('featureList', [App\Http\Controllers\FeatureController::class, 'index'])->name('admin.feature.list');
    Route::get('featureCreate', [App\Http\Controllers\FeatureController::class, 'create'])->name('admin.feature.create');
    Route::post('featureCreate', [App\Http\Controllers\FeatureController::class, 'store'])->name('admin.feature.store');
    Route::get('featureEdit/{id}', [App\Http\Controllers\FeatureController::class, 'edit'])->name('admin.feature.edit');
    Route::post('featureEdit/{id}', [App\Http\Controllers\FeatureController::class, 'update'])->name('admin.feature.update');
    Route::get('featureList/{id}', [App\Http\Controllers\FeatureController::class, 'destroy'])->name('admin.feature.destroy');
    Route::post('featureList/{id}', [App\Http\Controllers\FeatureController::class, 'destroy'])->name('admin.feature.delete');

    Route::get('featureproductList', [App\Http\Controllers\FeatureController::class, 'fpindex'])->name('admin.feature.product');
    Route::get('featureproductCreate', [App\Http\Controllers\FeatureController::class, 'fpcreate'])->name('admin.feature.product.create');
    Route::post('featureproductCreate', [App\Http\Controllers\FeatureController::class, 'fpstore'])->name('admin.feature.product.store');
    Route::get('featureproEdit/{id}', [App\Http\Controllers\FeatureController::class, 'fpedit'])->name('admin.feature.product.edit');
    Route::post('featureproEdit/{id}', [App\Http\Controllers\FeatureController::class, 'fpupdate'])->name('admin.feature.product.update');
    Route::get('featureproList/{id}', [App\Http\Controllers\FeatureController::class, 'fpdestroy'])->name('admin.feature.product.destroy');

    Route::get('dhanBristi', [\App\Http\Controllers\DhanBristiController::class, 'create'])->name('admin.dhanBristi.create');
    Route::post('dhanBristi', [App\Http\Controllers\DhanBristiController::class, 'store'])->name('admin.dhanBristi.store');
    Route::get('productView/{id}', [App\Http\Controllers\CompaniesController::class, 'product'])->name('admin.company.product');

    Route::get('wholelife', [\App\Http\Controllers\WholelifeController::class, 'create'])->name('admin.Wholelife.create');
    Route::post('wholelife', [App\Http\Controllers\WholelifeController::class, 'store'])->name('admin.wholelife.store');

    Route::get('ime-life-insurance', [ImelifeController::class, 'imelife'])
        ->name('admin.ime.life.insurance');
    Route::post('ime-life-insurance/one', [ImelifeController::class, 'postimeOne'])
        ->name('admin.ime.life.insurance.one');
    Route::get('ime-life-insurance/choose', [ImelifeController::class, 'imelifetwo'])
        ->name('admin.ime.life.two');
    Route::post('ime-life-insurance/two', [ImelifeController::class, 'postimeTwo'])
        ->name('admin.ime.life.insurance.two');
    Route::get('ime-life-insurance/confirm', [ImelifeController::class, 'imelifethree'])
        ->name('admin.ime.life.three');
    Route::post('ime-life-insurance/three', [ImelifeController::class, 'postimeThree'])
        ->name('admin.ime.life.insurance.three');
    Route::get('ime-life-insurance/personal-info', [ImelifeController::class, 'imelifefour'])
        ->name('admin.ime.life.four');
    Route::post('ime-life-insurance/four', [ImelifeController::class, 'postimefour'])
        ->name('admin.ime.life.insurance.four');
    Route::get('ime-life-insurance/details-of-plan', [ImelifeController::class, 'imelifefive'])
        ->name('admin.ime.life.five');
    Route::post('ime-life-insurance/final-confirmation', [ImelifeController::class, 'postimefive'])
        ->name('admin.ime.life.insurance.five');
    Route::get('ime-life-insurance/final-details-of-plan', [ImelifeController::class, 'imelifesix'])
        ->name('admin.ime.life.six');

    Route::get('paybackSchedule', [\App\Http\Controllers\PaybackScheduleController::class, 'index'])->name('admin.payback.index');
    Route::get('paybackSchedule/create', [\App\Http\Controllers\PaybackScheduleController::class, 'create'])->name('admin.payback.create');
    Route::post('paybackSchedule/create', [\App\Http\Controllers\PaybackScheduleController::class, 'store'])->name('admin.payback.store');
    Route::get('paybackSchedule/edit/{id}', [\App\Http\Controllers\PaybackScheduleController::class, 'edit'])->name('admin.payback.edit');
    Route::post('paybackSchedule/edit/{id}', [\App\Http\Controllers\PaybackScheduleController::class, 'update'])->name('admin.payback.update');
    Route::get('paybackSchedule/delete/{id}', [\App\Http\Controllers\PaybackScheduleController::class, 'destroy'])->name('admin.payback.destroy');

    Route::get('messages', [\App\Http\Controllers\MessagesController::class, 'index'])->name('admin.message.index');
    Route::post('messages/update/{id}', [\App\Http\Controllers\MessagesController::class, 'update'])->name('admin.message.update');
    Route::get('messages/show/{id}', [\App\Http\Controllers\MessagesController::class, 'show'])->name('admin.message.show');
    Route::delete('messages/delete/{id}', [\App\Http\Controllers\MessagesController::class, 'delete'])->name('admin.message.delete');

    Route::get('general-setting/contact', [\App\Http\Controllers\GeneralSettingController::class, 'contactList'])->name('general-setting.contact');
    Route::get('general-setting/contact/create', [\App\Http\Controllers\GeneralSettingController::class, 'contactCreate'])->name('general-setting.contact.create');
    Route::get('general-setting/contact/edit/{id}', [\App\Http\Controllers\GeneralSettingController::class, 'contactEdit'])->name('general-setting.contact.edit');
});
Route::resources([
    'companies' => CompaniesController::class,
    'loadingcharges' => LoadingChargeController::class,
    'premium' => PremiumController::class,
    'testimonial' => \App\Http\Controllers\TestimonialController::class,
    'association' => \App\Http\Controllers\AssociationController::class,
    'why-us' => \App\Http\Controllers\WhyUsController::class,
    'why-different' => \App\Http\Controllers\WhyDifferentController::class,
    'about-us' => \App\Http\Controllers\AboutUsController::class,
    'values' => \App\Http\Controllers\ValuesController::class,
    'social-link' => \App\Http\Controllers\SocialLinkController::class,
    'team' => \App\Http\Controllers\TeamController::class,
    'crcrate' => \App\Http\Controllers\CrcRateController::class,
    'general-setting' => \App\Http\Controllers\GeneralSettingController::class,
    'api-key' => \App\Http\Controllers\ApiKeyController::class,
    'paying-term' => \App\Http\Controllers\PayingTermController::class,
    'age-difference' => \App\Http\Controllers\CoupleAgeDifferenceController::class,
    'benefit' => \App\Http\Controllers\BenefitController::class,
]);
Route::get('crc/delete/{id}', [App\Http\Controllers\CrcRateController::class, 'delete'])->name('crcrate.delete');
Route::get('loading/delete/{id}', [App\Http\Controllers\LoadingChargeController::class, 'delete'])->name('loadingcharge.delete');
Route::post('association/status/{id}', [\App\Http\Controllers\AssociationController::class, 'statusChange'])->name('association.change.status');
Route::post('testimonial/status/{id}', [\App\Http\Controllers\TestimonialController::class, 'statusChange'])->name('testimonial.change.status');
Route::post('team/status/{id}', [\App\Http\Controllers\TeamController::class, 'statusChange'])->name('team.change.status');

Route::get('contact', [App\Http\Controllers\FrontendController::class, 'contact'])->name('contact');
Route::post('contact', [App\Http\Controllers\FrontendController::class, 'contactStore'])->name('contact.message');


Route::middleware('access:create-leads')->prefix('admin/leadcategories')->name('admin.leadcategories.')->group(function () {
    Route::resource('leadsource', \App\Http\Controllers\LeadSourceController::class)->except('show');
    Route::resource('leadtypes', \App\Http\Controllers\LeadTypeController::class)->except('create', 'show');
});

Route::middleware('access:create-leads')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('leads', \App\Http\Controllers\LeadController::class);
    Route::get('customers', [App\Http\Controllers\LeadController::class, 'customersList'])->name('leads.customers');
    // Route::get('/get-city-list/{province_id}','rajaongkirController@getCityList');

    Route::get('getCityList/{id}', [App\Http\Controllers\LeadController::class, 'getCityList']);
    Route::post('leads/create/client', [App\Http\Controllers\LeadController::class, 'makeUser'])->name('lead.make.user');
    Route::post('leads/update', [App\Http\Controllers\LeadController::class, 'update'])->name('lead.update');
    Route::get('leads/delete/{id}', [App\Http\Controllers\LeadController::class, 'delete'])->name('leads.delete');

    Route::get('lead/getleadremarks/{id}', [App\Http\Controllers\LeadController::class, 'GetRemarkList'])->name('leads.remarklist');
    Route::post('lead/remarks/', [App\Http\Controllers\LeadController::class, 'remark'])->name('leads.remarks');
    Route::post('lead/meetings/', [App\Http\Controllers\LeadController::class, 'meeting'])->name('leads.meetings');
    Route::get('lead/getleadmeetings/{id}', [App\Http\Controllers\LeadController::class, 'GetMeetingList'])->name('leads.meetinglist');
});

Route::middleware('access:create-policy')->prefix('admin/policycategories')->name('admin.policycategories.')->group(function () {
    Route::resource('sub', \App\Http\Controllers\PolicySubCategoryController::class)->except('create', 'show');
    Route::resource('type', \App\Http\Controllers\PolicyTypeController::class)->except('create', 'show');
});

Route::get('/admin/privilege/permission_roles/getpermission_rolesJson', [App\Http\Controllers\PermissionRoleController::class, 'getpermission_rolesJson'])->name('permission_roles.getdatajson');
Route::middleware('access:create-user')->prefix('admin/privilege')->name('admin.privilege.')->group(function () {
    Route::resource('permission', \App\Http\Controllers\PermissionController::class);
    Route::resource('permission_roles', \App\Http\Controllers\PermissionRoleController::class);
    Route::resource('role', \App\Http\Controllers\RoleController::class);
    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::put('user/change/status/{user}', ['as' => 'user.change.status', 'uses' => '\App\Http\Controllers\UserController@changeStatus']);
    Route::get('/login/user/{id}', [\App\Http\Controllers\UserController::class, 'manuallogin'])->name('login.as.user');
    Route::get('/user/list/excel', [\App\Http\Controllers\UserController::class, 'downloadExcel'])->name('user.excel');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/customer-kyc/{id}', [\App\Http\Controllers\KYCController::class, 'customerKyc'])->name('customer.kyc');
});

Route::middleware(['access:premium-calculation', 'agent:NonLife', 'cors', 'api'])->prefix('nonLife/calculator')->name('nonLife.calculator.')->group(function () {
    Route::get('motor', [App\Http\Controllers\NonLifeCalculatorController::class, 'bikeCalculator'])->name('bike');
    Route::post('motor', [App\Http\Controllers\NonLifeCalculatorController::class, 'calculationMotor'])->name('bike.first.party.calculate');
    Route::post('customer/select', [App\Http\Controllers\NonLifeCalculatorController::class, 'selectCustomer'])->name('bike.customer.select');
    Route::post('motor-payment', [App\Http\Controllers\NonLifeCalculatorController::class, 'paymentBikeFirstParty'])->name('bike.first.party.payment');
    Route::post('compulsary-excess', [App\Http\Controllers\NonLifeCalculatorController::class, 'compulsaryExcess'])->name('bike.first.party.compulsary.excess');
    Route::post('excess-damage', [App\Http\Controllers\NonLifeCalculatorController::class, 'excessDamage'])->name('motor.excess.damage');
    Route::post('manufacture-model', [App\Http\Controllers\NonLifeCalculatorController::class, 'getModel'])->name('bike.first.party.manufacture.model');
    Route::post('make-draft-policy', [App\Http\Controllers\NonLifeCalculatorController::class, 'makeDraftPolicy'])->name('make.draft.policy');
    Route::get('make-policy', [App\Http\Controllers\NonLifeCalculatorController::class, 'makeOnlinePolicy'])->name('motor.make.policy');
    Route::get('pdf-view', [App\Http\Controllers\NonLifeCalculatorController::class, 'loadPdf'])->name('pdf.load');
    Route::get('car', [App\Http\Controllers\NonLifeCalculatorController::class, 'carCalculator'])->name('car');
    Route::get('commercial-car', [App\Http\Controllers\NonLifeCalculatorController::class, 'commercialCarCalculator'])->name('commercial.car');
    Route::get('policy-details', [App\Http\Controllers\NonLifeCalculatorController::class, 'policyDone'])->name('policy.done');
    Route::get('policy-view', [App\Http\Controllers\NonLifeCalculatorController::class, 'viewPolicy'])->name('policy.view');
    Route::get('draft-policy-view', [App\Http\Controllers\NonLifeCalculatorController::class, 'viewDraftPolicy'])->name('draft.policy.view');
    Route::get('imepay/success', [App\Http\Controllers\NonLifeCalculatorController::class, 'imePaySuccess'])->name('imepay.success');
    Route::get('imepay/unsuccess', [App\Http\Controllers\NonLifeCalculatorController::class, 'imePayCancil'])->name('imepay.cancil');
    Route::post('category-type', [App\Http\Controllers\NonLifeCalculatorController::class, 'getCatType'])->name('motor.category.type');
    Route::get('debit-note', [App\Http\Controllers\NonLifeCalculatorController::class, 'getDebitNote'])->name('motor.make.debit.note');
});

Route::middleware('auth')->prefix('user/kyc')->group(function () {
    Route::get('entry', [App\Http\Controllers\KYCController::class, 'index'])->name('user.kyc.entry');
    Route::get('entry', [App\Http\Controllers\KYCController::class, 'index'])->name('user.kyc.entry');
    Route::post('entry', [App\Http\Controllers\KYCController::class, 'store'])->name('user.kyc.store');
    Route::post('get-district', [App\Http\Controllers\KYCController::class, 'getDistrict'])->name('province.district');
    Route::post('get-mnuvdc', [App\Http\Controllers\KYCController::class, 'getMnuVdc'])->name('district.mnuvdc');
});
Route::get('life/rate/validate', [App\Http\Controllers\LifeCalculatorController::class, 'validateRate'])->name('life.rate.validate');
Route::get('user/profile/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('user.profile.edit');
Route::post('user/profile/update/{id}', [App\Http\Controllers\UserController::class, 'modify'])->name('user.profile.modify');

 Route::fallback(function() {
     return view('fallback');
 });
require_once('calculator.php');
