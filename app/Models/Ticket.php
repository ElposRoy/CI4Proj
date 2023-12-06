<?php

namespace App\Models;

use CodeIgniter\Model;

class Ticket extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'office_id',
        'first_name',
        'last_name',
        'email',
        'state',
        'severity',
        'description',
        'remarks',
    ];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'office_id' => 'required|integer',
        'first_name' => 'required|string|max_length[255]',
        'last_name' => 'required|string|max_length[255]',
        'email' => 'required|valid_email|max_length[255]',
        'state' => 'required|in_list[pending,processing,resolved]',
        'severity' => 'required|in_list[low,moderate,high,critical]',
        'description' => 'required|string|max_length[255]',
        'remarks' => 'required|string|max_length[255]',
    ];
    
    protected $validationMessages = [
        'state.in_list' => 'The state field must be one of: pending, processing, resolved.',
    ];
    
    protected $skipValidation = false; // Set to true if you want to skip validation when saving
    
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
