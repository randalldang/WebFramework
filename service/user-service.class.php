<?php

class UserService extends BaseService {

    private $couriersDao;
    
    public function __construct(){
        parent::__construct();
        $this->couriersDao = new CouriersDao();
    }
    
    public function authenticate($username, $password){
        $courier = $this->couriersDao->getCouriersByUsername($username);
        return $courier->Password === $password;
    }

    public function getUser($username){
        $courier = $this->couriersDao->getCouriersByUsername($username);
        $user = new User();
        if (!empty($courier)) {
            $user->id = $courier->CourierId;
            $user->username = $courier->CourierCode;
            $user->password = $courier->Password;
            $user->displayName = $courier->CourierName;
        }
        
        return $user;
    }
}
?>
