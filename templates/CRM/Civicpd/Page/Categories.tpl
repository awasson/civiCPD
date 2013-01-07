
{* Output Categories *}
<p>
<form action="/civicrm/civicpd/EditCategories" method="get">
<input type="hidden" value="new" name="action">
<input type="submit" name="submit" id="submit" value="Add Category" class="form-submit-inline" />
</form>
</p>
<h3>Existing {$civi_cpd_long_name} Categories</h3> 
<p>&nbsp;</p>
<table class="civi-cpd-list" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <th class="sorting" rowspan="1" colspan="1">Category</th>
  <th class="sorting" rowspan="1" colspan="1">Description</th>
  <th class="" rowspan="1" colspan="1" style="text-align: center;">Credits (min)</th>
  <th class="" rowspan="1" colspan="1" style="text-align: center;">Credits (max)</th>
  <th class="" rowspan="1" colspan="1" style="text-align: center;">Action</th>
  </tr>
{$categories}
</table>
