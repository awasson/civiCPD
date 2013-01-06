<h3>{$long_name} Administration</h3>
<p>This page is in progress and only effects the membership types subject to {$short_name} activities. It will set the defaults for the {$long_name} system. </p>



<form method="post">
<input type="hidden" name="action" value="update" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><strong>Membership types subject to {$short_name} activities:</strong></td>
  </tr>
  <tr>
    <td colspan="2">{$membership_checkboxes}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Members can edit/update activities within:</strong></td>
  </tr>
  <tr>
    <td>{$member_edit_limit}</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Your organization's internal membership number:</strong><br/>
    Most organizations have an alphanumeric membership number attached to a members contact record. 
    By default the {$short_name} module uses the <i>'external_identifier'</i> however the <i>'user_unique_id'</i> can be used instead.</td>
  </tr>
  <tr>
    <td nowrap><label for="organization_member_number">Member number field:<label></td>
    <td>{$organization_member_number}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Defaults vocabulary settings:</strong></td>
  </tr>
  <tr>
    <td><label for="long_name">The name of this program:</label></td>
    <td>
    <input name="long_name" type="text" id="long_name" size="60" value="{$long_name}" /></td>
  </tr>
  <tr>
    <td><label for="short_name">Short name (abreviation):</label></td>
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

<p>Members can access and update their {$short_name} reporting pages from their Contact Dashboard</p>

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