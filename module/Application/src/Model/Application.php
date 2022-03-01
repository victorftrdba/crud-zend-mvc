<?php

namespace Application\Model;

use Application\Model\AbstractModel;

class Application extends AbstractModel {
    public $table = 'posts';

    public function fetchAll()
    {
        $select = $this->sql->select()
        ->from('posts')
        ->join('categories', 'categories.id = posts.category_id', ['name']);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        return $results;
    }

    public function showCategories()
    {
        $select = $this->sql->select()
        ->from('categories');

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        return $results;
    }

    public function insertNoticia(array $data)
    {
        $insert = $this->sql->insert()
        ->into($this->table)
        ->values($data);

        $statement = $this->sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        return $result;
    }

    public function deleteNoticia($id)
    {
        $delete = $this->sql->delete()
        ->from($this->table)
        ->where(['id' => $id]);

        $statement = $this->sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();

        return $result;
    }

    public function showNoticia($id)
    {
        $select = $this->sql->select()
        ->from($this->table)
        ->join('categories', 'categories.id = posts.category_id', ['name'])
        ->where([$this->table.'.id' => $id]);

        $statement = $this->sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        return $result->current();
    }

    public function updateNoticia(array $data, $id)
    {
        $update = $this->sql->update()
        ->table($this->table)
        ->set($data)
        ->where([$this->table.'.id' => $id]);

        $statement = $this->sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();

        return $result;
    }
}