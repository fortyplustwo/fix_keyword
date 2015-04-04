<?php
defined('_SECURE_') or die('Forbidden');

/*
 * intercept incoming sms and remove keyword
 *
 * @param $sms_datetime
 *   incoming SMS date/time
 * @param $sms_sender
 *   incoming SMS sender
 * @message
 *   incoming SMS message before interepted
 * @param $sms_receiver
 *   receiver number that is receiving incoming SMS
 * @return
 *   array $ret
 */
function fix_keyword_hook_recvsms_intercept($sms_datetime, $sms_sender, $message, $sms_receiver) {
        $ret = array();

        //We assume that the first word in the SMS is the keyword and remove it.
        $new_message = explode(" ", $message, 2);
        $username = str_replace('@', '', $new_message[0]);
        $nm = $new_message[1];

        logger_print("*******", 3, "fix_keyword");
        logger_print("sms_sender " . $sms_sender, 3, "fix_keyword");
        logger_print("message " . $message, 3, "fix_keyword");
        logger_print("new message " . $nm, 3, "fix_keyword");
        logger_print("sms target user" . $sms_receiver, 3, "fix_keyword");
        logger_print("*******", 3, "fix_keyword");

        if (($uid = user_username2uid($username)) && $nm) {
                _log("save in inbox u:" . $username . " uid:" . $uid . " dt:" . $sms_datetime . " s:" . $sms_sender . " r:" . $sms_receiver . " m:[" . $nm . "]", 3, 'fix_keyword');
                recvsms_inbox_add($sms_datetime, $sms_sender, $username, $nm, $sms_receiver);
        }

        $ret['param']['message'] = $nm;
        $ret['modified'] = TRUE;
        $ret['hooked'] = TRUE;

        return $ret;
}
