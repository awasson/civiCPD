<h3>{$civi_cpd_long_name} Activities for: <a href="#" title="Click to choose a different year" id="report_year">{$smarty.session.report_year}</a> <select class="cpd-frm" name="select_year" id="select_year">{$select_years}</select></h3>
<p>This report is for the year {$smarty.session.report_year}. To choose another year to report, click on the year in the sub-title above.</p>

{$report_table}

<div id="cover"></div>
<div id="progressbar" class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="100">
	<div class="ui-progressbar-value ui-widget-header ui-corner-left ui-corner-right" style="display: block; width: 20em; height: 1em;"></div>
</div>


{literal}

<style type="text/css">

#crm-container p {
    font-family: Helvetica,Arial,Sans;
    font-size: 12px;
    margin-bottom: 4px;
    padding: 4px 6px;
}

#crm-container table.report-table {
    border-collapse: inherit;
    width: 100%;
}

#crm-container table.report-table th {
    background-color: #EFEFEF;
    border: 1px solid #CCCCCC;
    color: #666666;
}
 
#crm-container table.report-table td {
    border: 1px solid #EFEFEF;
}

#select_year {
	display: none;
}

#report_year {
    display: inline-block;
    margin-left: 5px;
    position: relative;
}



</style>

<script type="text/javascript">
<!-- 

	cj.fn.center = function () {
    	this.css("position","fixed");
    	this.css("top", (cj(window).height() / 2) - (this.outerHeight() / 2));
    	this.css("left", (cj(window).width() / 2) - (this.outerWidth() / 2));
    	return this;
	}

	cj(function(){
	
		cj('#select_year').change(function() {
			var reportyear = cj(this).attr('value');
			
			cj(this).fadeOut('fast', function() {
    			cj('#report_year').text(reportyear);
    			cj('#report_year').fadeIn('slow');
  			}); 
  			
  			// Add Loading Spinner
			cj('#cover').css({'width': '100%', 'height': '100%', 'left': 0, 'top': 0, 'background-color': '#000000', 'opacity': '0.8'}).fadeIn( 'slow', function() {
    			cj('.ui-progressbar-value').css({'text-align': 'center','font-size': '1em','font-weight': 'normal', 'padding':'0.15em 0 0.35em'}).text('loading . . .');
    			cj('#progressbar').css({'padding': 0,'height': '1.4em'}).fadeIn('slow').center();
			});
  			
  			cj.ajax({
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
		
		cj(window).resize(function(){
   			cj('#progressbar').center();
		})
		
		cj('#report_year').click(function() {
			cj(this).fadeOut('fast', function() {
    			cj('#select_year').fadeIn('slow');
  			});
   		});
   		
   		cj('#print_button').click(function() {
   			window.print();
   		});	
			
	});

//-->
</script>

{/literal} 