<?php
//j// BOF

/*n// NOTE
----------------------------------------------------------------------------
secured WebGine
net-based application engine
----------------------------------------------------------------------------
(C) direct Netware Group - All rights reserved
http://www.direct-netware.de/redirect.php?swg

The following license agreement remains valid unless any additions or
changes are being made by direct Netware Group in a written form.

This program is free software; you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the
Free Software Foundation; either version 2 of the License, or (at your
option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
more details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc.,
59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.
----------------------------------------------------------------------------
http://www.direct-netware.de/redirect.php?licenses;gpl
----------------------------------------------------------------------------
#echo(sWGcpAccountVersion)#
sWG/#echo(__FILEPATH__)#
----------------------------------------------------------------------------
NOTE_END //n*/
/**
* cp/account/swg_profile.php
*
* @internal   We are using phpDocumentor to automate the documentation process
*             for creating the Developer's Manual. All sections including
*             these special comments will be removed from the release source
*             code.
*             Use the following line to ensure 76 character sizes:
* ----------------------------------------------------------------------------
* @author     direct Netware Group
* @copyright  (C) direct Netware Group - All rights reserved
* @package    sWG
* @subpackage cp_account
* @uses       direct_product_iversion
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;gpl
*             GNU General Public License 2
*/

/* -------------------------------------------------------------------------
All comments will be removed in the "production" packages (they will be in
all development packets)
------------------------------------------------------------------------- */

//j// Basic configuration

/* -------------------------------------------------------------------------
Direct calls will be honored with an "exit ()"
------------------------------------------------------------------------- */

if (!defined ("direct_product_iversion")) { exit (); }

//j// Script specific commands

if (!isset ($direct_settings['account_password_bytemix'])) { $direct_settings['account_password_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
if (!isset ($direct_settings['account_secid_bytemix'])) { $direct_settings['account_secid_bytemix'] = ($direct_settings['swg_id'] ^ (strrev ($direct_settings['swg_id']))); }
if (!isset ($direct_settings['cp_https_account'])) { $direct_settings['cp_https_account'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['users_min'])) { $direct_settings['users_min'] = 3; }
if (!isset ($direct_settings['users_registration_credits_onetime'])) { $direct_settings['users_registration_credits_onetime'] = 200; }
if (!isset ($direct_settings['users_registration_credits_periodically'])) { $direct_settings['users_registration_credits_periodically'] = 0; }
if (!isset ($direct_settings['users_registration_time'])) { $direct_settings['users_registration_time'] = 864000; }
$direct_settings['additional_copyright'][] = array ("Module cp_account #echo(sWGcpAccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "edit"
case "edit":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }

	$g_tid = (isset ($direct_settings['dsd']['atid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['atid'])) : "");

	$direct_cachedata['page_this'] = "m=cp&s=account;profile&a=edit";
	$direct_cachedata['page_backlink'] = "m=cp&s=account;index&a=services";
	$direct_cachedata['page_homelink'] = "m=cp&s=account;index&a=services";

	if ($direct_classes['kernel']->service_init_default ())
	{
	if ($direct_settings['cp_account'])
	{
	if (($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3)||($direct_classes['kernel']->v_group_user_check_right ("account_profile_edit")))
	{
	//j// BOA
	$direct_classes['kernel']->service_https ($direct_settings['cp_https_account'],$direct_cachedata['page_this']);
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("account");

	if ($g_tid)
	{
		$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

		if (($g_task_array)&&(isset ($g_task_array['uuid']))&&($g_task_array['uuid'] == $direct_settings['uuid']))
		{
			if (empty ($g_task_array['account_users_marked'])) { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
			else
			{
				$g_userid = array_shift ($g_task_array['account_users_marked']);

				if ($direct_classes['kernel']->v_user_check ($g_userid,"",true))
				{
					direct_class_init ("output");
					$direct_classes['output']->redirect (direct_linker ("url1","m=account&s=profile&a=edit&dsd=auid+{$g_userid}++source+".(urlencode (base64_encode ("m=cp&s=account;index&a=services"))),false));
				}
				else { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
			}
		}
		else { $direct_classes['error_functions']->error_page ("standard","core_tid_invalid","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
	}
	else
	{
		$g_selector_id = uniqid ("");

$g_task_array = array (
"core_back_return" => "m=cp&s=account;index&a=services",
"core_sid" => "9c95319bf274672d6eae7eb97c3dfda5",
// md5 ("cp")
"account_marker_return" => "m=cp&s=account;profile&a=edit&dsd=atid+".$g_selector_id,
"account_marker_title_0" => direct_local_get ("account_profile_edit"),
"account_selection_done" => 0,
"account_selection_quantity" => 1,
"uuid" => $direct_settings['uuid']
);

		direct_tmp_storage_write ($g_task_array,$g_selector_id,"9c95319bf274672d6eae7eb97c3dfda5","task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 900));

		direct_class_init ("output");
		$direct_classes['output']->redirect (direct_linker ("url1","m=dataport&s=swgap;account;selector&dsd=dtheme+1++tid+".$g_selector_id,false));
	}
	//j// EOA
	}
	else { $direct_classes['error_functions']->error_page ("login","core_access_denied","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// ($direct_settings['a'] == "new")||($direct_settings['a'] == "new-save")
case "new":
case "new-save":
{
	$g_mode_save = (($direct_settings['a'] == "new-save") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=cp&s=account;profile&a=new";
		$direct_cachedata['page_homelink'] = "m=cp&s=account;index&a=services";
	}
	else
	{
		$direct_cachedata['page_this'] = "m=cp&s=account;profile&a=new";
		$direct_cachedata['page_backlink'] = "m=cp&s=account;index&a=services";
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];
	}

	if ($direct_classes['kernel']->service_init_default ())
	{
	if ($direct_settings['cp_account'])
	{
	if (($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3)||($direct_classes['kernel']->v_group_user_check_right ("account_profile_new")))
	{
	//j// BOA
	if ($g_mode_save) { direct_output_related_manager ("cp_account_profile_new_form_save","pre_module_service_action"); }
	else
	{
		direct_output_related_manager ("cp_account_profile_new_form","pre_module_service_action");
		$direct_classes['kernel']->service_https ($direct_settings['cp_https_account'],$direct_cachedata['page_this']);
	}

	if ($g_mode_save) { $direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_account.php",true); }
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	direct_local_integration ("account");
	direct_local_integration ("cp_account");

	if ($g_mode_save)
	{
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php");
		$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	}

	direct_class_init ("formbuilder");
	direct_class_init ("output");
	$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if ($g_mode_save)
	{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

		$direct_cachedata['i_cusername'] = (isset ($GLOBALS['i_cusername']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_cusername'])) : "");
		$direct_cachedata['i_cemail'] = (isset ($GLOBALS['i_cemail']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_cemail'])) : "");

		$direct_cachedata['i_cdo_registration'] = (isset ($GLOBALS['i_cdo_registration']) ? (str_replace ("'","",$GLOBALS['i_cdo_registration'])) : 0);
		$direct_cachedata['i_cdo_registration'] = str_replace ("<value value='$direct_cachedata[i_cdo_registration]' />","<value value='$direct_cachedata[i_cdo_registration]' /><selected value='1' />","<evars><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>");

		$direct_cachedata['i_csend_email'] = (isset ($GLOBALS['i_csend_email']) ? (str_replace ("'","",$GLOBALS['i_csend_email'])) : 1);
		$direct_cachedata['i_csend_email'] = str_replace ("<value value='$direct_cachedata[i_csend_email]' />","<value value='$direct_cachedata[i_csend_email]' /><selected value='1' />","<evars><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>");

		$direct_cachedata['i_csend_email_to'] = (isset ($GLOBALS['i_csend_email_to']) ? ($direct_classes['basic_functions']->inputfilter_basic ($GLOBALS['i_csend_email_to'])) : "");
	}
	else
	{
		$direct_cachedata['i_cusername'] = "";
		$direct_cachedata['i_cemail'] = "";
		$direct_cachedata['i_cdo_registration'] = "<evars><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>";
		$direct_cachedata['i_csend_email'] = "<evars><yes><value value='1' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>";
		$direct_cachedata['i_csend_email_to'] = "";
	}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_classes['formbuilder']->entry_add_text ("cusername",(direct_local_get ("core_username")),true,"l",$direct_settings['users_min'],100,((direct_local_get ("core_helper_username_1")).$direct_settings['users_min'].(direct_local_get ("core_helper_username_2"))),"",true);
	$direct_classes['formbuilder']->entry_add_email ("cemail",(direct_local_get ("account_email")),true,"l",5,255);
	$direct_classes['formbuilder']->entry_add_radio ("cdo_registration",(direct_local_get ("cp_account_registration_finalize")),true,(direct_local_get ("cp_account_helper_registration_finalize")),"",true);
	$direct_classes['formbuilder']->entry_add_select ("csend_email",(direct_local_get ("cp_account_registration_email_send")),false,"s",(direct_local_get ("cp_account_helper_registration_email_send")),"",true);
	$direct_classes['formbuilder']->entry_add_text ("csend_email_to",(direct_local_get ("cp_account_email_target")),false,"l",5,255,(direct_local_get ("cp_account_helper_registration_email_target")),"",true);

	$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get ($g_mode_save);

	if (($g_mode_save)&&($direct_classes['formbuilder']->check_result))
	{
/* -------------------------------------------------------------------------
Save data edited
------------------------------------------------------------------------- */

		$g_username_invalid_chars = preg_replace ("#[0-9a-zA-Z\!\$\%\&\/\(\)\{\}\[\]\?\@\*\~\#,\.\-\;_ ]#i","",$direct_cachedata['i_cusername']);

		$direct_classes['db']->init_select ($direct_settings['users_table']);
		$direct_classes['db']->define_attributes (array ("ddbusers_email"));

$g_select_criteria = ("<sqlconditions>
".($direct_classes['db']->define_row_conditions_encode ("ddbusers_email",$direct_cachedata['i_cemail'],"string"))."
<element1 attribute='ddbusers_deleted' value='0' type='string' />
</sqlconditions>");

		$direct_classes['db']->define_row_conditions ($g_select_criteria);
		$direct_classes['db']->define_limit (1);

		if ($direct_classes['db']->query_exec ("nr")) { $direct_classes['error_functions']->error_page ("standard","account_email_exists","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		elseif ($direct_classes['kernel']->v_user_check ("",$direct_cachedata['i_cusername'],true)) { $direct_classes['error_functions']->error_page ("standard","account_username_exists","SERVICE ERROR:<br />&quot;$direct_cachedata[i_cusername]&quot; has already been registered<br />sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		elseif (strlen ($g_username_invalid_chars)) { $direct_classes['error_functions']->error_page ("standard","account_username_invalid","SERVICE ERROR:<br />Allowed characters are: 0-9, a-z, A-Z as well as !$%&amp;/(){}[]?@*~#,.-;_ and space<br />sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		else
		{
			$g_vid = md5 (uniqid (""));
			$g_vid_timeout = ($direct_cachedata['core_time'] + $direct_settings['users_registration_time']);
			$g_password = substr ($g_vid,(mt_rand (0,21)),10);
			$g_secid = $direct_classes['basic_functions']->tmd5 ($g_vid."_{$g_vid_timeout}_{$direct_cachedata['i_cusername']}_{$direct_cachedata['i_cemail']}_".$g_password,$direct_settings['account_secid_bytemix']);

$g_vid_array = array (
"core_vid_module" => "account_registration",
"account_username" => $direct_cachedata['i_cusername'],
"account_email" => $direct_cachedata['i_cemail'],
"account_password" => $direct_classes['basic_functions']->tmd5 ($g_password,$direct_settings['account_password_bytemix']),
"account_secid" => $g_secid
);

			if (direct_tmp_storage_write ($g_vid_array,$g_vid,"a617908b172c473cb8e8cda059e55bf0","registration","evars",0,$g_vid_timeout))
			// md5 ("validation")
			{
				if ($direct_cachedata['i_csend_email'])
				{
					$direct_cachedata['i_cusername'] = addslashes ($direct_cachedata['i_cusername']);
					if (!strlen ($direct_cachedata['i_csend_email_to'])) { $direct_cachedata['i_csend_email_to'] = $direct_cachedata['i_cemail']; }
					$g_redirect_url = ((isset ($direct_settings['swg_redirect_url'])) ? $direct_settings['swg_redirect_url'] : $direct_settings['home_url']."/swg_redirect.php");

					$g_sendmailer_object = new direct_sendmailer_formtags ();
					$g_sendmailer_object->recipients_define (array ($direct_cachedata['i_csend_email_to'] => $direct_cachedata['i_cusername']));

					if ($direct_cachedata['i_cdo_registration'])
					{
						$g_title = direct_local_get ("cp_account_title_registration","text");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_administration","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_cusername] ($direct_cachedata[i_csend_email_to])[/contentform]
".(direct_local_get ("cp_account_registration","text"))."

".(direct_local_get ("core_username","text")).": $direct_cachedata[i_cusername]
".(direct_local_get ("account_email","text")).": $direct_cachedata[i_cemail]
".(direct_local_get ("core_password","text")).": $g_password

[hr]
".(direct_local_get ("account_secid_howto","text"))."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_secid,32,"\n",1))."

[hr]
(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])
All rights reserved");
					}
					else
					{
						$g_title = direct_local_get ("account_title_registration","text");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_administration","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_cusername] ($direct_cachedata[i_csend_email_to])[/contentform]
".(direct_local_get ("cp_account_validation_for_registration","text"))."

".(direct_local_get ("core_username","text")).": $direct_cachedata[i_cusername]
".(direct_local_get ("account_email","text")).": $direct_cachedata[i_cemail]
".(direct_local_get ("core_password","text")).": $g_password

[url]$g_redirect_url?validation;{$g_vid}[/url]

".(direct_local_get ("core_one_line_link","text"))."

[hr]
".(direct_local_get ("account_secid_howto","text"))."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_secid,32,"\n",1))."

[hr]
(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])
All rights reserved");
					}

					$g_sendmailer_object->message_set ($g_message);
					$g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".$g_title);
				}

				if ($direct_cachedata['i_cdo_registration']) { $direct_classes['output']->redirect (direct_linker ("url1","m=validation&dsd=idata+{$g_vid}++source+".(urlencode (base64_encode ("m=cp&s=account;index&a=services"))),false)); }
				else
				{
					$direct_cachedata['output_job'] = direct_local_get ("cp_account_profile_new");
					$direct_cachedata['output_job_desc'] = direct_local_get ("cp_account_done_profile_new");
					$direct_cachedata['output_jsjump'] = 2000;
					$direct_cachedata['output_pagetarget'] = direct_linker ("url0","m=cp&s=account;index&a=services");
					$direct_cachedata['output_scripttarget'] = direct_linker ("url0","m=cp&s=account;index&a=services",false);

					direct_output_related_manager ("cp_account_profile_new_form_save","post_module_service_action");
					$direct_classes['output']->oset ("default","done");
					$direct_classes['output']->options_flush (true);
					$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
					$direct_classes['output']->page_show ($direct_cachedata['output_job']);
				}
			}
			else { $direct_classes['error_functions']->error_page ("fatal","core_database_error","FATAL ERROR:<br />tmpStorager has reported an error<br />sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		}
	}
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
		$direct_cachedata['output_formtarget'] = "m=cp&s=account;profile&a=new-save";
		$direct_cachedata['output_formtitle'] = direct_local_get ("cp_account_profile_new");

		direct_output_related_manager ("cp_account_profile_new_form","post_module_service_action");
		$direct_classes['output']->oset ("default","form");
		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
	}
	//j// EOA
	}
	else { $direct_classes['error_functions']->error_page ("login","core_access_denied","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// ($direct_settings['a'] == "reset")||($direct_settings['a'] == "reset-save")
case "reset":
case "reset-save":
{
	$g_mode_save = (($direct_settings['a'] == "reset-save") ? true : false);
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=cp&s=account;profile&a=reset";
		$direct_cachedata['page_homelink'] = "m=cp&s=account;index&a=services";
	}
	else
	{
		$direct_cachedata['page_this'] = "m=cp&s=account;profile&a=reset";
		$direct_cachedata['page_backlink'] = "m=cp&s=account;index&a=services";
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];
	}

	if ($direct_classes['kernel']->service_init_default ())
	{
	if ($direct_settings['cp_account'])
	{
	if (($direct_settings['user']['type'] == "ad")||($direct_classes['kernel']->v_group_user_check_right ("account_profile_reset")))
	{
	//j// BOA
	if ($g_mode_save) { direct_output_related_manager ("cp_account_profile_reset_form_save","pre_module_service_action"); }
	else { direct_output_related_manager ("cp_account_profile_reset_form","pre_module_service_action"); }

	if ($g_mode_save) { $direct_classes['basic_functions']->settings_get ($direct_settings['path_data']."/settings/swg_account.php",true); }
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formbuilder.php");
	if ($g_mode_save) { $direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_sendmailer_formtags.php"); }
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("account");
	direct_local_integration ("cp_account");

	direct_class_init ("formbuilder");
	direct_class_init ("output");
	$direct_classes['output']->options_insert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if ($g_mode_save)
	{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

		$direct_cachedata['i_cuser'] = (isset ($GLOBALS['i_cuser']) ? (urlencode ($GLOBALS['i_cuser'])) : "");

		$direct_cachedata['i_cpassword'] = (isset ($GLOBALS['i_cpassword']) ? (str_replace ("'","",$GLOBALS['i_cpassword'])) : "");
		$direct_cachedata['i_cpassword'] = str_replace ("<value value='$direct_cachedata[i_cpassword]' />","<value value='$direct_cachedata[i_cpassword]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");

		$direct_cachedata['i_csecid'] = (isset ($GLOBALS['i_csecid']) ? (str_replace ("'","",$GLOBALS['i_csecid'])) : "");
		$direct_cachedata['i_csecid'] = str_replace ("<value value='$direct_cachedata[i_csecid]' />","<value value='$direct_cachedata[i_csecid]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");
	}
	else
	{
		$direct_cachedata['i_cuser'] = uniqid ("");

$g_task_array = array (
"core_back_return" => $direct_cachedata['page_this'],
"core_sid" => "9c95319bf274672d6eae7eb97c3dfda5",
// md5 ("cp")
"account_marker_title_0" => direct_local_get ("cp_account_profile_reset_select"),
"account_selection_done" => 0,
"account_selection_quantity" => 1,
"uuid" => $direct_settings['uuid']
);

		direct_tmp_storage_write ($g_task_array,$direct_cachedata['i_cuser'],"9c95319bf274672d6eae7eb97c3dfda5","task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 900));

		$direct_cachedata['i_cpassword'] = "<evars><no><value value='0' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>";
		$direct_cachedata['i_csecid'] = "<evars><no><value value='0' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>";
	}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_classes['formbuilder']->entry_add_embed ("cuser",(direct_local_get ("core_username")),false,"m=dataport&s=swgap;account;selector&dsd=",false,"s");
	$direct_classes['formbuilder']->entry_add ("spacer");
	$direct_classes['formbuilder']->entry_add_radio ("cpassword",(direct_local_get ("cp_account_profile_reset_password")),true);
	$direct_classes['formbuilder']->entry_add_radio ("csecid",(direct_local_get ("cp_account_profile_reset_secid")),true);

	$direct_cachedata['output_formelements'] = $direct_classes['formbuilder']->form_get ($g_mode_save);

	if (($g_mode_save)&&($direct_classes['formbuilder']->check_result))
	{
/* -------------------------------------------------------------------------
Save data edited
------------------------------------------------------------------------- */

		if (($direct_cachedata['i_cpassword'])||($direct_cachedata['i_csecid']))
		{
			$g_task_array = direct_tmp_storage_get ("evars",$direct_cachedata['i_cuser'],"","task_cache");
			$g_continue_check = false;

			if ((is_array ($g_task_array['account_users_marked']))&&(!empty ($g_task_array['account_users_marked'])))
			{
				$g_uid = array_shift ($g_task_array['account_users_marked']);
				$g_user_array = $direct_classes['kernel']->v_user_get ($g_uid,"",true);

				if (is_array ($g_user_array)) { $g_continue_check = true; }
				else { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
			}

			if ($g_continue_check)
			{
				$g_random_string = md5 (uniqid (""));
				$g_password = substr ($g_random_string,(mt_rand (0,21)),10);
				$g_secid = $direct_classes['basic_functions']->tmd5 ($g_random_string."_{$g_user_array['ddbusers_name']}_{$g_user_array['ddbusers_email']}_".$g_password,$direct_settings['account_secid_bytemix']);
				$g_username = addslashes ($g_user_array['ddbusers_name']);

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_administration","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $g_username ({$g_user_array['ddbusers_email']})[/contentform]
".(direct_local_get ("cp_account_profile_reset","text"))."\n\n");

				if ($direct_cachedata['i_cpassword'])
				{
					$g_message .= (direct_local_get ("core_password","text")).": $g_password\n\n";
					$g_user_array['ddbusers_password'] = $direct_classes['basic_functions']->tmd5 ($g_password,$direct_settings['account_password_bytemix']);
				}

				if ($direct_cachedata['i_csecid'])
				{
					if ($direct_cachedata['i_cpassword']) { $g_message .= "[hr]\n"; }

$g_message .= (direct_local_get ("account_secid_howto","text")."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_secid,32,"\n",1))."\n\n");

					$g_user_array['ddbusers_secid'] = $g_secid;
				}

				$g_message .= "[hr]\n(C) $direct_settings[swg_title_txt] ([url]{$direct_settings['home_url']}[/url])";

				$g_sendmailer_object = new direct_sendmailer_formtags ();
				$g_sendmailer_object->recipients_define (array ($g_user_array['ddbusers_email'] => $g_username));
				$g_sendmailer_object->message_set ($g_message);
				$g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".(direct_local_get ("cp_account_title_profile_reset","text")));

				$g_user_object = new direct_user ();

				if (($g_user_object)&&($g_user_object->set_update ($g_user_array))) { $g_continue_check = true; }
				else { $direct_classes['error_functions']->error_page ("fatal","core_database_error","sWG/#echo(__FILEPATH__)# _a=reset-save_ (#echo(__LINE__)#)"); }
			}
			else { $direct_classes['error_functions']->error_page ("standard","core_username_unknown","sWG/#echo(__FILEPATH__)# _a=reset-save_ (#echo(__LINE__)#)"); }
		}
		else { $g_continue_check = true; }

		if ($g_continue_check)
		{
			$direct_cachedata['output_job'] = direct_local_get ("cp_account_profile_reset");
			$direct_cachedata['output_job_desc'] = direct_local_get ("cp_account_done_profile_reset");
			$direct_cachedata['output_jsjump'] = 2000;
			$direct_cachedata['output_pagetarget'] = direct_linker ("url0","m=cp&s=account;index&a=services");
			$direct_cachedata['output_scripttarget'] = direct_linker ("url0","m=cp&s=account;index&a=services",false);

			direct_output_related_manager ("cp_account_profile_new_form_save","post_module_service_action");
			$direct_classes['output']->oset ("default","done");
			$direct_classes['output']->options_flush (true);
			$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
			$direct_classes['output']->page_show ($direct_cachedata['output_job']);
		}
	}
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
		$direct_cachedata['output_formtarget'] = "m=cp&s=account;profile&a=reset-save";
		$direct_cachedata['output_formtitle'] = direct_local_get ("cp_account_profile_reset");

		direct_output_related_manager ("cp_account_profile_reset_form","post_module_service_action");
		$direct_classes['output']->oset ("default","form");
		$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_classes['output']->header_elements ("<script language='JavaScript1.5' src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_default_filter.php.js++dbid+".$direct_settings['product_buildid'],true))."' type='text/javascript'><!-- // Filter logic module // --></script>","javascript_swg_default_filter.php.js");
		$direct_classes['output']->page_show ($direct_cachedata['output_formtitle']);
	}
	//j// EOA
	}
	else { $direct_classes['error_functions']->error_page ("login","core_access_denied","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>