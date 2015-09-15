<?php
namespace Cms\Model\Entity;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\ORM\Entity;

/**
 * CmsRow Entity.
 */
class CmsRow extends Entity
{

    /**
     * Block types this row contains
     *
     * @var array
     */
    protected $_blockTypes = [];

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
     * Finds if a block type is present in this row
     *
     * @param  string|array $type One or more block types
     * @return bool
     */
    public function hasBlockType($type)
    {
        if (count($this->_blockTypes) == 0) {
            $this->_findTypes();
        }

        if (is_array($type)) {
            foreach ($type as $typeName) {
                if (isset($this->_blockTypes[$typeName])) {
                    return true;
                }
            }
        } else {
            if (isset($this->_blockTypes[$type])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Builds the type map for contained blocks
     *
     * @return void
     */
    protected function _findTypes()
    {
        foreach ($this->cms_blocks as $block) {
            $widget = $block->widget;
            if (!isset($this->_blockTypes[$widget])) {
                $this->_blockTypes[$widget] = true;
            }
        }
    }

    /**
     * Return all blocks to render in the given row column
     *
     * @param int $column Numeric column index, starting with 1
     * @return array
     */
    public function getBlocksForColumn($column)
    {
        $blocks = new \Cake\Collection\Collection($this->cms_blocks);
        return $blocks->filter(function ($block) use ($column) {
            return ($block->column_index == $column);
        })->toArray();
    }

    /**
     * Returns a map of possible layouts for a CMS row
     *
     * @return array
     */
    public static function getLayouts()
    {
        $layouts = Configure::read('Cms.Design.rowLayouts');
        return array_combine($layouts, $layouts);
    }

    /**
     * Returns the next highest block position
     *
     * @return int
     */
    public function getNextBlockPosition()
    {
        $blocks = new Collection($this->cms_blocks);
        $highestBlock = $blocks->max('position');
        $maxPosition = 0;
        if ($highestBlock) {
            $maxPosition = $highestBlock->position;
        }
        return ($maxPosition + 1);
    }
}
