<?php

namespace App\Repositories;

interface RepositoryInterface {

    /**
     * Should return all the record as an array
     *
     * @return array
     */
    public function getAll();

    // public function paginate($perPage = 15, $columns = array('*'));

    // public function create(array $data);

    // public function update(array $data, $id);

    // public function delete($id);

    public function find($id);

    // public function findBy($field, $value, $columns = array('*'));
}

?>
