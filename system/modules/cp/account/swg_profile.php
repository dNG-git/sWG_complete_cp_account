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
* @since      v0.1.00
* @license    http://www.direct-netware.de/redirect.php?licenses;gpl
*             GNU General Public License 2
*/

/*#use(direct_use) */
use dNG\sWG\directSendmailerFormtags,
    dNG\sWG\web\directPyHelper;
/* #\n*/

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
if (!isset ($direct_settings['cp_account_password_default_reset_supported'])) { $direct_settings['cp_account_password_default_reset_supported'] = true; }
if (!isset ($direct_settings['cp_https_account'])) { $direct_settings['cp_https_account'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
if (!isset ($direct_settings['swg_pyhelper'])) { $direct_settings['swg_pyhelper'] = false; }
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

	$g_tid = (isset ($direct_settings['dsd']['tid']) ? ($direct_globals['basic_functions']->inputfilterBasic ($direct_settings['dsd']['tid'])) : "");

	$direct_cachedata['page_this'] = "m=cp;s=account+profile;a=edit";
	$direct_cachedata['page_backlink'] = "m=cp;s=account+index;a=services";
	$direct_cachedata['page_homelink'] = "m=cp;s=account+index;a=services";

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	if ($direct_settings['cp_account'])
	{
	if (($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type']) > 3)||($direct_globals['kernel']->vGroupUserCheckRight ("account_profile_edit")))
	{
	//j// BOA
	$direct_globals['kernel']->serviceHttps ($direct_settings['cp_https_account'],$direct_cachedata['page_this']);
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("account");

	if ($g_tid)
	{
		$g_task_array = direct_tmp_storage_get ("evars",$g_tid,"","task_cache");

		if (($g_task_array)&&(isset ($g_task_array['uuid']))&&($g_task_array['uuid'] == ($direct_globals['input']->uuidGet ())))
		{
			if (empty ($g_task_array['account_users_marked'])) { $direct_globals['output']->outputSendError ("standard","core_tid_invalid","","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
			else
			{
				$g_userid = array_shift ($g_task_array['account_users_marked']);

				if ($direct_globals['kernel']->vUserCheck ($g_userid,"",true)) { $direct_globals['output']->redirect (direct_linker ("url1","m=account;s=profile;a=edit;dsd=auid+{$g_userid}++source+".(urlencode (base64_encode ("m=cp;s=account+index;a=services"))),false)); }
				else { $direct_globals['output']->outputSendError ("standard","core_username_unknown","","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
			}
		}
		else { $direct_globals['output']->outputSendError ("standard","core_tid_invalid","","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
	}
	else
	{
		$g_tid = uniqid ("");

$g_task_array = array (
"core_back_return" => "m=cp;s=account+index;a=services",
"core_sid" => "9c95319bf274672d6eae7eb97c3dfda5",
// md5 ("cp")
"account_marker_return" => "m=cp;s=account+profile;a=edit;dsd=tid+".$g_tid,
"account_marker_title_0" => direct_local_get ("account_profile_edit"),
"account_selection_done" => 0,
"account_selection_quantity" => 1,
"uuid" => $direct_globals['input']->uuidGet ()
);

		direct_tmp_storage_write ($g_task_array,$g_tid,"9c95319bf274672d6eae7eb97c3dfda5","task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 900));
		$direct_globals['output']->redirect (direct_linker ("url1","m=account;s=selector;dsd=tid+".$g_tid,false));
	}
	//j// EOA
	}
	else { $direct_globals['output']->outputSendError ("login","core_access_denied","","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
	}
	else { $direct_globals['output']->outputSendError ("standard","core_service_inactive","","sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// ($direct_settings['a'] == "new")||($direct_settings['a'] == "new-save")
case "new":
case "new-save":
{
	$g_mode_ajax_dialog = false;
	$g_mode_save = false;

	if ($direct_settings['a'] == "new-save")
	{
		if ($direct_settings['ohandler'] == "ajax_dialog") { $g_mode_ajax_dialog = true; }
		$g_mode_save = true;
	}

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=cp;s=account+profile;a=new";
		$direct_cachedata['page_homelink'] = "m=cp;s=account+index;a=services";
	}
	else
	{
		$direct_cachedata['page_this'] = "m=cp;s=account+profile;a=new";
		$direct_cachedata['page_backlink'] = "m=cp;s=account+index;a=services";
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];
	}

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	if ($direct_settings['cp_account'])
	{
	if (($direct_globals['kernel']->vUsertypeGetInt ($direct_settings['user']['type']) > 3)||($direct_globals['kernel']->vGroupUserCheckRight ("account_profile_new")))
	{
	//j// BOA
	$g_mode = ($g_mode_ajax_dialog ? "_ajax" : "");

	if ($g_mode_save) { $direct_globals['output']->relatedManager ("cp_account_profile_new_form_save","pre_module_service_action".$g_mode); }
	else
	{
		$direct_globals['output']->relatedManager ("cp_account_profile_new_form","pre_module_service_action".$g_mode);
		$direct_globals['kernel']->serviceHttps ($direct_settings['cp_https_account'],$direct_cachedata['page_this']);
	}

	$direct_globals['basic_functions']->requireClass ('dNG\sWG\directFormbuilder');
	direct_local_integration ("account");
	direct_local_integration ("cp_account");

	if ($g_mode_save)
	{
		$direct_globals['basic_functions']->settingsGet ($direct_settings['path_data']."/settings/swg_account.php",true);
		$direct_globals['basic_functions']->requireClass ('dNG\sWG\directSendmailerFormtags');
		$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	}

	direct_class_init ("formbuilder");
	$direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if ($g_mode_save)
	{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

		$direct_cachedata['i_ausername'] = (isset ($GLOBALS['i_ausername']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_ausername'])) : "");
		$direct_cachedata['i_aemail'] = (isset ($GLOBALS['i_aemail']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_aemail'])) : "");
		$direct_cachedata['i_alang'] = (isset ($GLOBALS['i_alang']) ? (str_replace ("'","",$GLOBALS['i_alang'])) : $direct_settings['lang']);

		$direct_cachedata['i_ado_registration'] = (isset ($GLOBALS['i_ado_registration']) ? (str_replace ("'","",$GLOBALS['i_ado_registration'])) : 0);
		$direct_cachedata['i_ado_registration'] = str_replace ("<value value='$direct_cachedata[i_ado_registration]' />","<value value='$direct_cachedata[i_ado_registration]' /><selected value='1' />","<evars><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>");

		$direct_cachedata['i_asend_email'] = (isset ($GLOBALS['i_asend_email']) ? (str_replace ("'","",$GLOBALS['i_asend_email'])) : 1);
		$direct_cachedata['i_asend_email'] = str_replace ("<value value='$direct_cachedata[i_asend_email]' />","<value value='$direct_cachedata[i_asend_email]' /><selected value='1' />","<evars><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>");

		$direct_cachedata['i_asend_email_to'] = (isset ($GLOBALS['i_asend_email_to']) ? ($direct_globals['basic_functions']->inputfilterBasic ($GLOBALS['i_asend_email_to'])) : "");
	}
	else
	{
		$direct_cachedata['i_alang'] = $direct_settings['lang'];
		$direct_cachedata['i_ado_registration'] = "<evars><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>";
		$direct_cachedata['i_asend_email'] = "<evars><yes><value value='1' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no></evars>";
	}

	$g_languages_installed_array = array ();
	$g_languages_array = array ();

	if (file_exists ($direct_settings['path_data']."/lang/swg_languages_installed.xml"))
	{
		$g_file_data = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_languages_installed.xml");
		if ($g_file_data) { $g_languages_installed_array = direct_evars_get ($g_file_data); }
	}

	if (($g_languages_installed_array)&&(file_exists ($direct_settings['path_data']."/lang/swg_language_table.xml")))
	{
		$g_file_data = direct_file_get ("s0",$direct_settings['path_data']."/lang/swg_language_table.xml");
		if ($g_file_data) { $g_languages_array = direct_evars_get ($g_file_data); }
	}

	if ($g_languages_array)
	{
		$g_language_selected = $direct_cachedata['i_alang'];
		$direct_cachedata['i_alang'] = "<evars>";

		foreach ($g_languages_installed_array as $g_language)
		{
			$direct_cachedata['i_alang'] .= (($g_language == $g_language_selected) ? "<$g_language><value value='$g_language' /><selected value='1' />" : "<$g_language><value value='$g_language' />");
			if (isset ($g_languages_array[$g_language])) { $direct_cachedata['i_alang'] .= "<text><![CDATA[".(direct_html_encode_special ($g_languages_array[$g_language]['national']))."]]></text>"; }
			$direct_cachedata['i_alang'] .= "</$g_language>";
		}

		$direct_cachedata['i_alang'] .= "</evars>";
	}
	else { $direct_cachedata['i_alang'] = "<evars><$direct_settings[lang]><value value='$direct_settings[lang]' /><selected value='1' /></$direct_settings[lang]></evars>"; }

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_globals['formbuilder']->entryAddText (array ("name" => "ausername","title" => (direct_local_get ("core_username")),"required" => true,"size" => "s","min" => $direct_settings['users_min'],"max" => 100,"helper_text" => ((direct_local_get ("account_helper_username_1")).$direct_settings['users_min'].(direct_local_get ("account_helper_username_2")))));
	$direct_globals['formbuilder']->entryAddEMail (array ("name" => "aemail","title" => (direct_local_get ("account_email")),"required" => true,"size" => "l","min" => 5,"max" => 255));
	$direct_globals['formbuilder']->entryAdd ("spacer");
	$direct_globals['formbuilder']->entryAddRadio (array ("name" => "alang","title" => (direct_local_get ("account_language")),"required" => true));
	$direct_globals['formbuilder']->entryAddRadio (array ("name" => "ado_registration","title" => (direct_local_get ("cp_account_registration_finalize")),"required" => true,"helper_text" => (direct_local_get ("cp_account_helper_registration_finalize"))));
	$direct_globals['formbuilder']->entryAddSelect (array ("name" => "asend_email","title" => (direct_local_get ("cp_account_registration_email_send")),"helper_text" => (direct_local_get ("cp_account_helper_registration_email_send"))));
	$direct_globals['formbuilder']->entryAddEMail (array ("name" => "asend_email_to","title" => (direct_local_get ("cp_account_email_target")),"size" => "l","min" => 5,"max" => 255,"helper_text" => (direct_local_get ("cp_account_helper_registration_email_target"))));

	$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->formGet ($g_mode_save);

	if (($g_mode_save)&&($direct_globals['formbuilder']->check_result))
	{
/* -------------------------------------------------------------------------
Save data edited
------------------------------------------------------------------------- */

		$g_username_invalid_chars = preg_replace ("#[\w\!\$\%\&\/\(\)\{\}\[\]\?\@\*\~\#,\.\-\; ]#iu","",$direct_cachedata['i_ausername']);

		$direct_globals['db']->initSelect ($direct_settings['users_table']);
		$direct_globals['db']->defineAttributes (array ($direct_settings['users_table'].".ddbusers_email"));

$g_select_criteria = ("<sqlconditions>
<attribute value='{$direct_settings['users_table']}.ddbusers_email' />
".($direct_globals['db']->defineSearchConditionsTerm ($direct_cachedata['i_aemail']))."
</sqlconditions>");

		$direct_globals['db']->defineSearchConditions ($g_select_criteria);
		$direct_globals['db']->defineRowConditions ("<sqlconditions><element1 attribute='{$direct_settings['users_table']}.ddbusers_deleted' value='0' type='string' /></sqlconditions>");
		$direct_globals['db']->defineLimit (1);

		if ($direct_globals['db']->queryExec ("nr")) { $direct_globals['output']->outputSendError ("standard","account_email_exists","","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		elseif ($direct_globals['kernel']->vUserCheck ("",$direct_cachedata['i_ausername'],true)) { $direct_globals['output']->outputSendError ("standard","account_username_exists","SERVICE ERROR: &quot;$direct_cachedata[i_ausername]&quot; has already been registered","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		elseif (strlen ($g_username_invalid_chars)) { $direct_globals['output']->outputSendError ("standard","account_username_invalid","SERVICE ERROR: Allowed characters are: 0-9, a-z, A-Z as well as !$%&amp;/(){}[]?@*~#,.-;_ and space","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		else
		{
			$g_vid = md5 (uniqid (""));
			$g_vid_timeout = ($direct_cachedata['core_time'] + $direct_settings['users_registration_time']);
			$g_password = substr ($g_vid,(mt_rand (0,21)),10);
			$g_secid = $direct_globals['basic_functions']->tmd5 ($g_vid."_{$g_vid_timeout}_{$direct_cachedata['i_ausername']}_{$direct_cachedata['i_aemail']}_".$g_password,$direct_settings['account_secid_bytemix']);

$g_vid_array = array (
"core_vid_module" => "account_registration",
"account_username" => $direct_cachedata['i_ausername'],
"account_email" => $direct_cachedata['i_aemail'],
"account_password" => $direct_globals['basic_functions']->tmd5 ($g_password,$direct_settings['account_password_bytemix']),
"account_secid" => $g_secid
);

			if (direct_tmp_storage_write ($g_vid_array,$g_vid,"a617908b172c473cb8e8cda059e55bf0","registration","evars",0,$g_vid_timeout))
			// md5 ("validation")
			{
				if ($direct_cachedata['i_asend_email'])
				{
					$direct_cachedata['i_ausername'] = addslashes ($direct_cachedata['i_ausername']);
					if (!strlen ($direct_cachedata['i_asend_email_to'])) { $direct_cachedata['i_asend_email_to'] = $direct_cachedata['i_aemail']; }

					if ($direct_cachedata['i_alang'] != $direct_settings['lang'])
					{
						direct_local_integration ("core","en",true,$direct_cachedata['i_alang']);
						direct_local_integration ("account","en",true,$direct_cachedata['i_alang']);
						direct_local_integration ("cp_account","en",true,$direct_cachedata['i_alang']);
					}

					if ($direct_cachedata['i_ado_registration'])
					{
						$g_title = direct_local_get ("cp_account_title_registration","text");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_administration","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_ausername] ($direct_cachedata[i_asend_email_to])[/contentform]
".(direct_local_get ("cp_account_registration","text"))."

".(direct_local_get ("core_username","text")).": $direct_cachedata[i_ausername]
".(direct_local_get ("account_email","text")).": $direct_cachedata[i_aemail]
".(direct_local_get ("core_password","text")).": $g_password

[hr]
".(direct_local_get ("account_secid_howto","text"))."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_secid,32,"\n",1)));
					}
					else
					{
						$g_redirect_url = ((isset ($direct_settings['swg_redirect_url'])) ? $direct_settings['swg_redirect_url'] : $direct_settings['home_url']."/swg_redirect.php?");
						$g_title = direct_local_get ("account_title_registration","text");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_administration","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $direct_cachedata[i_ausername] ($direct_cachedata[i_asend_email_to])[/contentform]

".(direct_local_get ("cp_account_validation_for_registration","text"))."

".(direct_local_get ("core_username","text")).": $direct_cachedata[i_ausername]
".(direct_local_get ("account_email","text")).": $direct_cachedata[i_aemail]
".(direct_local_get ("core_password","text")).": $g_password

[url]{$g_redirect_url}validation;{$g_vid}[/url]

".(direct_local_get ("core_one_line_link","text"))."

[hr]
".(direct_local_get ("account_secid_howto","text"))."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_secid,32,"\n",1)));
					}

					if ($direct_cachedata['i_alang'] != $direct_settings['lang'])
					{
						direct_local_integration ("core","en",true);
						direct_local_integration ("account","en",true);
						direct_local_integration ("cp_account","en",true);
					}

					$g_continue_check = false;

					if (($direct_settings['swg_pyhelper'])&&(direct_autoload ('dNG\sWG\web\directPyHelper')))
					{
						$g_daemon_object = new directPyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $direct_cachedata['i_asend_email_to'],
"data" => direct_evars_write (array (
 "core_lang" => $direct_cachedata['i_alang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $direct_cachedata['i_asend_email_to'],
 "account_sendmail_recipient_name" => $direct_cachedata['i_ausername'],
 "account_sendmail_title" => $g_title
 ))
);

						$g_continue_check = $g_daemon_object->resourceCheck ();

						if ($g_continue_check) { $g_continue_check = $g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",(array ($g_entry_array))); }
						else { $direct_globals['output']->outputSendError ("standard","core_daemon_unavailable","","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
					}
					else
					{
						$g_sendmailer_object = new directSendmailerFormtags ();
						$g_sendmailer_object->recipientsDefine (array ($direct_cachedata['i_asend_email_to'] => $direct_cachedata['i_ausername']));

						$g_sendmailer_object->messageSet ($g_message);
						$g_continue_check = $g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".$g_title);
					}
				}
				else { $g_continue_check = true; }

				if ($g_continue_check)
				{
					if ($direct_cachedata['i_ado_registration']) { $direct_globals['output']->redirect (direct_linker ("url1","m=validation;dsd=idata+{$g_vid}++source+".(urlencode (base64_encode ("m=cp;s=account+index;a=services"))),false)); }
					else
					{
						$direct_cachedata['output_job'] = direct_local_get ("cp_account_profile_new");
						$direct_cachedata['output_job_desc'] = direct_local_get ("cp_account_done_profile_new");
						$direct_cachedata['output_jsjump'] = 2000;
						$direct_cachedata['output_pagetarget'] = direct_linker ("url0","m=cp;s=account+index;a=services");

						$direct_globals['output']->relatedManager ("cp_account_profile_new_form_save","post_module_service_action".$g_mode);
						$direct_globals['output']->optionsFlush (true);
						$direct_globals['output']->oset ("default","done");

						if ($g_mode_ajax_dialog)
						{
							$direct_globals['output']->header (false,true);
							$direct_globals['output']->outputSend (direct_local_get ("core_done").": ".$direct_cachedata['output_job']);
						}
						else
						{
							$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
							$direct_globals['output']->outputSend ($direct_cachedata['output_job']);
						}
					}
				}
				else { $direct_globals['output']->outputSendError ("standard","core_unknown_error","","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
			}
			else { $direct_globals['output']->outputSendError ("fatal","core_database_error","FATAL ERROR: tmpStorager has reported an error","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
		}
	}
	elseif ($g_mode_ajax_dialog)
	{
		$direct_globals['output']->header (false,true);
		$direct_globals['output']->relatedManager ("cp_account_profile_new_form_save","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","form_results");
		$direct_globals['output']->outputSend (direct_local_get ("formbuilder_error"));
	}
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
		$direct_cachedata['output_formsupport_ajax_dialog'] = true;
		$direct_cachedata['output_formtarget'] = "m=cp;s=account+profile;a=new-save";
		$direct_cachedata['output_formtitle'] = direct_local_get ("cp_account_profile_new");

		$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_globals['output']->relatedManager ("cp_account_profile_new_form","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","form");
		$direct_globals['output']->outputSend ($direct_cachedata['output_formtitle']);
	}
	//j// EOA
	}
	else { $direct_globals['output']->outputSendError ("login","core_access_denied","","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}
	else { $direct_globals['output']->outputSendError ("standard","core_service_inactive","","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// ($direct_settings['a'] == "reset")||($direct_settings['a'] == "reset-save")
case "reset":
case "reset-save":
{
	$g_mode_ajax_dialog = false;
	$g_mode_save = false;

	if ($direct_settings['a'] == "reset-save")
	{
		if ($direct_settings['ohandler'] == "ajax_dialog") { $g_mode_ajax_dialog = true; }
		$g_mode_save = true;
	}

	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }

	if ($g_mode_save)
	{
		$direct_cachedata['page_this'] = "";
		$direct_cachedata['page_backlink'] = "m=cp;s=account+profile;a=reset";
		$direct_cachedata['page_homelink'] = "m=cp;s=account+index;a=services";
	}
	else
	{
		$direct_cachedata['page_this'] = "m=cp;s=account+profile;a=reset";
		$direct_cachedata['page_backlink'] = "m=cp;s=account+index;a=services";
		$direct_cachedata['page_homelink'] = $direct_cachedata['page_backlink'];
	}

	if ($direct_globals['kernel']->serviceInitDefault ())
	{
	if (($direct_settings['cp_account'])&&($direct_settings['cp_account_password_default_reset_supported']))
	{
	if (($direct_settings['user']['type'] == "ad")||($direct_globals['kernel']->vGroupUserCheckRight ("account_profile_reset")))
	{
	//j// BOA
	$g_mode = ($g_mode_ajax_dialog ? "_ajax" : "");

	if ($g_mode_save) { $direct_globals['output']->relatedManager ("cp_account_profile_reset_form_save","pre_module_service_action".$g_mode); }
	else
	{
		$direct_globals['output']->relatedManager ("cp_account_profile_reset_form","pre_module_service_action".$g_mode);
		$direct_globals['kernel']->serviceHttps ($direct_settings['cp_https_account'],$direct_cachedata['page_this']);
	}

	$direct_globals['basic_functions']->requireClass ('dNG\sWG\directFormbuilder');
	$direct_globals['basic_functions']->requireFile ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("account");
	direct_local_integration ("cp_account");

	if ($g_mode_save)
	{
		$direct_globals['basic_functions']->settingsGet ($direct_settings['path_data']."/settings/swg_account.php",true);
		$direct_globals['basic_functions']->requireClass ('dNG\sWG\directSendmailerFormtags');
	}

	direct_class_init ("formbuilder");
	$direct_globals['output']->optionsInsert (2,"servicemenu",$direct_cachedata['page_backlink'],(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	if ($g_mode_save)
	{
/* -------------------------------------------------------------------------
We should have input in save mode
------------------------------------------------------------------------- */

		$direct_cachedata['i_auser'] = (isset ($GLOBALS['i_auser']) ? (urlencode ($GLOBALS['i_auser'])) : "");

		$direct_cachedata['i_apassword'] = (isset ($GLOBALS['i_apassword']) ? (str_replace ("'","",$GLOBALS['i_apassword'])) : "");
		$direct_cachedata['i_apassword'] = str_replace ("<value value='$direct_cachedata[i_apassword]' />","<value value='$direct_cachedata[i_apassword]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");

		$direct_cachedata['i_asecid'] = (isset ($GLOBALS['i_asecid']) ? (str_replace ("'","",$GLOBALS['i_asecid'])) : "");
		$direct_cachedata['i_asecid'] = str_replace ("<value value='$direct_cachedata[i_asecid]' />","<value value='$direct_cachedata[i_asecid]' /><selected value='1' />","<evars><no><value value='0' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>");
	}
	else
	{
		$direct_cachedata['i_auser'] = uniqid ("");

$g_task_array = array (
"core_back_return" => $direct_cachedata['page_this'],
"core_sid" => "9c95319bf274672d6eae7eb97c3dfda5",
// md5 ("cp")
"account_marker_title_0" => direct_local_get ("cp_account_profile_reset_select"),
"account_selection_done" => 0,
"account_selection_quantity" => 1,
"account_selection_title_hidden" => true,
"uuid" => $direct_globals['input']->uuidGet ()
);

		direct_tmp_storage_write ($g_task_array,$direct_cachedata['i_auser'],"9c95319bf274672d6eae7eb97c3dfda5","task_cache","evars",$direct_cachedata['core_time'],($direct_cachedata['core_time'] + 900));

		$direct_cachedata['i_apassword'] = "<evars><no><value value='0' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>";
		$direct_cachedata['i_asecid'] = "<evars><no><value value='0' /><selected value='1' /><text><![CDATA[".(direct_local_get ("core_no"))."]]></text></no><yes><value value='1' /><text><![CDATA[".(direct_local_get ("core_yes"))."]]></text></yes></evars>";
	}

/* -------------------------------------------------------------------------
Build the form
------------------------------------------------------------------------- */

	$direct_globals['formbuilder']->entryAddEmbed (array ("name" => "auser","title" => (direct_local_get ("core_username")),"size" => "m"),"m=account;s=selector;dsd=");
	$direct_globals['formbuilder']->entryAdd ("spacer");
	$direct_globals['formbuilder']->entryAddRadio (array ("name" => "apassword","title" => (direct_local_get ("cp_account_profile_reset_password")),"required" => true));
	$direct_globals['formbuilder']->entryAddRadio (array ("name" => "asecid","title" => (direct_local_get ("cp_account_profile_reset_secid")),"required" => true));

	$direct_cachedata['output_formelements'] = $direct_globals['formbuilder']->formGet ($g_mode_save);

	if (($g_mode_save)&&($direct_globals['formbuilder']->check_result))
	{
/* -------------------------------------------------------------------------
Save data edited
------------------------------------------------------------------------- */

		if (($direct_cachedata['i_apassword'])||($direct_cachedata['i_asecid']))
		{
			$g_task_array = direct_tmp_storage_get ("evars",$direct_cachedata['i_auser'],"","task_cache");
			$g_continue_check = false;

			if ((is_array ($g_task_array['account_users_marked']))&&(!empty ($g_task_array['account_users_marked'])))
			{
				$g_uid = array_shift ($g_task_array['account_users_marked']);
				$g_user_array = $direct_globals['kernel']->vUserGet ($g_uid,"",true);

				if (is_array ($g_user_array)) { $g_continue_check = true; }
				else { $direct_globals['output']->outputSendError ("standard","core_username_unknown","","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
			}

			if ($g_continue_check)
			{
				$g_random_string = md5 (uniqid (""));
				$g_password = substr ($g_random_string,(mt_rand (0,21)),10);
				$g_secid = $direct_globals['basic_functions']->tmd5 ($g_random_string."_{$g_user_array['ddbusers_name']}_{$g_user_array['ddbusers_email']}_".$g_password,$direct_settings['account_secid_bytemix']);
				$g_username = addslashes ($g_user_array['ddbusers_name']);

				direct_local_integration ("core","en",true,$g_user_array['ddbusers_lang']);
				direct_local_integration ("account","en",true,$g_user_array['ddbusers_lang']);
				direct_local_integration ("cp_account","en",true,$g_user_array['ddbusers_lang']);

				$g_title = direct_local_get ("cp_account_title_profile_reset","text");

$g_message = ("[contentform:highlight]".(direct_local_get ("core_message_by_administration","text"))."

[font:bold]".(direct_local_get ("core_message_to","text")).":[/font] $g_username ({$g_user_array['ddbusers_email']})[/contentform]

".(direct_local_get ("cp_account_profile_reset_message","text"))."\n\n");

				if ($direct_cachedata['i_apassword'])
				{
					$g_message .= (direct_local_get ("core_password","text")).": $g_password\n\n";
					$g_user_array['ddbusers_password'] = $direct_globals['basic_functions']->tmd5 ($g_password,$direct_settings['account_password_bytemix']);
				}

				if ($direct_cachedata['i_asecid'])
				{
					if ($direct_cachedata['i_apassword']) { $g_message .= "[hr]\n"; }

$g_message .= (direct_local_get ("account_secid_howto","text")."

".(direct_local_get ("account_secid","text")).":
".(wordwrap ($g_secid,32,"\n",1)));

					$g_user_array['ddbusers_secid'] = $g_secid;
				}

				direct_local_integration ("core","en",true);
				direct_local_integration ("account","en",true);
				direct_local_integration ("cp_account","en",true);
				$g_continue_check = false;

				if (($direct_settings['swg_pyhelper'])&&(direct_autoload ('dNG\sWG\web\directPyHelper')))
				{
					$g_daemon_object = new directPyHelper ();

$g_entry_array = array (
"id" => uniqid (""),
"name" => "de.direct_netware.sWG.plugins.sendmail",
"identifier" => $g_user_array['ddbusers_email'],
"data" => direct_evars_write (array (
 "core_lang" => $g_user_array['ddbusers_lang'],
 "account_sendmail_message" => $g_message,
 "account_sendmail_recipient_email" => $g_user_array['ddbusers_email'],
 "account_sendmail_recipient_name" => $g_username,
 "account_sendmail_title" => $g_title
 ))
);

					$g_continue_check = $g_daemon_object->resourceCheck ();

					if ($g_continue_check) { $g_continue_check = $g_daemon_object->request ("de.direct_netware.psd.plugins.queue.addEntry",(array ($g_entry_array))); }
					else { $direct_globals['output']->outputSendError ("standard","core_daemon_unavailable","","sWG/#echo(__FILEPATH__)# _a=new-save_ (#echo(__LINE__)#)"); }
				}
				else
				{
					$g_sendmailer_object = new directSendmailerFormtags ();
					$g_sendmailer_object->recipientsDefine (array ($g_user_array['ddbusers_email'] => $g_username));

					$g_sendmailer_object->messageSet ($g_message);
					$g_continue_check = $g_sendmailer_object->send ("single",$direct_settings['administration_email_out'],$direct_settings['swg_title_txt']." - ".$g_title);
				}

				$g_user_object = new direct_user ();

				if (($g_user_object)&&($g_user_object->setUpdate ($g_user_array))) { $g_continue_check = true; }
				else { $direct_globals['output']->outputSendError ("fatal","core_database_error","","sWG/#echo(__FILEPATH__)# _a=reset-save_ (#echo(__LINE__)#)"); }
			}
			else { $direct_globals['output']->outputSendError ("standard","core_username_unknown","","sWG/#echo(__FILEPATH__)# _a=reset-save_ (#echo(__LINE__)#)"); }
		}
		else { $g_continue_check = true; }

		if ($g_continue_check)
		{
			$direct_cachedata['output_job'] = direct_local_get ("cp_account_profile_reset");
			$direct_cachedata['output_job_desc'] = direct_local_get ("cp_account_done_profile_reset");
			$direct_cachedata['output_jsjump'] = 2000;
			$direct_cachedata['output_pagetarget'] = direct_linker ("url0","m=cp;s=account+index;a=services");

			$direct_globals['output']->relatedManager ("cp_account_profile_reset_form_save","post_module_service_action".$g_mode);
			$direct_globals['output']->optionsFlush (true);
			$direct_globals['output']->oset ("default","done");

			if ($g_mode_ajax_dialog)
			{
				$direct_globals['output']->header (false,true);
				$direct_globals['output']->outputSend (direct_local_get ("core_done").": ".$direct_cachedata['output_job']);
			}
			else
			{
				$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
				$direct_globals['output']->outputSend ($direct_cachedata['output_job']);
			}
		}
	}
	elseif ($g_mode_ajax_dialog)
	{
		$direct_globals['output']->header (false,true);
		$direct_globals['output']->relatedManager ("cp_account_profile_reset_form_save","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","form_results");
		$direct_globals['output']->outputSend (direct_local_get ("formbuilder_error"));
	}
	else
	{
/* -------------------------------------------------------------------------
View form
------------------------------------------------------------------------- */

		$direct_cachedata['output_formbutton'] = direct_local_get ("core_continue");
		$direct_cachedata['output_formsupport_ajax_dialog'] = true;
		$direct_cachedata['output_formtarget'] = "m=cp;s=account+profile;a=reset-save";
		$direct_cachedata['output_formtitle'] = direct_local_get ("cp_account_profile_reset");

		$direct_globals['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
		$direct_globals['output']->relatedManager ("cp_account_profile_reset_form","post_module_service_action".$g_mode);
		$direct_globals['output']->oset ("default","form");
		$direct_globals['output']->outputSend ($direct_cachedata['output_formtitle']);
	}
	//j// EOA
	}
	else { $direct_globals['output']->outputSendError ("login","core_access_denied","","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}
	else { $direct_globals['output']->outputSendError ("standard","core_service_inactive","","sWG/#echo(__FILEPATH__)# _a={$direct_settings['a']}_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>