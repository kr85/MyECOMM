<?php

    require_once('PHPMailer_5.2.4/PHPMailer.php');

    /**
     * Class Email
     */
    class Email {

        // PHPMailer instance
        private $objMailer;

        /**
         * Constructor
         *
         * @throws phpmailerException
         */
        public function __construct() {

            $this->objMailer = new PHPMailer();
            $this->objMailer->IsSMTP();
            $this->objMailer->SMTPDebug = 1;
            $this->objMailer->SMTPAuth = true;
            $this->objMailer->SMTPKeepAlive = true;
            $this->objMailer->Host = "smtp.gmail.com";
            $this->objMailer->Port = 587;
            $this->objMailer->SMTPSecure = "tls";
            $this->objMailer->Username = ProjectVariable::$MAILER_USERNAME;
            $this->objMailer->Password = ProjectVariable::$MAILER_PASSWORD;
            $this->objMailer->SetFrom(ProjectVariable::$MAILER_USERNAME,
                ProjectVariable::$MAILER_NAME);
            $this->objMailer->AddReplyTo(ProjectVariable::$MAILER_USERNAME,
                ProjectVariable::$MAILER_NAME);
        }

        /**
         * Process email
         *
         * @param null $case
         * @param null $parameters
         * @return bool
         * @throws Exception
         * @throws phpmailerException
         */
        public function process($case = null, $parameters = null) {

            if (!empty($case)) {
                switch ($case) {
                    case 1:
                        $link = "<a href=\"" . SITE_URL . "/?page=activate&code=";
                        $link .= $parameters['hash'];
                        $link .= "\">";
                        $link .= SITE_URL . "/?page=activate&code=";
                        $link .= $parameters['hash'];
                        $link .= "</a>";
                        $parameters['link'] = $link;
                        $this->objMailer->Subject = "Activate your account";
                        $this->objMailer->MsgHTML($this->fetchEmail(
                            $case,
                            $parameters)
                        );
                        $this->objMailer->AddAddress(
                            $parameters['email'],
                            $parameters['first_name'] . ' ' . $parameters['last_name']
                        );
                        break;
                }
                if ($this->objMailer->Send()) {
                    $this->objMailer->ClearAddresses();

                    return true;
                }
                Helper::addToErrorsLog($this->objMailer->ErrorInfo);

                return false;
            }

            return false;
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
                require_once(EMAILS_PATH . DS . $case . ".php");
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

            if (!empty($content)) {
                $emailWrapper = "<div style=\"font-family: Arial,Verdana,Sans-serif;";
                $emailWrapper .= "font-size: 15px;";
                $emailWrapper .= "color: #333;";
                $emailWrapper .= "line-height: 23px;";
                $emailWrapper .= "\">";
                $emailWrapper .= $content;
                $emailWrapper .= "</div>";

                return $emailWrapper;
            }

            return false;
        }
    }