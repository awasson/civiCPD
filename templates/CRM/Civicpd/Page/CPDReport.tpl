<h3>Review and update your {$civi_cpd_long_name} activities.</h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
  	<tr valign="top">
      <th nowrap="">{$civi_cpd_long_name} Activities for: <a href="#" title="Click to choose a different year" style="font-weight:normal;" id="report_year">{$smarty.session.report_year}</a> <select class="cpd-frm" name="select_year" id="select_year">{$select_years}</select>
      <p class="cpd-message">This report is for the year {$smarty.session.report_year}. To choose another year to report, click on the year above.</p></th>
    </tr>
    <tr valign="top">
      <td>&nbsp;</td>
    </tr>
    <!-- Loop Results -->
    {$output}
    <!-- End Looping Results -->
    <tr valign="top">
      <td height="18" colspan="7">{$civi_cpd_short_name} credits for activities undertaken 
        in the calendar year {$smarty.session.report_year}: <strong>{$total_credits}</strong></td>
    </tr>
    <tr valign="top">
      <td nowrap="" height="18">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td nowrap="nowrap">{$display_name}</td>
              <td width="3%" nowrap="nowrap">&nbsp;</td>
              <td nowrap="nowrap">Membership Number: {$membership_number}</td>
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
    margin-left: 5px;
    position: relative;
}

p.cpd-message {
    font-style: italic;
    font-weight: normal;
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
  			
  			jq.ajax({
  				type: 'POST',
  				url: '/civicrm/civicpd/reportyear?reset=1&snippet=2',
  				data: { new_year : reportyear },
  				success: function(data){
    				window.setTimeout('location.reload()', 0);
  				},
  				error: function(){
    				alert('There was a problem changing the year. \nPlease refresh the page and try again.');
  				}
			});
			
		});
		
		jq('#report_year').click(function() {
			jq(this).fadeOut('fast', function() {
    			jq('#select_year').fadeIn('slow');
  			});
   		});
   		
   		jq('#print_button').click(function() {
   			window.print();
   		});	
			
	});

//-->
</script>

{/literal} 