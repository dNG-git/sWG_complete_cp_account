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
* cp/account/swg_index.php
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

if ($direct_settings['a'] == "index") { $direct_settings['a'] = "services"; }
//j// BOS
switch ($direct_settings['a'])
{
//j// $direct_settings['a'] == "services"
case "services":
{
	if (USE_debug_reporting) { direct_debug (1,"sWG/#echo(__FILEPATH__)# _a=services_ (#echo(__LINE__)#)"); }

	$direct_cachedata['output_page'] = (isset ($direct_settings['dsd']['page']) ? ($direct_classes['basic_functions']->inputfilter_number ($direct_settings['dsd']['page'])) : 1);

	$direct_cachedata['page_this'] = "m=cp&s=account;index&a=services&dsd=page+".$direct_cachedata['output_page'];
	$direct_cachedata['page_backlink'] = "m=cp&a=services";
	$direct_cachedata['page_homelink'] = "m=cp&a=services";

	if ($direct_classes['kernel']->service_init_default ())
	{
	if ($direct_settings['cp_account'])
	{
	if (($direct_classes['kernel']->v_usertype_get_int ($direct_settings['user']['type']) > 3)||($direct_classes['kernel']->v_group_user_check_right ("cp_account")))
	{
	//j// BOA
	direct_output_related_manager ("cp_account_index_services","pre_module_service_action");
	$direct_classes['kernel']->service_https ($direct_settings['cp_https_account'],$direct_cachedata['page_this']);
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/classes/swg_formtags.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_service_list.php");
	$direct_classes['basic_functions']->require_file ($direct_settings['path_system']."/functions/swg_tmp_storager.php");
	direct_local_integration ("cp_account");

	direct_class_init ("formtags");
	direct_class_init ("output");
	$direct_classes['output']->options_insert (2,"servicemenu","m=cp&a=services",(direct_local_get ("core_back")),$direct_settings['serviceicon_default_back'],"url0");

	$direct_cachedata['output_filter_fid'] = "cp_account_services";
	$direct_cachedata['output_filter_source'] = urlencode (base64_encode ($direct_cachedata['page_this']));
	$direct_cachedata['output_filter_text'] = "";
	$direct_cachedata['output_filter_tid'] = $direct_settings['uuid'];

	$g_task_array = direct_tmp_storage_get ("evars",$direct_settings['uuid'],"","task_cache");

	if (($g_task_array)&&(isset ($g_task_array['core_filter_cp_account_services']))&&($g_task_array['uuid'] == $direct_settings['uuid']))
	{
		$direct_cachedata['output_filter_text'] = $direct_classes['formtags']->decode ($g_task_array['core_filter_cp_account_services']);
		$g_services_array = direct_service_list_search ("cp_account",$direct_cachedata['output_filter_text'],"title-desc_preg",$direct_cachedata['output_page']);
	}
	else { $g_services_array = direct_service_list ("cp_account",$direct_cachedata['output_page']); }

	$direct_cachedata['output_services'] = $g_services_array['list'];

	$direct_cachedata['output_page'] = $g_services_array['data']['page'];
	$direct_cachedata['output_page_url'] = "m=cp&s=account;index&a=services&dsd=";
	$direct_cachedata['output_pages'] = $g_services_array['data']['pages'];
	$direct_cachedata['output_services_title'] = direct_local_get ("cp_account_service_list");

	direct_output_related_manager ("cp_account_index_services","post_module_service_action");
	$direct_classes['output']->oset ("default","service_list");
	$direct_classes['output']->header (false,true,$direct_settings['p3p_url'],$direct_settings['p3p_cp']);
	$direct_classes['output']->header_elements ("<script language='JavaScript' src='".(direct_linker_dynamic ("url0","s=cache&dsd=dfile+$direct_settings[path_mmedia]/swg_formbuilder.js++dbid+".$direct_settings['product_buildid'],true,false))."' type='text/javascript'><!-- // FormBuilder javascript functions // --></script>");
	$direct_classes['output']->page_show (direct_local_get ("cp_account_service_list"));
	//j// EOA
	}
	else { $direct_classes['error_functions']->error_page ("login","core_access_denied","sWG/#echo(__FILEPATH__)# _a=services_ (#echo(__LINE__)#)"); }
	}
	else { $direct_classes['error_functions']->error_page ("standard","core_service_inactive","sWG/#echo(__FILEPATH__)# _a=services_ (#echo(__LINE__)#)"); }
	}

	$direct_cachedata['core_service_activated'] = true;
	break 1;
}
//j// EOS
}

//j// EOF
?>