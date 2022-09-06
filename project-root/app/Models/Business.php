<?php

namespace App\Models;

use CodeIgniter\Model;

class Business extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'business';
    protected $primaryKey       = 'business_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'business_id', 'business_name', 'owner_contact', 'yield_period', 'yield_percentage', 'due_date', 'description', 'business_category', 'publisher', 'business_value', 'max_unit'
    ];


    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
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


    public function getBusinessList(){
        $db      = \Config\Database::connect();
        $builder = $this->db->table('v_business_list');
        $query = $builder->get();
        $return = $query->getResultArray();
        return($return);
    }

    public function getById($id){
        $db      = \Config\Database::connect();
        $builder = $this->db->table('v_business_list');
        $query = $builder->where('business_id',$id);
        $return = $query->get()->getFirstRow();
        return($return);
    }
}
