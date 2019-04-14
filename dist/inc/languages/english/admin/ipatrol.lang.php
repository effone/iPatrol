<?php

$l['ipatrol_desc'] = "A Plugin for MyBB to take better control over visitors.";
$l['ipatrol_locateuser_title'] = "Locate users based on their IP address.";
$l['ipatrol_apicachelimit_title'] = "Number of API calls to cache";
$l['ipatrol_apicachelimit_desc'] = "This can reduce external API calls and load site faster. You may increase the number if you have a large user base. Note that very bigger number of cache entries have negative performance impact too.";
$l['ipatrol_locateuser_desc'] = "Allow admins and mods with permission to fetch various details of the user based on their IP.";
$l['ipatrol_banproxy_title'] = "Ban users using proxy";
$l['ipatrol_banproxy_desc'] = "Ban the IP address of the users who use proxy to access the site.";
$l['ipatrol_banregdupe_title'] = "Ban duplicate user registration";
$l['ipatrol_banregdupe_desc'] = "Ban the IP address of the users who already has an account registered with same IP.";
$l['ipatrol_skipregdupe_title'] = "Exclude groups from banning";
$l['ipatrol_skipregdupe_desc'] = "Skip banning the IP address if the user belongs to the group.";
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
$l['ipatrol_simstrength_desc'] = "The % strength of the matching. A lower value has a chance of detecting more matches but with less efficiency. 100% means will catch only exact matches. If you are unsure about it leave with default value (40%).";
$l['ipatrol_mailalert_title'] = "Send mail notification";
$l['ipatrol_mailalert_desc'] = "Alert sending a mail to board admin email whenever iPatrol commits an action.";