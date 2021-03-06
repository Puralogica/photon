<?php

/**
 * Description of ModuleComparator
 *
 * @author Ivan Batić <ivan.batic@live.com>
 */

namespace Orangehill\Photon\Library\Creator\Report;

use Orangehill\Photon\Library\Creator\Report\Comparator;
use Orangehill\Photon\Library\Support\ArrayLib;
use Orangehill\Photon\Library\Creator\Report\Changes\Change;
use Orangehill\Photon\Library\Creator\Report\Changes\Changeset;

class ModuleComparator extends Comparator
{

    protected static $modulesTable = 'modules';
    protected static $fieldsTableName = 'fields';

    public function compare(array $input = array(), array $module = array())
    {
        $inputModule = $input;
        $inputUpdatedFields = isset($input['fields']) ? $input['fields'] : array();
        $inputNewFields = empty($inputUpdatedFields) ? array() : (isset($inputUpdatedFields['new']) ? $inputUpdatedFields['new'] : array());

        $originalModule = $module;
        $origF = isset($module['fields']) ? $module['fields'] : array();
        $originalFields = ArrayLib::index($origF);

        unset($originalModule['fields']);
        unset($inputModule['fields']);
        unset($inputUpdatedFields['new']);

        $changesets = array(
            'module'         => $this->createChangesets(array($inputModule), array($originalModule), empty($originalModule) ? 'create' : 'update', 'module', 'name'),
            'updated_fields' => $this->createChangesets($inputUpdatedFields, $originalFields, 'update'),
            'created_fields' => $this->createChangesets($inputNewFields, array(), 'create'),
            'deleted_fields' => $this->createChangesets($originalFields, $inputUpdatedFields, 'delete')
        );

        return $changesets;
    }

    private function createChangesets(array $input, array $against, $changesetType, $itemType = 'field', $nameField = 'name')
    {
        $set = array();
        foreach ($input as $id => $field) {
            $againstValue = isset($against[$id]) ? $against[$id] : array();
            $changes = $this->compareItem($field, $againstValue);
            if (!empty($changes) && !($changesetType == 'delete' && count($changes) !== count($field))) {
                $changeset = new Changeset($changes);
                $itemName = null;
                if (isset($againstValue[$nameField]) && !empty($againstValue[$nameField])) {
                    $itemName = $againstValue[$nameField];
                } elseif (isset($field[$nameField])) {
                    $itemName = $field[$nameField];
                }
                $set[] = $changeset
                    ->setType($changesetType)
                    ->setItemType($itemType)
                    ->setItemId($field['id'] ?: null)
                    ->setItemName($itemName);
            }
        }
        return $set;
    }

    public function compareItem(array $input, array $original, $idKey = 'id')
    {
        $changes = array();
        foreach ($input as $key => $value) {
            $originalValue = isset($original[$key]) ? $original[$key] : null;
            if ($value !== $originalValue || !array_key_exists($key, $original)) {
                $change = new Change($originalValue, $value);
                $change->setName($key)
                    ->setId(isset($input[$idKey]) ? $input[$idKey] : null);
                $changes[] = $change;
            }
        }
        return $changes;
    }

}
