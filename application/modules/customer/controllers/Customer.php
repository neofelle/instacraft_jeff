<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Customer extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer/Customer_model');
        $this->load->model('customer/Cus_prescription_model');
        $this->load->model('customer/Products_model');
        $this->load->helper('common_helper');
        $this->load->helper('user_helper');
        $this->load->helper('url');
        $this->load->library('s3');
        $this->load->library('facebook');
        checkCartQuantity();
    }
    
    
    public function facebookLogin(){
        $proObj = new Products_model();
        $custObj = new Customer_model();
        $userData = array();
        $output['title'] = 'Login';
        $output['pageName'] = 'Login';
        // Check if user is logged in
        if ($this->facebook->is_authenticated()){
         $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');

            // Preparing data for database insertion
            $slug = substr($userProfile['email'], 0, 8);
            $userData['facebook_social_id'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['first_name'];
            $userData['last_name'] = $userProfile['last_name'];
            $userData['email'] = $userProfile['email'];
            $userData['gender'] = $userProfile['gender'];
            $userData['profile_pic'] = $userProfile['picture']['data']['url'];
            $userData['user_type'] = "0";
            $userData['slug']    = create_unique_slug_for_common($slug, 'users');
            $custObj->checkUser($userData);
            if ($this->session->userdata('CUSTOMER-ID') != '') {
                $totalQuantity = $proObj->checkAddToCartProductQuantity();
                $this->session->set_userdata('total_item',$totalQuantity);
                redirect('cus-home');
            } else {
                redirect('cus-login');
            }
             
        }else {
            $output['authUrl'] = $this->facebook->login_url();
        }
    
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/login_register');
        $this->load->view($this->config->item('customer') . '/mobile/footer');


    }

    public function register() {
        if ($this->session->userdata('CUSTOMER-SL') != '') {
            redirect('cus-profile-view');
        }
        $failure = false;
        $custObj = new Customer_model();
        $output['authUrl'] = $this->facebook->login_url();
        $output['title'] = 'Register';
        $output['pageName'] = 'Register';
        $output['authUrl'] = $this->facebook->login_url();
        //$output['allProducts']		= $this->banner_model->getAllBannersForFront('linker-front');
        if (!empty($_POST)) {

            $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            $password = md5($this->input->post('password'));
            $email = $this->input->post('email');
            $reffered_by = $this->input->post('referrel_code');
            $fingerprint = $this->input->post('fingerprint');
            $ip = $this->input->post('ip');

            if ($this->form_validation->run()) {

                $custObj->set_password($password);
                $custObj->set_email($email);
                $custObj->set_registration_type(1);
                //$custObj->set_refferal_code($refferel_code);
                $custObj->set_is_termcondition_accepted(1);
                $custObj->set_reffered_by($reffered_by);
                $custObj->set_fingerprint($fingerprint);
                $custObj->set_ip($ip);

                /*                 * ****** Insert user record ***************** */
                $res = $custObj->register();
                if ($res != '') {
                    $success_message = 'Registration success.';
                } else {
                    $errorMsg = 'Something went wrong, Please try again later.';
                    $failure = true;
                }
            } else {
                $errorMsg .= validation_errors();
                $failure = true;
            }
            if ($this->input->is_ajax_request()) {
                if ($failure) {
                    $data['success'] = false;
                    $data['error_message'] = $errorMsg;
                } else {
                    $data['success'] = true;
                    $data['url'] = site_url('cus-profile-edit');
                    $data['resetForm'] = false;
                    $data['success_message'] = $success_message;
                }
                $data['scrollToThisForm'] = true;
                echo json_encode($data);
                die;
            }
        }
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/login_register');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function login() {
        $proObj = new Products_model();
        if ($this->session->userdata('CUSTOMER-SL') != '') {
            //redirect('cus-home');
             redirect('cus-our-products');
        }
        $custObj = new Customer_model();
        $output['authUrl'] = $this->facebook->login_url();
        $output['title'] = 'Login';
        $output['pageName'] = 'Login';
        $output['authUrl'] = $this->facebook->login_url();
        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            $password = md5($this->input->post('password'));
            $email = $this->input->post('email');
            if ($this->form_validation->run()) {
                $failure = false;
                $custObj->set_email($email);
                $custObj->set_password($password);

                $userRecord = $custObj->login();
                //print_r($userRecord); exit;
                if ($userRecord != false) {
                    if ($userRecord->is_deleted == '1') {
                        $errorMsg = 'Sorry, your Account is Deleted.';
                        $failure = true;
                    } elseif ($userRecord->is_blocked == '1') {
                        $errorMsg = 'Sorry, your Account is Blocked by admin.';
                        $failure = true;
                    } else {
                        $totalQuantity = $proObj->checkAddToCartProductQuantity();
                        $this->session->set_userdata('total_item',$totalQuantity);
                        $success_message = 'Login success';
                    }
                } else {
                    $errorMsg = 'Sorry, Email or Password does not match. Please try again.';
                    $failure = true;
                }
            } else {
                $errorMsg .= validation_errors();
                $failure = true;
            }
            if ($this->input->is_ajax_request()) {
                if ($failure) {
                    $data['success'] = false;
                    $data['error_message'] = $errorMsg;
                } else {
                    $data['success'] = true;
                    if ($this->session->userdata('REDIRECT_URL') != '') {
                        $data['url'] = $this->session->userdata('REDIRECT_URL');
                    } else {
                        $data['url'] = site_url('cus-home');
                    }
                    $data['resetForm'] = false;
                    $data['success_message'] = $success_message;
                }
                $data['scrollToThisForm'] = true;
                echo json_encode($data);
                die;
            }
        }
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/login_register');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function editProfile() {
        checkMemberLogin();
        $custObj = new Customer_model();
        $output['title'] = 'Edit Profile';
        $output['pageName'] = 'Edit Profile';
        $output['header_class'] = 'icon-back-arrow,'.base_url().'cus-profile-view';

        /*         * ***** get user record *************** */
        $output['userRecord'] = $custObj->getUserRecordBySlug();

        if (!empty($_POST)) {
            //print_r($_POST);die;
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'required|min_length[10]|max_length[13]');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('dob', 'Date Of Birst', 'required');
            $this->form_validation->set_rules('gender', 'Gender', 'required');

            if ($this->form_validation->run()) {
                $failure = false;
                $custObj->set_phone_number($this->input->post('phone_number'));
                $custObj->set_first_name($this->input->post('first_name'));
                $custObj->set_last_name($this->input->post('last_name'));
                $custObj->set_dob($this->input->post('dob'));
                $custObj->set_gender($this->input->post('gender'));
                $custObj->set_address($this->input->post('location'));

                $isUpdated = $custObj->updateProfile();
                if ($isUpdated) {
                    $success_message = 'Profile edited successfully.';
                    $failure = false;
                } else {
                    $errorMsg = 'Something went wrong, Please try again later.';
                    $failure = true;
                }
            } else {
                $errorMsg .= validation_errors();
                $failure = true;
            }
            if ($this->input->is_ajax_request()) {
                if ($failure) {
                    $data['success'] = false;
                    $data['error_message'] = $errorMsg;
                } else {
                    $data['success'] = true;
                    $data['url'] = site_url('cus-profile-view');
                    $data['resetForm'] = false;
                    $data['success_message'] = $success_message;
                }
                $data['scrollToThisForm'] = true;
                echo json_encode($data);
                die;
            }
        }
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/edit_profile');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function viewProfile() {
        checkMemberLogin();
        $custObj = new Customer_model();
        $output['title'] = 'View Profile';
        $output['pageName'] = 'My Profile';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';
        $output['header_class_right'][0] = 'icon-edit,'.base_url().'cus-profile-edit';
        
        /*         * ***** get user record *************** */
        $output['userRecord'] = $custObj->getUserRecordBySlug();

        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/view_profile');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    public function myProfile() {
     
        checkMemberLogin();
        //$presObj = new Cus_prescription_model();
        $custObj = new Customer_model();
        $output['title'] = 'Home';
        $output['pageName'] = 'Home';
        $output['header_class'] = 'icon-menu,javascript:;';
        $output['header_class_right'][0] = 'icon-cart cart-badge,'. base_url().'cus-add-tocart';
        $output['header_class_right'][1] = 'icon-bell,javascript:;';

        /*         * ***** get user record *************** */
        $output['userRecord'] = $custObj->getUserRecordBySlug();
        $output['upcomingAppointment'] = $custObj->checkUpcomingAppointment();
        //print_r($output['upcomingAppointment']);
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/my_profile');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    function valid_email($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    function valid_phone_number_or_empty($value) {
        $value = trim($value);
        if ($value == '') {
            return TRUE;
        } else {
            if (preg_match('/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/', $value)) {
                return preg_replace('/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/', '($1) $2-$3', $value);
            } else {
                $this->form_validation->set_message('valid_phone_number_or_empty', 'The %s not valid');
                return FALSE;
            }
        }
    }

    function forgotPassword() {
        $custObj = new Customer_model();
        if (!empty($_POST)) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            if ($this->form_validation->run()) {
                $failure = false;
                $custObj->set_email($this->input->post('email'));
                $isUpdated = $custObj->forgotPassword();
                $success_message = 'Password has been successfully sent to registered email id.';
                $failure = false;
            } else {
                $errorMsg .= validation_errors();
                $failure = true;
            }
            if ($this->input->is_ajax_request()) {
                if ($failure) {
                    $data['success'] = false;
                    $data['error_message'] = $errorMsg;
                } else {
                    $data['success'] = true;
                    $data['url'] = site_url('cus-login');
                    $data['resetForm'] = false;
                    $data['success_message'] = $success_message." The window will reload in 5 seconds.";
                    $data['forgot'] = true;
                }
                $data['scrollToThisForm'] = true;
                echo json_encode($data);
                die;
            }
        }
    }

    function changePassword() {
        checkMemberLogin();
        $custObj = new Customer_model();
        $output['title'] = 'Change Password';
        $output['pageName'] = 'Change Password';
        $output['header_class'] = 'icon-back-arrow,' .base_url().'cus-settings';

        if (!empty($_POST)) {
            $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'trim|required|min_length[6]|matches[new_password]');
            if ($this->form_validation->run()) {
                $cusDetail  =   $custObj->getUserRecordBySlug($this->session->userdata('CUSTOMER-SL'));
                $password = $cusDetail->password;
                if ($password == md5($this->input->post('current_password'))) {
                    if ($password != md5($this->input->post('new_password'))) {
                        $isUpdated  =   $custObj->changePassword();
                        if($isUpdated){
                            $success_message = '<p>Your password successfully changed.</p>';
                        }else{
                            $errorMsg = '<p>Something went wrong, Please try again later.</p>';
                        }
                    } else {
                        $errorMsg = '<p>New Password is same as current password.Please choose a new password.</p>';
                        $failure = true;
                    }
                } else {
                    $errorMsg = '<p>Current Password is Incorrect.</p>';
                    $failure = true;
                }
            } else {
                $errorMsg = validation_errors();
                $failure = true;
            }
            if ($this->input->is_ajax_request()) {
                if ($failure) {
                    $data['success'] = false;
                    $data['error_message'] = $errorMsg;
                } else {
                    $data['success'] = true;
                    $data['url'] = site_url('cus-login');
                    $data['resetForm'] = false;
                    $data['success_message'] = $success_message;
                }
                $data['scrollToThisForm'] = true;
                echo json_encode($data);
                die;
            }
        }
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/change_password');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    function socialShare() {
        if ($this->session->userdata('CUSTOMER-SL') == '') {
            redirect('cus-login');
        }
        $custObj = new Customer_model();
        $output['title'] = 'Share on Social Media';
        $output['pageName'] = 'Share on Social Media';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';
        $output['header_class_right'][0] = ',javascript:;,skip';
        
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/social_share');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    function settings() {
        checkMemberLogin();
        $custObj = new Customer_model();
        $output['title'] = 'Settings';
        $output['pageName'] = 'Settings';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-home';
        //$output['header_class_right'][0] = ',javascript:;,skip';
        
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/settings');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
    
    function logout() {
        $custObj = new Customer_model();
        $custObj->logout();
        redirect('');
    }
    
    function mailTest() {
       
       /* $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
            'smtp_port' => 465,
            'smtp_user' => 'AKIAIS665GVV52BJEPTA',
            'smtp_pass' => 'AgHSltp490y5jMqZw+aUqkSTceaVcCBupXq1GAmv6dvm',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'smtp_crypto' => 'ssl',
        );*/
        //        $config = Array(
        //    'protocol'  => 'smtp',
        //    'smtp_host' => 'ssl://email-smtp.us-east-1.amazonaws.com',
        //    'smtp_port' => '465',
        //    'smtp_user' => 'AKIAIS665GVV52BJEPTA',
        //    'smtp_pass' => 'AgHSltp490y5jMqZw+aUqkSTceaVcCBupXq1GAmv6dvm',
        //    'mailtype'  => 'html',
        //    'starttls'  => true,
        //    'newline'   => "\r\n",
        //     'smtp_crypto' => 'ssl',        
        //);


        $this->load->library('email');
        //$this->email->set_newline("\r\n");

        $this->email->from('support@getinstacraft.com');
        $this->email->to('mitanshi@techaheadcorp.com');
        $this->email->subject('Test email from CI and Gmail');
        $this->email->message('This is a test.');
        // echo"<pre/>"; print_r($this->email); die;
        $result = $this->email->send();
        
        echo $this->email->print_debugger();
        echo"<pre/>"; print_r($result); die;
    }
    
    public function uploadDocs() {
        $cusObj = new Customer_model();
        $output['title'] = 'Proof Upload';
        $output['pageName'] = 'Proof Upload';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-new-prescription';

        if (!empty($_FILES)) {
            $cusObj->set_id($this->session->userdata('CUSTOMER-ID'));

            /******* Insert medical license record ***************** */
            $res = $cusObj->uploadProofs();
            if($res){
                $success_message = 'Proofs uploaded success.';
            }else{
                $errorMsg   =   'Something went wrong, Please try again';
                $failure    =   true;
            }
            if ($this->input->is_ajax_request()) {
                if ($failure) {
                    $data['success'] = false;
                    $data['error_message'] = $errorMsg;
                } else {
                    $data['success'] = true;
                    $data['url'] = site_url('cus-new-prescription');
                    $data['resetForm'] = false;
                    $data['success_message'] = $success_message;
                }
                $data['scrollToThisForm'] = true;
                echo json_encode($data);
                die;
            }
        }
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/proof_upload');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }

    public function checkIfNewVisitor()
    {
        $customerModel = new Customer_model();
        $result = array();

        if ( true )
        {
            $fingerprint = $this->input->get('fp');
            $ip = $this->input->get('ip');

            // set the params
            $customerModel->set_ip($ip);
            $customerModel->set_fingerprint($fingerprint);

            // query results and see if a customer does really exist
            $result['visitor'] = $customerModel->getUserDetailsByFingerPrintAndIP();
            // set header response
            $this->output->set_header('HTTP/1.0 200 OK');
            $this->output->set_header('HTTP/1.1 200 OK');
            $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
            $this->output->set_header('Cache-Control: post-check=0, pre-check=0');
            $this->output->set_header('Pragma: no-cache');
            // send result alongside with headers
            $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                    ->_display();

            exit(); // stop the process
        }
    }

    public function caregiverDesignationForm() 
    {
        $cusObj = new Customer_model();
        $output['title'] = 'Caregiver Designation Form';
        $output['pageName'] = 'Caregiver Designation Form';
        $output['header_class'] = 'icon-back-arrow,' . base_url().'cus-designation-form';
        $this->load->view($this->config->item('customer') . '/mobile/header', $output);
        $this->load->view($this->config->item('customer') . '/mobile/caregiver_designation_forms');
        $this->load->view($this->config->item('customer') . '/mobile/footer');
    }
}


