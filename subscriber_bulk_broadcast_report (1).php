<section class="section section_custom">
  <div class="section-header">
    <h1><i class="fas fa-users"></i> <?php echo $page_title;?></h1>
    
    <div class="section-header-button">
      <a href="<?php echo base_url('messenger_bot_enhancers/create_subscriber_broadcast_campaign'); ?>" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line("basic"); ?></a>
      <a href="<?php echo base_url('messenger_bot_enhancers/create_subscriber_broadcast_campaign_pro'); ?>" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line("pro"); ?></a>
      <a href="<?php echo base_url('messenger_bot_enhancers/pro_templates_manager'); ?>" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <?php echo $this->lang->line("template"); ?></a>
      <!-- Dropdown اختيار نوع الحملات -->
<div class="running-campaigns-dropdown">
  <div class="dropdown">
    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="campaignsFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-filter"></i> <?php echo $this->lang->line('Filter Campaigns') ?: 'Filter Campaigns'; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="campaignsFilterDropdown" style="min-width:220px;">
      <a class="dropdown-item show_campaigns_btn" href="javascript:void(0)" data-filter="running" id="show_running_campaigns"><i class="fas fa-play-circle mr-2"></i> <?php echo $this->lang->line('Processing') ?: 'Processing'; ?></a>
      <a class="dropdown-item show_campaigns_btn" href="javascript:void(0)" data-filter="pending" id="show_pending_campaigns"><i class="fas fa-clock mr-2"></i> <?php echo $this->lang->line('Pending') ?: 'Pending'; ?></a>
      <a class="dropdown-item show_campaigns_btn" href="javascript:void(0)" data-filter="completed" id="show_completed_today_campaigns"><i class="fas fa-calendar-check mr-2"></i> <?php echo $this->lang->line('Completed Today') ?: 'Completed Today'; ?></a>
    </div>
  </div>
</div>
    </div>
    
    <div style="display: flex;">
        <div class="form-group">
            <!-- Select Dropdown -->
            <select id="optionSelect" class="form-control" style="margin: -4px 9px -28px 10px;">
                <option value="refresh">Refresh all compaigns</option>
                <option value="delete">Delete Completed & on-hold</option>
                <option value="delete_all">Delete all compaigns</option>
    
                <!-- Add more options here -->
            </select>
        </div>
        
        <!-- Button -->
        <button id="actionButton" class="btn btn-primary" style="margin-left: 21px;">Run</button>
    <button id="delete_selected_btn" class="btn btn-danger text-white" style="margin-left: 10px; display:none;">
    <i class="fas fa-trash"></i> <?php echo $this->lang->line("Delete Selected"); ?>
</button>
    </div>
    
    
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?php echo base_url('messenger_bot_broadcast'); ?>"><?php echo $this->lang->line("Broadcasting");?></a></div>
      <div class="breadcrumb-item"><?php echo $page_title;?></div>
    </div>
  </div>

  <?php $this->load->view('admin/theme/message'); ?>

  <style type="text/css">
    #search_page_id{width: 145px;}
    #search_status{width: 95px;}
    @media (max-width: 575.98px) {
      #search_page_id{width: 90px;}
      #search_status{width: 75px;}
    }
  </style>

  <?php $status_options = array(""=>$this->lang->line("Status"),"0"=>$this->lang->line("Pending"),"1"=>$this->lang->line("Processing"),"2"=>$this->lang->line("Completed")) ?>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body data-card">
            <div class="row">
              <div class="col-12 col-md-9">
                <?php echo 
                '<div class="input-group mb-3" id="searchbox">
                  <div class="input-group-prepend">
                    '.form_dropdown('search_page_id',$page_list,$this->session->userdata('selected_global_page_table_id'),'class="form-control select2" id="search_page_id"').'
                  </div>
                  
                  <div class="input-group-prepend">'; ?>

                  <select name="search_status" id="search_status"  class="form-control select2">
                  	<option value=""><?php echo $this->lang->line("status") ?></option>
                  	<option value="0"><?php echo $this->lang->line("Pending") ?></option>
                  	<option value="1"><?php echo $this->lang->line("Processing") ?></option>
                  	<option value="2"><?php echo $this->lang->line("Completed") ?></option>
                  	<option value="3"><?php echo $this->lang->line("Stopped") ?></option>
                  </select>
                  </div>

                  <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->session->userdata('csrf_token_session'); ?>">


                  <?php
                  echo 
                  '<input type="text" class="form-control" id="search_value" autofocus name="search_value" placeholder="'.$this->lang->line("Search...").'" style="max-width:30%;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button" id="search_action"><i class="fas fa-search"></i> <span class="d-none d-sm-inline">'.$this->lang->line("Search").'</span></button>
                    
                  </div>
                </div>'; ?>                                          
              </div>

              <div class="col-12 col-md-3">

              	<?php
                
				echo $drop_menu ='<a href="javascript:;" id="campaign_date_range" class="btn btn-primary btn-lg float-right icon-left btn-icon"><i class="fas fa-calendar"></i> '.$this->lang->line("Choose Date").'</a><input type="hidden" id="campaign_date_range_val">';
				?>

                                         
              </div>
                
            </div>
                        <!-- Global Broadcast Summary -->
            <div id="broadcast_global_summary" class="row mb-3" style="display:none;">

              <div class="col-12 col-md-3 mb-2">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                    <i class="fas fa-users"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4><?php echo $this->lang->line('Targeted Subscribers') ?: 'Targeted Subscribers'; ?></h4>
                    </div>
                    <div class="card-body" id="sum_total_targeted">0</div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-3 mb-2">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-info">
                    <i class="far fa-paper-plane"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4><?php echo $this->lang->line('Sent'); ?> <span class="small text-muted">(%)</span></h4>
                    </div>
                    <div class="card-body">
                      <span id="sum_total_sent">0</span>
                      <span class="small text-muted">(<span id="sum_sent_rate">0</span>%)</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-3 mb-2">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-success">
                    <i class="fas fa-check-circle"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4><?php echo $this->lang->line('Delivered'); ?> <span class="small text-muted">(%)</span></h4>
                    </div>
                    <div class="card-body">
                      <span id="sum_total_delivered">0</span>
                      <span class="small text-muted">(<span id="sum_delivery_rate">0</span>%)</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-md-3 mb-2">
                <div class="card card-statistic-1">
                  <div class="card-icon bg-warning">
                    <i class="fas fa-envelope-open"></i>
                  </div>
                  <div class="card-wrap">
                    <div class="card-header">
                      <h4><?php echo $this->lang->line('Open'); ?> <span class="small text-muted">(%)</span></h4>
                    </div>
                    <div class="card-body">
                      <span id="sum_total_open">0</span>
                      <span class="small text-muted">(<span id="sum_open_rate">0</span>%)</span>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="table-responsive2">
                <input type="hidden" id="put_page_id">
                <table class="table table-bordered" id="mytable">
                  <thead>
                    <tr>
                      <th>#</th>      
                      <th style="vertical-align:middle;width:20px">
                          <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label for="datatableSelectAllRows"></label>        
                      </th>
                      <th><?php echo $this->lang->line("Name"); ?></th>
                      <th><?php echo $this->lang->line("Page Name")?></th>
                      <th><?php echo $this->lang->line("Type")?></th>
                      <th><?php echo $this->lang->line("Status"); ?></th>
                      <th><?php echo $this->lang->line("Actions"); ?></th>
                      <th><?php echo $this->lang->line("Media"); ?></th>
                      <th><?php echo $this->lang->line("Subscriber"); ?></th>
                      <th><?php echo $this->lang->line("Sent"); ?></th>
                      <th><?php echo $this->lang->line("Delivered"); ?></th>
                      <th><?php echo $this->lang->line("Open"); ?></th>
                      <th><?php echo $this->lang->line("Scheduled at"); ?></th>
                      <th><?php echo $this->lang->line("Created at"); ?></th>
                      <th><?php echo $this->lang->line("Labels"); ?></th>

                    </tr>
                  </thead>
                </table>
            </div>
          </div>
        </div>
      </div>       
        
    </div>
  </div>          

</section>


<?php
	$somethingwentwrong = $this->lang->line("Something went wrong.");
	$Doyouwanttopausethiscampaign = $this->lang->line("Do you want to pause this campaign? Pause campaign may not stop the campaign immediately if it is currently processing by cron job. This will affect from next cron job run after it finish currently processing messages.");
	$whenitpause = $this->lang->line("This will affect from next cron job run after it finish currently processing messages.");
	$Doyouwanttostartthiscampaign = $this->lang->line("Do you want to resume this campaign?");
	$doyoureallywanttodeletethiscampaign = $this->lang->line("Do you really want to delete this campaign?");
	$alreadyEnabled = $this->lang->line("This campaign is already enabled for processing.");
	$doyoureallywanttoReprocessthiscampaign = $this->lang->line("Force Reprocessing means you are going to process this campaign again from where it ended. You should do only if you think the campaign is hung for long time and didn't send message for long time. It may happen for any server timeout issue or server going down during last attempt or any other server issue. So only click OK if you think message is not sending. Are you sure to Reprocessing ?");
	$wanttounsubscribe = $this->lang->line("Do you really want to unsubscribe this user?");

 ?>
<script>

	var base_url="<?php echo site_url(); ?>";

	var somethingwentwrong = "<?php echo $somethingwentwrong; ?>";
	var Doyouwanttopausethiscampaign = "<?php echo $Doyouwanttopausethiscampaign; ?>";
	var whenitpause = "<?php echo $whenitpause; ?>";
	var Doyouwanttostartthiscampaign = "<?php echo $Doyouwanttostartthiscampaign; ?>";
	var doyoureallywanttodeletethiscampaign = "<?php echo $doyoureallywanttodeletethiscampaign; ?>";
	var alreadyEnabled = "<?php echo $alreadyEnabled; ?>";
	var doyoureallywanttoReprocessthiscampaign = "<?php echo $doyoureallywanttoReprocessthiscampaign; ?>";
	var wanttounsubscribe = "<?php echo $wanttounsubscribe; ?>";

	$('#campaign_date_range').daterangepicker({
	  ranges: {
	    '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
	    '<?php echo $this->lang->line("This Month");?>'  : [moment().startOf('month'), moment().endOf('month')],
	    '<?php echo $this->lang->line("Last Month");?>'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	  },
	  startDate: moment().subtract(29, 'days'),
	  endDate  : moment()
	}, function (start, end) {
	  $('#campaign_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
	});

	var perscroll;
	var table1 = '';
	table1 = $("#mytable").DataTable({
	  serverSide: true,
	  processing:true,
	  bFilter: false,
	  order: [[ 12, "desc" ]],
	  pageLength: 10,
	   ajax: {
    url: base_url+'messenger_bot_enhancers/subscriber_broadcast_campaign_data',
    type: 'POST',
    cache: false,
    data: function ( d )
    {
        d.search_page_id      = $('#search_page_id').val();
        d.search_value        = $('#search_value').val();
        d.search_status       = $('#search_status').val();
        d.campaign_date_range = $('#campaign_date_range_val').val();
        d.csrf_token          = $("#csrf_token").val();
        d.prevent_cache       = new Date().getTime();
    },
    dataSrc: function (json) {
        try {
            if (json && json.summary) {
                $('#broadcast_global_summary').show();
                $('#sum_total_targeted').text( json.summary.total_targeted || 0 );
                $('#sum_total_sent').text( json.summary.total_sent || 0 );
                $('#sum_total_delivered').text( json.summary.total_delivered || 0 );
                $('#sum_total_open').text( json.summary.total_open || 0 );

                $('#sum_sent_rate').text( json.summary.sent_rate || 0 );
                $('#sum_delivery_rate').text( json.summary.delivery_rate || 0 );
                $('#sum_open_rate').text( json.summary.open_rate || 0 );
            } else {
                $('#broadcast_global_summary').hide();
            }
        } catch(e) {
            if (window.console && console.error) {
                console.error('broadcast summary update error', e, json);
            }
        }
        return json.data;
    }
},
	  language: 
	  {
	    url: "<?php echo base_url('assets/modules/datatables/language/'.$this->language.'.json'); ?>"
	  },
	  dom: '<"top"f>rt<"bottom"lip><"clear">',
	  columnDefs: [
	    {
	        targets: [10], // إبقاء العمود 10 (المعرفات المخفية) مخفياً
	        visible: false
	    },
	    {
	        targets: [1], // إظهار العمود 1 (مربعات الاختيار)
	        visible: true,
	        orderable: false, // منع الترتيب حسب هذا العمود
	        className: 'text-center'
	    },
	    {
	        targets: [4,5,6,7,8,9,10,11,12,13],
	        className: 'text-center'
	    },
	    {
	        targets: [0,6,8],
	        sortable: false
	    }
	  ],
	  fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
	         if(areWeUsingScroll)
	         {
	           if (perscroll) perscroll.destroy();
	           perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
	         }
	     },
	     scrollX: 'auto',
	     fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again 
	         if(areWeUsingScroll)
	         { 
	           if (perscroll) perscroll.destroy();
	           perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
	         }
	     }
	});


	$("document").ready(function(){	   
    

	    setInterval(function() {
            // التحقق من أن الجدول موجود والصفحة نشطة
            if (typeof table1 !== 'undefined' && !document.hidden) {
                // false تعني: حدث البيانات ولكن لا تُعد تحميل الصفحة بالكامل (حافظ على رقم الصفحة الحالية)
                table1.ajax.reload(null, false); 
            }
        }, 10000); // 10000 ميلي ثانية = 10 ثواني
        // --- نهاية الإضافة ---

	    $(document).on('change', '#search_page_id', function(e) {
	        table1.draw();
	    });

	    $(document).on('change', '#search_status', function(e) {
	        table1.draw();
	    });

	    $(document).on('change', '#campaign_date_range_val', function(event) {
        	event.preventDefault(); 
        	table1.draw();
      	});

      	$(document).on('click', '#search_action', function(event) {
        	event.preventDefault(); 
        	table1.draw();
      	});

      	var table2 = '';
	    $(document).on('click','.sent_report',function(e){
	      
	      e.preventDefault();

	      var id = $(this).attr('cam-id');
	      var csrf_token = $("#csrf_token").val();

	      $('#hidden_cam_id').val(id);

	      $("#sent_report_modal").modal();

	      $("#sent_report_body").html('<div class="text-center waiting"><i class="fas fa-spinner fa-spin blue text-center" style="font-size: 50px"></i></div><br/>');
    	  setTimeout(function(){
	    	$.ajax({
	    		type:'POST' ,
	    		url:"<?php echo site_url();?>messenger_bot_enhancers/campaign_sent_status",
	    		data:{id:id,csrf_token:csrf_token},
	    		dataType:'JSON',
	    		success:function(response){
	    			$("#sent_report_body").html(response.response1);

	    			if (table2 == '')
	    			{
	    			  setTimeout(function(){ 
	                  	$("#mytable2_filter").append(response.response3);
	                  	$("[data-toggle=\'tooltip\']").tooltip();
	                  }, 1000);

	                  var perscroll2;
	    			  table2 = $("#mytable2").DataTable({
	    			      serverSide: true,
	    			      processing:true,
	    			      bFilter: true,
	    			      order: [[ 3, "desc" ]],
	    			      pageLength: 10,
	    			      ajax: {
	    			          url: '<?php echo base_url("messenger_bot_enhancers/campaign_sent_status_data"); ?>',
	    			          type: 'POST',
	    			          dataSrc: function ( json ) 
	    			          {
	    			            $(".table-responsive").niceScroll();
	    			            return json.data;
	    			          },
	    			          data: function ( d )
	    			          {
	    			              d.campaign_id = $('#hidden_cam_id').val();
	    			              d.csrf_token = $("#csrf_token").val();
	    			          }
	    			      },
	    			      language: 
	    			      {
	    			        url: '<?php echo base_url('assets/modules/datatables/language/'.$this->language.'.json');?>'
	    			      },
	    			      dom: '<"top"f>rt<"bottom"lip><"clear">',
	    			      columnDefs: [
	    			        {
	    			            targets: [1,7],
	    			            visible: false
	    			        },
	    			        {
	    			            targets: [0,4,5,6,7,8],
	    			            className: 'text-center'
	    			        }
	    			      ],
	    			      fnInitComplete:function(){  // when initialization is completed then apply scroll plugin
	    			          if(areWeUsingScroll)
	    			          {
	    			            if (perscroll2) perscroll2.destroy();
	    			            perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
	    			          }
	    			      },
	    			      scrollX: 'auto',
	    			      fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again 
	    			          if(areWeUsingScroll)
	    			          { 
	    			            if (perscroll2) perscroll2.destroy();
	    			            perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
	    			          }
	    			      }
	    			  });
	    			}
	    			else table2.draw();
	    		}
	    	});

	    	
    	  }, 1000);


	    });

	});


	$(document).on('click','.restart_button',function(e){
		e.preventDefault();
		var table_id = $(this).attr('table_id');
		var csrf_token = $("#csrf_token").val();

		swal({
			title: '<?php echo $this->lang->line("Force Resume"); ?>',
			text: Doyouwanttostartthiscampaign,
			icon: 'warning',
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) 
			{
			    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
			    $.ajax({
			       context: this,
			       type:'POST' ,
			       url: "<?php echo base_url('messenger_bot_enhancers/restart_campaign')?>",
			       data: {table_id:table_id,csrf_token:csrf_token},
			       success:function(response)
			       {
				       	$(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');
				       	if(response=='1') 
				       	{
				       		$("#sent_report_modal").modal('hide');
				      		iziToast.success({title: '',message: '<?php echo $this->lang->line("Campaign has been resumed by force successfully."); ?>',position: 'bottomRight'});
				       		table1.draw();
				       	}      	
				      	else iziToast.error({title: '',message: somethingwentwrong,position: 'bottomRight'});
			       }
				});
			} 
		});

	});

	$(document).on('click','.force',function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		var csrf_token = $("#csrf_token").val();
		var alreadyEnabled = "<?php echo $alreadyEnabled; ?>";
		var doyoureallywanttoReprocessthiscampaign = "<?php echo $doyoureallywanttoReprocessthiscampaign; ?>";

		swal({
			title: '<?php echo $this->lang->line("Force Re-process Campaign"); ?>',
			text: doyoureallywanttoReprocessthiscampaign,
			icon: 'warning',
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) 
			{
			    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
			    $.ajax({
			       context: this,
			       type:'POST' ,
			       url: "<?php echo base_url('messenger_bot_enhancers/force_reprocess_campaign')?>",
			       data: {id:id,csrf_token:csrf_token},
			       success:function(response)
			       {
				       	$(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');

				      	if(response=='1') 
				       	{
				      		iziToast.success({title: '',message: '<?php echo $this->lang->line("Campaign has been re-processed by force successfully."); ?>',position: 'bottomRight'});
				       		table1.draw();
				       	}      	
				      	else iziToast.error({title: '',message: alreadyEnabled,position: 'bottomRight'});
			       }
				});
			} 
		});

	});

	$(document).on('click','.pause_campaign_info',function(e){
		e.preventDefault();
		var table_id = $(this).attr('table_id');
		var csrf_token = $("#csrf_token").val();

		swal({
			title: '<?php echo $this->lang->line("Pause Campaign"); ?>',
			text: Doyouwanttopausethiscampaign,
			icon: 'warning',
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) 
			{
			    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
			    $.ajax({
			       context: this,
			       type:'POST' ,
			       url: "<?php echo base_url('messenger_bot_enhancers/ajax_campaign_pause')?>",
			       data: {table_id:table_id,csrf_token:csrf_token},
			       success:function(response)
			       {
				       	$(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');

				      	if(response=='1') 
				       	{
				      		iziToast.success({title: '',message: '<?php echo $this->lang->line("Campaign has been paused successfully."); ?>',position: 'bottomRight'});
				       		table1.draw();
				       	}      	
				      	else iziToast.error({title: '',message: somethingwentwrong,position: 'bottomRight'});
			       }
				});
			} 
		});

	});

	$(document).on('click','.play_campaign_info',function(e){
		e.preventDefault();
		var table_id = $(this).attr('table_id');
		var csrf_token = $("#csrf_token").val();

		swal({
			title: '<?php echo $this->lang->line("Resume Campaign"); ?>',
			text: Doyouwanttostartthiscampaign,
			icon: 'warning',
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) 
			{
			    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
			    $.ajax({
			       context: this,
			       type:'POST' ,
			       url: "<?php echo base_url('messenger_bot_enhancers/ajax_campaign_play')?>",
			       data: {table_id:table_id,csrf_token:csrf_token},
			       success:function(response)
			       {
				       	$(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');

				      	if(response=='1') 
				       	{
				      		iziToast.success({title: '',message: '<?php echo $this->lang->line("Campaign has been resumed successfully."); ?>',position: 'bottomRight'});
				       		table1.draw();
				       	}      	
				      	else iziToast.error({title: '',message: somethingwentwrong,position: 'bottomRight'});
			       }
				});
			} 
		});

	});


	$(document).on('click','.delete',function(e){
		e.preventDefault();

		var id = $(this).attr('id');
		var csrf_token = $("#csrf_token").val();
	    if (typeof(id)==='undefined')
	    { 
	    	swal('', '<?php echo $this->lang->line("This campaign is in processing state and can not be deleted.");?>', 'warning');
	    	return;
	    }

		swal({
			title: '<?php echo $this->lang->line("Delete Campaign"); ?>',
			text: doyoureallywanttodeletethiscampaign,
			icon: 'warning',
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) 
			{
			    $(this).parent().prev().addClass('btn-progress btn-primary').removeClass('btn-outline-primary');
			    $.ajax({
			       context: this,
			       type:'POST' ,
			       url: "<?php echo base_url('messenger_bot_enhancers/subscriber_delete_campaign')?>",
			       data: {id:id,csrf_token:csrf_token},
			       success:function(response)
			       {
				       	$(this).parent().prev().removeClass('btn-progress btn-primary').addClass('btn-outline-primary');

				      	if(response=='1') 
				       	{
				      		iziToast.success({title: '',message: '<?php echo $this->lang->line("Campaign has been deleted successfully."); ?>',position: 'bottomRight'});
				       		table1.draw();
				       	}      	
				      	else iziToast.error({title: '',message: somethingwentwrong,position: 'bottomRight'});
			       }
				});
			} 
		});

	});

    
    $(document).ready(function() {
        $('#actionButton').click(function() {
            var selectedOption = $('#optionSelect').val();
            var csrf_token = $("#csrf_token").val();
            
            if(selectedOption == 'refresh'){
                
                $.ajax({
			       type:'POST' ,
			       url: "<?php echo base_url('messenger_bot_enhancers/force_reprocess_all_campaign')?>",
			       data: {csrf_token:csrf_token},
			       success:function(response)
			       {
				       	iziToast.success({title: '',message: response,position: 'bottomRight'});
			       }
				});
                
            }else if(selectedOption == 'delete') {
                
                $.ajax({
			       type:'POST' ,
			       url: "<?php echo base_url('messenger_bot_enhancers/subscriber_delete_all_compeleted_on_hold_campaign')?>",
			       data: {csrf_token:csrf_token},
			       success:function(response)
			       {
				       	iziToast.success({title: '',message: response,position: 'bottomRight'});
			       }
				});
                
            }else if(selectedOption == 'delete_all') {
                
                $.ajax({
			       type:'POST' ,
			       url: "<?php echo base_url('messenger_bot_enhancers/subscriber_delete_all_campaign')?>",
			       data: {csrf_token:csrf_token},
			       success:function(response)
			       {
				       	iziToast.success({title: '',message: response,position: 'bottomRight'});
			       }
				});
                
            }
            
        });
    });
// --- بداية كود الحذف الجماعي ---

    // 1. عند الضغط على "تحديد الكل" في رأس الجدول
    $(document).on('click', '#datatableSelectAllRows', function() {
        if ($(this).is(':checked')) {
            $('.datatableCheckboxRow').prop('checked', true);
            $('#delete_selected_btn').show(); // إظهار زر الحذف
        } else {
            $('.datatableCheckboxRow').prop('checked', false);
            $('#delete_selected_btn').hide(); // إخفاء زر الحذف
        }
    });

    // 2. عند الضغط على مربع اختيار لصف واحد
    $(document).on('click', '.datatableCheckboxRow', function() {
        if($('.datatableCheckboxRow:checked').length > 0) {
            $('#delete_selected_btn').show();
        } else {
            $('#delete_selected_btn').hide();
            $('#datatableSelectAllRows').prop('checked', false);
        }
    });

    // 3. عند الضغط على زر "حذف المحدد" الأحمر
    $(document).on('click', '#delete_selected_btn', function(e) {
        e.preventDefault();
        
        var ids = [];
        $('.datatableCheckboxRow:checked').each(function() {
            ids.push($(this).val());
        });

        if(ids.length == 0) return;

        var csrf_token = $("#csrf_token").val();

        swal({
            title: '<?php echo $this->lang->line("Delete Campaigns"); ?>',
            text: '<?php echo $this->lang->line("Do you really want to delete the selected campaigns?"); ?>',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $(this).addClass('btn-progress'); // تأثير التحميل على الزر
                $.ajax({
                    context: this,
                    type: 'POST',
                    url: "<?php echo base_url('messenger_bot_enhancers/subscriber_delete_bulk_campaigns')?>",
                    data: {ids: ids, csrf_token: csrf_token},
                    dataType: 'JSON',
                    success: function(response) {
                        $(this).removeClass('btn-progress');
                        if (response.status == '1') {
                            iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                            table1.draw(); // تحديث الجدول
                            $('#delete_selected_btn').hide();
                            $('#datatableSelectAllRows').prop('checked', false);
                        } else {
                            iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                        }
                    }
                });
            }
        });
    });
    // --- نهاية كود الحذف الجماعي ---

</script>




<div class="modal fade" id="sent_report_modal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-mega">
		<div class="modal-content">
			<div class="modal-header">
				<?php 
				$delete_junk_data_after_how_many_days = $this->config->item("delete_junk_data_after_how_many_days");
	    		if($delete_junk_data_after_how_many_days=="") $delete_junk_data_after_how_many_days = 30;
				?>
			  <h5 class="modal-title"><i class="fas fa-eye"></i> <?php echo $this->lang->line("Campaign Report"); ?> <small>(<?php echo $this->lang->line("Details data shows for last")." : ".$delete_junk_data_after_how_many_days." ".$this->lang->line("days"); ?>)</small></h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>

			<div class="modal-body data-card">
				<input type="hidden" id="hidden_cam_id">
				<div id="sent_report_body"></div>
				<div class="table-responsive2">
				    <table class="table table-bordered" id="mytable2">
				      <thead>
				        <tr>
				          <th>#</th>      
				          <th style="vertical-align:middle;width:20px">
				              <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label for="datatableSelectAllRows"></label>        
				          </th>
				          <th><?php echo $this->lang->line("First Name"); ?></th>
				          <th><?php echo $this->lang->line("Last Name"); ?></th>
				          <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
				          <th><?php echo $this->lang->line("Sent at"); ?></th>
				          <th><?php echo $this->lang->line("Delivered at"); ?></th>
				          <th><?php echo $this->lang->line("Opened at"); ?></th>
				          <th><?php echo $this->lang->line("Sent Response"); ?></th>
				        </tr>
				      </thead>
				    </table>
				</div>
			</div>
		</div>
	</div>
</div>


<style>
/* خفيف CSS ليتماشى مع شكل المنصة */
.running-campaigns-dropdown { display:inline-block; margin-right:12px; }
.running-campaigns-dropdown .btn { min-width: 170px; }
.running-campaigns-list .card { border-radius:6px; }
.running-campaigns-list .list-group-item { border: none; border-bottom: 1px solid #eef2f6; }
.running-campaigns-list .list-group-item:last-child { border-bottom: none; }
.running-campaigns-list .badge { font-size:0.8rem; }
</style>
<style>
/* هذا الكود يعمل فقط على شاشات الموبايل (أقل من 768 بكسل) */
@media (max-width: 767.98px) {

    /* --- 1. إصلاح الهيدر المزدحم --- */

    /* نجعل عناصر الهيدر تترتب فوق بعضها */
    .section-header {
        flex-direction: column;
        align-items: flex-start; /* محاذاة لليسار */
    }

    /* إخفاء الـ breadcrumbs (غير ضرورية في التطبيق) */
    .section-header-breadcrumb {
        display: none;
    }

    /* ترتيب الأزرار بجانب بعضها والسماح لها بالنزول لسطر جديد */
    .section-header-button {
        display: flex;
        flex-wrap: wrap; /* أهم خاصية: للنزول لسطر جديد */
        gap: 8px; /* مسافات بين الأزرار */
        width: 100%;
        margin-bottom: 15px;
    }
    
    .section-header-button .btn {
        flex-grow: 1; /* جعل الأزرار تملأ المساحة */
    }

    /* إصلاح مكان قائمة الاختيارات وزر "Run" */
    .section-header > div[style*="display: flex;"] {
        flex-direction: column; /* ترتيبهم فوق بعض */
        width: 100%;
        gap: 10px;
    }
    .section-header > div[style*="display: flex;"] select {
        margin: 0 !important; /* إلغاء الـ margin السلبي الغريب */
    }
    .section-header > div[style*="display: flex;"] button {
        margin-left: 0 !important; /* إلغاء الـ margin */
    }


    /* --- 2. إصلاح شريط الفلترة والبحث --- */

    /* جعل الفلاتر تترتب فوق بعضها */
    .data-card .row {
        flex-direction: column;
    }
    .data-card .col-12, .data-card .col-md-3 {
        width: 100%;
        max-width: 100%;
        flex: 0 0 100%;
    }
    
    /* إصلاح زر اختيار التاريخ (كان على اليمين) */
    .data-card a#campaign_date_range {
        float: none !important; /* إلغاء الـ float */
        width: 100%;
        margin-top: 10px;
    }

    /* جعل مجموعة البحث تترتب فوق بعضها */
    #searchbox {
        display: flex;
        flex-direction: column;
        gap: 10px; /* مسافات بين عناصر البحث */
    }
    #searchbox .input-group-prepend {
        width: 100%;
    }
    /* جعل حقول الإدخال والأزرار بعرض كامل */
    #searchbox .form-control,
    #searchbox .select2,
    #searchbox .btn {
        width: 100% !important;
        max-width: 100% !important; /* لكسر الـ inline style */
    }
    #searchbox .input-group-append {
        width: 100%;
    }


    /* --- 3. تحويل الجدول إلى "كروت" (الأهم) --- */

    /* إخفاء رأس الجدول الأصلي (سنضيف العناوين يدوياً) */
    #mytable thead {
        display: none;
    }

    #mytable tr {
        display: block; /* تحويل الصف إلى "بلوك" كأنه كارت */
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    #mytable td {
        display: flex; /* !! لاستخدام flexbox في محاذاة العنوان والمحتوى */
        justify-content: space-between; /* العنوان يسار، والمحتوى يمين */
        align-items: center;
        padding: 12px 15px;
        border-bottom: 1px dashed #eee; /* فواصل خفيفة داخل الكارت */
        text-align: right; /* محاذاة المحتوى (البيانات) لليمين */
        word-break: break-word; /* لكسر الكلمات الطويلة */
    }

    #mytable td:last-child {
        border-bottom: 0; /* آخر عنصر بدون خط */
    }

    /* استخدام pseudo-element لإضافة "العنوان" قبل المحتوى */
    #mytable td::before {
        font-weight: 600;
        color: #34395e; /* لون العنوان */
        text-align: left;
        padding-right: 10px;
        white-space: nowrap; /* لمنع العنوان من النزول لسطر جديد */
    }

    /* --- ترتيب الأعمدة في الجدول الأصلي ---
    1: #
    2: Checkbox
    3: Name
    4: Page Name
    5: Type
    6: Status
    7: Actions
    ... (والباقي)
    */

    /* إخفاء الأعمدة غير المهمة في عرض الموبايل */
    #mytable td:nth-of-type(1), /* # */
    #mytable td:nth-of-type(2), /* Checkbox */
    #mytable td:nth-of-type(8), /* Media */
    #mytable td:nth-of-type(9), /* Subscriber */
    #mytable td:nth-of-type(10),/* Sent */
    #mytable td:nth-of-type(11),/* Delivered (مخفي أصلاً) */
    #mytable td:nth-of-type(12),/* Open */
    #mytable td:nth-of-type(13),/* Scheduled at */
    #mytable td:nth-of-type(14),/* Created at */
    #mytable td:nth-of-type(15) /* Labels */
    {
        display: none;
    }

    /* إضافة العناوين للأعمدة الظاهرة */
    #mytable td:nth-of-type(3)::before { content: "<?php echo $this->lang->line('Name'); ?>"; }
    #mytable td:nth-of-type(4)::before { content: "<?php echo $this->lang->line('Page Name'); ?>"; }
    #mytable td:nth-of-type(5)::before { content: "<?php echo $this->lang->line('Type'); ?>"; }
    #mytable td:nth-of-type(6)::before { content: "<?php echo $this->lang->line('Status'); ?>"; }
    
    /* تنسيق خاص لعامود "Actions" */
    #mytable td:nth-of-type(7)::before { content: "<?php echo $this->lang->line('Actions'); ?>"; }
    #mytable td:nth-of-type(7) {
        flex-direction: column; /* ترتيب الأزرار فوق بعض */
        align-items: flex-end; /* محاذاة لليمين */
        gap: 5px; /* مسافة بين الأزرار */
    }
    #mytable td:nth-of-type(7)::before {
        align-self: flex-start; /* إبقاء العنوان على اليسار */
    }

}
</style>


<!-- Modal: campaigns list -->
<div class="modal fade" id="running_campaigns_modal" tabindex="-1" role="dialog" aria-labelledby="running_campaigns_modal_label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="running_campaigns_modal_label"><i class="fas fa-tasks"></i> <?php echo $this->lang->line('Campaigns') ?: 'Campaigns'; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $this->lang->line('Close') ?: 'Close'; ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-3" id="running_campaigns_body">
        <div class="text-center">
          <i class="fas fa-spinner fa-spin" style="font-size:26px"></i>
          <?php echo $this->lang->line('Loading') ?: 'Loading'; ?>...
        </div>
      </div>
      <div class="modal-footer">
        <small class="text-muted mr-auto"><?php echo $this->lang->line('Tip_SelectFilter') ?: 'Choose a filter to view campaigns across all pages.'; ?></small>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('Close') ?: 'Close'; ?></button>
      </div>
    </div>
  </div>
</div>

<script>
/* Inline JS — defensive and compatible with page handlers already present.
   Requires: jQuery, Bootstrap (for modal & dropdown).
   Uses #csrf_token value present in the page.
*/
(function($){
  'use strict';

  function getCsrf() {
    return $("#csrf_token").length ? $("#csrf_token").val() : '';
  }

  function openCampaignsModal() {
    var $body = $('#running_campaigns_body');
    if ($body.length) {
      $body.html('<div class="text-center"><i class="fas fa-spinner fa-spin" style="font-size:26px"></i> <?php echo addslashes($this->lang->line("Loading") ?: "Loading"); ?>...</div>');
    }
    $('#running_campaigns_modal').modal();
  }

  // unified handler for the dropdown items (Processing / Pending / Completed)
  $(document).on('click', '.show_campaigns_btn', function(e){
    e.preventDefault();
    var filter = $(this).data('filter') || 'running';

    if ($('#running_campaigns_modal').length === 0) {
      alert('<?php echo addslashes($this->lang->line("Something went wrong.") ?: "Something went wrong."); ?>');
      return;
    }

    openCampaignsModal();

    $.ajax({
      url: '<?php echo base_url("messenger_bot_enhancers/ajax_get_campaigns_by_filter"); ?>',
      type: 'POST',
      dataType: 'json',
      data: { filter: filter, csrf_token: getCsrf() },
      timeout: 15000,
      success: function(res){
        try {
          if (!res || typeof res !== 'object') throw new Error('Invalid JSON response');
          if (res.status && res.status === 'success' && res.html) {
            $('#running_campaigns_body').html(res.html);

            // bind 'View Report' inside returned html (re-uses existing sent report modal)
            $('#running_campaigns_body').find('.sent_report').off('click').on('click', function(ev){
              ev.preventDefault();
              var id = $(this).attr('cam-id');
              if(!id) return;
              $('#hidden_cam_id').val(id);
              $("#sent_report_modal").modal();
              $("#sent_report_body").html('<div class="text-center waiting"><i class="fas fa-spinner fa-spin blue" style="font-size: 50px"></i></div><br/>');

              setTimeout(function(){
                $.ajax({
                  type:'POST',
                  url:"<?php echo site_url('messenger_bot_enhancers/campaign_sent_status');?>",
                  data:{id:id,csrf_token:getCsrf()},
                  dataType:'JSON',
                  success:function(response){
                    if(response && response.response1) $("#sent_report_body").html(response.response1);
                    else $("#sent_report_body").html('<div class="alert alert-warning"><?php echo addslashes($this->lang->line("Something went wrong.") ?: "Something went wrong."); ?></div>');
                  },
                  error:function(xhr,status,err){
                    console.error('campaign_sent_status error', status, err, xhr && xhr.responseText);
                    $("#sent_report_body").html('<div class="alert alert-danger"><?php echo addslashes($this->lang->line("Something went wrong.") ?: "Something went wrong."); ?></div>');
                  }
                });
              }, 300);
            });

            // initialize tooltips if any
            if (typeof $().tooltip === 'function') {
              $('#running_campaigns_body').find('[data-toggle="tooltip"]').tooltip();
            }

          } else {
            $('#running_campaigns_body').html('<div class="alert alert-info"><?php echo addslashes($this->lang->line("No campaigns found for this filter.") ?: "No campaigns found for this filter."); ?></div>');
            console.warn('ajax_get_campaigns_by_filter returned non-success:', res);
          }
        } catch(err) {
          console.error('Error processing ajax_get_campaigns_by_filter response:', err, res);
          $('#running_campaigns_body').html('<div class="alert alert-danger"><?php echo addslashes($this->lang->line("Something went wrong.") ?: "Something went wrong."); ?></div>');
        }
      },
      error: function(xhr,status,err){
        console.error('ajax_get_campaigns_by_filter failed:', status, err, xhr && xhr.responseText);
        var msg = '<?php echo addslashes($this->lang->line("Something went wrong.") ?: "Something went wrong."); ?>';
        if(status === 'timeout') msg = '<?php echo addslashes($this->lang->line("Request timed out. Please try again.") ?: "Request timed out. Please try again."); ?>';
        $('#running_campaigns_body').html('<div class="alert alert-danger">'+msg+'</div>');
      }
    });
  });

})(jQuery);
</script>


<?php 
echo '
<div class="modal fade" id="error_message_learn" tabindex="-1" role="dialog" aria-labelledby="error_message_learn" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-bug"></i> '.$this->lang->line("Common Error Message").'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

     <div class="section">               

        <h2 class="section-title"> '.$this->lang->line("(#551) This person isn't available right now").'</h2>
        <p>
        '.$this->lang->line("This error messages comes from Facebook. The possible reasons are below").' : 
         <ol>
              <li>'.$this->lang->line("Subscriber deactivated their account.").'</li>
              <li>'.$this->lang->line("Subscriber blocked your page.").'</li>
              <li>'.$this->lang->line("Subscriber does not have activity for long days with your page.").'</li>
              <li>'.$this->lang->line("The user may in conversation subscribers as got private reply of comment but never replied back.").'</li>
              <li>'.$this->lang->line("APP may not have pages_messaging approval.").'</li>
        </ol>
        '.$this->lang->line("In this case system automatically mark the subscriber as unviable for future conversation broadcasting campaign. ").'
        </p>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>'; ?>
