<?php

namespace Controllers;

use Psr\Container\ContainerInterface;
use App\Ami;

class UsersController{

    protected $container;
    
    public function __construct( ContainerInterface $container ) {
		$this->container = $container;
    }
    
    function getUsers($request, $response, $args) {

        $db = $this->container->get('db');
        $users = $db->table('user')->get();

        $response->getBody()->write($users);
        return $response;
    }

}