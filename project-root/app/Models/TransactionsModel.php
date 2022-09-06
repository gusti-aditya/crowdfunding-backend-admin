<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_transaction';
    protected $primaryKey       = 'transaction_id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'transaction_id','customer_id','business_id','lot_amount','lot_value','subtotal','purchase_date','status','transaction_method','transaction_dest','transaction_type','is_confirmed','confirmed_file'
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

    public function getTransactionsList($id){
        $db      = \Config\Database::connect();
        $builder = $this->db->table('v_checkout_transactions');
        $query = $builder->where('customer_id',$id)->get();
        $return = $query->getResultArray();
        return($return);
    }

    public function getById($id){
        $db      = \Config\Database::connect();
        $builder = $this->db->table('v_checkout_transactions');
        $query = $builder->where('business_id',$id);
        $return = $query->get()->getFirstRow();
        return($return);
    }
}
