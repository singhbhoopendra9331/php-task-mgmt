<?php
 
namespace App\Models;

use App\Core\Model;

class Task extends Model
{
    protected string $table = 'tasks';

    protected string $pk = 'id';

    protected string $name = ''; 
    
    function __construct()
    {
        parent::__construct();
    }

    public function all(): array
    {
        return [];
    }

    public function get(int $id): array
    {
        $task = [
            'id'=> $id,
        ];

        return $task;
    }
}