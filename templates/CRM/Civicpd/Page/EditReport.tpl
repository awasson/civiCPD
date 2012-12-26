{$return_button} {$new_button}

<h3>{$sub_title}</h3>

<p><em>{$cpd_message}</em></p>
{$output}


{literal}
<script type="text/javascript">
<!-- 

	var jq = jQuery.noConflict();

	jq(function() {
        jq('#credit_date').datepicker({
        	dateFormat: 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:+1y',
            maxDate: '+1y'
        });
    });
    
    
    jq('.delete.button').click(function(){	
    	
    	jq('<div></div>').appendTo('body')
        	.html('<div><p>Once an entry has been removed it cannot be restored<br/> Please confirm this deletion.</p></div>')
        	.dialog({
                modal: true, title: 'Confirm Delete', zIndex: 10000, autoOpen: true,
                width: 'auto', resizable: false,
                buttons: {
                    Yes: function () {
                    	jq(this).dialog("close");
                    	top.location = "{/literal}{$delete_url}{literal}";
                    },
                    No: function () {
                    	jq(this).dialog("close");
                    	
                    }
                },
                close: function (event, ui) {
                    jq(this).remove();
                }
        });
        return false;
    });
        
        

//-->
</script>

{/literal} 
