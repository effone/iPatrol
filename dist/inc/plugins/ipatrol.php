<?php
/**
 * @package iPatrol
 * @version 1.0.0
 * @category MyBB 1.8.x Plugin
 * @author effone <effone@mybb.com>
 * @license MIT
 *
 * @todo ACP Settings
 */

if (!defined('IN_MYBB')) {
    die('Direct access prohibited.');
}

if (defined('IN_ADMINCP')) {
    $plugins->add_hook('admin_settings_print_peekers', 'ipatrol_settingspeekers');
} else {
    $plugins->add_hook('xmlhttp', 'ipatrol_fetchdetails');
    $plugins->add_hook('global_start', 'ipatrol_bot_trap');
    $plugins->add_hook('global_end', 'ipatrol_ban_proxy');
    $plugins->add_hook('member_do_register_start', 'ipatrol_ban_regdupe');
}

function ipatrol_info()
{
    global $lang;
    $lang->load('ipatrol');

    return array(
        'name' => 'iPatrol',
        'description' => $lang->ipatrol_desc,
        'website' => 'https://github.com/mybbgroup/iPatrol',
        'author' => 'effone</a> of <a href="https://mybb.group">MyBBGroup</a>',
        'authorsite' => 'https://eff.one',
        'version' => '1.0.0',
        'compatibility' => '18*',
        'codename' => 'ipatrol',
    );
}

function ipatrol_install()
{
	global $db;

	// Create our table collation
	$collation = $db->build_create_table_collation();
    $db->write_query("CREATE TABLE ".TABLE_PREFIX."ipatrol_bottrap (
        bid int unsigned NOT NULL auto_increment,
        trapped_botname varchar(100) NOT NULL default '',
        trapped_botua varchar(300) NOT NULL default '',
        trapped_on int(10) unsigned NOT NULL default 0,
        trapped_notify tinyint(1) NOT NULL default 0,
        PRIMARY KEY (bid)
    ) ENGINE=MyISAM{$collation};");
}

function ipatrol_is_installed()
{
	global $db;
	return $db->table_exists('ipatrol_bottrap');
}

function ipatrol_activate()
{
    global $db, $lang;
    $lang->load('ipatrol');
    // Build Plugin Settings
    $ipatrol_group = array(
        "name" => "ipatrol",
        "title" => "iPatrol",
        "description" => $lang->ipatrol_desc,
        "disporder" => "9",
        "isdefault" => "0",
    );
    $db->insert_query("settinggroups", $ipatrol_group);
    $gid = $db->insert_id();

    $ipatrol[] = array(
        "name" => "ipatrol_locateuser",
        "title" => $lang->ipatrol_locateuser_title,
        "description" => $lang->ipatrol_locateuser_desc,
        "optionscode" => "onoff",
        "value" => '1',
        "disporder" => '1',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_apicachelimit",
        "title" => $lang->ipatrol_apicachelimit_title,
        "description" => $lang->ipatrol_apicachelimit_desc,
        "optionscode" => "numeric",
        "value" => '100',
        "disporder" => '2',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_banproxy",
        "title" => $lang->ipatrol_banproxy_title,
        "description" => $lang->ipatrol_banproxy_desc,
        "optionscode" => "onoff",
        "value" => '1',
        "disporder" => '3',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_noregdupe",
        "title" => $lang->ipatrol_noregdupe_title,
        "description" => $lang->ipatrol_noregdupe_desc,
        "optionscode" => "onoff",
        "value" => '0',
        "disporder" => '4',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_skipregdupe",
        "title" => $lang->ipatrol_skipregdupe_title,
        "description" => $lang->ipatrol_skipregdupe_desc,
        "optionscode" => "groupselect",
        "value" => '1,3,4',
        "disporder" => '5',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_detectbot",
        "title" => $lang->ipatrol_detectbot_title,
        "description" => $lang->ipatrol_detectbot_desc,
        "optionscode" => "onoff",
        "value" => '1',
        "disporder" => '6',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_autoaddbot",
        "title" => $lang->ipatrol_autoaddbot_title,
        "description" => $lang->ipatrol_autoaddbot_desc,
        "optionscode" => "onoff",
        "value" => '1',
        "disporder" => '7',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_uashortbot",
        "title" => $lang->ipatrol_uashortbot_title,
        "description" => $lang->ipatrol_uashortbot_desc,
        "optionscode" => "radio\n0=" . $lang->ipatrol_uashortbot_option_1 . "\n1=" . $lang->ipatrol_uashortbot_option_2,
        "value" => '1',
        "disporder" => '8',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_similarbot",
        "title" => $lang->ipatrol_similarbot_title,
        "description" => $lang->ipatrol_similarbot_desc,
        "optionscode" => "onoff",
        "value" => '1',
        "disporder" => '9',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_simstrength",
        "title" => $lang->ipatrol_simstrength_title,
        "description" => $lang->ipatrol_simstrength_desc,
        "optionscode" => "numeric",
        "value" => '70',
        "disporder" => '10',
        "gid" => intval($gid),
    );

    $ipatrol[] = array(
        "name" => "ipatrol_mailalert",
        "title" => $lang->ipatrol_mailalert_title,
        "description" => $lang->ipatrol_mailalert_desc,
        "optionscode" => "yesno",
        "value" => '1',
        "disporder" => '11',
        "gid" => intval($gid),
    );

    foreach ($ipatrol as $ipatrol_opt) {
        $db->insert_query("settings", $ipatrol_opt);
    }

    rebuild_settings();
}
function ipatrol_deactivate()
{
    global $db;
    $db->delete_query("settings", "name LIKE '%ipatrol%'");
    $db->delete_query("settinggroups", "name='ipatrol'");

    rebuild_settings();
}

function ipatrol_uninstall()
{
    global $db;
    $db->drop_table('ipatrol_bottrap');
}

function ipatrol_settingspeekers(&$peekers)
{
    $peekers[] = 'new Peeker($(".setting_ipatrol_noregdupe"), $("#row_setting_ipatrol_skipregdupe"),/1/,true)';
    $peekers[] = 'new Peeker($(".setting_ipatrol_detectbot"), $("#row_setting_ipatrol_autoaddbot"),/1/,true)';
    $peekers[] = 'new Peeker($(".setting_ipatrol_autoaddbot"), $("#row_setting_ipatrol_uashortbot"),/1/,true)';
    $peekers[] = 'new Peeker($(".setting_ipatrol_similarbot"), $("#row_setting_ipatrol_simstrength"),/1/,true)';
}

function ipatrol_fetchdetails()
{
    global $mybb, $lang;
    //$lang->load('ipatrol');

    switch ($mybb->input['action']) {
        case 'get_iplocation':
            if (!verify_post_check($mybb->get_input('my_post_key'), true)) {
                xmlhttp_error($lang->invalid_post_code);
            }

            if (!$mybb->usergroup['canuseipsearch']) {
                xmlhttp_error($lang->permission_error);
            }

            header("Content-type: application/json; charset={$charset}");
            die(ipatrol_apicall($mybb->get_input('ip'), $mybb->get_input('fields')));
            break;
    }
}

function ipatrol_ban_proxy()
{
    global $mybb;
    // IP Ban the user using Proxy
    if ($mybb->settings['ipatrol_banproxy']) {
        // Don't try to track real IP using get_ip(), we need to punish presented IP
        $ip = my_strtolower(trim($_SERVER['REMOTE_ADDR']));

        if (!is_banned_ip($ip)) { // Also check with some whitelist for already passed IPs
            $response = ipatrol_apicall($ip, 'proxy');
            if (!empty($response) && json_decode($response, true)['proxy']) {
                // Ban this IP
                ipatrol_ip_ban($ip);
                my_mail('me@eff.one', 'Proxy IP banned @ Demonate', 'Banned IP: ' . $ip);

                // Redirect immediately to trap the user with IP ban notice
                header("Location: {$mybb->settings['bburl']}");
            }
        }
    }
}

function ipatrol_bot_trap()
{
    global $db, $mybb, $lang, $cache;
    $lang->load('ipatrol');

    if ($mybb->settings['ipatrol_detectbot'] && !$mybb->user['uid']) {

        //$logged = file('skipbot.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logged = $cache->read('ipatrol_bottrap');
        if (!isset($logged) || empty($logged)) {
            $logged = array();
        }

        $query = $db->simple_select("sessions", "useragent", "sid NOT LIKE'%bot%' AND UID = '0'");
        while ($skip = $db->fetch_array($query)) {
            $u_agent = trim($skip['useragent']);
            if (!empty($u_agent) && !in_array($u_agent, $logged)) {

                // Load the detector library
                $lib_files = ['CrawlerDetect', 'AbstractProvider', 'Crawlers', 'Exclusions', 'Headers'];
                foreach ($lib_files as $i => $file) {
                    $file = $i ? 'Fixtures/' . $file : $file;
                    require_once MYBB_ROOT . '/inc/3rdparty/crawlerdetect/' . $file . '.php';
                }
                $CrawlerDetect = new Jaybizzle\CrawlerDetect\CrawlerDetect;

                if ($CrawlerDetect->isCrawler($u_agent)) {
                    $similar_spiders = $db_insert = array();
                    $bot_name = $CrawlerDetect->getMatches();
                    $db_insert['trapped_botname'] = $bot_name;
                    $db_insert['trapped_botua'] = $u_agent;
                    $db_insert['trapped_on'] = TIME_NOW;

                    if ($mybb->settings['ipatrol_similarbot']) {
                        $registered_spiders = $cache->read('spiders');
                        $match_power = (int) $mybb->settings['ipatrol_simstrength'];
                        $match_power = (!$match_power || $match_power < 1) ? 70 : (($match_power > 100) ? 100 : $match_power);

                        foreach ($registered_spiders as $registered_spider) {
                            similar_text($bot_name, $registered_spider['name'], $match);
                            if ($match >= $match_power) {
                                $similar_spiders[] = $registered_spider['name'];
                            }
                        }
                    }
// ['notified', 'similar', 'added']
                    if (count($similar_spiders)) {
                        $db_insert['trapped_notify'] = 1;
                        // Send mail
                        if ($mybb->settings['ipatrol_mailalert']) {
                            $mail_to = empty($mybb->settings['returnemail']) ? $mybb->settings['adminemail'] : $mybb->settings['returnemail'];
                            $mail_matter = $lang->newcrawler_detected;
                            $mail_matter .= " " . $lang->sprintf($lang->newcrawler_detail, $bot_name, $u_agent);
                            $mail_matter .= " " . $lang->sprintf($lang->newcrawler_similar, count($similar_spiders));
                            $mail_matter .= " " . $lang->newcrawler_notify;
                            my_mail(trim($mail_to), $lang->sprintf($lang->newcrawler_subject, $mybb->settings['bbname']), $mail_matter);
                        }
                        // Log here
                    } else {
                        if ($mybb->settings['ipatrol_autoaddbot']) {
                            $alert_message = $lang->newcrawler_dbadded;
                            $insert = array(
                                'name' => $bot_name,
                                'useragent' => strtolower($mybb->settings['ipatrol_uashortbot'] ? $bot_name : $u_agent),
                                'lastvisit' => TIME_NOW,
                            );

                            $db->insert_query("spiders", $insert);
                            $cache->update_spiders();
                            $db_insert['trapped_notify'] = 2;
                        } else {
                            $db_insert['trapped_notify'] = 0;
                            $alert_message = $lang->newcrawler_notify;
                        }

                        //file_put_contents('skipbot.txt', $u_agent . "\n", FILE_APPEND | LOCK_EX); // Add to CACHE INSTEAD
                        // Send mail
                        if ($mybb->settings['ipatrol_mailalert']) {
                            $mail_to = empty($mybb->settings['returnemail']) ? $mybb->settings['adminemail'] : $mybb->settings['returnemail'];
                            $mail_matter = $lang->newcrawler_detected;
                            $mail_matter .= " " . $lang->sprintf($lang->newcrawler_detail, $bot_name, $u_agent) . " " . $alert_message;
                            my_mail(trim($mail_to), $lang->sprintf($lang->newcrawler_subject, $mybb->settings['bbname']), $mail_matter);
                        }
                    }

                    $logged[] = $u_agent;
                    $cache->update('ipatrol_bottrap', $logged);
                    $db->insert_query('ipatrol_bottrap', $db_insert);
                }
            }
        }
    }
}

function ipatrol_ip_ban(&$ip)
{
    global $db, $cache;
    $insert = array(
        "filter" => $db->escape_string($ip),
        "type" => 1,
        "dateline" => TIME_NOW,
    );
    $db->insert_query("banfilters", $insert);
    $cache->update_bannedips();
}

function ipatrol_ban_regdupe()
{
    global $mybb;
    // Restrict registration of user havind an account already with same IP
    if ($mybb->settings['ipatrol_noregdupe']) {
    }
}

function ipatrol_apicall($ip, $fields = '')
{
    global $cache;
    $prepatrol = $cache->read('ipatrol_apiresponses');
    if (isset($prepatrol) && !empty($prepatrol) && ipatrol_cached($ip, $prepatrol) !== false) {
        $response = $prepatrol[ipatrol_cached($ip, $prepatrol)];
    } else {
        $stream = stream_context_create(array(
            'http' => array(
                'timeout' => 3, // Timeout in seconds
            ),
        ));
        $fetch = "country,regionName,city,district,zip,lat,lon,timezone,isp,as,reverse,mobile,proxy,query,status,message"; // Fetch all data for reference
        $response = @file_get_contents("http://ip-api.com/json/" . $ip . "?fields=" . $fetch, 0, $stream);
        $response = json_decode($response, true);
        if (!json_last_error() == 0) {
            // ITS A NON JSON HANDLE ERROR
        } else {
            if (!isset($prepatrol) || empty($prepatrol)) {
                $prepatrol = array();
            }
            // Push the new data to the beginning so that we can trim limit overflow from end
            array_unshift($prepatrol, $response);
            $limit = (int) $mybb->settings['ipatrol_apicachelimit'];
            if (!$limit) {
                $limit = 100;
            }

            if (count($prepatrol) > $limit) {
                array_splice($prepatrol, $limit, count($prepatrol) - $limit);
            }

            $cache->update('ipatrol_apiresponses', $prepatrol);
        }
    }

    if (!empty($fields)) {
        if (!is_array($fields)) {
            $fields = explode(',', $fields);
        }

        foreach ($response as $field => $data) {
            if (!in_array($field, $fields)) {
                unset($response[$field]);
            }
        }
    }
    return json_encode($response);
}

function ipatrol_publish($action, $data = array())
{
    if (!empty($data)) {
        global $mybb, $lang;
        $lang->load('ipatrol');

        $mailbody = $lang->sprintf($lang->newcrawler_detected, $data['botname'], $data['botua']);
        switch ($action) {
            case 'newcrawler_similar':
                break;

            case 'newcrawler_autoadd':
                break;

            case 'newcrawler_notify':
                break;

            case 'ip_proxyban':
                break;
        }

        // Send mail
        if ($mybb->settings['ipatrol_mailalert']) {
            $mail_to = empty($mybb->settings['returnemail']) ? $mybb->settings['adminemail'] : $mybb->settings['returnemail'];
            $subject = $action . '_subject';
            my_mail(trim($mail_to), $lang->sprintf($lang->$subject, $mybb->settings['bbname']), $mail_matter);
        }

        // Notify in-site

        // Log action
    }
}

function ipatrol_cached($val, $array, $node = 'query')
{
    foreach ($array as $index => $entry) {
        if ($entry[$node] == $val) {
            return $index;
        }
        return false;
    }
}
