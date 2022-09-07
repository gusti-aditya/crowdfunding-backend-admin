<?php

namespace App\Models;

use CodeIgniter\Model;

class PortofolioModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customers_business';
    protected $primaryKey       = 'customers_business_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'customers_business_id', 'business_id', 'customer_id', 'purchased_lot', 'purchase_status', 'created_at', 'updated_at', 'transaction_id'
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


    public function getPortofolioList(){
        $db      = \Config\Database::connect();
        $builder = $this->db->table('v_portofolio');
        $query = $builder->get();
        $return = $query->getResultArray();
        return($return);
    }

    public function getById($id){
        $db      = \Config\Database::connect();
        $builder = $this->db->table('v_portofolio');
        $query = $builder->where('business_id',$id);
        $return = $query->get()->getFirstRow();
        return($return);
    }
}
