{$return_button} {$new_button}

<h3>{$sub_title}</h3>

<p><em>{$cpd_message}</em></p>

{$output}


{literal}
<script type="text/javascript">
<!-- 

	jQuery(function() {
        jQuery('#credit_date').datepicker({
        	dateFormat: 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:+1y',
            maxDate: '+1y'
        });
    });

//-->
</script>

{/literal} 
