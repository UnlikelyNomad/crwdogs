<?php

namespace crwdogs\events\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use crwdogs\events\Event as ChildEvent;
use crwdogs\events\EventQuery as ChildEventQuery;
use crwdogs\events\Item as ChildItem;
use crwdogs\events\ItemOption as ChildItemOption;
use crwdogs\events\ItemOptionQuery as ChildItemOptionQuery;
use crwdogs\events\ItemQuery as ChildItemQuery;
use crwdogs\events\PurchasedItem as ChildPurchasedItem;
use crwdogs\events\PurchasedItemQuery as ChildPurchasedItemQuery;
use crwdogs\events\Map\ItemOptionTableMap;
use crwdogs\events\Map\ItemTableMap;
use crwdogs\events\Map\PurchasedItemTableMap;

/**
 * Base class that represents a row from the 'item' table.
 *
 *
 *
 * @package    propel.generator.crwdogs.events.Base
 */
abstract class Item implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\crwdogs\\events\\Map\\ItemTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the item_id field.
     *
     * @var        int
     */
    protected $item_id;

    /**
     * The value for the event_id field.
     *
     * @var        int
     */
    protected $event_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the qty_type field.
     *
     * @var        string
     */
    protected $qty_type;

    /**
     * The value for the min_qty field.
     *
     * @var        int
     */
    protected $min_qty;

    /**
     * The value for the max_qty field.
     *
     * @var        int
     */
    protected $max_qty;

    /**
     * The value for the event_qty field.
     *
     * @var        int
     */
    protected $event_qty;

    /**
     * The value for the image field.
     *
     * @var        string
     */
    protected $image;

    /**
     * The value for the label field.
     *
     * @var        string
     */
    protected $label;

    /**
     * The value for the base_cost field.
     *
     * @var        string
     */
    protected $base_cost;

    /**
     * The value for the multiple_variations field.
     *
     * @var        string
     */
    protected $multiple_variations;

    /**
     * The value for the qty_label field.
     *
     * @var        string
     */
    protected $qty_label;

    /**
     * The value for the cost_label field.
     *
     * @var        string
     */
    protected $cost_label;

    /**
     * The value for the sort field.
     *
     * @var        int
     */
    protected $sort;

    /**
     * @var        ChildEvent
     */
    protected $aEvent;

    /**
     * @var        ObjectCollection|ChildItemOption[] Collection to store aggregation of ChildItemOption objects.
     */
    protected $collItemOptions;
    protected $collItemOptionsPartial;

    /**
     * @var        ObjectCollection|ChildPurchasedItem[] Collection to store aggregation of ChildPurchasedItem objects.
     */
    protected $collPurchasedItems;
    protected $collPurchasedItemsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItemOption[]
     */
    protected $itemOptionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPurchasedItem[]
     */
    protected $purchasedItemsScheduledForDeletion = null;

    /**
     * Initializes internal state of crwdogs\events\Base\Item object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Item</code> instance.  If
     * <code>obj</code> is an instance of <code>Item</code>, delegates to
     * <code>equals(Item)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Item The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [item_id] column value.
     *
     * @return int
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Get the [event_id] column value.
     *
     * @return int
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [qty_type] column value.
     *
     * @return string
     */
    public function getQtyType()
    {
        return $this->qty_type;
    }

    /**
     * Get the [min_qty] column value.
     *
     * @return int
     */
    public function getMinQty()
    {
        return $this->min_qty;
    }

    /**
     * Get the [max_qty] column value.
     *
     * @return int
     */
    public function getMaxQty()
    {
        return $this->max_qty;
    }

    /**
     * Get the [event_qty] column value.
     *
     * @return int
     */
    public function getEventQty()
    {
        return $this->event_qty;
    }

    /**
     * Get the [image] column value.
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get the [label] column value.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the [base_cost] column value.
     *
     * @return string
     */
    public function getBaseCost()
    {
        return $this->base_cost;
    }

    /**
     * Get the [multiple_variations] column value.
     *
     * @return string
     */
    public function getMultipleVariations()
    {
        return $this->multiple_variations;
    }

    /**
     * Get the [qty_label] column value.
     *
     * @return string
     */
    public function getQtyLabel()
    {
        return $this->qty_label;
    }

    /**
     * Get the [cost_label] column value.
     *
     * @return string
     */
    public function getCostLabel()
    {
        return $this->cost_label;
    }

    /**
     * Get the [sort] column value.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set the value of [item_id] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->item_id !== $v) {
            $this->item_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_ITEM_ID] = true;
        }

        return $this;
    } // setItemId()

    /**
     * Set the value of [event_id] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setEventId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_id !== $v) {
            $this->event_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_EVENT_ID] = true;
        }

        if ($this->aEvent !== null && $this->aEvent->getEventId() !== $v) {
            $this->aEvent = null;
        }

        return $this;
    } // setEventId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ItemTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [qty_type] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setQtyType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->qty_type !== $v) {
            $this->qty_type = $v;
            $this->modifiedColumns[ItemTableMap::COL_QTY_TYPE] = true;
        }

        return $this;
    } // setQtyType()

    /**
     * Set the value of [min_qty] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setMinQty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->min_qty !== $v) {
            $this->min_qty = $v;
            $this->modifiedColumns[ItemTableMap::COL_MIN_QTY] = true;
        }

        return $this;
    } // setMinQty()

    /**
     * Set the value of [max_qty] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setMaxQty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->max_qty !== $v) {
            $this->max_qty = $v;
            $this->modifiedColumns[ItemTableMap::COL_MAX_QTY] = true;
        }

        return $this;
    } // setMaxQty()

    /**
     * Set the value of [event_qty] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setEventQty($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_qty !== $v) {
            $this->event_qty = $v;
            $this->modifiedColumns[ItemTableMap::COL_EVENT_QTY] = true;
        }

        return $this;
    } // setEventQty()

    /**
     * Set the value of [image] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[ItemTableMap::COL_IMAGE] = true;
        }

        return $this;
    } // setImage()

    /**
     * Set the value of [label] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label !== $v) {
            $this->label = $v;
            $this->modifiedColumns[ItemTableMap::COL_LABEL] = true;
        }

        return $this;
    } // setLabel()

    /**
     * Set the value of [base_cost] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setBaseCost($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->base_cost !== $v) {
            $this->base_cost = $v;
            $this->modifiedColumns[ItemTableMap::COL_BASE_COST] = true;
        }

        return $this;
    } // setBaseCost()

    /**
     * Set the value of [multiple_variations] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setMultipleVariations($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->multiple_variations !== $v) {
            $this->multiple_variations = $v;
            $this->modifiedColumns[ItemTableMap::COL_MULTIPLE_VARIATIONS] = true;
        }

        return $this;
    } // setMultipleVariations()

    /**
     * Set the value of [qty_label] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setQtyLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->qty_label !== $v) {
            $this->qty_label = $v;
            $this->modifiedColumns[ItemTableMap::COL_QTY_LABEL] = true;
        }

        return $this;
    } // setQtyLabel()

    /**
     * Set the value of [cost_label] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setCostLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cost_label !== $v) {
            $this->cost_label = $v;
            $this->modifiedColumns[ItemTableMap::COL_COST_LABEL] = true;
        }

        return $this;
    } // setCostLabel()

    /**
     * Set the value of [sort] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sort !== $v) {
            $this->sort = $v;
            $this->modifiedColumns[ItemTableMap::COL_SORT] = true;
        }

        return $this;
    } // setSort()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemTableMap::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemTableMap::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemTableMap::translateFieldName('QtyType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->qty_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ItemTableMap::translateFieldName('MinQty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->min_qty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ItemTableMap::translateFieldName('MaxQty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->max_qty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ItemTableMap::translateFieldName('EventQty', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_qty = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ItemTableMap::translateFieldName('Image', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ItemTableMap::translateFieldName('Label', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ItemTableMap::translateFieldName('BaseCost', TableMap::TYPE_PHPNAME, $indexType)];
            $this->base_cost = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ItemTableMap::translateFieldName('MultipleVariations', TableMap::TYPE_PHPNAME, $indexType)];
            $this->multiple_variations = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ItemTableMap::translateFieldName('QtyLabel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->qty_label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : ItemTableMap::translateFieldName('CostLabel', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cost_label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : ItemTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sort = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = ItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\crwdogs\\events\\Item'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aEvent !== null && $this->event_id !== $this->aEvent->getEventId()) {
            $this->aEvent = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEvent = null;
            $this->collItemOptions = null;

            $this->collPurchasedItems = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Item::setDeleted()
     * @see Item::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildItemQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ItemTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aEvent !== null) {
                if ($this->aEvent->isModified() || $this->aEvent->isNew()) {
                    $affectedRows += $this->aEvent->save($con);
                }
                $this->setEvent($this->aEvent);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->itemOptionsScheduledForDeletion !== null) {
                if (!$this->itemOptionsScheduledForDeletion->isEmpty()) {
                    \crwdogs\events\ItemOptionQuery::create()
                        ->filterByPrimaryKeys($this->itemOptionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->itemOptionsScheduledForDeletion = null;
                }
            }

            if ($this->collItemOptions !== null) {
                foreach ($this->collItemOptions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->purchasedItemsScheduledForDeletion !== null) {
                if (!$this->purchasedItemsScheduledForDeletion->isEmpty()) {
                    \crwdogs\events\PurchasedItemQuery::create()
                        ->filterByPrimaryKeys($this->purchasedItemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->purchasedItemsScheduledForDeletion = null;
                }
            }

            if ($this->collPurchasedItems !== null) {
                foreach ($this->collPurchasedItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ItemTableMap::COL_ITEM_ID] = true;
        if (null !== $this->item_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ItemTableMap::COL_ITEM_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ItemTableMap::COL_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'item_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_EVENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'event_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(ItemTableMap::COL_QTY_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'qty_type';
        }
        if ($this->isColumnModified(ItemTableMap::COL_MIN_QTY)) {
            $modifiedColumns[':p' . $index++]  = 'min_qty';
        }
        if ($this->isColumnModified(ItemTableMap::COL_MAX_QTY)) {
            $modifiedColumns[':p' . $index++]  = 'max_qty';
        }
        if ($this->isColumnModified(ItemTableMap::COL_EVENT_QTY)) {
            $modifiedColumns[':p' . $index++]  = 'event_qty';
        }
        if ($this->isColumnModified(ItemTableMap::COL_IMAGE)) {
            $modifiedColumns[':p' . $index++]  = 'image';
        }
        if ($this->isColumnModified(ItemTableMap::COL_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'label';
        }
        if ($this->isColumnModified(ItemTableMap::COL_BASE_COST)) {
            $modifiedColumns[':p' . $index++]  = 'base_cost';
        }
        if ($this->isColumnModified(ItemTableMap::COL_MULTIPLE_VARIATIONS)) {
            $modifiedColumns[':p' . $index++]  = 'multiple_variations';
        }
        if ($this->isColumnModified(ItemTableMap::COL_QTY_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'qty_label';
        }
        if ($this->isColumnModified(ItemTableMap::COL_COST_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'cost_label';
        }
        if ($this->isColumnModified(ItemTableMap::COL_SORT)) {
            $modifiedColumns[':p' . $index++]  = 'sort';
        }

        $sql = sprintf(
            'INSERT INTO item (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'item_id':
                        $stmt->bindValue($identifier, $this->item_id, PDO::PARAM_INT);
                        break;
                    case 'event_id':
                        $stmt->bindValue($identifier, $this->event_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'qty_type':
                        $stmt->bindValue($identifier, $this->qty_type, PDO::PARAM_STR);
                        break;
                    case 'min_qty':
                        $stmt->bindValue($identifier, $this->min_qty, PDO::PARAM_INT);
                        break;
                    case 'max_qty':
                        $stmt->bindValue($identifier, $this->max_qty, PDO::PARAM_INT);
                        break;
                    case 'event_qty':
                        $stmt->bindValue($identifier, $this->event_qty, PDO::PARAM_INT);
                        break;
                    case 'image':
                        $stmt->bindValue($identifier, $this->image, PDO::PARAM_STR);
                        break;
                    case 'label':
                        $stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
                        break;
                    case 'base_cost':
                        $stmt->bindValue($identifier, $this->base_cost, PDO::PARAM_STR);
                        break;
                    case 'multiple_variations':
                        $stmt->bindValue($identifier, $this->multiple_variations, PDO::PARAM_STR);
                        break;
                    case 'qty_label':
                        $stmt->bindValue($identifier, $this->qty_label, PDO::PARAM_STR);
                        break;
                    case 'cost_label':
                        $stmt->bindValue($identifier, $this->cost_label, PDO::PARAM_STR);
                        break;
                    case 'sort':
                        $stmt->bindValue($identifier, $this->sort, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setItemId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getItemId();
                break;
            case 1:
                return $this->getEventId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getQtyType();
                break;
            case 4:
                return $this->getMinQty();
                break;
            case 5:
                return $this->getMaxQty();
                break;
            case 6:
                return $this->getEventQty();
                break;
            case 7:
                return $this->getImage();
                break;
            case 8:
                return $this->getLabel();
                break;
            case 9:
                return $this->getBaseCost();
                break;
            case 10:
                return $this->getMultipleVariations();
                break;
            case 11:
                return $this->getQtyLabel();
                break;
            case 12:
                return $this->getCostLabel();
                break;
            case 13:
                return $this->getSort();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Item'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Item'][$this->hashCode()] = true;
        $keys = ItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getItemId(),
            $keys[1] => $this->getEventId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getQtyType(),
            $keys[4] => $this->getMinQty(),
            $keys[5] => $this->getMaxQty(),
            $keys[6] => $this->getEventQty(),
            $keys[7] => $this->getImage(),
            $keys[8] => $this->getLabel(),
            $keys[9] => $this->getBaseCost(),
            $keys[10] => $this->getMultipleVariations(),
            $keys[11] => $this->getQtyLabel(),
            $keys[12] => $this->getCostLabel(),
            $keys[13] => $this->getSort(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aEvent) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'event';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'event';
                        break;
                    default:
                        $key = 'Event';
                }

                $result[$key] = $this->aEvent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collItemOptions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'itemOptions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'item_options';
                        break;
                    default:
                        $key = 'ItemOptions';
                }

                $result[$key] = $this->collItemOptions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPurchasedItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'purchasedItems';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'purchased_items';
                        break;
                    default:
                        $key = 'PurchasedItems';
                }

                $result[$key] = $this->collPurchasedItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\crwdogs\events\Item
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\crwdogs\events\Item
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setItemId($value);
                break;
            case 1:
                $this->setEventId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setQtyType($value);
                break;
            case 4:
                $this->setMinQty($value);
                break;
            case 5:
                $this->setMaxQty($value);
                break;
            case 6:
                $this->setEventQty($value);
                break;
            case 7:
                $this->setImage($value);
                break;
            case 8:
                $this->setLabel($value);
                break;
            case 9:
                $this->setBaseCost($value);
                break;
            case 10:
                $this->setMultipleVariations($value);
                break;
            case 11:
                $this->setQtyLabel($value);
                break;
            case 12:
                $this->setCostLabel($value);
                break;
            case 13:
                $this->setSort($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEventId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setQtyType($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setMinQty($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setMaxQty($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setEventQty($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setImage($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setLabel($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setBaseCost($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setMultipleVariations($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setQtyLabel($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCostLabel($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setSort($arr[$keys[13]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\crwdogs\events\Item The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemTableMap::COL_ITEM_ID)) {
            $criteria->add(ItemTableMap::COL_ITEM_ID, $this->item_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_EVENT_ID)) {
            $criteria->add(ItemTableMap::COL_EVENT_ID, $this->event_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_NAME)) {
            $criteria->add(ItemTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ItemTableMap::COL_QTY_TYPE)) {
            $criteria->add(ItemTableMap::COL_QTY_TYPE, $this->qty_type);
        }
        if ($this->isColumnModified(ItemTableMap::COL_MIN_QTY)) {
            $criteria->add(ItemTableMap::COL_MIN_QTY, $this->min_qty);
        }
        if ($this->isColumnModified(ItemTableMap::COL_MAX_QTY)) {
            $criteria->add(ItemTableMap::COL_MAX_QTY, $this->max_qty);
        }
        if ($this->isColumnModified(ItemTableMap::COL_EVENT_QTY)) {
            $criteria->add(ItemTableMap::COL_EVENT_QTY, $this->event_qty);
        }
        if ($this->isColumnModified(ItemTableMap::COL_IMAGE)) {
            $criteria->add(ItemTableMap::COL_IMAGE, $this->image);
        }
        if ($this->isColumnModified(ItemTableMap::COL_LABEL)) {
            $criteria->add(ItemTableMap::COL_LABEL, $this->label);
        }
        if ($this->isColumnModified(ItemTableMap::COL_BASE_COST)) {
            $criteria->add(ItemTableMap::COL_BASE_COST, $this->base_cost);
        }
        if ($this->isColumnModified(ItemTableMap::COL_MULTIPLE_VARIATIONS)) {
            $criteria->add(ItemTableMap::COL_MULTIPLE_VARIATIONS, $this->multiple_variations);
        }
        if ($this->isColumnModified(ItemTableMap::COL_QTY_LABEL)) {
            $criteria->add(ItemTableMap::COL_QTY_LABEL, $this->qty_label);
        }
        if ($this->isColumnModified(ItemTableMap::COL_COST_LABEL)) {
            $criteria->add(ItemTableMap::COL_COST_LABEL, $this->cost_label);
        }
        if ($this->isColumnModified(ItemTableMap::COL_SORT)) {
            $criteria->add(ItemTableMap::COL_SORT, $this->sort);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildItemQuery::create();
        $criteria->add(ItemTableMap::COL_ITEM_ID, $this->item_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getItemId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getItemId();
    }

    /**
     * Generic method to set the primary key (item_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setItemId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getItemId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \crwdogs\events\Item (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEventId($this->getEventId());
        $copyObj->setName($this->getName());
        $copyObj->setQtyType($this->getQtyType());
        $copyObj->setMinQty($this->getMinQty());
        $copyObj->setMaxQty($this->getMaxQty());
        $copyObj->setEventQty($this->getEventQty());
        $copyObj->setImage($this->getImage());
        $copyObj->setLabel($this->getLabel());
        $copyObj->setBaseCost($this->getBaseCost());
        $copyObj->setMultipleVariations($this->getMultipleVariations());
        $copyObj->setQtyLabel($this->getQtyLabel());
        $copyObj->setCostLabel($this->getCostLabel());
        $copyObj->setSort($this->getSort());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getItemOptions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItemOption($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPurchasedItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPurchasedItem($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setItemId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \crwdogs\events\Item Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildEvent object.
     *
     * @param  ChildEvent $v
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function setEvent(ChildEvent $v = null)
    {
        if ($v === null) {
            $this->setEventId(NULL);
        } else {
            $this->setEventId($v->getEventId());
        }

        $this->aEvent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildEvent object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildEvent object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildEvent The associated ChildEvent object.
     * @throws PropelException
     */
    public function getEvent(ConnectionInterface $con = null)
    {
        if ($this->aEvent === null && ($this->event_id != 0)) {
            $this->aEvent = ChildEventQuery::create()->findPk($this->event_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aEvent->addItems($this);
             */
        }

        return $this->aEvent;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ItemOption' == $relationName) {
            $this->initItemOptions();
            return;
        }
        if ('PurchasedItem' == $relationName) {
            $this->initPurchasedItems();
            return;
        }
    }

    /**
     * Clears out the collItemOptions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItemOptions()
     */
    public function clearItemOptions()
    {
        $this->collItemOptions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItemOptions collection loaded partially.
     */
    public function resetPartialItemOptions($v = true)
    {
        $this->collItemOptionsPartial = $v;
    }

    /**
     * Initializes the collItemOptions collection.
     *
     * By default this just sets the collItemOptions collection to an empty array (like clearcollItemOptions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItemOptions($overrideExisting = true)
    {
        if (null !== $this->collItemOptions && !$overrideExisting) {
            return;
        }

        $collectionClassName = ItemOptionTableMap::getTableMap()->getCollectionClassName();

        $this->collItemOptions = new $collectionClassName;
        $this->collItemOptions->setModel('\crwdogs\events\ItemOption');
    }

    /**
     * Gets an array of ChildItemOption objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildItemOption[] List of ChildItemOption objects
     * @throws PropelException
     */
    public function getItemOptions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemOptionsPartial && !$this->isNew();
        if (null === $this->collItemOptions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItemOptions) {
                // return empty collection
                $this->initItemOptions();
            } else {
                $collItemOptions = ChildItemOptionQuery::create(null, $criteria)
                    ->filterByItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemOptionsPartial && count($collItemOptions)) {
                        $this->initItemOptions(false);

                        foreach ($collItemOptions as $obj) {
                            if (false == $this->collItemOptions->contains($obj)) {
                                $this->collItemOptions->append($obj);
                            }
                        }

                        $this->collItemOptionsPartial = true;
                    }

                    return $collItemOptions;
                }

                if ($partial && $this->collItemOptions) {
                    foreach ($this->collItemOptions as $obj) {
                        if ($obj->isNew()) {
                            $collItemOptions[] = $obj;
                        }
                    }
                }

                $this->collItemOptions = $collItemOptions;
                $this->collItemOptionsPartial = false;
            }
        }

        return $this->collItemOptions;
    }

    /**
     * Sets a collection of ChildItemOption objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $itemOptions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function setItemOptions(Collection $itemOptions, ConnectionInterface $con = null)
    {
        /** @var ChildItemOption[] $itemOptionsToDelete */
        $itemOptionsToDelete = $this->getItemOptions(new Criteria(), $con)->diff($itemOptions);


        $this->itemOptionsScheduledForDeletion = $itemOptionsToDelete;

        foreach ($itemOptionsToDelete as $itemOptionRemoved) {
            $itemOptionRemoved->setItem(null);
        }

        $this->collItemOptions = null;
        foreach ($itemOptions as $itemOption) {
            $this->addItemOption($itemOption);
        }

        $this->collItemOptions = $itemOptions;
        $this->collItemOptionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ItemOption objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ItemOption objects.
     * @throws PropelException
     */
    public function countItemOptions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemOptionsPartial && !$this->isNew();
        if (null === $this->collItemOptions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItemOptions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItemOptions());
            }

            $query = ChildItemOptionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByItem($this)
                ->count($con);
        }

        return count($this->collItemOptions);
    }

    /**
     * Method called to associate a ChildItemOption object to this object
     * through the ChildItemOption foreign key attribute.
     *
     * @param  ChildItemOption $l ChildItemOption
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function addItemOption(ChildItemOption $l)
    {
        if ($this->collItemOptions === null) {
            $this->initItemOptions();
            $this->collItemOptionsPartial = true;
        }

        if (!$this->collItemOptions->contains($l)) {
            $this->doAddItemOption($l);

            if ($this->itemOptionsScheduledForDeletion and $this->itemOptionsScheduledForDeletion->contains($l)) {
                $this->itemOptionsScheduledForDeletion->remove($this->itemOptionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildItemOption $itemOption The ChildItemOption object to add.
     */
    protected function doAddItemOption(ChildItemOption $itemOption)
    {
        $this->collItemOptions[]= $itemOption;
        $itemOption->setItem($this);
    }

    /**
     * @param  ChildItemOption $itemOption The ChildItemOption object to remove.
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function removeItemOption(ChildItemOption $itemOption)
    {
        if ($this->getItemOptions()->contains($itemOption)) {
            $pos = $this->collItemOptions->search($itemOption);
            $this->collItemOptions->remove($pos);
            if (null === $this->itemOptionsScheduledForDeletion) {
                $this->itemOptionsScheduledForDeletion = clone $this->collItemOptions;
                $this->itemOptionsScheduledForDeletion->clear();
            }
            $this->itemOptionsScheduledForDeletion[]= clone $itemOption;
            $itemOption->setItem(null);
        }

        return $this;
    }

    /**
     * Clears out the collPurchasedItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPurchasedItems()
     */
    public function clearPurchasedItems()
    {
        $this->collPurchasedItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPurchasedItems collection loaded partially.
     */
    public function resetPartialPurchasedItems($v = true)
    {
        $this->collPurchasedItemsPartial = $v;
    }

    /**
     * Initializes the collPurchasedItems collection.
     *
     * By default this just sets the collPurchasedItems collection to an empty array (like clearcollPurchasedItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPurchasedItems($overrideExisting = true)
    {
        if (null !== $this->collPurchasedItems && !$overrideExisting) {
            return;
        }

        $collectionClassName = PurchasedItemTableMap::getTableMap()->getCollectionClassName();

        $this->collPurchasedItems = new $collectionClassName;
        $this->collPurchasedItems->setModel('\crwdogs\events\PurchasedItem');
    }

    /**
     * Gets an array of ChildPurchasedItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPurchasedItem[] List of ChildPurchasedItem objects
     * @throws PropelException
     */
    public function getPurchasedItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchasedItemsPartial && !$this->isNew();
        if (null === $this->collPurchasedItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPurchasedItems) {
                // return empty collection
                $this->initPurchasedItems();
            } else {
                $collPurchasedItems = ChildPurchasedItemQuery::create(null, $criteria)
                    ->filterByItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPurchasedItemsPartial && count($collPurchasedItems)) {
                        $this->initPurchasedItems(false);

                        foreach ($collPurchasedItems as $obj) {
                            if (false == $this->collPurchasedItems->contains($obj)) {
                                $this->collPurchasedItems->append($obj);
                            }
                        }

                        $this->collPurchasedItemsPartial = true;
                    }

                    return $collPurchasedItems;
                }

                if ($partial && $this->collPurchasedItems) {
                    foreach ($this->collPurchasedItems as $obj) {
                        if ($obj->isNew()) {
                            $collPurchasedItems[] = $obj;
                        }
                    }
                }

                $this->collPurchasedItems = $collPurchasedItems;
                $this->collPurchasedItemsPartial = false;
            }
        }

        return $this->collPurchasedItems;
    }

    /**
     * Sets a collection of ChildPurchasedItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $purchasedItems A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function setPurchasedItems(Collection $purchasedItems, ConnectionInterface $con = null)
    {
        /** @var ChildPurchasedItem[] $purchasedItemsToDelete */
        $purchasedItemsToDelete = $this->getPurchasedItems(new Criteria(), $con)->diff($purchasedItems);


        $this->purchasedItemsScheduledForDeletion = $purchasedItemsToDelete;

        foreach ($purchasedItemsToDelete as $purchasedItemRemoved) {
            $purchasedItemRemoved->setItem(null);
        }

        $this->collPurchasedItems = null;
        foreach ($purchasedItems as $purchasedItem) {
            $this->addPurchasedItem($purchasedItem);
        }

        $this->collPurchasedItems = $purchasedItems;
        $this->collPurchasedItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PurchasedItem objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PurchasedItem objects.
     * @throws PropelException
     */
    public function countPurchasedItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPurchasedItemsPartial && !$this->isNew();
        if (null === $this->collPurchasedItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPurchasedItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPurchasedItems());
            }

            $query = ChildPurchasedItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByItem($this)
                ->count($con);
        }

        return count($this->collPurchasedItems);
    }

    /**
     * Method called to associate a ChildPurchasedItem object to this object
     * through the ChildPurchasedItem foreign key attribute.
     *
     * @param  ChildPurchasedItem $l ChildPurchasedItem
     * @return $this|\crwdogs\events\Item The current object (for fluent API support)
     */
    public function addPurchasedItem(ChildPurchasedItem $l)
    {
        if ($this->collPurchasedItems === null) {
            $this->initPurchasedItems();
            $this->collPurchasedItemsPartial = true;
        }

        if (!$this->collPurchasedItems->contains($l)) {
            $this->doAddPurchasedItem($l);

            if ($this->purchasedItemsScheduledForDeletion and $this->purchasedItemsScheduledForDeletion->contains($l)) {
                $this->purchasedItemsScheduledForDeletion->remove($this->purchasedItemsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPurchasedItem $purchasedItem The ChildPurchasedItem object to add.
     */
    protected function doAddPurchasedItem(ChildPurchasedItem $purchasedItem)
    {
        $this->collPurchasedItems[]= $purchasedItem;
        $purchasedItem->setItem($this);
    }

    /**
     * @param  ChildPurchasedItem $purchasedItem The ChildPurchasedItem object to remove.
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function removePurchasedItem(ChildPurchasedItem $purchasedItem)
    {
        if ($this->getPurchasedItems()->contains($purchasedItem)) {
            $pos = $this->collPurchasedItems->search($purchasedItem);
            $this->collPurchasedItems->remove($pos);
            if (null === $this->purchasedItemsScheduledForDeletion) {
                $this->purchasedItemsScheduledForDeletion = clone $this->collPurchasedItems;
                $this->purchasedItemsScheduledForDeletion->clear();
            }
            $this->purchasedItemsScheduledForDeletion[]= clone $purchasedItem;
            $purchasedItem->setItem(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Item is new, it will return
     * an empty collection; or if this Item has previously
     * been saved, it will retrieve related PurchasedItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Item.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPurchasedItem[] List of ChildPurchasedItem objects
     */
    public function getPurchasedItemsJoinRegistration(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPurchasedItemQuery::create(null, $criteria);
        $query->joinWith('Registration', $joinBehavior);

        return $this->getPurchasedItems($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEvent) {
            $this->aEvent->removeItem($this);
        }
        $this->item_id = null;
        $this->event_id = null;
        $this->name = null;
        $this->qty_type = null;
        $this->min_qty = null;
        $this->max_qty = null;
        $this->event_qty = null;
        $this->image = null;
        $this->label = null;
        $this->base_cost = null;
        $this->multiple_variations = null;
        $this->qty_label = null;
        $this->cost_label = null;
        $this->sort = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collItemOptions) {
                foreach ($this->collItemOptions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPurchasedItems) {
                foreach ($this->collPurchasedItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collItemOptions = null;
        $this->collPurchasedItems = null;
        $this->aEvent = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
