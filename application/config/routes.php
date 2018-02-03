<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'customer/Welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
/* Under Construction */
$route['under_construction']   = 'admin/Login/underconstruction';
/*Admin Panel Routing Starts*/


/* Login Panel */
//$route['login']             	= 'admin/Login/login';                  //login page
$route['admin']             	  = 'admin/Login/login';                  //login page
$route['login_check']        	  = 'admin/Login/signIn';                 //check admin credentials
$route['forgot_password']   	  = 'admin/Login/forgetPassword';         //check admin credentials
$route['reset_password/(:any)']   = 'admin/Login/changePassword/$1';      //Reset Passwords
$route['mypush']                  = 'admin/Mypush/sendpush';              //Send Push Alert - Cron Jobs 
$route['admin-dashboard']         = 'admin/Manager/dashboard';            // Admin Dashboard

$route['care-givers']               = 'admin/Manager/care_givers';           // Care Giver List
$route['add-care-giver']            = 'admin/Manager/add_care_giver';        // Add Care Giver
$route['care-giver-details']        = "admin/Manager/care_giver_details";    // View/Edit Care Giver
$route['edit-care-giver-details/(:num)']        = "admin/Manager/edit_care_giver_details/$1";    // View/Edit Care Giver
$route['care-giver-details/(:num)'] = "admin/Manager/care_giver_details/$1"; // View/Edit Care Giver
$route['delete-care-giver/(:num)'] = "admin/Manager/delete_care_giver_details/$1"; // View/Edit Care Giver

$route['orders']                  = 'admin/Manager/orders';               // Admin Orders
$route['order-detail']            = "admin/Manager/order_detail";         // View/Edit Order Detail
$route['order-detail/(:num)']     = "admin/Manager/order_detail/$1";      // View/Edit Order Detail
$route['fetch-drivers-list']      = 'admin/Manager/fetch_drivers_list'; //Doctor Details

$route['minimum-delivery-prices'] = 'admin/Setting/minimum_delivery_prices'; // Minimum Delivery Prices
$route['update-minimum-delivery-price']  = 'admin/Setting/update_minimum_delivery_price'; // Update Minimum Delivery Prices
$route['change-minimum-delivery-status'] = 'admin/Setting/change_min_dvry_price_status'; // Change Min Delivery Status
$route['change-minimum-delivery-status/(:num)'] = 'admin/Setting/change_min_dvry_price_status/$1'; // Change Min Delivery Status


$route['restricted-areas']        = 'admin/Setting/manage_restricted_areas'; // Manage Restricted Areas
$route['add-restricted-area']     = 'admin/Setting/add_restricted_area';     // Add Restricted Area
$route['view-restricted-area']    = "admin/Setting/view_restricted_area";    // View Restricted Area
$route['view-restricted-area/(:num)']   = "admin/Setting/view_restricted_area/$1";    // View Restricted Areas
$route['delete-restricted-area']        = 'admin/Setting/delete_restricted_area';     // Delete Restricted Areas
$route['delete-restricted-area/(:num)'] = 'admin/Setting/delete_restricted_area/$1';  // Delete Restricted Areas

$route['manage-warehouses']       = 'admin/Setting/manage_warehouses';    // Manage Ware Houses
$route['add-warehouse']           = 'admin/Setting/add_warehouse';        // Add Ware House
$route['view-warehouse']          = "admin/Setting/view_warehouse";       // View view-warehouse
$route['view-warehouse/(:num)']   = "admin/Setting/view_warehouse/$1";    // View view-warehouse
$route['delete-warehouse']        = 'admin/Setting/delete_warehouse';     // Delete Ware House
$route['delete-warehouse/(:num)'] = 'admin/Setting/delete_warehouse/$1';  // Delete Ware House
$route['change-warehouse-status'] = 'admin/Setting/change_warehouse_status';           // Change Warehouse Status
$route['change-warehouse-status/(:num)'] = 'admin/Setting/change_warehouse_status/$1'; // Change WarehouseStatus

$route['manage-users']            = 'admin/Setting/manage_users';         // Manage Users Setting
$route['view-user']               = "admin/Setting/view_admin_user";      //View Admin User
$route['view-user/(:num)']        = "admin/Setting/view_admin_user/$1";   //View Admin User
$route['delete-user']             = "admin/Setting/delete_user";          //Delete User
$route['delete-user/(:num)']      = "admin/Setting/delete_user/$1";       //Delete User
$route['add-user']                = 'admin/Setting/add_user';             // Add Users Setting

$route['manage-products']         = 'admin/Setting/manage_products';               // Manage Products 
$route['check-product-family']    = 'admin/Setting/check_product_family';          // Check family exist
$route['add-product-family']      = 'admin/Setting/add_product_family';            // Add Product family
$route['view-product-family']         = "admin/Setting/view_product_family";       //View Product Family
$route['view-product-family/(:num)']  = "admin/Setting/view_product_family/$1";    //View Product Family
$route['change-family-status']    = 'admin/Setting/change_family_status';          // Change family Status
$route['change-family-status/(:num)'] = 'admin/Setting/change_family_status/$1';   // Change family Status
$route['delete-product-family']   = 'admin/Setting/delete_product_family';         // Delete Product family
$route['delete-product-family/(:num)'] = 'admin/Setting/delete_product_family/$1'; // Delete Product family


$route['coupons']                 = 'admin/Manager/coupons';             // All Coupon List
$route['add-coupon']              = 'admin/Manager/add_coupon';          // Add New Coupon
$route['view-coupon']             = 'admin/Manager/view_coupon';         // View / Edit Coupon
$route['view-coupon/(:num)']      = 'admin/Manager/view_coupon/$1';         // View / Edit Coupon

$route['messages']                = 'admin/Manager/messages';             //get all Messages 
$route['add-message']             = 'admin/Manager/add_message';          //Add New Message

$route['categories']              = 'admin/Manager/categories';           //get all categories
$route['add-category']            = 'admin/Manager/add_category';         //Add New category
$route['check-category']          = 'admin/Manager/check_category';       //Add New category
$route['category-details/(:any)'] = 'admin/Manager/view_details/$1';      //get all categories

$route['products']                = 'admin/Manager/products';             //get all products
$route['add-product']             = 'admin/Manager/add_product';          //Add Product Details
$route['product-details/(:any)']  = 'admin/Manager/view_product/$1';      //View/EditProducts Details

$route['doctors']                 = 'admin/Manager/doctors';              //get all doctors
$route['add-doctor']              = 'admin/Manager/add_doctor';           //Doctor Details
$route['doctor-details/(:any)']   = 'admin/Manager/view_doctor/$1';       //Doctor Details
$route['appointment-userinfo']    = 'admin/Manager/appointment_userinfo'; //Doctor Details
$route['prescription-userinfo']   = 'admin/Manager/prescription_userinfo'; //Doctor Details

$route['save-drivers']      = 'admin/Driver/saveDriver';                //add drivers
$route['add-driver']        = 'admin/Driver/addDriver';                 //add drivers
$route['drivers']           = 'admin/Driver/getAllDrivers';             //get all drivers
$route['view-driver/(:any)']= 'admin/Driver/viewDriver/$1';//add drivers


$route['logout']                   = 'admin/Login/signOut'; 
$route['view-driver-detail/(:any)']= 'admin/Driver/view_driver_detail/$1'; 
$route['manageInventory/(:any)']   = 'admin/Driver/manageInventory/$1'; 
$route['get-template-item']        = 'admin/Driver/getTemplateItem'; 
$route['save-template-item']       = 'admin/Driver/saveTemplateItem'; 
$route['assing-template']          = 'admin/Driver/assignTemplate'; 
$route['searchItem']               = 'admin/Driver/searchItem'; 
//$route['assignPickups']            = 'admin/Driver/assignPickups'; 
$route['add-template']            = 'admin/Driver/addTemplate'; 
$route['remove-template']         = 'admin/Driver/removeTemplate'; 
$route['remove-assigned-product']  = 'admin/Driver/removeAssignedProduct'; 
$route['update-assigned-quantity'] = 'admin/Driver/updateAssignedQuantity'; 
$route['drivercompletedata']       = 'admin/Driver/drivercompletedata'; 
$route['customer-reviews/(:any)']  = 'admin/Driver/customerReviews/$1'; 
$route['block-driver/(:any)/(:any)'] = 'admin/Driver/blockDriver/$1/$1'; 
$route['view-shift-detailed-page/(:any)/(:any)'] = 'admin/Driver/viewShiftDetailedPage/$1/$1';
$route['driverShiftTimeEdit']   = 'admin/Driver/driverShiftTimeEdit';
$route['driverShiftAmountEdit'] = 'admin/Driver/driverShiftAmountEdit';
$route['update-worked-time']    = 'admin/Driver/updateWorkedTime';
$route['update-break-time']     = 'admin/Driver/updateBreakTime';
$route['edit-worked-time/(:any)/(:any)']= 'admin/Driver/editWorkedTime/$1/$1';
$route['edit-break-time/(:any)/(:any)']= 'admin/Driver/editbreakTime/$1/$1';


/*Customer sections starts here*/
$route['customers']    = 'admin/Customer/customersList';
$route['add-customer'] = 'admin/Customer/addCustomer';
$route['save-customer']= 'admin/Customer/saveCustomer';
$route['view-customer/(:any)']= 'admin/Customer/viewCustomerDetails/$1';

/*Customer Redeem Reward */
$route['customer-redeem-reward/(:any)']= 'admin/Customer/redeemReward/$1';


/* Doctor Panel */

$route['login']             = 'website/Login/login';//login page
$route['loginCheckWeb']     = 'website/Login/signIn';//check doctor credentials
$route['doctor']            = 'website/Login/login';//doctor dashboard
$route['dashboard']         = 'website/Doctor/dashboard';//doctor dashboard
$route['updateStatus']      = 'website/Doctor/updateStatus';//update doctor availablity
$route['updateDaysAndTime'] = 'website/Doctor/updateDaysAndTime';//update days and time of doctor
$route['updateDoctorSchedules']     = 'website/Doctor/updateDoctorSchedules';//doctor dashboard updating days and time of doctor
$route['appointments']      = 'website/Doctor/appointments';//appointments of doctor
$route['prescriptions']     = 'website/Doctor/prescriptions';//prescriptions of doctor
$route['analysis']          = 'website/Doctor/analysis'; //analysis of doctor
$route['generatePdf']       = 'website/Doctor/generatePdf';//generate Pdf
$route['changePassword']    = 'website/Login/Changepwd';//change password of doctor
//$route['clientCall/(:any)']      = 'website/Doctor/clientDetailedPage/$1';//client detailed page
$route['clientDetail/(:any)']       = 'website/Doctor/clientDetailedPage/$1';//client detailed page
$route['recommendation/(:any)']       = 'website/Doctor/recommendation/$1';//client detailed page
$route['prescriptionDetail/(:any)'] = 'website/Doctor/prescriptionDetail/$1';//prescription detailed page
$route['confirmAppointment']        = 'website/Doctor/confirmAppointment';//client appointment confirmation(ajax)
$route['cancelAppointment']         = 'website/Doctor/cancelAppointment';//client appointment cancel(ajax)
$route['rescheduleAppointment']     = 'website/Doctor/rescheduleAppointment';//client appointment reschedule(ajax)
$route['profile']           = 'website/Doctor/profile';//doctor profile
$route['updateProfile']     = 'website/Doctor/updateProfile';//Update doctor profile
$route['webLogout']         = 'website/Login/signOut';
$route['signatureUpload']   = 'website/Doctor/signatureUpload';
$route['updatePrescriptionNotes']     = 'website/Doctor/updatePrescriptionNotes';//Update prescription notes
$route['updatePrescriptionRecommendations']     = 'website/Doctor/updatePrescriptionRecommendations';//Update prescription recommendations
$route['check-incoming-call']   = 'website/Doctor/checkIncomingCall';

//customer referred users
$route['customer-referred_user/(:any)']= 'admin/Customer/getCustomerReferredUsers/$1';

$route['verify_prescription/(:any)']= 'admin/Manager/updatePrescriptionVerification/$1';
$route['reject_prescription']= 'admin/Manager/rejectPrescriptionStatus';

/********** Mobile web routes starts here **********************************/
/************* customer routes ****************************/

$route['user_authentication']   = 'customer/Customer/facebookLogin';
$route['cus-signup']            = 'customer/Customer/register';
$route['cus-login']             = 'customer/Customer/login';
$route['cus-splash']            = 'customer/Welcome/splash';
$route['cus-log-out']           = 'customer/Customer/logout';
$route['cus-profile-edit']      = 'customer/Customer/editProfile';
$route['cus-profile-view']      = 'customer/Customer/viewProfile';
$route['cus-home']              = 'customer/Customer/myProfile';
$route['cus-facebook-login']    = "customer/Fblogin/index";
$route['cus-forgot-password']   = "customer/Customer/forgotPassword";
$route['cus-change-password']   = "customer/Customer/changePassword";
$route['cus-social-share']      = "customer/Customer/socialShare";
$route['cus-settings']          = "customer/Customer/settings";

/************ prescription routes *************************/
$route['cus-new-prescription']                  = "customer/Prescription/consultations";
$route['cus-medical-license']                   = "customer/Prescription/medicalLicenceInfo";
$route['save-selected-consultations']           = "customer/Prescription/saveSelectedConsultations";
$route['cus-time-availability']                 = "customer/Prescription/cusTimeAvailability";
$route['save-selected-time']                    = "customer/Prescription/saveSelectedTime";
$route['cus-my-prescription']                   = "customer/Prescription/myPrescription";
$route['check-upcoming-appointment']            = "customer/Prescription/checkUpcomingAppointment";
$route['download-recommended-prescription']     = "customer/Prescription/downloadPrescription";
$route['check-for-doctor']                      = "customer/Payment/checkDoctorAvailbility";

/***************** payment routes *********************************************************/
$route['cus-prescription-payment']      = "customer/Payment/makePrescriptionPayment";
$route['cus-products-payment']          = "customer/Payment/makeProductsPayement";

/********************* video consultation call from customer *************/
$route['cus-video-consultation']        = "customer/Flash_phoner/makeVideoCall";
$route['save-video-room']               = 'customer/Flash_phoner/saveVideoRoom';
$route['remove-video-room']             = 'customer/Flash_phoner/removeVideoRoom';
$route['change-call-status']            = 'customer/Flash_phoner/changeCallStatus';

/********************* product routes ************************************/
$route['cus-our-products']            = 'customer/Products/productListing';
$route['cus-product-detail/(:num)']   = 'customer/Products/productDetail/$1';
$route['get-sub-categories']          = 'customer/Products/getSubCategoriesAndProducts';
$route['get-products-by-subcat']      = 'customer/Products/getProductsBySubCategory';

/********************* product routes ************************************/
$route['cus-delivery-datetime']             = 'customer/Caregiver/deliveryDateTime';
$route['cus-caregiver-step1']               = 'customer/Caregiver/caregiverFirst';
$route['cus-caregiver-step2']               = 'customer/Caregiver/caregiverSecond';
$route['cus-caregivers-view']               = 'customer/Caregiver/caregiverFinal';

/********************* cart/order routes **************************************/
$route['cus-add-tocart-products']     = 'customer/Products/productAddToCart';
$route['cus-add-tocart']              = 'customer/Products/addToCart';
$route['cus-cart-checkout']           = 'customer/Products/cartCheckout';
$route['cus-my-orders']               = 'customer/Orders/myOrders';
$route['cus-order-detail']            = 'customer/Orders/orderDetail';
$route['cus-order-status']            = 'customer/Orders/orderStatus';
$route['cus-delete-from-cart']        = 'customer/Products/removeItemFromCart';
$route['cus-delete-all-cart']         = 'customer/Products/emptyCart';

/******************** static pages ****************************************/
$route['cus-page/(:any)']             = 'customer/Pages/getPageBySlug/$1';

/********** Mobile web routes ends here **********************************/
//add coupon to users account
$route['assign_coupon_to_user'] = 'admin/Manager/addCouponToUserAccount';
$route['taxes'] = 'admin/Setting/manage_taxes';
$route['add-tax']      = 'admin/Setting/add_tax';
$route['view-tax/(:num)']  = "admin/Setting/view_tax/$1"; 
$route['change-tax-status/(:num)'] = 'admin/Setting/change_tax_status/$1';
$route['delete-tax/(:num)'] = 'admin/Setting/delete_tax/$1';
