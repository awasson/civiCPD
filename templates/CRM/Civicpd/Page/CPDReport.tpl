<h3>Review and update your CPD activities.</h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
  	<tr valign="top">
      <th nowrap="">Continuing Professional Development Activities for: <a href="#" title="Choose a different year" style="font-weight:normal;" id="report_year">{$report_year}</a> <select class="cpd-frm" name="select_year" id="select_year">{$select_years}</select></th>
    </tr>
    <tr valign="top">
      <td>&nbsp;</td>
    </tr>
    <!-- Loop Results -->
    {$output}
    <!-- End Looping Results -->
    <tr valign="top">
      <td height="18" colspan="7">CDP credits for activities undertaken 
        in the calendar year {$report_year}: <strong>{$total_credits}</strong></td>
    </tr>
    <tr valign="top">
      <td nowrap="" height="18">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td nowrap="nowrap">{$display_name}</td>
              <td width="3%" nowrap="nowrap">&nbsp;</td>
              <td nowrap="nowrap">Membership Number: {$external_identifier}</td>
              <td width="3%" nowrap="nowrap">&nbsp;</td>
              <td nowrap="nowrap">Date: {$today}</td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
    <tr valign="top">
      <td nowrap="" height="18">&nbsp;</td>
    </tr>
    <tr valign="top">
      <td nowrap="" height="18">| <a title="Click here to print this page" href="#" id="print_button">Print this page</a> |</td>
    </tr>
  </tbody>
</table>

{literal}

<style type="text/css">

#select_year {
	display: none;
}

#report_year {
    display: inline-block;
    position: relative;
}



</style>

<script type="text/javascript">
<!-- 
	var jq = jQuery.noConflict();
	
	jQuery(function(){
	
	
		jq('#select_year').change(function() {
			var reportyear = jq(this).attr('value');
			
			jq(this).fadeOut('fast', function() {
    			jq('#report_year').text(reportyear);
    			jq('#report_year').fadeIn('slow');
  			}); 
		
			jq.post("/civicrm/civicpd/reportyear", 
				{ new_year : reportyear }
				, jq('.report-year').text(reportyear)
				, window.setTimeout('location.reload()', 500)
			);
				
		});
		
		
		jq('#report_year').click(function() {
			jq(this).fadeOut('fast', function() {
    			jq('#select_year').fadeIn('slow');
  			});
   		});
			
			
		jq('.close').click(function() {
   			jq('.messagebox').fadeOut('fast');
   		});	
   		
   		jq('#print_button').click(function() {
   			window.print();
   		});	
			
	});

//-->
</script>

{/literal} 