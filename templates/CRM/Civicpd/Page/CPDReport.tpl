<h3>Review and update your CPD activities.</h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
  	<tr valign="top">
      <th nowrap="">Continuing Professional Development Activities for: <a href="#" title="Choose a different year" style="font-weight:normal;" class="report-year">{$report_year}</a></th>
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

<div class="messagebox">
<p>Choose a different year<br/> 
for this report: 
<select class="cpd-frm" name="select_year" id="select_year">
{$select_years}
</select>
</p>
<a class="close" href="#" title="Close">Close</a>
</div>


{literal}

<style type="text/css">

.report-year {
    display: inline-block;
    position: relative;
}

.messagebox {
    background-color: #FFFFFF;
    border: 3px ridge #0779BF;
    display: none;
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 0.9em;
    padding: 25px 20px 15px 20px;
    position: absolute;
}

.messagebox .close {
    border-bottom: 1px solid #B19953;
    border-left: 1px solid #B19953;
    font-size: 0.9em;
    padding-left: 3px;
    padding-right: 3px;
    position: absolute;
    right: 0;
    top: 0;
}

</style>

<script type="text/javascript">
<!-- 
	var jq = jQuery.noConflict();
	
	jQuery(function(){
	
	
		jq('#select_year').change(function() {
			var reportyear = jq(this).attr('value');
		
			jq.post("/civicrm/civicpd/reportyear", 
				{ new_year: reportyear }, 
				jq('.report-year').text(reportyear), 
				jq('.messagebox').fadeOut('fast'), 
				window.setTimeout('location.reload()', 500)
			);
				
		});
		
		
		jq('.report-year').click(function(e) {
			jq('.messagebox').css("top", "0px");
			jq('.messagebox').css("left", "350px");
   			jq('.messagebox').fadeIn('slow');
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