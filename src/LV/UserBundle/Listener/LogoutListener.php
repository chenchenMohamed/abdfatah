<?php

// LogoutListener.php - Change the namespace according to the location of this class in your bundle
namespace LV\UserBundle\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use FOS\UserBundle\Model\UserManagerInterface;

class LogoutListener implements LogoutHandlerInterface {
    protected $userManager;
    
    public function __construct(UserManagerInterface $userManager){
        $this->userManager = $userManager;
    }
    
    public function logout(Request $Request, Response $Response, TokenInterface $Token) {
        // ..
        // Here goes the logic that you want to execute when the user logouts
        // ..
        
        // The following example will create the logout.txt file in the /web directory of your project
        $myfile = fopen("logout.txt", "w");
        fwrite($myfile, 'logout succesfully executed !');
        fclose($myfile);
    }
}