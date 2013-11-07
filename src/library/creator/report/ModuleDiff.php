<?php

/**
 * Description of ModuleDiff
 *
 * @author Ivan Batić <ivan.batic@live.com>
 */

namespace Orangehill\Photon\Library\Creator\Report;

use Orangehill\Photon\Module;
use Orangehill\Photon\Library\Creator\Report\ModuleComparator;

class ModuleDiff
{

    public static function diffChanges($moduleInput)
    {
        $comparator = new ModuleComparator();
        $id = isset($moduleInput['id']) ? $moduleInput['id'] : 0;

        $module = Module::with('Fields')->find($id);
        $module = is_object($module) ? $module->toArray() : array();

        $changes = $comparator->compare($moduleInput, $module);
        foreach ($changes as &$changesets) {
            foreach ($changesets as &$changeset) {
                $changeset = $changeset->toArray();
            }
        }
        return $changes;
    }

}
