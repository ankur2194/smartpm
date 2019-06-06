<?php
defined('BASEPATH') or exit('No direct script access allowed');
?> <div class="container-fluid">
                <div class="row">
           <?= $this->session->flashdata('message') ?>
                   <div class="col-md-8">
                        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Update Lead</h4> <a href="javascript:window.history.go(-1);" class="btn btn-info btn-fill pull-right">Back</a>
<div class="clearfix"></div>
                                
                                                             <?php if(validation_errors())
{   
echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
echo validation_errors();
echo '</div>';
}
?>
                            </div>
                            <div class="content">
                                  <?php
                             
                                   foreach( $leads as $lead ) : ?>  

                                <?php echo form_open('lead/'.$lead->id.'/update',array('method'=>'post'));?>
                         
                                    <div class="row">
                                       
                                        <div class="col-md-12">
                                            <div class="form-group"> <input type="hidden" name="id" class="hidden_id" value="<?php echo $lead->id ?>"/>
                                                <label>Lead Name<span class="red-mark">*</span></label>
                                                <input class="form-control" placeholder="Lead Name" name="jobname" value="<?php echo $lead->job_name ?>" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>First Name<span class="red-mark">*</span></label>
                                                <input class="form-control" name="firstname" value="<?php echo $lead->firstname ?>" placeholder="" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Name<span class="red-mark">*</span></label>
                                                <input class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lead->lastname ?>" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address<span class="red-mark">*</span></label>
                                                <input class="form-control" placeholder="Address" name="address" value="<?php echo $lead->address ?>" type="text">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>City<span class="red-mark">*</span></label>
                                                <input class="form-control" placeholder="City" value="<?php echo $lead->city ?>" name="city" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State<span class="red-mark">*</span></label>
                                                <input class="form-control" placeholder="Country" Name="country" value="<?php echo $lead->state ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postal Code<span class="red-mark">*</span></label>
                                                <input class="form-control" placeholder="ZIP Code" value="<?php echo $lead->zip ?>" name="zip" type="text">
                                            </div>
                                        </div>
                                    </div>

                                 <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cell Phone<span class="red-mark">*</span></label>
                                                <input class="form-control" placeholder="Phone 1" name="phone1" value="<?php echo $lead->phone1 ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Home Phone</label>
                                                <input class="form-control" placeholder="Phone 2" name="phone2" value="<?php echo $lead->phone2 ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" name="email" placeholder="Email" value="<?php echo $lead->email ?>" type="email">
                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                                    <div class="clearfix"></div>
                                <?php echo form_close(); ?>
      
                            
                       
					    <div class="footer" style="margin-bottom: 10px;">
                                    
                                    <hr>
   <a href="<?php echo base_url('photos/'.$lead->id);?>" class="btn btn-success btn-fill">Photos</a>
   <a href="<?php echo base_url('lead/'.$lead->id.'/reports');?>" class="btn btn-danger btn-fill">All Report</a>
   <a href="" class="btn btn-success btn-fill">Create Estimate</a>
   <a href="<?php echo base_url('docs/'.$lead->id);?>" class="btn btn-danger btn-fill">Docs</a>
                                </div>
								                                   <?php endforeach; ?>
					</div>
                          
                        </div>
                    </div>

 <div class="col-md-4">
    <?php
        $lstatus="";
        $cstatus="";
        $jtype=""; ?>
<?php foreach( $leadstatus as $status ) : 
    $lstatus = $status->lead;
    $cstatus = $status->contract;
    $jtype = $status->job;
endforeach; ?>
            <div class="card">
                <div class="header">
                    <h4 class="title" style="float: left;">Lead Status</h4>
                    <span class="status lead <?php if($lstatus=='closed'){ echo 'closed';}else{ echo 'open';} ?>"><?php if($lstatus!=''){echo $lstatus; }else{ echo "None"; } ?>
                    </span> 
                    <div class="clearfix"></div>
                    <div class="content">
                    <select class="form-control" id="lead">
                        <?php foreach( $lead_status_tags as $s_tags ) : ?>     
                        <option value="<?php echo $s_tags->status_value ?>" <?php if($s_tags->status_value == $lstatus){ echo 'selected'; } ?> >
                            <?php echo $s_tags->status_value ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div>                       
                </div>
           
                <div class="header">
                                    <h4 class="title" style="float: left;">Contract Status</h4><span class="status contract <?php if($cstatus=='unsigned'){ echo 'closed';}else{ echo 'open';} ?>"><?php if($cstatus!=''){echo $cstatus; }else{ echo "None"; } ?></span> 
                                    <div class="clearfix"></div>
                                    <div class="content">
                                            <select class="form-control lead-status" id="contract">
                                               
                             <?php foreach( $contract_status_tags as $contract ) : ?>     
                            <option value="<?php echo $contract->status_value ?>" <?php if($contract->status_value == $cstatus){ echo 'selected'; } ?> ><?php echo $contract->status_value ?></option>
                        <?php endforeach; ?>
                        </select>
                                    </div>                       
                                </div>
             
                <div class="header">
                                    <h4 class="title" style="float: left;">Job Type</h4><span class="status job <?php if($jtype==''){ echo 'closed';}else{ echo 'open';} ?>"><?php if($jtype!=''){echo $jtype; }else{ echo "None"; } ?></span> 
                                    <div class="clearfix"></div>
                                    <div class="content">
                                            <select class="form-control lead-status" id="job" disabled="">
                                                <option value="">Choose type</option>
                          <?php foreach( $job_type_tags as $job ) : ?>     
                            <option value="<?php echo $job->status_value ?>" <?php if($job->status_value == $jtype){ echo 'selected'; } ?> ><?php echo $job->status_value ?></option>
                        <?php endforeach; ?>
                        </select>
                                    </div>                       
                                </div>
             </div>
        <div class="card">
                           
                           
                
                            <div class="header">
                                <h4 class="title" style="float: left;">Additional Party(If any)</h4> 
                                <div class="clearfix"></div>
                              
                                                           
                            </div>
                            <div class="content">
                            <?php if( !empty( $add_info ) ) : ?>
                            <?php foreach( $add_info as $info ) : ?>  
                                <?php echo form_open('party/'.$jobid.'/update',array('method'=>'post'));?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input class="form-control" name="firstname" value="<?php echo $info->fname ?>" placeholder="First Name" type="text">
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $info->lname ?>" type="text">
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input class="form-control" placeholder="Phone" name="phone" value="<?php echo $info->phone ?>" type="text">
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" placeholder="Email" name="email" value="<?php echo $info->email ?>" type="text">
                                            </div>
                                             <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                                        </div>
                                    </div>

                                 <?php echo form_close(); ?>
                                 <?php endforeach; ?>
                                <?php else : ?>
                                   <?php echo form_open('party/'.$jobid.'/add',array('method'=>'post'));?>

                                    <div class="row">
                                         
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input class="form-control" name="firstname" value="" placeholder="First Name" type="text">
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input class="form-control" placeholder="Last Name" name="lastname" value="" type="text">
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input class="form-control" placeholder="Phone" name="phone" value="" type="text">
                                            </div>
                                       
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" placeholder="Email" name="email" value="" type="text">
                                            </div>
                                             <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                                        </div>
                                    </div>

                                 <?php echo form_close(); ?>

                                <?php endif; ?>
                            </div>
                        </div>
</div>
					   </div>
                        </div>
<script>
  $(document).ready(function(){
    var baseUrl = '<?= base_url(); ?>';
        $('#lead').change(function(){
                var value=$(this).val();
                var id=$('.hidden_id').val();
                var status=$(this).attr('id');
                var contract_status=$('#contract').val();
                if(value=='open'){
                    $('#contract').removeAttr('disabled');
                    $('#job').removeAttr('disabled');
                    $.ajax({
                        url: baseUrl+'lead/updatestatus',
                        data: {value: value, id: id, status:status},        
                        type: 'post',
                        success: function(php_script_response){
                            $('.'+status).html(value);
                            }
                    });
                }else if(value!=open && contract_status!='signed'){
                    $('#contract').prop('disabled', 'disabled');    
                    $('#job').prop('disabled', 'disabled');
                    $.ajax({
                        url: baseUrl+'lead/updatestatus',
                        data: {value: value, id: id, status:status},        
                        type: 'post',
                        success: function(php_script_response){
                            $('.'+status).html(value);
                            }
                    });
                }else{
                    alert('Contract Already Signed. First Unsigned Contract than update lead Status!');
                }
            });

            $('.lead-status').change(function(){
                var value=$(this).val();
                var id=$('.hidden_id').val();
                var status=$(this).attr('id');

                var lead_status=$('#lead').val();
                var contract_status=$('#contract').val();
                if(contract_status=="signed"){
                    $('#job').removeAttr('disabled');
                }else{
                     $('#job').prop('disabled', 'disabled');
                }
            
                    if(lead_status=='open'){
                        $.ajax({
                                url: baseUrl+'lead/updatestatus',
                                data: {value: value, id: id, status:status},        
                                type: 'post',
                                success: function(php_script_response){
                                
                                    $('.'+status).html(value);
                                    if(value=='unsigned'){
                                        $("#job option:selected").prop("selected", false)
                                    }
                                }
                             });
                    }else{

                        alert('Job Status Must be Open Before Sign a Contract!');
                    }
                
                });

  });
</script>
  
