<?php

$l['ipatrol_desc'] = "A Plugin for MyBB to take better control over visitors.";
$l['ipatrol_locateuser_title'] = "Locate users based on their IP address.";
$l['ipatrol_locateuser_desc'] = "Allow admins and mods with permission to fetch various details of the user based on their IP.";
$l['ipatrol_apicachelimit_title'] = "Number of API calls to cache";
$l['ipatrol_apicachelimit_desc'] = "This can reduce external API calls and load site faster. You may increase the number if you have a large user base. Note that very bigger number of cache entries have negative performance impact too.";
$l['ipatrol_banproxy_title'] = "Ban users using proxy";
$l['ipatrol_banproxy_desc'] = "Ban the IP address of the users who use proxy to access the site.";
$l['ipatrol_whitegids_title'] = "Usergroups to allow using proxy";
$l['ipatrol_whitegids_desc'] = "Users under any of these groups will not be banned even if they use proxy to access the site (separated by comma).";
$l['ipatrol_whiteip_title'] = "Whitelist IP addresses";
$l['ipatrol_whiteip_desc'] = "Whitelist known IP addresses and those will never be banned by iPatrol. Enter single IP in each line.";
$l['ipatrol_postcheck_title'] = "Auto unapprove spam posts";
$l['ipatrol_postcheck_desc'] = "Scan the posts made by new users (users having less post count) for spam (external) links and auto unapprove those.";
$l['ipatrol_postcheckedit_title'] = "Detect late edit spamming";
$l['ipatrol_postcheckedit_desc'] = "Scan the posts for spam (external) links during late edit by smart spammers and auto unapprove those.";
$l['ipatrol_postcheckword_title'] = "Scan for words to determine spamming";
$l['ipatrol_postcheckword_desc'] = "Scan the posts for certain words / strings to determine the post as spam (separated by comma).";
$l['ipatrol_postchecknum_title'] = "Spam detection post count";
$l['ipatrol_postchecknum_desc'] = "The post count limit for spam detection. Posts will be scanned for spam link by users having less of this post count.";
$l['ipatrol_postcheckgids_title'] = "Usergroups to scan for spamming";
$l['ipatrol_postcheckgids_desc'] = "The affected usergroups for spam check (GIDs, separated by comma). Check will be performed if posting user belongs to one of these groups.";
$l['ipatrol_postcheckwlist_title'] = "Whitelisted users from spam check";
$l['ipatrol_postcheckwlist_desc'] = "Define the user IDs whose posts will not be checked from spamming (separated by comma)";
// $l['ipatrol_honeypot_title'] = "Add Form Honeypot";
// $l['ipatrol_honeypot_desc'] = "Add an extra layer of security by using a honeypot for each form submission to attempt catching automation.";
// $l['ipatrol_honeypact_title'] = "Ban IPs teapped in Honeypot";
// $l['ipatrol_honeypact_desc'] = "Set yes to ban the IP addresses trapped in honeypot. Setting no will only restrict the form submission only.";
// $l['ipatrol_noregdupe_title'] = "Restrict duplicate user registration";
// $l['ipatrol_noregdupe_desc'] = "Restrict registration of the users who already has an account registered with same IP.";
// $l['ipatrol_skipregdupe_title'] = "Exclude groups from restricting registration";
// $l['ipatrol_skipregdupe_desc'] = "Skip restricting registration if the user belongs to the group.";
$l['ipatrol_detectbot_title'] = "Automatically detect spiders visiting your site";
$l['ipatrol_detectbot_desc'] = "Detect new / unregistered spiders that MyBB is considering as guest.";
$l['ipatrol_autoaddbot_title'] = "Add the detected spider to database";
$l['ipatrol_autoaddbot_desc'] = "Update spider database so that MyBB detects it and the new spider name can show up in online list.";
$l['ipatrol_uashortbot_title'] = "Use the keyword for User Agent String";
$l['ipatrol_uashortbot_desc'] = "Using keyword in place of whole user agent string has a greater chance to detect similar strings.";
$l['ipatrol_uashortbot_option_1'] = "Save full user agent string";
$l['ipatrol_uashortbot_option_2'] = "Save keyword only";
$l['ipatrol_similarbot_title'] = "Check Similar Named Spiders";
$l['ipatrol_similarbot_desc'] = "Find for similar named spiders and if exists just notify for manual action. Setting this on will not add the spider to the database in case of a match.";
$l['ipatrol_simstrength_title'] = "Spider name existance match strength";
$l['ipatrol_simstrength_desc'] = "The % strength of the matching. A lower value has a chance of detecting more matches but with less efficiency. 100% means will catch only exact matches. If you are unsure about it leave with default value (70%).";
$l['ipatrol_pmalert_title'] = "Send PM notification";
$l['ipatrol_pmalert_desc'] = "Send a private message to Superadmin whenever iPatrol commits an action.";
$l['ipatrol_mailalert_title'] = "Send mail notification";
$l['ipatrol_mailalert_desc'] = "Alert sending a mail to board admin email whenever iPatrol commits an action.";