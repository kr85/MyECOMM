<?php namespace MyECOMM;

/**
 * Class User
 */
class User extends Application {

    /**
     * @var Url|null Url class instance
     */
    public $objUrl;

    /**
     * @var string Users table name
     */
    protected $table = "clients";

    /**
     * @var string The name of the reset password table
     */
    protected $tableResetPassword = "reset_password";

    /**
     * Constructor
     *
     * @param null $objUrl
     */
    public function __construct($objUrl = null) {
        parent::__construct();
        $this->objUrl = is_object($objUrl) ? $objUrl : new Url();
    }

    /**
     * Check if the user exist
     *
     * @param $email
     * @param $password
     * @return bool
     */
    public function isUser($email = null, $password = null) {
        if (!$this->isEmailPasswordEmpty($email, $password)) {
            $password = Login::stringToHash($password);
            $sql = "SELECT *
                    FROM `{$this->table}`
                    WHERE `email` = ?
                    AND `password` = ?
                    AND `active` = ?";
            $result = $this->Db->fetchOne($sql, [$email, $password, 1]);
            if (!empty($result)) {
                $this->id = $result['id'];
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Check if email and password are empty
     *
     * @param null $email
     * @param null $password
     * @return bool
     */
    private function isEmailPasswordEmpty($email = null, $password = null) {
        return (empty($email) || empty($password));
    }

    /**
     * Add user and send confirmation email
     *
     * @param null $params
     * @param null $password
     * @return bool
     */
    public function addUser($params = null, $password = null) {
        if (
            $this->areAddUserParametersValid($params, $password) &&
            $this->insert($params)
        ) {
            $objEmail = new Email();
            $email = [
                'email'      => $params['email'],
                'first_name' => $params['first_name'],
                'last_name'  => $params['last_name'],
                'password'   => $password,
                'hash'       => $params['hash']
            ];
            if ($objEmail->process(1, $email)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Reset password
     *
     * @param null $email
     * @param null $hash
     * @param null $date
     * @return bool
     */
    public function resetPassword($email = null, $hash = null, $date = null) {
        if ($this->areSetResetPasswordParamsValid($email, $hash, $date)) {
            if ($this->setResetPasswordParams($email, $hash, $date)) {
                $objEmail = new Email();
                $email = [
                    'email' => $email,
                    'hash'  => $hash,
                    'time'  => $date
                ];
                if ($objEmail->process(3, $email)) {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    /**
     * Set reset password parameters
     *
     * @param null $email
     * @param null $hash
     * @param null $date
     * @return bool
     */
    public function setResetPasswordParams($email = null, $hash = null, $date = null) {
        if ($this->areSetResetPasswordParamsValid($email, $hash, $date)) {
            if ($this->isResetPasswordCountValid($email)) {
                $reset = $this->getResetPasswordByEmail($email);
                $count = intval($reset['count']);
                if ($count == 0) {
                    $result = $this->Db->insert($this->tableResetPassword, [
                        'email' => $email,
                        'hash'  => $hash,
                        'date'  => $date,
                        'count' => $count + 1
                    ]);
                    if ($result) {
                        return true;
                    }
                    return false;
                } else {
                    $result = $this->Db->update($this->tableResetPassword, [
                        'email' => $email,
                        'hash'  => $hash,
                        'date'  => $date,
                        'count' => $count + 1
                    ], $reset['id']);
                    if ($result) {
                        return true;
                    }
                    return false;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * Check if set reset password params are valid
     *
     * @param null $email
     * @param null $hash
     * @param null $date
     * @return bool
     */
    public function areSetResetPasswordParamsValid(
        $email = null, $hash = null, $date = null
    ) {
        return (!empty($email) && !empty($hash) && !empty($date));
    }

    /**
     * Check how many times the user has changed his/hers password
     *
     * @param null $email
     * @return bool
     */
    private function isResetPasswordCountValid($email = null) {
        if (!empty($email)) {
            $result = $this->getResetPasswordByEmail($email);
            $currentCount = (empty($result)) ? 0 : intval($result['count']);
            $newCount = $currentCount + 1;
            if ($newCount <= 10) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Get how many times the user has changed his/hers password
     *
     * @param null $email
     * @return mixed
     */
    public function getResetPasswordByEmail($email = null) {
        $sql = "SELECT *
                FROM `{$this->tableResetPassword}`
                WHERE `email` = ?";
        return $this->Db->fetchOne($sql, $email);
    }

    /**
     * Check if the add user parameters are valid
     *
     * @param null $params
     * @param null $password
     * @return bool
     */
    private function areAddUserParametersValid($params = null, $password = null) {
        return (!empty($params) && !empty($password));
    }

    /**
     * Get user by hash
     *
     * @param null $hash
     * @return mixed
     */
    public function getUserByHash($hash = null) {
        return $this->getOne($hash, 'hash');
    }

    /**
     * Activate user account
     *
     * @param null $id
     * @return resource
     */
    public function activate($id = null) {
        return $this->update(['active' => 1], $id);
    }

    /**
     * Get user by email
     *
     * @param null $email
     * @return mixed
     */
    public function getByEmail($email = null) {
        return $this->getOne($email, 'email');
    }

    /**
     * Get user by id
     *
     * @param null $id
     * @return mixed
     */
    public function getUser($id = null) {
        return $this->getOne($id);
    }

    /**
     * Update an existing user
     *
     * @param null $params
     * @param null $id
     * @return bool
     */
    public function updateUser($params = null, $id = null) {
        return $this->update($params, $id);
    }

    /**
     * Get all users
     *
     * @param null $search
     * @return array
     */
    public function getUsers($search = null) {
        $params = [];
        $params[] = 1;
        $sql = "SELECT *
                FROM `{$this->table}`
                WHERE `active` = ?";
        if (!empty($search)) {
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $sql .= " AND (`first_name` LIKE ? || `last_name` LIKE ?)";
        }
        $sql .= " ORDER BY `last_name`, `first_name` ASC";
        return $this->Db->fetchAll($sql, $params);
    }

    /**
     * Delete a user by id
     *
     * @param null $id
     * @return bool|resource
     */
    public function removeUser($id = null) {
        return $this->delete($id);
    }
}