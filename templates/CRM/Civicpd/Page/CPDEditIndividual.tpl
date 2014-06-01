{$return_button} {$new_button}

<h3>{$sub_title}</h3>

<p><em>{$cpd_message}</em></p>
{$output}


{literal}
<style type="text/css">

.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-content, .ui-widget-header {
    color: #3E3E3E;
    font-family: helvetica;
    font-size: 0.95em;
}

</style>

<script type="text/javascript">
<!-- 

	cj(function() {
	
		// Change Breadcrumb to swap CiviCRM Contact Dashboard for link to CiviCRM
		cj('#branding div.breadcrumb').html('<a href="/">Home</a> » <a href="/user">BCSLA User Profile</a> » Continuing Education Reporting');
	
        cj('#credit_date').datepicker({
        	dateFormat: 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:+1y',
            maxDate: '+1y'
        });
    });
    
    
    cj('.delete.button').click(function(){	
    	
    	cj('<div></div>').appendTo('body')
        	.html('<div><p>Once an activity has been removed, it cannot be restored<br/>without manually re-entering it. Please confirm this deletion.</p></div>')
        	.dialog({
                modal: true, title: 'DELETE CONFIRMATION', zIndex: 10000, autoOpen: true,
                width: 'auto', resizable: false,
                buttons: {
                    Yes: function () {
                    	cj(this).dialog("close");
                    	top.location = "{/literal}{$delete_url}{literal}";
                    },
                    No: function () {
                    	cj(this).dialog("close");
                    	
                    }
                },
                close: function (event, ui) {
                    cj(this).remove();
                }
        });
        return false;
    });
        
        

//-->
</script>

{/literal} 
