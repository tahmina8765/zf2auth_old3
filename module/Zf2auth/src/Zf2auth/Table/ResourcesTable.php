<?php
namespace Zf2auth\Table;

use Zend\Db\TableGateway\TableGateway;


use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zf2auth\Entity\Resources;

class ResourcesTable extends AbstractTableGateway
{
    protected $table = 'resources';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Resources());

        $this->initialize();
    }

    public function fetchAll(Select $select = null, $paginated = false) {
        $adapter = $this->adapter;
        if (null === $select)
            $select  = new Select();
        $select->from($this->table);
        if ($paginated) {
            $paginatorAdapter = new DbSelect($select, $adapter);
            $paginator        = new Paginator($paginatorAdapter);
            return $paginator;
        } else {
            $sql       = new Sql($adapter);
            $statement = $sql->getSqlStringForSqlObject($select);
            $resultSet = $adapter->query($statement, $adapter::QUERY_MODE_EXECUTE);
            $resultSet->buffer();
            return $resultSet;
        }
    }


    public function getResources($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

    public function saveResources(Resources $resources)
    {
        $result = array(
            'status' => 0,
            'message' => ''
        );
        $data = array(
            'name' => $resources->name,
		
        );

        $id = (int)$resources->id;
        if ($id == 0) {
            unset($data['modified_by']);
            unset($data['modified']);
            $result['status'] = $this->insert($data);
        } else {
            if ($this->getResources($id)) {
                unset($data['created_by']);
                unset($data['created']);
                $result['status'] = $this->update($data, array('id' => $id));
            } else {
                $result['message'] = 'ID does not exist';
            }
        }

        return $result;
    }

    public function deleteResources($id)
    {
        $result = array(
            'status' => 0,
            'message' => ''
        );
        try{
            $result['status'] = $this->delete(array('id' => $id));

            }catch(\Exception $e){
            $result['message'] = 'Information can not be deleted.';
            }
            return $result;
    }

    public function dropdownRoles(Select $select = null) {
        if (null === $select)
            $select    = new Select();
        $select->from($this->table);
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();

        $options     = array ();
        $options[''] = '--- Please Select ---';
        if (count($resultSet) > 0) {
            foreach ($resultSet as $row)
                $options[$row->getId()] = $row->getName();
        }
        return $options;

    }
}
            