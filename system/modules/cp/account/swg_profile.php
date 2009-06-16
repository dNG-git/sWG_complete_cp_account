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
$Id$
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

if (!isset ($direct_settings['cp_https_account'])) { $direct_settings['cp_https_account'] = false; }
if (!isset ($direct_settings['serviceicon_default_back'])) { $direct_settings['serviceicon_default_back'] = "mini_default_back.png"; }
$direct_settings['additional_copyright'][] = array ("Module cp_account #echo(sWGcpAccountVersion)# - (C) ","http://www.direct-netware.de/redirect.php?swg","direct Netware Group"," - All rights reserved");

//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "edit"
case "edit":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=edit_ (#echo(__LINE__)#)"); }

	$g_tid = (isset ($direct_settings['dsd']['atid']) ? ($direct_classes['basic_functions']->inputfilter_basic ($direct_settings['dsd']['atid'])) : "");

	$direct_cachedata['page_this'] = "m=cp&s=account;index&a=select";
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
		// md5 ("cp")
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
//j// EOS
}

//j// EOF
?>