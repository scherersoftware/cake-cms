<?php
namespace Cms\Model\Entity;

use Cake\Collection\Collection;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Entity;

/**
 * CmsPage Entity.
 */
class CmsPage extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Returns the next highest position for adding a new row
     *
     * @return int
     */
    public function getNextRowPosition()
    {
        $rows = new Collection($this->cms_rows);
        $highestRow = $rows->max('position');
        $maxPosition = 0;
        if ($highestRow) {
            $maxPosition = $highestRow->position;
        }
        return ($maxPosition + 1);
    }

    /**
     * Get the row with the given ID from the page entity
     *
     * @param string $id Row ID
     * @return CmsRow
     */
    public function getRow($id)
    {
        foreach ($this->cms_rows as $row) {
            if ($row->id == $id) {
                return $row;
            }
        }
        throw new RecordNotFoundException("Row with id {$id} wasn't found in this CmsPage entity");
    }
}
