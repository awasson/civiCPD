<h3>Review and update your CPD activities.</h3>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody>
  	<tr valign="top">
      <th nowrap="">Continuing Professional Development Activities for: {$report_year}</th>
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
      <td nowrap="" height="18">| <a title="Click here to print this page" href="#">Print this page</a> |</td>
    </tr>
  </tbody>
</table>