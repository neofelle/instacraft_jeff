<?php 
                        //echo "<pre>";print_r($drivers);die;
                     ?>

<style>
 
.top-act .form-group {
    float: left;
}
.top-act .form-group input.btn, .top-act .clear-search button{
    margin-left: 4px;
}
.btn.d-grey{
   background-color:#e4e3e3;
}
td.action i.fa.fa-user {
    color: #fff;
}
.selectSearch{
    display : inline-block;
    width : 90px;
    padding: 0px 3px !important;
    font-weight:bold;
}
.selectSearch option{
    font-weight:bold;
}
.modal.fade.in {
    top: 10%;
    padding-right: 15px;
    display: block;
    width: 651px;
    right: 84%;
    left: 49%;
}
.modal{ width:670px; }

.modal-content {
    box-shadow: none !Important;
    border: none !Important;
}
.paginate{     padding-left: 40px; }


input.datetime{
    display: inline-block;
    width: 100px;
    padding-left: 10px;
    border-radius : 0px !important  ;
}

/*----------------- Main Dashboard fields css----------------*/


/* fontawesome */
[class*="fontawesome-"]:before {
  font-family: 'FontAwesome', sans-serif;
}
.left {
  float: left;
}
.clear {
clear: both;
}

.buysblock { background: rgba(133, 62, 226, 0.79);}
.commentsblock {  background: rgb(38,168,226);}
.colorParrot {  background: rgba(105, 191, 52, 0.8);}
.colorPink {  background: rgba(216, 106, 106, 0.8);}

.colorBlog {  background: rgba(0, 62, 115, 0.75);}
.colorFlower {  background: rgba(206, 18, 113, 0.82);}
.colorReddish {  background: rgba(243, 0, 0, 0.77);}
.table-scrollable > .table-bordered {font-size: 12px;}
.metroblock {
    width: 240px;
    min-height: 115px;
    padding: 0em 1em 1em 1em;
    color: #fff;
    font-family: 'Open Sans', sans-serif;
    margin-left: 4px;
    margin-bottom: 4px;
}

.metroblock h1, .metroblock h2, .metroblock .icon {
  font-weight: 300;
  margin: 0;
  padding: 0;
}
.metroblock h1, .metroblock .icon {
  font-size: 4em;
  text-align: center;
}
.metroblock .icon {
  margin-right: .2em;
}
.metroblock .icon i {
    font-size: 36px;
}
h2{font-size:16px;}

.error {
    border:1px solid red !important;
    box-shadow:2px 3px 3px 3px black;
    margin: 5px;
}
</style>

<?php $this->session->userdata('loginId'); ?>
<div class="page-content-wrapper">
    <div class="page-content" style="min-height:895px"> 
<!--        <h3 class="page-title page_mrg">Manage Users</h3>-->
        <?php echo validation_errors(); ?>
       
        <?php if ($this->session->userdata('SuccessMsg') != "") {  ?>
                    <div class="success alert-info toBeHidden custom-success" role="alert">
                        <?php echo $this->session->userdata('SuccessMsg');
                            $this->session->unset_userdata('SuccessMsg');
                        ?>
                    </div>
        <?php } ?>
        
        <?php if ($this->session->userdata('errorMsg') != "") { 
                ?>
                <div class="alert alert-danger toBeHidden custom-danger" role="alert"> 
                    <?php echo $this->session->userdata('errorMsg');
                        $this->session->unset_userdata('errorMsg');
                    ?>
                </div>
         <?php  } ?>

        <div class="row-fluid top-act">   
            <form action='' id="searchData" method="post" >  
               <input type="text" class="search-custom" style="width:32%;" value="<?php echo $this->input->post('searchText')!= '' ? $this->input->post('searchText'):'';?>" name="searchText"  placeholder="Search by Name, Email, Contact, Address">
                <select class="form-control selectSearch" id="doctorStatus" name="doctorStatus" onChange="formsubmit(this.form.id)">
                    <option value="" style="font-weight:bold;">Status</option>
                    <option value='0' <?php echo $this->input->post('doctorStatus')=='0' ?'selected':''; ?> >Offline</option>
                    <option value='1' <?php echo $this->input->post('doctorStatus')=='1' ?'selected':''; ?> >Online</option>
                    <option value='2' <?php echo $this->input->post('doctorStatus')=='2' ?'selected':''; ?> >In call</option>
                </select>                
                <a href="" style="margin-left: 5px;" class="btn red reset p-xl-pad red" id="start_button" type="button" ><i class="fa fa-refresh"></i></a>
                <button class="btn red reset p-xl-pad" id="submitform" type="submit" value="Submit"><i class="fa  fa-check"></i></button>
                
            <div class="form-group pull-right">
                <a class="btn red reset p-xl-pad" href="add-doctor" id="add_doctor"><i class="fa fa-plus" style="color:white;"></i> Add Doctor</a>
            </div>
            
            </form>
        </div>
        
       
        
        <div class="row row_mrg" id="myData">
            <div class="col-md-12">
                <div class="portlet-body flip-scroll table-scrollable">
                    <table class="table table-bordered table-striped table-condensed flip-content table-hover" >
                        <thead class="flip-content">
                            <tr>
                                <th width="50px"> S No.</th>
                                <th> Doctor Name</th>
                                <th class="numeric"> Email </th>
                                <th class="numeric"> Contact </th>
                                <th class="numeric" style="min-width:140px;"> Address </th>
                                <th class="numeric"> Qualification </th>
                                <th class="numeric"> Appointments </th>
                                <th class="numeric"> Status </th>
                                <th class="numeric"> Action </th>
                            </tr>
                        </thead>
                        <?php
                         if (count($result) > 0) {
                            if ($_GET['page'] == '') {
                                    $i = 0;
                                } else {
                                    $i = ($_GET['page'] - 1 ) * RECORDS_PERPAGE;
                                }
                            foreach ($result as $key => $list) {
                                $a = $list['status'];
                                $status =  $a != '0' ? ($a != '1' ? "In-Call" : "Online") : 'Offline';
                                $address = '';
                                if(isset($list['address']) && $list['address'] != ''){
                                    $address .= ucfirst($list['address']);
                                    if(isset($list['city'])  && $list['city'] != ''){
                                        $address .=',<br>';
                                        $address .= ucfirst($list['city']);
                                        if(isset($list['state'])  && $list['state'] != ''){
                                            $address .=',<br>';
                                            $address .= ucfirst($list['state']);
                                        }
                                    }   
                                }
                        ?>
                                    <tr>
                                        <td> <?php echo $i + 1; ?> </td>
                                        <td class="numeric editable"><b><?php echo ucfirst($list['doctor_fname'])." ".ucfirst($list['doctor_lname'])."</b>"; ?></td>
                                        <td class="numeric editable"><?php echo $list['doctor_email']; ?> </td>
                                        <td class="numeric editable"><?php echo $list['doctor_contact'];   ?></td>
                                        <td class="numeric editable"><?php echo $address; ?> </td>
                                        <td class="numeric editable"><?php echo $list['doctor_qualification']; ?></td>
                                        <td class="numeric editable"><b><?php echo $list['appointments']; ?></b></td>
                                        <td class="numeric editable"><?php echo $status; ?></td>
                                        <td class="action">
                                            <span class="no_wrap">
                                                <a title="View this order details" id ="viewDoctor" href="doctor-details/<?php echo $list['id']; ?>" class="btn btn-default btn-xs"> <i class="fa fa-eye" style="color:green;"></i> </a>
                                            </span>
                                        </td>
                                    </tr>                                
                                <?php
                                $i++;
                            }
                        } else {
                            ?>
                            <tbody>
                                <tr>
                                    <td colspan="6" style="text-align: center"> No Record Found </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                    <div class=" row_mrg paginate">
                        <div class=" row_mrg paginate">
                            <?php if($this->input->get('searchText') != '' || $this->input->get('all')){ ?>
                                <span  class="right show-more" ><a href="<?php echo base_url();?>orders" data-ci-pagination-page="2" rel="next">Back</a></span>
                            <?php }else{ ?>
                                 <span  class="right show-more" ><?php echo $this->pagination->create_links(); ?><a class= "btn" href="<?php echo base_url();?>orders?all=true" data-ci-pagination-page="2" rel="next">All</a></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Model for Block User -->
<div class="modal fade in" id="block" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePop"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to block the user? </div>
            <div class="modal-footer">
                <a href="" id="writeDeactivateURL"  class="btn green">Yes</a>
                <a class="btn red"  id="closePop">No</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Model for Activate User -->
<div class="modal fade in" id="activate" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePop"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to activate the user again? </div>
            <div class="modal-footer">
                <a href="" id="writeActivateURL" class="btn green">Yes</a>
                <a class="btn red" id="closePop">No</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Model for Delete User -->
<div class="modal fade in" id="deluser" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 15px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" id="closePopForDel"></a>
                <h4 class="modal-title">Alert Message</h4>
            </div>
            <div class="modal-body">Are you sure you want to delete the user? </div>
            <div class="modal-footer">
                <a href="" id="writeDeleteURL"  class="btn green">Yes</a>
                <a class="btn red"  id="closePopForDel">No</a>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>-->
<!--<script src="<?php echo base_url();?>js/jquery.validate.js"></script>-->
<script>
    jQuery(document).ready(function () {
        
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        QuickSidebar.init(); // init quick sidebar
        Demo.init(); // init demo features
        
        $(document).on("click","#blockUser",function() {//enable disabled driver message popup
            var userId = $(this).attr('userId');//get driver Id
            var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php// echo $_GET['searchText']; ?>';//write new url to deactivate for popup
            var url = 'activeDeactiveUser/'+status+'/'+userId;
            $('#writeDeactivateURL').attr("href", url);//write new generated url
            $('#block').show();//show popup
        });
        
        $(document).on("click","#activeUser",function() {//enable activate driver message popup
            var userId = $(this).attr('userId');//get driver Id
            var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+driverId+'?searchText=<?php //echo $_GET['searchText']; ?>'; //write new url to activate for popup
            var url = 'activeDeactiveUser/'+status+'/'+userId;
            $('#writeActivateURL').attr("href", url);//write new generated url
            $('#activate').show();//show popup
        });
        
        $(document).on("click","#closePop",function() {//disable both popup
            $('#block').hide();//hide deactive driver popup
            $('#activate').hide();//hide deactive driver popup
        });
        //--- Delete User
        $(document).on("click","#userDel",function() {//enable disabled driver message popup
            var xhref = $(this).attr('href');//get driver Id
            //var status = $(this).attr('status');//get driver status
            //var url = 'activeDeactiveDriver/'+status+'/'+userId+'?searchText=<?php //echo $_GET['searchText']; ?>';//write new url to deactivate for popup
            //var url = 'activeDeactiveUser/'+status+'/'+userId
            $('#writeDeleteURL').attr("href", xhref);//write new generated url
            $('#deluser').show();//show popup
        });
        
        $(document).on("click","#closePopForDel",function() {//disable both popup
            $('#deluser').hide();//hide deactive driver popup
            $('#ActivateDriver').hide();// hide activate driver popup
        });
        
        //--- Start Date  
        jQuery('#date_timepicker_start').datetimepicker({
            format:'Y-m-d',
            mask :'',
            onShow:function( ct ){
             this.setOptions({
              maxDate:jQuery('#date_timepicker_end').val()?jQuery('#date_timepicker_end').val():false
             })
            },
            timepicker:false
        });
        //--- End Date
        jQuery('#date_timepicker_end').datetimepicker({
            format:'Y-m-d',
            value:'<?php echo date('Y-m-d'); ?>',
            mask : '',
            onShow:function( ct ){
             this.setOptions({
              minDate:jQuery('#date_timepicker_start').val()?jQuery('#date_timepicker_start').val():false,
             })
            },
            maxDate:'+1970/01/01',
            timepicker:false
        });
        
        
        //--- SEARCH BOX VALIDATOR 
        $('#start_button').click(function(){ 
            $("#searchData").validate({ 
               rules: {
                   searchText:{
                       required: true
                   }
               },
               messages: {
                   searchText:{
                       required: "Please enter a text to search"
                   }
               }
            });
        });
        
        
        //--- Validate Date Range Form 
        /*
        $("#searchData").validate({
            validateOnBlur : false, // disable validation when input looses focus
            errorMessagePosition : 'top', // Instead of 'inline' which is default
            scrollToTopOnError : false, // Set this property to true on longer forms
            //-- date_timepicker_start date_timepicker_end
            rules: {
                    sdate: {
                            required: true
                    },
                    edate: {
                            required: true
                    },
            },
            errorPlacement: function(error, element) {}

        });
        */
        
    });
</script> 
