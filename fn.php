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
function remove_keyword_hook_recvsms_intercept($sms_datetime, $sms_sender, $message, $sms_receiver) {
    $ret = array();
    //We assume that the first word in the SMS is the keyword and remove it.
    $new_message = explode(" ",$message, 2);

    $ret['param']['message'] = $new_message[1]; 
    logger_print("*******", 3, "remove_keyword");
    logger_print("sms_sender ".$sms_sender, 3, "remove_keyword");
    logger_print("message ".$message, 3, "remove_keyword");
    logger_print("new message ".$new_message[1], 3, "remove_keyword");
    logger_print("sms_receiver ".$sms_receiver, 3, "remove_keyword");
    logger_print("*******", 3, "remove_keyword");

    $ret['param']['message'] = $new_message[1];
    $ret['modified'] = TRUE;
    $ret['hooked'] = TRUE;

    return $ret;
}
