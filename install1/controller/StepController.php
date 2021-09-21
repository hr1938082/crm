<?php
/**
* Step Controller
*/
class StepController
{
    /**
    * Display view according to url
    * Site installed or not
    */
    public function index($view) 
    {
        if($view == 'step_1') {
            require 'view/install/step_1.tpl';
        }
        elseif($view == 'step_2') {
            if($this->is_site_installed()) {
                header('location: index.php?route=install/3');
                exit();
            }
            require 'view/install/step_2.tpl';
        }
        elseif($view == 'step_3') {
            require 'view/install/step_3.tpl';
        }
    }
    /**
    * Check database exist or not and insert table into database
    * Dumping data for table 
    */
    public function indexAction ()
    {
        $data = $this->validate();
        if($data[0] == 1) {
            $_SESSION['ERROR_INPUT'] = $data[1];
            header('location: index.php?route=install/2');
            exit();
        }
        else {
            require_once 'model/Database.php';
            $db_var = new Database();
            $check_db_arr = $db_var->check_db($data[1]);
            if($check_db_arr == 1) {
                $db_var->setup_db($data[1]);
                $this->write_config_files($data[1]);
                $this->sendMail($data[1]);
                header('location: index.php?route=install/3');
                exit();
            }
            else { 
                $_SESSION['ERROR'] = $check_db_arr;
                header('location: index.php?route=install/2');
                exit();
            }
        }
    }
    /**
    * Post variable validation
    */
    private function validate() 
    {
        $error;
        $error_status = 0;
        $data;
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            if (empty($_POST['db_hostname'])) {
                $data['db_hostname'] = 'localhost';
            } else {
                $data['db_hostname'] = $_POST['db_hostname'];
            }

            if (empty($_POST['db_username'])) {
                $error[] = 'Please enter valid User Name!';
                $error_status = 1;
            } else {
                $data['db_username'] = $_POST['db_username'];
            }

            if (empty($_POST['db_password'])) {
                $error[] = 'Please enter valid Database Password!';
                $error_status = 1;
            } else {
                $data['db_password'] = $_POST['db_password'];
            }

            if (empty($_POST['db_name'])) {
                $error[] = 'Please enter valid Database Name!';
                $error_status = 1;
            } else {
                $data['db_name'] = $_POST['db_name'];
            }

            if (empty($_POST['db_prefix'])) {
                $data['db_prefix'] = 'kk_';
            } else {
                $data['db_prefix'] = $_POST['db_prefix'];
            }

            if (empty($_POST['name'])) {
                $error[] = 'Please enter valid Name!';
                $error_status = 1;
            } else {
                $data['name'] = $_POST['name'];
            }

            if (empty($_POST['email'])) {
                $error[] = 'Please enter valid Email!';
                $error_status = 1;
            } else {
                $data['email'] = $_POST['email'];
            }

            if (empty($_POST['username'])) {
                $error[] = 'Please enter valid User Name!';
                $error_status = 1;
            } else {
                $data['username'] = $_POST['username'];
            }

            if (empty($_POST['password'])) {
                $error[] = 'Please enter valid Password!';
                $error_status = 1;
            } else {
                $data['password'] = $_POST['password'];
            }

            $password = $_POST['password'];
            if (strlen($password) < 8) {
                $error[] = 'Please enter valid Password!';
                $error_status = 1;
            } else {
                $data['password'] = $_POST['password'];
            }
        }
        if($error_status === 1) {
            return array($error_status, $error);
        }
        else {
            return array($error_status, $data);
        }
    }
    /**
    * Write configuration file
    */
    private function write_config_files($options)
    {
        $output  = '<?php' . "\n";
        $output .= '/*This name will represent title in auto generated mail*/' . "\n";
        $output .= 'define(\'NAME\', \'' . $options['name'] .'\');' . "\n";
        $output .= '/*Domain name like www.yourdomain.com*/' . "\n";
        $output .= 'define(\'URL\', \'' . HTTP_KLINIKAL . '\');' . "\n";
        $output .= 'define(\'URL_CLIENTS\', \'' . HTTP_CLIENTS . '\');' . "\n";
        $output .= '/*Support email*/' . "\n";
        $output .= 'define(\'SITEEMAIL\', \'' . $options['email'] . '\');' . "\n";
        $output .= '/*Clinic address*/' . "\n";
        $output .= 'define(\'ADDRESS\', \'' . $options['name'] . '\');' . "\n";
        
        $output .= "\n\n";
        $output .= '/*Application Address*/' . "\n";
        $output .= 'define(\'DIR_ROUTE\', \'index.php?route=\');' . "\n";
        $output .= 'define(\'DIR\', \'' . APPLICATION . '\');' . "\n";
        $output .= 'define(\'DIR_CLIENTS\', \'' . CLIENTS . '\');' . "\n";
        $output .= 'define(\'DIR_APP\', \'' . APP . '\');' . "\n";
        $output .= 'define(\'DIR_BUILDER\', \'' . BUILDER . '\');' . "\n";

        /*SMTP Details*/
        $output .= "\n\n";
        $output .= '/** SMTP Credentials **/' . "\n";
        $output .= 'define(\'SMTP_HOST\', \'\');' . "\n";
        $output .= 'define(\'SMTP_USERNAME\', \'\');' . "\n";
        $output .= 'define(\'SMTP_PASSWORD\', \'\');' . "\n";
        $output .= 'define(\'SMTP_PORT\', \'\');' . "\n";

        $output .= "\n\n";
        $output .= '/** MySQL settings - You can get this info from your web host **/' . "\n";
        $output .= '/*MySQL database host*/' . "\n";
        $output .= 'define(\'DB_HOSTNAME\', \'' . addslashes($options['db_hostname']) . '\');' . "\n";
        $output .= '/*MySQL database username*/' . "\n";
        $output .= 'define(\'DB_USERNAME\', \'' . addslashes($options['db_username']) . '\');' . "\n";
        $output .= '/*MySQL database password*/' . "\n";
        $output .= 'define(\'DB_PASSWORD\', \'' . addslashes($options['db_password']) . '\');' . "\n";
        $output .= '/*MySQL database Name*/' . "\n";
        $output .= 'define(\'DB_DATABASE\', \'' . addslashes($options['db_name']) . '\');' . "\n";
        $output .= '/*Table Prefix*/' . "\n";
        $output .= 'define(\'DB_PREFIX\', \'' . addslashes($options['db_prefix']) . '\');' . "\n";

        /*Token*/
        $output .= "\n\n";
        $output .= 'define(\'AUTH_KEY\', \'' . $this->token_generator(64) . '\');' . "\n";
        $output .= 'define(\'LOGGED_IN_SALT\', \'' . $this->token_generator(64) . '\');' . "\n";
        $output .= 'define(\'TOKEN\', \'' . $this->token_generator(64) . '\');' . "\n";
        $output .= 'define(\'TOKEN_SALT\', \'' . $this->token_generator(64) . '\');' . "\n";

        
        $file = fopen(APPLICATION.'config/config.php', 'w'); 
        fwrite($file, $output); 
        fclose($file);
        
        $output  = '<?php' . "\n";
        $output .= '/*This name will represent title in auto generated mail*/' . "\n";
        $output .= 'define(\'NAME\', \'' . $options['name'] .'\');' . "\n";
        
        $output .= '/*Domain name like www.yourdomain.com*/' . "\n";
        $output .= 'define(\'URL\', \'' . HTTP_KLINIKAL . '\');' . "\n";
        $output .= 'define(\'URL_CLIENTS\', \'' . HTTP_CLIENTS . '\');' . "\n";
        $output .= '/*Support Email*/' . "\n";
        $output .= 'define(\'SITEEMAIL\', \'' . $options['email'] . '\');' . "\n";
        $output .= '/*Clinic Address*/' . "\n";
        $output .= 'define(\'ADDRESS\', \'' . $options['name'] . '\');' . "\n";
        
        $output .= "\n\n";
        $output .= '/*Application Address*/' . "\n";
        $output .= 'define(\'DIR_ROUTE\', \'index.php?route=\');' . "\n";
        $output .= 'define(\'DIR\', \'' . APPLICATION . '\');' . "\n";
        $output .= 'define(\'DIR_CLIENTS\', \'' . CLIENTS . '\');' . "\n";
        $output .= 'define(\'DIR_APP\', \'' . CLIENTS_APP . '\');' . "\n";
        $output .= 'define(\'DIR_BUILDER\', \'' . CLIENTS_BUILDER . '\');' . "\n";
        
        
        /*SMTP Details*/
        $output .= "\n\n";
        $output .= '/*SMTP Credentials*/' . "\n";
        $output .= 'define(\'SMTP_HOST\', \'\');' . "\n";
        $output .= 'define(\'SMTP_USERNAME\', \'\');' . "\n";
        $output .= 'define(\'SMTP_PASSWORD\', \'\');' . "\n";
        $output .= 'define(\'SMTP_PORT\', \'\');' . "\n";
        
        $output .= "\n\n";
        $output .= '/** MySQL settings - You can get this info from your web host **/' . "\n";
        $output .= '/*Database hostname*/' . "\n";
        $output .= 'define(\'DB_HOSTNAME\', \'' . addslashes($options['db_hostname']) . '\');' . "\n";
        $output .= '/*Database Username*/' . "\n";
        $output .= 'define(\'DB_USERNAME\', \'' . addslashes($options['db_username']) . '\');' . "\n";
        $output .= '/*Database Password*/' . "\n";
        $output .= 'define(\'DB_PASSWORD\', \'' . addslashes($options['db_password']) . '\');' . "\n";
        $output .= '/*Database Name*/' . "\n";
        $output .= 'define(\'DB_DATABASE\', \'' . addslashes($options['db_name']) . '\');' . "\n";
        $output .= '/*Table Prefix*/' . "\n";
        $output .= 'define(\'DB_PREFIX\', \'' . addslashes($options['db_prefix']) . '\');' . "\n";
        
        /*Token*/
        $output .= "\n\n";
        $output .= 'define(\'AUTH_KEY\', \'' . $this->token_generator(64) . '\');' . "\n";
        $output .= 'define(\'LOGGED_IN_SALT\', \'' . $this->token_generator(64) . '\');' . "\n";
        $output .= 'define(\'TOKEN\', \'' . $this->token_generator(64) . '\');' . "\n";
        $output .= 'define(\'TOKEN_SALT\', \'' . $this->token_generator(64) . '\');' . "\n";

        $file = fopen(APPLICATION.'clients/config/config.php', 'w'); 
        fwrite($file, $output); 
        fclose($file);
    }
    /**
    * Check if site already installed or not
    */
    private function is_site_installed()
    {
        if( defined('DB_HOSTNAME') && defined('DB_USERNAME') && defined('DB_PASSWORD') && defined('DB_DATABASE')) { 
            if (empty(DB_HOSTNAME) || empty(DB_USERNAME) || empty(DB_PASSWORD) || empty(DB_DATABASE) ) { 
                return false; 
            }
            else {
                return true;
            }
        }
        else {
            return false;
        }
    }
    /**
    * Token Generator Method
    */
    private function token_generator( $length = 64 ) {
        $token = "";
        $charArray = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz#~%|<>{}())?&*-;");
        for($i = 0; $i < $length; $i++){
            $randItem = array_rand($charArray);
            $token .= "".$charArray[$randItem];
        }
        return $token;
    }

    private function sendMail($data)
    {
        require_once 'libs/Mailer.php';
        $mailer = new Mailer();
        $mailer->mail->setFrom('support@pepdev.com', 'ManasaTheme (Pepdev)');
        $mailer->mail->addAddress($data['email'], $data['name']);
        $mailer->mail->addBCC('pepdevofficial@gmail.com', 'ManasaTheme (Pepdev)');
        $mailer->mail->isHTML(true);
        $mailer->mail->Subject = 'Client Manager Web Application.';
        $mailer->mail->Body = 'Hello '.$data['name'].',<br><br>
        Your new Client Manager theme has been successfully set up at:<br> <a href="'.HTTP_KLINIKAL.'">'.HTTP_KLINIKAL.'</a><br /><br />
        We hope you enjoy your new Client Manager web app. Thanks!<br /><br />
        If you have any questions that are beyond the scope of help file, please feel free to contact us here <a href="http://support.pepdev.com/">pepdev</a> or mail us at pepdevofficial@gmail.com.<br /><br />
        ManasaTheme<br />
        <a href="https://codecanyon.net/user/manasatheme/portfolio">themeforest</a><br />
        ';
        $mailer->mail->AltBody = '';
        $mailer->sendMail();
    }
}