<?php

namespace Eye4web\ZfcUser\ForgotPassword\Service;

use Zend\Mail\Message;

interface MailTransporterInterface
{
    /**
     * Send a message with given variables for the body
     *
     * If no message object is set a default message object is
     * used. In the options array at least a "to", "subject" and
     * "template" key must be available to send the message.
     *
     * Valid options are:
     * - to:              the email address to send the message to (required)
     * - subject:         the subject of the message (required)
     * - template:        the view name of the (html) template (required)
     * - to_name:         the name of the user to send to
     * - cc:              an email address to send a cc to
     * - cc_name:         the name of the user to cc
     * - bcc:             an email address to send a bcc to
     * - bcc_name:        the name of the user to bcc
     * - from:            the email address the message came from
     * - from_name:       the name of the user from the from address
     * - reply_to:        the email address to reply to
     * - reply_to_name:   the name of the user from the reply to address
     * - template_text:   the plain text version of the template
     * - attachments:     an array of attachments (not implemented currently)
     * - headers:         a key/value array of additional headers to set
     *
     * All address fields (to, cc, bcc, from, reply_to) can also be an array with
     * key/value pairs of multiple addresses. All keys in the array are considered
     * email addresses, all values (null allowed) are the corresponding names.
     *
     * @param  array $options   Additional options to set
     * @param  array $variables Variables to use for the view
     * @param  Message|null $message Optional message object to use
     * @return void
     */
    public function send(array $options, array $variables = array(), Message $message = null);
}
