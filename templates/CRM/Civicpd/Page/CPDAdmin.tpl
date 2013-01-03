<h3>Administration page in development...</h3>
<p>This page sets the defaults for Continued Professional development. </p>



<form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><strong>Membership types that report CPD activities:</strong></td>
  </tr>
  <tr>
    <td colspan="2">{$membership_checkboxes}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Defaults vocabulary settings:</strong></td>
  </tr>
  <tr>
    <td><label for="long_name">Name:</label></td>
    <td>
    <input name="long_name" type="text" id="long_name" size="60" value="{$long_name}" /></td>
  </tr>
  <tr>
    <td><label for="short_name">Short Name:</label></td>
    <td>
    <input type="text" name="short_name" id="short_name" value="{$short_name}" /></td>
  </tr>
  <tr>
    <td>
      <input type="submit" name="submit" id="submit" value="Submit" /></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

<p>Members can access and update their CPD reporting pages from their Contact Dashboard</p>

{literal}

<style type="text/css">

#crm-container p {
    font-family: Helvetica,Arial,Sans;
    font-size: 12px;
    margin-bottom: 4px;
    padding: 4px 6px;
}


</style>

{/literal} 