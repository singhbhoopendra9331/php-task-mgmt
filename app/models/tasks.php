<?php
 
namespace app\models;

use app\core\Model;

class Task extends Model
{
    protected string $table = 'tasks';

    protected string $pk = 'id';

    protected string $name = '';
    protected string $autoWriteTimestamp = true;
    
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