{*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.2                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2012                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*}

<table class="dashboard-elements">


{* 
+--------------------------------------------------------------------+
| AWASSON 12/05/2012 - Continuing Education Information Here         |
|                                                                    |
| We will be adding code to this block so that a contact/member can  |
| link to their reporting page where they can review and update      |
| their CPD Activities for the year.                                 |
|                                                                    |
| We will add a model or equivalent template to query the database   |
| and provide a CPD synopsis with link to reporting page.            |
|                                                                    |
+--------------------------------------------------------------------+
*}

<tr>
	<td>
    	<div class="header-dark">
    	{ts}Your {$civi_cpd_long_name} Credits{/ts} 
        </div>	  
        <div id="cpddescription">
    		<div class="view-content"> 
                <div class="messages status">
                	<div class="icon inform-icon"></div>
                    {$mcd_cpd_message}            
                </div>            
				<div class="form-item">&nbsp;</div>	
            </div>
		</div>	
    </td>
</tr>


{if $showGroup}
    <tr>
        <td>
          <div class="header-dark">
          {ts}Your Group(s){/ts}  
          </div>	  
          {include file="CRM/Contact/Page/View/UserDashBoard/GroupContact.tpl"}	
            
        </td>
    </tr>
{/if}

    {foreach from=$dashboardElements item=element}
    <tr>
        <td>
            <div class="header-dark">{$element.sectionTitle}</div>	        
            {include file=$element.templatePath}
        </td>
    </tr>
    {/foreach}
</table>
