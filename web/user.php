<?php

include '../include.php';

class UserAction extends BaseAction {

    private $couriersService;
    
    function __construct() {
        parent::__construct();
        $this->userService = new UserService();
    }

    function doGet() {
    }

    public function doPost(){
        $action = $this->post->action;
        if ($action === 'LOGIN') {
            $this->login();
        }
            
    }

    private function login(){
        $username = $this->post->username;
        $password = $this->post->password;
        $result = false;
        if (!empty($username) && !empty($password)) {
            $user = $this->userService->getUser($username);
            if ($user->password === $password) {
                $result = true;
                set_user_to_cookie($user, time() + 3600 * 24 * 7);
            }
        } 
        echo json_encode(array('status' => ($result ? 'true' : 'false')));
    }
}

run('UserAction');
?>
