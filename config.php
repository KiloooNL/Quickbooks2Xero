<?php
/**
 * Quickbooks2Xero
 * 	coded by Ben Weidenhofer
 *
 * Config file
 */

########################################
# Server directories
#	: include trailing slash
#	: leave blank for default
#
#   STATS_DIR: the directory you will want to display server statistics
#   CONFIG_DIR: the directory for this file.
########################################
define("QUICKBOOKS_CODE", "quickbooks_");
define("XERO_CODE", "xero_");


########################################
# Server directories
#	: include trailing slash
#
#   UPLOAD_DIR: the temp upload directory
########################################
define("UPLOAD_DIR", "uploads/");


########################################
# Debugging settings
#
#   DEBUG_ENABLED: True = Enabled
########################################
define("DEBUG_ENABLED", true);



/************************************************
 *  WARNING!
 *
 * DO NOT EDIT CODE BELOW THIS LINE
 * UNLESS YOU KNOW WHAT YOU'RE DOING
 ***********************************************/

$csvInArray = array();

// Require functions.php
require_once("functions.php");
?>