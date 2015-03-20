<?php namespace MyECOMM;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions as SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

/**
 * Class Email
 */
class Email {

    /**
     * @var Url|null Url object instance
     */
    public $objUrl;

    /**
     * @var Message Zend Message object instance
     */
    private $objMessage;

    /**
     * @var SendmailTransport Zend Transport object instance
     */
    private $objTransport;

    /**
     * SMTP configuration and credentials
     */
    private $useSmtp = SMTP_USE;
    private $smtpHost = SMTP_HOST;
    private $smtpUsername = SMTP_USERNAME;
    private $smtpPassword = SMTP_PASSWORD;
    private $smtpPort = SMTP_PORT;
    private $smtpSsl = SMTP_SSL;

    /**
     * Constants
     */
    const EMAIL_ADMIN = MAILER_USERNAME;
    const NAME_ADMIN = 'MyECOMM';

    /**
     * Constructor
     *
     * @param null $objUrl
     */
    public function __construct($objUrl = null) {
        // Check if url object has been passes and if not then instantiate it
        $this->objUrl = is_object($objUrl) ? $objUrl : new Url();
        // Instantiate Zend Message object
        $this->objMessage = new Message();
        // Set SMTP configs if it exists
        if ($this->useSmtp) {
            $this->objTransport = new SmtpTransport();
            $options = new SmtpOptions();
            $options->setName($this->smtpHost);
            $options->setHost($this->smtpHost);
            $options->setPort($this->smtpPort);
            $options->setConnectionClass('login');
            $options->setConnectionConfig([
                'username' => $this->smtpUsername,
                'password' => $this->smtpPassword,
                'ssl' => $this->smtpSsl
            ]);
            // Set transport options
            $this->objTransport->setOptions($options);
        } else {
            $this->objTransport = new SendmailTransport();
        }
    }

    /**
     * Process email
     *
     * @param null $case
     * @param null $parameters
     * @return bool
     */
    public function process($case = null, $parameters = null) {
        if (!empty($case)) {
            switch ($case) {
                case 1:
                    $link = "<a href=\"";
                    $link .= SITE_URL.$this->objUrl->href('activate', [
                            'code',
                            $parameters['hash']
                        ]);
                    $link .= "\">";
                    $link .= SITE_URL.$this->objUrl->href('activate', [
                            'code',
                            $parameters['hash']
                        ]);
                    $link .= "</a>";
                    $parameters['link'] = $link;
                    $this->objMessage->addTo($parameters['email'],
                        $parameters['first_name'].' '.$parameters['last_name']
                    );
                    $this->objMessage->addFrom(self::EMAIL_ADMIN, self::NAME_ADMIN);
                    $this->objMessage->setSubject('Activate Your Account');
                    $this->objMessage->setBody($this->setHtmlBody(
                        $this->fetchEmail($case, $parameters)
                    ));
                    break;
                case 2:
                    $this->objMessage->addTo(self::EMAIL_ADMIN, self::NAME_ADMIN);
                    $this->objMessage->addFrom($parameters['email'], $parameters['name']);
                    $this->objMessage->setSubject('New Comment');
                    $this->objMessage->setBody($this->setHtmlBody(
                        $this->fetchEmail($case, $parameters)
                    ));
                    break;
                case 3:
                    $objUser = new User();
                    $user = $objUser->getByEmail($parameters['email']);
                    $link = "<a href=\"";
                    $link .= SITE_URL.$this->objUrl->href('password-reset', [
                            'token',
                            $parameters['hash'],
                            'id',
                            $user['id'],
                        ]);
                    $link .= "\">";
                    $link .= "Reset Password Link";
                    $link .= "</a>";
                    $parameters['link'] = $link;
                    $this->objMessage->addTo($user['email'],
                                             $user['first_name'].' '.$user['last_name']
                    );
                    $this->objMessage->addFrom(self::EMAIL_ADMIN, self::NAME_ADMIN);
                    $this->objMessage->setSubject('Reset Your Password');
                    $this->objMessage->setBody($this->setHtmlBody(
                        $this->fetchEmail($case, $parameters)
                    ));
                    break;
            }
            // Send email
            $this->objTransport->send($this->objMessage);
            return true;
        }
        return false;
    }

    /**
     * Set the message as html
     *
     * @param null $message
     * @return MimeMessage
     */
    private function setHtmlBody($message = null) {
        // Instantiate mime part and set type
        $objMimePart = new MimePart($message);
        $objMimePart->type = "text/html";
        // Instantiate mime message and add mime part
        $objMimeMessage = new MimeMessage();
        $objMimeMessage->addPart($objMimePart);
        // Return mime message
        return $objMimeMessage;
    }

    /**
     * Fetch the email
     *
     * @param null $case
     * @param null $parameters
     * @return string
     */
    public function fetchEmail($case = null, $parameters = null) {
        if (!empty($case)) {
            if (!empty($parameters)) {
                foreach ($parameters as $key => $value) {
                    ${$key} = $value;
                }
            }
            ob_start();
            require_once(EMAILS_PATH.DS.$case.".php");
            $out = ob_get_clean();
            return $this->wrapEmail($out);
        }
        return false;
    }

    /**
     * Wrap the email content in html
     *
     * @param null $content
     * @return string
     */
    public function wrapEmail($content = null) {
        // Check if content was passed
        if (!empty($content)) {
            $emailWrapper = "<div style=\"font-family: Arial,Verdana,Sans-serif;";
            $emailWrapper .= "font-size: 15px;";
            $emailWrapper .= "color: #333;";
            $emailWrapper .= "line-height: 23px;";
            $emailWrapper .= "\">";
            $emailWrapper .= $content;
            $emailWrapper .= "</div>";
            // Return the content in html wrapper
            return $emailWrapper;
        }
        return false;
    }
}