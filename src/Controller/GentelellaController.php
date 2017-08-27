<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class GentelellaController extends AppController
{
    public function initialize()
    {
	    parent::initialize();
	    $this->layout = '';
    }

    public function index()
    {
    }

    public function tablesDynamic()
    {
    } 
}
