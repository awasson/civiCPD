<h3>Use the form below to edit this category</h3>
<p>&nbsp;</p>
<form action="/civicrm/civicpd/categories" method="post">
  <input type="hidden" value="{$id}" name="catid">
  <input type="hidden" value="{$action}" name="action">
  <table width="500" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td>Category:</td>
      <td><input type="text" name="category" id="category" value="{$category}" class="required" /></td>
    </tr>
    <tr>
      <td>Description:</td>
      <td><textarea name="description" id="description" cols="45" rows="5" class="required">{$description}</textarea></td>
    </tr>
    <tr>
      <td>Min Credits:</td>
      <td><input name="minimum" type="text" id="minimum" size="4" value="{$minimum}" class="required" /></td>
    </tr>
    <tr>
      <td>Max Credits:</td>
      <td><input name="maximum" type="text" id="maximum" size="4" value="{$maximum}" class="required" /></td>
    </tr>
    <tr>
      <td colspan="2">
      	{$submit_button} &nbsp; 
      	{$cancel_button} &nbsp; 
        {$delete_button}
      </td>
    </tr>
  </table>
</form>
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

	cj('.delete.button').click(function(){	
    	
    	cj('<div></div>').appendTo('body')
        	.html('<div><p>Once a category has been removed, it cannot be restored<br/>without manually re-entering it. Please confirm this deletion.</p></div>')
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