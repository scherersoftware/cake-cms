<?php
namespace Cms\Model\Entity;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Entity;
use Exception;

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

    /**
     * Merges the configured, available attributes with data from the page_attributes
     * field.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributesConfig = Configure::read('Cms.Pages.attributes');
        foreach ($attributesConfig as $attribute => $attributeConfig) {
            $attributesConfig[$attribute]['value'] = isset($this->page_attributes[$attribute]) ? $this->page_attributes[$attribute] : $attributeConfig['default'];
        }
        return $attributesConfig;
    }

    /**
     * Returns the value of the given page attribute. Will return the configured
     * default value if no value is present.
     *
     * @param string $attribute Attribute Field Name
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        $attributes = $this->getAttributes();
        if (!isset($attributes[$attribute])) {
            throw new Exception("Attribute {$attribute} is not configured.");
        }
        return $attributes[$attribute]['value'];
    }
}
