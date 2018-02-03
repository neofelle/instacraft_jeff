<?php include('templates/header.php')  ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $("#datepicker").datepicker();        
  });
  </script>
<section class="main-body">
    <p class="title">Prescriptions</p>
        <div class="ground-elements">
            <div class="top-action-bar">
                
                <form action="<?php echo base_url(); ?>prescriptions" method="GET" >
                <div class="Search"><input type="text" placeholder="Search" name="search" /></div>
                <div class="Combo" style="display: none;">
                    <select name="status" class="mozkit-fix">
                        <option value="">All</option>
                    </select>
                    <span class="btn-bk"></span>
                </div>
                
                    <div class="datepiker">
                        <input class="form-control" id="datepicker" type="text" placeholder="MM/DD/YY" name="date">
                        <span class="btn-bk cal"></span>
                    </div>
                    <div class="actions-fil">
<!--                        <a href="#" class="icon-search"></a>-->
<span class="thm-btn cstm-btn"><input type="submit" value="Go" class="icon-search thm-btn"/></span>
                        <a href="<?php echo base_url(); ?>prescriptions" class="reset-btn">Reset</a>
                    </div>
                </form>
            </div>
            <div class="data-details">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 8%;text-align: center;">Sr.No</th>
                            <th style="width: 10%;text-align: left;">Customer Name</th>
                            <th style="width: 12%;text-align: left;">Email Id</th>
                            <th style="width: 35%;text-align: left;">Consultation For</th>
                            <th style="width: 8%;text-align: left;">Appointment</th>
                            <th style="width: 7%;text-align: left;">Time</th>
                            <th style="width: 10%;text-align: left;">Status</th>
                            <th style="width: 10%;text-align: left;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //print_r($appointments);exit;  
                   if(count($prescriptions)>0){     
                        foreach($prescriptions as $key=>$values){
                            $data = getUsers($values['user_id']);
//                            echo "<pre>";
//                            print_r($data);
                        ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $data['first_name']; ?></td>
                            <td><?php echo $data['last_name']; ?></td>
                            <td><?php echo $data['email']; ?></td>
                            <td><?php echo "Recovery" ?></td>
                            <td><?php echo $values['appointment_time']; ?></td>
                            <td>
                                <?php 
                                  if($values['status'] == '0'){
                                      echo "Pending";
                                  }else if($values['status'] == '1'){
                                      echo "Confirm";
                                  }else if($values['status'] == '2'){
                                      echo "Re-schedule";
                                  }else if($values['status'] == '3'){
                                      echo "Cancel";
                                  }else{
                                      
                                  } 
                                
                                ?>
                            </td>
                          
                            
                            <td><a href="<?php echo base_url(); ?>prescriptionDetail/<?php echo $values['user_id']; ?>">View</a></td>
                        </tr>
                   <?php  } }else{ ?>
                        <tr><td colspan="8">No data found</td></tr>
                   <?php } ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </section>

<?php include('templates/footer.php')  ?>
