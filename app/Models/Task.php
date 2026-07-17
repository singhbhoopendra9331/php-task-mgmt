<?php
 
namespace App\Models;

use App\Core\Model;

class Task extends Model
{
    protected string $table = 'tasks';

    protected string $primaryKey = 'id';

    protected int $perPage = 10;

    public function get(int $id): array|false
    {
        return $this->find($id);
    }
}
