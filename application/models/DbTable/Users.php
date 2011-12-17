<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';

    public function getUser($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find user $id");
        }
        return $row->toArray();
    }

    public function addUser($newUser)
    {
        $data = array(
            'email' => $newUser['email']
        );

        if(isset($newUser['firstname'])){
          $data['firstname'] = $newUser['firstname'];
        }
        
        if(isset($newUser['lastname'])){
          $data['lastname'] = $newUser['lastname'];
        }
        
        if(isset($newUser['password'])){
          $data['password'] = sha1($newUser['password']);
        }

        
        $this->insert($data);
    }

    public function updateUser($id, $user)
    {
        $data = array(
            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
        );
        
        if(isset($user['password'])){
          $data['password'] = sha1($user['password']);
        }
        
        $this->update($data, 'id = '. (int)$id);
    }

    public function deleteUser($id)
    {
        $this->delete('id =' . (int)$id);
    }
}
