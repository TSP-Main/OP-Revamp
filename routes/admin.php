<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;


Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.index');

Route::prefix('admin')->middleware(['check.userAuthCheck'])->group(function () {
    //Auth
    Route::match(['get', 'post'], '/passwordChange', [AuthController::class, 'password_change'])->name('admin.passwordChange');
    Route::match(['get', 'post'], '/setting', [AuthController::class, 'profile_setting'])->name('admin.profileSetting');

    //Dashboard
    Route::get('/faq', [DashboardController::class, 'faq'])->name('admin.faq');
    Route::get('/allReadNotifications', [DashboardController::class, 'read_notifications'])->name('admin.allReadNotifications');
    Route::get('/notifications/unread', [DashboardController::class, 'get_unread_notifications'])->name('admin.notifications.unread');
    Route::match(['get', 'post'], '/storeQuery', [DashboardController::class, 'store_query'])->name('admin.storeQuery');
    Route::match(['get', 'post'], '/storeCompanyDetails', [DashboardController::class, 'store_company_details'])->name('admin.storeCompanyDetails');
    Route::get('/dashboard', [DashboardController::class, 'admin_dashboard_detail'])->name('admin.dashboard.detail');
    Route::get('/contact', [DashboardController::class, 'contact'])->name('admin.contact');


    Route::get('/doctors', [SystemController::class, 'doctors'])->name('admin.doctors');
    Route::match(['get', 'post'], '/addDoctor',   [SystemController::class, 'add_doctor'])->name('admin.addDoctor');
    Route::match(['get', 'post'], '/storeDoctor', [SystemController::class, 'store_doctor'])->name('admin.storeDoctor');
    Route::get('/categories', [SystemController::class, 'categories'])->name('admin.categories');
    Route::match(['get', 'post'], '/addCategory', [SystemController::class, 'add_category'])->name('admin.addCategory');


    Route::match(['get', 'post'], '/deleteSOP/{id}', [SystemController::class, 'delete_sop'])->name('admin.deleteSOP');
    Route::match(['get', 'post'], '/addSOP/{id?}', [SystemController::class, 'add_sop'])->name('admin.addSOP');
    Route::match(['get', 'post'], '/storeSOP', [SystemController::class, 'store_sop'])->name('admin.storeSOP');
    Route::get('/sops', [SystemController::class, 'sops'])->name('admin.sops');

    Route::match(['get', 'post'], '/storeCategory', [SystemController::class, 'store_category'])->name('admin.storeCategory');
    Route::get('/subCategories', [SystemController::class, 'sub_categories'])->name('admin.subCategories');
    Route::get('/childCategories', [SystemController::class, 'child_categories'])->name('admin.childCategories');
    Route::get('/getParentCategory', [SystemController::class, 'get_parent_category'])->name('admin.getParentCategory');
    Route::get('/getSubCategory', [SystemController::class, 'get_sub_category'])->name('admin.getSubCategory');
    Route::get('/getChildCategory', [SystemController::class, 'get_child_category'])->name('admin.getChildCategory');
    Route::match(['get', 'post'], '/dellCategory', [SystemController::class, 'delete_category'])->name('admin.dellCategory');
    Route::match(['get', 'post'], '/categoriesTrash/{cat_type}', [SystemController::class, 'trash_categories'])->name('admin.categoriesTrash');

    Route::get('/collections', [SystemController::class, 'collections'])->name('admin.collections');
    Route::match(['get', 'post'], '/addCollection', [SystemController::class, 'add_collection'])->name('admin.addCollection');
    Route::match(['get', 'post'], '/storeCollection', [SystemController::class, 'store_collection'])->name('admin.storeCollection');

    Route::match(['get', 'post'], '/products', [ProductController::class, 'products'])->name('admin.prodcuts');
    Route::match(['get', 'post'], '/proTrash', [ProductController::class, 'product_trash'])->name('admin.proTrash');
    Route::match(['get', 'post'], '/productsLimits', [ProductController::class, 'products_limits'])->name('admin.prodcutsLimits');
    Route::match(['get', 'post'], '/featuredProducts', [ProductController::class, 'featured_products'])->name('admin.featuredProducts');
    Route::match(['get', 'post'], '/storeFeaturedProducts', [ProductController::class, 'store_featured_products'])->name('admin.storeFeaturedProducts');
    Route::match(['get', 'post'], '/deleteFeaturedProducts', [ProductController::class, 'delete_featured_products'])->name('admin.deleteFeaturedProducts');
    Route::match(['get', 'post'], '/importedProducts', [ProductController::class, 'imported_products'])->name('admin.importedProdcuts');
    Route::get('/importProducts', [ProductController::class, 'import_products'])->name('admin.importProducts');
    Route::post('/importProducts', [ProductController::class, 'store_import_products'])->name('admin.importProducts');
    Route::match(['get', 'post'], '/addProduct', [ProductController::class, 'add_product'])->name('admin.addProduct');
    Route::match(['get', 'post'], '/storeProduct', [ProductController::class, 'store_product'])->name('admin.storeProduct');
    Route::match(['get', 'post'], '/deleteProductAttribute', [ProductController::class, 'delete_product_attribute'])->name('admin.deleteProductAttribute');
    Route::match(['get', 'post'], '/updateBuyLimits', [ProductController::class, 'update_buy_limits'])->name('admin.updateBuyLimits');
    Route::match(['get', 'post'], '/updateStatus', [ProductController::class, 'update_status'])->name('admin.updateStatus');
    Route::match(['get', 'post'], '/searchProducts', [ProductController::class, 'search_products'])->name('admin.searchProducts');
    Route::match(['get', 'post'], '/exportProductsCSV', [ProductController::class, 'exportCSV'])->name('admin.exportProductsCSV');

    Route::get('/admins', [SystemController::class, 'admins'])->name('admin.admins');
    Route::match(['get', 'post'], '/addAdmin',   [SystemController::class, 'add_admin'])->name('admin.addAdmin');
    Route::match(['get', 'post'], '/storeAdmin', [SystemController::class, 'store_admin'])->name('admin.storeAdmin');
    Route::get('/users', [SystemController::class, 'users'])->name('admin.users');

    Route::get('/questionCategories', [SystemController::class, 'question_categories'])->name('admin.questionCategories');
    Route::match(['get', 'post'], '/addQuestionCategory', [SystemController::class, 'add_question_category'])->name('admin.addQuestionCategory');
    Route::post('/storeQuestionCategory', [SystemController::class, 'store_question_category'])->name('admin.storeQuestionCategory');
    Route::get('/questions', [SystemController::class, 'questions'])->name('admin.questions');
    Route::get('/faqQuestions', [SystemController::class, 'faq_questions'])->name('admin.faqQuestions');
    Route::match(['get', 'post'], '/StorefaqQuestions', [SystemController::class, 'store_faq_question'])->name('admin.StorefaqQuestions');
    Route::match(['get', 'post'], '/addfaqQuestion', [SystemController::class, 'add_faq_question'])->name('admin.addfaqQuestion');
    Route::match(['get', 'post'], '/addQuestion', [SystemController::class, 'add_question'])->name('admin.addQuestion');
    Route::match(['get', 'post'], '/storeQuestion', [SystemController::class, 'store_question'])->name('admin.storeQuestion');
    Route::get('/assignQuestion', [SystemController::class, 'assign_question'])->name('admin.assignQuestion');
    Route::match(['get', 'post'], '/getAssignQuestion', [SystemController::class, 'get_assign_quest'])->name('admin.getAssignQuestion');
    Route::match(['get', 'post'], '/storeAssignQuestion', [SystemController::class, 'store_assign_quest'])->name('admin.storeAssignQuestion');
    Route::post('/questionMapping', [SystemController::class, 'question_mapping'])->name('admin.qustionMapping');
    Route::get('/questionDetail', [SystemController::class, 'question_detail'])->name('admin.qustionDetail');
    Route::get('/getDp_questions', [SystemController::class, 'get_dp_questions'])->name('admin.getDp_questions');
    Route::get('/pMedGQ', [SystemController::class, 'p_med_general_questions'])->name('admin.pMedGQ');
    Route::get('/prescriptionMedGQ', [SystemController::class, 'prescription_med_general_questions'])->name('admin.prescriptionMedGQ');
    Route::match(['get', 'post'], '/questionsTrash/{q_type}', [SystemController::class, 'trash_questions'])->name('admin.questionsTrash');
    Route::match(['get', 'post'], '/dellQuestion', [SystemController::class, 'delete_question'])->name('admin.dellQuestion');
    Route::match(['get', 'post'], '/gpLocations', [SystemController::class, 'gp_locations'])->name('admin.gpLocations');

    Route::get('/comments/id', [SystemController::class, 'comments'])->name('admin.comments');
    Route::match(['get', 'post'], '/commentStore', [SystemController::class, 'comment_store'])->name('admin.commentStore');

    Route::get('/ordersReceived', [SystemController::class, 'orders_recieved'])->name('admin.ordersRecieved');
    Route::get('/ordersAll', [SystemController::class, 'all_orders'])->name('admin.allOrders');
    Route::get('/ordersUnpaid', [SystemController::class, 'unpaid_orders'])->name('admin.unpaidOrders');
    Route::get('/ordersCreated', [SystemController::class, 'orders_created'])->name('admin.ordersCreated');
    Route::post('/duplicate-order', [SystemController::class, 'duplicate_Order'])->name('admin.duplicateOrder');

    Route::match(['get', 'post'], '/addOrder', [SystemController::class, 'add_order'])->name('admin.addOrder');
    Route::match(['get', 'post'], '/storeOder', [SystemController::class, 'store_order'])->name('admin.storeOder');
    Route::get('/ordersRefunded', [SystemController::class, 'orders_refunded'])->name('admin.ordersRefunded');
    Route::get('/doctorsApproval', [SystemController::class, 'doctors_approval'])->name('admin.doctorsApproval');
    Route::get('/dispensaryApproval', [SystemController::class, 'dispensary_approval'])->name('admin.dispensaryApproval');
    Route::get('/ordersShiped', [SystemController::class, 'orders_shiped'])->name('admin.ordersShiped');
    Route::get('/orders-ShippingFail', [SystemController::class, 'orders_unshipped'])->name('admin.ordersShippingFail');
    Route::get('/ordersAudit', [SystemController::class, 'orders_audit'])->name('admin.ordersAudit');
    Route::get('/gpaLeters', [SystemController::class, 'gpa_letters'])->name('admin.gpaLeters');
    Route::get('/orderDetail/{id}', [SystemController::class, 'order_detail'])->name('admin.orderDetail');
    Route::get('/consultationView/{odd_id}', [SystemController::class, 'consultation_view'])->name('admin.consultationView');
    Route::get('/consultationUserView/{odd_id}', [SystemController::class, 'consultation_user_view'])->name('admin.consultationUserView');
    Route::match(['get', 'post'], '/changeStatus', [SystemController::class, 'change_status'])->name('admin.changeStatus');
    Route::match(['get', 'post'], '/refundOrder', [SystemController::class, 'refund_order'])->name('admin.refundOrder');
    Route::match(['get', 'post'], '/createShippingOrder', [SystemController::class, 'create_shiping_order'])->name('admin.createShippingOrder');
    Route::match(['get', 'post'], '/getShippingOrder/{id}', [SystemController::class, 'get_shiping_order'])->name('admin.getShippingOrder');

    Route::get('/prescriptionOrders', [OrderController::class, 'prescription_orders'])->name('admin.prescriptionOrders');
    Route::get('/onlineClinicOrders', [OrderController::class, 'online_clinic_orders'])->name('admin.onlineClinicOrders');
    Route::get('/shopOrders', [OrderController::class, 'shop_orders'])->name('admin.shopOrders');

    Route::match(['get', 'post'], '/updateAdditionalNote', [SystemController::class, 'update_additional_note'])->name('admin.updateAdditionalNote');
    Route::match(['get', 'post'], '/updateShippingAddress', [SystemController::class, 'update_shipping_address'])->name('admin.updateShippingAddress');
    Route::delete('/deleteVariant', [ProductController::class, 'delete_variant'])->name('admin.deleteVariant');

    Route::match(['get', 'post'], '/AddPMedQuestion', [SystemController::class, 'Add_PMedQuestion'])->name('Add.P.Med.Questions');
    Route::match(['get', 'post'], '/createPMedQuestion', [SystemController::class, 'create_PMedQuestion'])->name('admin.storePMedQuestion');
    Route::get('/getPMedDp_questions', [SystemController::class, 'get_PMeddp_questions'])->name('admin.getPMedDp_questions');
    Route::post('/update-question-order', [SystemController::class, 'updateOrder'])->name('Update.Question.Order');
    Route::post('/delete-question', [SystemController::class, 'deletePMedQuestion'])->name('Delete.P.Med.Question');

    Route::match(['get', 'post'], '/AddPrescriptionMedQuestion', [SystemController::class, 'Add_PrescriptionMedQuestion'])->name('Add.Prescription.Med.Questions');
    Route::match(['get', 'post'], '/createPrescriptionMedQuestion', [SystemController::class, 'create_PrescriptionMedQuestion'])->name('admin.storePrescriptionMedQuestion');
    Route::get('/getPrescription_MedDp_questions', [SystemController::class, 'get_PrescriptionMeddp_questions'])->name('admin.getPrescriptionMedDpQuestions');
    Route::post('/update-prescription-question-order', [SystemController::class, 'updatePrescriptionQuestionOrder'])->name('Update.PrescriptionQuestion.Order');
    Route::post('/delete-prescription-question', [SystemController::class, 'deletePrescriptionMedQuestion'])->name('Delete.Prescription.Med.Question');

    Route::match(['get', 'post'], '/VetPrescriptions', [SystemController::class, 'vet_prescriptions'])->name('admin.VetPrescriptions');
    Route::match(['get', 'post'], '/deleteHumanForm', [SystemController::class, 'delete_human_form'])->name('admin.deleteHumanForm');


});
