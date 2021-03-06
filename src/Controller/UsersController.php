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
class UsersController extends AppController
{
	public function initialize()
	{
		parent::initialize();
	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['index', 'view', 'signup', 'login', 'logout', 'confirm', 'complete']);
	}

	public function login()
	{
		if($this->request->is('post')){
			$user = $this->Auth->identify();
			if($user){
				if($this->request->data('autologin') == '1'){
				    $this->_setupAutoLogin($user);
				}
				$this->Auth->setUser($user);
				$this->Flash->success('Login Success.');
				$user_id = $user['id'];
				return $this->redirect(['action' => 'view/'.$user_id]);
			}
			$this->Flash->error(__('Invalid username or password, try again'));
		} else {
		    $autoLoginKey = $this->Cookie->read('AUTO_LOGIN');
		    if($autoLoginKey){
			$this->loadModel('AutoLogins');
			$query = $this->AutoLogins->findByAutoLoginKey($autoLoginKey);
			if($query->count() > 0){
			    $user_id = $query->first()->user_id;
			    $user = $this->Users->get($user_id)->toArray();
			    if($user){
				$this->_destroyAutoLogin($user);
				$this->_setupAutoLogin($user);
				$this->Auth->setUser($user);
				$this->Flash->success('Auto Login Success.');
				return $this->redirect(['action' => 'view/'.$user_id]);
			    }
			} else {
			    $this->Cookie->delete('AUTO_LOGIN');
			}
		    }
		}
	}

	public function logout(){
	    $this->_destroyAutoLogin($this->Auth->user());
	    $this->Flash->success('You are now logged out.');
	    return $this->redirect($this->Auth->logout());
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    public function complete()
    {
    if ($this->request->is('post')) {
        $user = $this->Auth->identify();
        if ($user) {
            $this->Auth->setUser($user);
                            $user_id = $user['id'];
            $this->Flash->success(__('Log In Success.'));
                            return $this->redirect(['action' => 'view/'.$user_id]);
        }
        $this->Flash->error('Your username or password is incorrect.');
            }
    }

    public function confirm()
    {
            $req_data = $this->Session->read('Signin.valid');
            if (!$req_data) {
                    return $this->redirect(['action' => 'add']);
            }

    $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $req_data);
    if ($this->request->is('post')) {
                    if ($user->errors()) {
                            return $this->redirect(['action' => 'add']);
                    }
                    $this->Session->delete('Signin.valid');

        if ($this->Users->save($user)) {
            return $this->redirect(['action' => 'complete']);
        }
        $this->Flash->error(__('The user could not be saved. Please, try again.'));
    }
    $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function signup()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
			$req_data = $this->request->getData();
			$user = $this->Users->patchEntity($user, $req_data);
			if(!$user->errors()){
				$this->Session->write('Signin.valid', $req_data);
				return $this->redirect(['action' => 'confirm']);
			} else {
				$this->Flash->error(__('Something wrong... Please, try again.'));
			}
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    private function _setupAutoLogin($user)
    {
	$this->loadModel('AutoLogins');
	$autoLoginKey = sha1(uniqid() . mt_rand(1, 999999999) . '_auto_login');
	$entity = $this->AutoLogins->newEntity([
	    'user_id' => $user['id'],
	    'auto_login_key' => $autoLoginKey,
	]);
	$this->AutoLogins->save($entity);
	
	$this->Cookie->config([
	    'expires' => '+7 days',
	    'path' => '/',
	]);
	$this->Cookie->write('AUTO_LOGIN', $autoLoginKey);
    }
    
    private function _destroyAutoLogin($user)
    {
	$this->loadModel('AutoLogins');
	try {
	    $entity = $this->AutoLogins->find('all')->where(['user_id' => $user['id']])->first();
	    if($entity){
		$this->AutoLogins->delete($entity);
		$this->Cookie->delete('AUTO_LOGIN');
	    }
	} catch (RecordNotFoundException $e){
	    $this->Cookie->delete('AUTO_LOGIN');
	}
    }
}
