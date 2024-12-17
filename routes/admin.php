<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.index');
Route::prefix('admin')->middleware(['check.userAuthCheck'])->group(callback: function () {
    //Auth
    Route::match(['get', 'post'], '/passwordChange', [AuthController::class, 'password_change'])->name('admin.passwordChange');

    //Dashboard
    Route::get('/faq', [DashboardController::class, 'faq'])->name('admin.faq');
    Route::get('/allReadNotifications', [DashboardController::class, 'read_notifications'])->name('admin.allReadNotifications');
    Route::get('/notifications/unread', [DashboardController::class, 'get_unread_notifications'])->name('admin.notifications.unread');
    Route::match(['get', 'post'], '/storeQuery', [DashboardController::class, 'store_query'])->name('admin.storeQuery');
    Route::match(['get', 'post'], '/storeCompanyDetails', [DashboardController::class, 'store_company_details'])->name('admin.storeCompanyDetails');
    Route::get('/dashboard', [DashboardController::class, 'admin_dashboard_detail'])->name('admin.dashboard.detail');
    Route::get('/contact', [DashboardController::class, 'contact'])->name('admin.contact');

    //Product Controller
    Route::match(['get', 'post'], '/products', [ProductController::class, 'products'])->name('admin.products');
    Route::match(['get', 'post'], '/proTrash', [ProductController::class, 'product_trash'])->name('admin.proTrash');
    Route::match(['get', 'post'], '/productsLimits', [ProductController::class, 'products_limits'])->name('admin.productsLimits');
    Route::match(['get', 'post'], '/lowstockProducts', [ProductController::class, 'lowlimit_products'])->name('admin.lowlimitProducts');
    Route::match(['get', 'post'], '/featuredProducts', [ProductController::class, 'featured_products'])->name('admin.featuredProducts');
    Route::match(['get', 'post'], '/storeFeaturedProducts', [ProductController::class, 'store_featured_products'])->name('admin.storeFeaturedProducts');
    Route::match(['get', 'post'], '/deleteFeaturedProducts', [ProductController::class, 'delete_featured_products'])->name('admin.deleteFeaturedProducts');
    Route::match(['get', 'post'], '/importedProducts', [ProductController::class, 'imported_products'])->name('admin.importedProducts');
    Route::get('/importProducts', [ProductController::class, 'import_products'])->name('admin.importProducts');
    Route::post('/importProducts', [ProductController::class, 'store_import_products'])->name('admin.importProducts');
    Route::match(['get', 'post'], '/addProduct', [ProductController::class, 'add_product'])->name('admin.addProduct');
    Route::match(['get', 'post'], '/storeProduct', [ProductController::class, 'store_product'])->name('admin.storeProduct');
    Route::match(['get', 'post'], '/deleteProductAttribute', [ProductController::class, 'delete_product_attribute'])->name('admin.deleteProductAttribute');
    Route::match(['get', 'post'], '/updateBuyLimits', [ProductController::class, 'update_buy_limits'])->name('admin.updateBuyLimits');
    Route::match(['get', 'post'], '/updateStatus', [ProductController::class, 'update_status'])->name('admin.updateStatus');
    Route::match(['get', 'post'], '/searchProducts', [ProductController::class, 'search_products'])->name('admin.searchProducts');
    Route::match(['get', 'post'], '/exportProductsCSV', [ProductController::class, 'exportCSV'])->name('admin.exportProductsCSV');
    Route::delete('/deleteVariant', [ProductController::class, 'delete_variant'])->name('admin.deleteVariant');

    //Order controller
    Route::get('/prescriptionOrders', [OrderController::class, 'prescription_orders'])->name('admin.prescriptionOrders');
    Route::get('/onlineClinicOrders', [OrderController::class, 'online_clinic_orders'])->name('admin.onlineClinicOrders');
    Route::get('/shopOrders', [OrderController::class, 'shop_orders'])->name('admin.shopOrders');

    //System Controller
    Route::get('/admins', [AdminDashboardController::class, 'admins'])->name('admin.admins');
    Route::match(['get', 'post'], '/addAdmin',   [AdminDashboardController::class, 'add_admin'])->name('admin.addAdmin');
    Route::match(['get', 'post'], '/storeAdmin', [AdminDashboardController::class, 'store_admin'])->name('admin.storeAdmin');
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('admin.users');

    //Pharmacy Role 
    Route::get('/pharmacy', [AdminDashboardController::class, 'pharmacy'])->name('admin.pharmacy');
    Route::match(['get', 'post'], '/addPharmacy',   [AdminDashboardController::class, 'add_pharmacy'])->name('admin.addPharmacy');
    Route::match(['get', 'post'], '/storePharmacy', [AdminDashboardController::class, 'store_pharmacy'])->name('admin.storePharmacy');

    Route::get('/questionCategories', [AdminDashboardController::class, 'question_categories'])->name('admin.questionCategories');
    Route::match(['get', 'post'], '/addQuestionCategory', [AdminDashboardController::class, 'add_question_category'])->name('admin.addQuestionCategory');
    Route::post('/storeQuestionCategory', [AdminDashboardController::class, 'store_question_category'])->name('admin.storeQuestionCategory');
    Route::get('/questions', [AdminDashboardController::class, 'questions'])->name('admin.questions');
    Route::get('/faqQuestions', [AdminDashboardController::class, 'faq_questions'])->name('admin.faqQuestions');
    Route::match(['get', 'post'], '/StorefaqQuestions', [AdminDashboardController::class, 'store_faq_question'])->name('admin.StorefaqQuestions');
    Route::match(['get', 'post'], '/addfaqQuestion', [AdminDashboardController::class, 'add_faq_question'])->name('admin.addfaqQuestion');
    Route::match(['get', 'post'], '/addQuestion', [AdminDashboardController::class, 'add_question'])->name('admin.addQuestion');
    Route::match(['get', 'post'], '/storeQuestion', [AdminDashboardController::class, 'store_question'])->name('admin.storeQuestion');
    Route::get('/assignQuestion', [AdminDashboardController::class, 'assign_question'])->name('admin.assignQuestion');
    Route::match(['get', 'post'], '/getAssignQuestion', [AdminDashboardController::class, 'get_assign_quest'])->name('admin.getAssignQuestion');
    Route::match(['get', 'post'], '/storeAssignQuestion', [AdminDashboardController::class, 'store_assign_quest'])->name('admin.storeAssignQuestion');
    Route::post('/questionMapping', [AdminDashboardController::class, 'question_mapping'])->name('admin.qustionMapping');
    Route::get('/questionDetail', [AdminDashboardController::class, 'question_detail'])->name('admin.qustionDetail');
    Route::get('/getDp_questions', [AdminDashboardController::class, 'get_dp_questions'])->name('admin.getDp_questions');
    Route::get('/pMedGQ', [AdminDashboardController::class, 'p_med_general_questions'])->name('admin.pMedGQ');
    Route::get('/prescriptionMedGQ', [AdminDashboardController::class, 'prescription_med_general_questions'])->name('admin.prescriptionMedGQ');
    Route::match(['get', 'post'], '/questionsTrash/{q_type}', [AdminDashboardController::class, 'trash_questions'])->name('admin.questionsTrash');
    Route::match(['get', 'post'], '/dellQuestion', [AdminDashboardController::class, 'delete_question'])->name('admin.dellQuestion');
    Route::match(['get', 'post'], '/gpLocations', [AdminDashboardController::class, 'gp_locations'])->name('admin.gpLocations');

    Route::get('/comments/id', [AdminDashboardController::class, 'comments'])->name('admin.comments');
    Route::match(['get', 'post'], '/commentStore', [AdminDashboardController::class, 'comment_store'])->name('admin.commentStore');

    Route::get('/doctors', [AdminDashboardController::class, 'doctors'])->name('admin.doctors');
    Route::match(['get', 'post'], '/addDoctor',   [AdminDashboardController::class, 'add_doctor'])->name('admin.addDoctor');
    Route::match(['get', 'post'], '/storeDoctor', [AdminDashboardController::class, 'store_doctor'])->name('admin.storeDoctor');
    Route::get('/categories', [AdminDashboardController::class, 'categories'])->name('admin.categories');
    Route::match(['get', 'post'], '/addCategory', [AdminDashboardController::class, 'add_category'])->name('admin.addCategory');


    Route::match(['get', 'post'], '/deleteSOP/{id}', [AdminDashboardController::class, 'delete_sop'])->name('admin.deleteSOP');
    Route::match(['get', 'post'], '/addSOP/{id?}', [AdminDashboardController::class, 'add_sop'])->name('admin.addSOP');
    Route::match(['get', 'post'], '/storeSOP', [AdminDashboardController::class, 'store_sop'])->name('admin.storeSOP');
    Route::get('/sops', [AdminDashboardController::class, 'sops'])->name('admin.sops');

    Route::match(['get', 'post'], '/storeCategory', [AdminDashboardController::class, 'store_category'])->name('admin.storeCategory');
    Route::get('/subCategories', [AdminDashboardController::class, 'sub_categories'])->name('admin.subCategories');
    Route::get('/childCategories', [AdminDashboardController::class, 'child_categories'])->name('admin.childCategories');
    Route::get('/getParentCategory', [AdminDashboardController::class, 'get_parent_category'])->name('admin.getParentCategory');
    Route::get('/getSubCategory', [AdminDashboardController::class, 'get_sub_category'])->name('admin.getSubCategory');
    Route::get('/getChildCategory', [AdminDashboardController::class, 'get_child_category'])->name('admin.getChildCategory');
    Route::match(['get', 'post'], '/dellCategory', [AdminDashboardController::class, 'delete_category'])->name('admin.dellCategory');
    Route::match(['get', 'post'], '/categoriesTrash/{cat_type}', [AdminDashboardController::class, 'trash_categories'])->name('admin.categoriesTrash');

    Route::get('/collections', [AdminDashboardController::class, 'collections'])->name('admin.collections');
    Route::match(['get', 'post'], '/addCollection', [AdminDashboardController::class, 'add_collection'])->name('admin.addCollection');
    Route::match(['get', 'post'], '/storeCollection', [AdminDashboardController::class, 'store_collection'])->name('admin.storeCollection');

    Route::get('/ordersReceived', [AdminDashboardController::class, 'ordersReceived'])->name('admin.ordersRecieved');
    Route::get('/ordersAll', [AdminDashboardController::class, 'all_orders'])->name('admin.allOrders');
    Route::get('/ordersAllUser', [AdminDashboardController::class, 'user_all_orders'])->name('user.allOrders');
    Route::get('/orderOtc', [AdminDashboardController::class,'otc_orders'])->name('admin.otcorders');
    Route::get('/ordersUnpaid', [AdminDashboardController::class, 'unpaid_orders'])->name('admin.unpaidOrders');
    Route::get('/ordersCreated', [AdminDashboardController::class, 'orders_created'])->name('admin.ordersCreated');
    Route::post('/duplicate-order', [AdminDashboardController::class, 'duplicate_Order'])->name('admin.duplicateOrder');

    Route::match(['get', 'post'], '/addOrder', [AdminDashboardController::class, 'add_order'])->name('admin.addOrder');
    Route::match(['get', 'post'], '/storeOder', [AdminDashboardController::class, 'store_order'])->name('admin.storeOder');
    Route::get('/ordersRefunded', [AdminDashboardController::class, 'orders_refunded'])->name('admin.ordersRefunded');
    Route::get('/doctorsApproval', [AdminDashboardController::class, 'doctors_approval'])->name('admin.doctorsApproval');
    Route::get('/dispensaryApproval', [AdminDashboardController::class, 'dispensary_approval'])->name('admin.dispensaryApproval');
    Route::get('/ordersShipped', [AdminDashboardController::class, 'orders_shipped'])->name('admin.ordersShiped');
    Route::get('/orders-ShippingFail', [AdminDashboardController::class, 'orders_unshipped'])->name('admin.ordersShippingFail');
    Route::get('/ordersAudit', [AdminDashboardController::class, 'orders_audit'])->name('admin.ordersAudit');
    Route::get('/admin/orders/export-csv', [AdminDashboardController::class, 'exportOrdersCSV'])->name('admin.auditorders.exportCsv');
    Route::get('/admin/pomorders/export-csv', [AdminDashboardController::class, 'exportDoctorsApprovalCSV'])->name('admin.POMorders.exportCsv');
    Route::get('/gpaLeters', [AdminDashboardController::class, 'gpa_letters'])->name('admin.gpaLeters');
    Route::get('/orderDetail/{id}', [AdminDashboardController::class, 'order_detail'])->name('admin.orderDetail');
    Route::get('/consultationView/{odd_id}', [AdminDashboardController::class, 'consultation_view'])->name('admin.consultationView');
    Route::get('/consultationUserView/{odd_id}', [AdminDashboardController::class, 'consultation_user_view'])->name('admin.consultationUserView');
    Route::match(['get', 'post'],'/consultationEdit/{odd_id}', [AdminDashboardController::class, 'consultation_form_edit'])->name('admin.consultationFormEdit');
    Route::match(['get', 'post'], '/changeStatus', [AdminDashboardController::class, 'change_status'])->name('admin.changeStatus');
    Route::post('/changeProductstatus', [AdminDashboardController::class, 'changeProductStatus'])->name('admin.changeProductStatus');
    Route::match(['get', 'post'], '/refundOrder', [AdminDashboardController::class, 'refund_order'])->name('admin.refundOrder');
    Route::match(['get', 'post'], '/createShippingOrder', [AdminDashboardController::class, 'create_shipping_order'])->name('admin.createShippingOrder');
    Route::match(['get', 'post'], '/createBatchShipping', [AdminDashboardController::class, 'batchShipping'])->name('admin.batchShipping');
    Route::match(['get', 'post'], '/getShippingOrder/{id}', [AdminDashboardController::class, 'get_shipping_order'])->name('admin.getShippingOrder');

    Route::match(['get', 'post'], '/updateAdditionalNote', [AdminDashboardController::class, 'update_additional_note'])->name('admin.updateAdditionalNote');
    Route::match(['get', 'post'], '/updateShippingAddress', [AdminDashboardController::class, 'update_shipping_address'])->name('admin.updateShippingAddress');

    Route::match(['get', 'post'], '/AddPMedQuestion', [AdminDashboardController::class, 'Add_PMedQuestion'])->name('Add.P.Med.Questions');
    Route::match(['get', 'post'], '/createPMedQuestion', [AdminDashboardController::class, 'create_PMedQuestion'])->name('admin.storePMedQuestion');
    Route::get('/getPMedDp_questions', [AdminDashboardController::class, 'get_PMeddp_questions'])->name('admin.getPMedDp_questions');
    Route::post('/update-question-order', [AdminDashboardController::class, 'updateOrder'])->name('Update.Question.Order');
    Route::post('/delete-question', [AdminDashboardController::class, 'deletePMedQuestion'])->name('Delete.P.Med.Question');

    Route::match(['get', 'post'], '/AddPrescriptionMedQuestion', [AdminDashboardController::class, 'Add_PrescriptionMedQuestion'])->name('Add.Prescription.Med.Questions');
    Route::match(['get', 'post'], '/createPrescriptionMedQuestion', [AdminDashboardController::class, 'create_PrescriptionMedQuestion'])->name('admin.storePrescriptionMedQuestion');
    Route::get('/getPrescription_MedDp_questions', [AdminDashboardController::class, 'get_PrescriptionMeddp_questions'])->name('admin.getPrescriptionMedDpQuestions');
    Route::post('/update-prescription-question-order', [AdminDashboardController::class, 'updatePrescriptionQuestionOrder'])->name('Update.PrescriptionQuestion.Order');
    Route::post('/delete-prescription-question', [AdminDashboardController::class, 'deletePrescriptionMedQuestion'])->name('Delete.Prescription.Med.Question');

    Route::match(['get', 'post'], '/VetPrescriptions', [AdminDashboardController::class, 'vet_prescriptions'])->name('admin.VetPrescriptions');
    Route::match(['get', 'post'], '/deleteHumanForm', [AdminDashboardController::class, 'delete_human_form'])->name('admin.deleteHumanForm');

    Route::match(['get', 'post'], '/addDiscount', [DiscountController::class, 'add_discount'])->name('admin.addDiscount');
    Route::match(['get', 'post'], '/discounts', [DiscountController::class, 'discount'])->name('admin.Discount');
    Route::post( '/storeDiscount', [DiscountController::class, 'store'])->name('admin.storeDiscount');
    Route::get('/discounts/{discount?}', [DiscountController::class, 'edit'])->name('admin.editDiscount');
    Route::get('/SubCategoryDiscount', [DiscountController::class, 'getSubCategories'])->name('admin.getSubCategories');
    Route::get('/ChildCategoryDiscount', [DiscountController::class, 'getChildCategories'])->name('admin.getChildCategories');
    Route::get('/VariantsDiscount', [DiscountController::class, 'getProductVariants']);


});
