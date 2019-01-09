<?php

namespace Base;

use \EarlyDiscount as ChildEarlyDiscount;
use \EarlyDiscountQuery as ChildEarlyDiscountQuery;
use \Event as ChildEvent;
use \EventQuery as ChildEventQuery;
use \Item as ChildItem;
use \ItemQuery as ChildItemQuery;
use \Location as ChildLocation;
use \LocationQuery as ChildLocationQuery;
use \Question as ChildQuestion;
use \QuestionQuery as ChildQuestionQuery;
use \Registration as ChildRegistration;
use \RegistrationQuery as ChildRegistrationQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\EarlyDiscountTableMap;
use Map\EventTableMap;
use Map\ItemTableMap;
use Map\QuestionTableMap;
use Map\RegistrationTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'event' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Event implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\EventTableMap';


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
     * The value for the event_id field.
     *
     * @var        int
     */
    protected $event_id;

    /**
     * The value for the location_id field.
     *
     * @var        int
     */
    protected $location_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the start_date field.
     *
     * @var        DateTime
     */
    protected $start_date;

    /**
     * The value for the end_date field.
     *
     * @var        DateTime
     */
    protected $end_date;

    /**
     * The value for the include_time field.
     *
     * @var        string
     */
    protected $include_time;

    /**
     * The value for the start_time field.
     *
     * @var        DateTime
     */
    protected $start_time;

    /**
     * The value for the end_time field.
     *
     * @var        DateTime
     */
    protected $end_time;

    /**
     * The value for the info field.
     *
     * @var        string
     */
    protected $info;

    /**
     * The value for the reg_start field.
     *
     * @var        DateTime
     */
    protected $reg_start;

    /**
     * The value for the reg_end field.
     *
     * @var        DateTime
     */
    protected $reg_end;

    /**
     * The value for the reg_cost field.
     *
     * @var        string
     */
    protected $reg_cost;

    /**
     * @var        ChildLocation
     */
    protected $aLocation;

    /**
     * @var        ObjectCollection|ChildEarlyDiscount[] Collection to store aggregation of ChildEarlyDiscount objects.
     */
    protected $collEarlyDiscounts;
    protected $collEarlyDiscountsPartial;

    /**
     * @var        ObjectCollection|ChildItem[] Collection to store aggregation of ChildItem objects.
     */
    protected $collItems;
    protected $collItemsPartial;

    /**
     * @var        ObjectCollection|ChildQuestion[] Collection to store aggregation of ChildQuestion objects.
     */
    protected $collQuestions;
    protected $collQuestionsPartial;

    /**
     * @var        ObjectCollection|ChildRegistration[] Collection to store aggregation of ChildRegistration objects.
     */
    protected $collRegistrations;
    protected $collRegistrationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEarlyDiscount[]
     */
    protected $earlyDiscountsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildItem[]
     */
    protected $itemsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildQuestion[]
     */
    protected $questionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRegistration[]
     */
    protected $registrationsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Event object.
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
     * Compares this with another <code>Event</code> instance.  If
     * <code>obj</code> is an instance of <code>Event</code>, delegates to
     * <code>equals(Event)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Event The current object, for fluid interface
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
     * Get the [event_id] column value.
     *
     * @return int
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * Get the [location_id] column value.
     *
     * @return int
     */
    public function getLocationId()
    {
        return $this->location_id;
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
     * Get the [optionally formatted] temporal [start_date] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartDate($format = NULL)
    {
        if ($format === null) {
            return $this->start_date;
        } else {
            return $this->start_date instanceof \DateTimeInterface ? $this->start_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [end_date] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndDate($format = NULL)
    {
        if ($format === null) {
            return $this->end_date;
        } else {
            return $this->end_date instanceof \DateTimeInterface ? $this->end_date->format($format) : null;
        }
    }

    /**
     * Get the [include_time] column value.
     *
     * @return string
     */
    public function getIncludeTime()
    {
        return $this->include_time;
    }

    /**
     * Get the [optionally formatted] temporal [start_time] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartTime($format = NULL)
    {
        if ($format === null) {
            return $this->start_time;
        } else {
            return $this->start_time instanceof \DateTimeInterface ? $this->start_time->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [end_time] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndTime($format = NULL)
    {
        if ($format === null) {
            return $this->end_time;
        } else {
            return $this->end_time instanceof \DateTimeInterface ? $this->end_time->format($format) : null;
        }
    }

    /**
     * Get the [info] column value.
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Get the [optionally formatted] temporal [reg_start] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getRegStart($format = NULL)
    {
        if ($format === null) {
            return $this->reg_start;
        } else {
            return $this->reg_start instanceof \DateTimeInterface ? $this->reg_start->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [reg_end] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getRegEnd($format = NULL)
    {
        if ($format === null) {
            return $this->reg_end;
        } else {
            return $this->reg_end instanceof \DateTimeInterface ? $this->reg_end->format($format) : null;
        }
    }

    /**
     * Get the [reg_cost] column value.
     *
     * @return string
     */
    public function getRegCost()
    {
        return $this->reg_cost;
    }

    /**
     * Set the value of [event_id] column.
     *
     * @param int $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setEventId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_id !== $v) {
            $this->event_id = $v;
            $this->modifiedColumns[EventTableMap::COL_EVENT_ID] = true;
        }

        return $this;
    } // setEventId()

    /**
     * Set the value of [location_id] column.
     *
     * @param int $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setLocationId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->location_id !== $v) {
            $this->location_id = $v;
            $this->modifiedColumns[EventTableMap::COL_LOCATION_ID] = true;
        }

        if ($this->aLocation !== null && $this->aLocation->getLocationId() !== $v) {
            $this->aLocation = null;
        }

        return $this;
    } // setLocationId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[EventTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Sets the value of [start_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_date !== null || $dt !== null) {
            if ($this->start_date === null || $dt === null || $dt->format("Y-m-d") !== $this->start_date->format("Y-m-d")) {
                $this->start_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_START_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setStartDate()

    /**
     * Sets the value of [end_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setEndDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_date !== null || $dt !== null) {
            if ($this->end_date === null || $dt === null || $dt->format("Y-m-d") !== $this->end_date->format("Y-m-d")) {
                $this->end_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_END_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEndDate()

    /**
     * Set the value of [include_time] column.
     *
     * @param string $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setIncludeTime($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->include_time !== $v) {
            $this->include_time = $v;
            $this->modifiedColumns[EventTableMap::COL_INCLUDE_TIME] = true;
        }

        return $this;
    } // setIncludeTime()

    /**
     * Sets the value of [start_time] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setStartTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_time !== null || $dt !== null) {
            if ($this->start_time === null || $dt === null || $dt->format("H:i:s.u") !== $this->start_time->format("H:i:s.u")) {
                $this->start_time = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_START_TIME] = true;
            }
        } // if either are not null

        return $this;
    } // setStartTime()

    /**
     * Sets the value of [end_time] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setEndTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_time !== null || $dt !== null) {
            if ($this->end_time === null || $dt === null || $dt->format("H:i:s.u") !== $this->end_time->format("H:i:s.u")) {
                $this->end_time = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_END_TIME] = true;
            }
        } // if either are not null

        return $this;
    } // setEndTime()

    /**
     * Set the value of [info] column.
     *
     * @param string $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setInfo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->info !== $v) {
            $this->info = $v;
            $this->modifiedColumns[EventTableMap::COL_INFO] = true;
        }

        return $this;
    } // setInfo()

    /**
     * Sets the value of [reg_start] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setRegStart($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->reg_start !== null || $dt !== null) {
            if ($this->reg_start === null || $dt === null || $dt->format("Y-m-d") !== $this->reg_start->format("Y-m-d")) {
                $this->reg_start = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_REG_START] = true;
            }
        } // if either are not null

        return $this;
    } // setRegStart()

    /**
     * Sets the value of [reg_end] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setRegEnd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->reg_end !== null || $dt !== null) {
            if ($this->reg_end === null || $dt === null || $dt->format("Y-m-d") !== $this->reg_end->format("Y-m-d")) {
                $this->reg_end = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventTableMap::COL_REG_END] = true;
            }
        } // if either are not null

        return $this;
    } // setRegEnd()

    /**
     * Set the value of [reg_cost] column.
     *
     * @param string $v new value
     * @return $this|\Event The current object (for fluent API support)
     */
    public function setRegCost($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->reg_cost !== $v) {
            $this->reg_cost = $v;
            $this->modifiedColumns[EventTableMap::COL_REG_COST] = true;
        }

        return $this;
    } // setRegCost()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EventTableMap::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EventTableMap::translateFieldName('LocationId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->location_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EventTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EventTableMap::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->start_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EventTableMap::translateFieldName('EndDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->end_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EventTableMap::translateFieldName('IncludeTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->include_time = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EventTableMap::translateFieldName('StartTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->start_time = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EventTableMap::translateFieldName('EndTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->end_time = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EventTableMap::translateFieldName('Info', TableMap::TYPE_PHPNAME, $indexType)];
            $this->info = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : EventTableMap::translateFieldName('RegStart', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->reg_start = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : EventTableMap::translateFieldName('RegEnd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->reg_end = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : EventTableMap::translateFieldName('RegCost', TableMap::TYPE_PHPNAME, $indexType)];
            $this->reg_cost = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = EventTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Event'), 0, $e);
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
        if ($this->aLocation !== null && $this->location_id !== $this->aLocation->getLocationId()) {
            $this->aLocation = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(EventTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aLocation = null;
            $this->collEarlyDiscounts = null;

            $this->collItems = null;

            $this->collQuestions = null;

            $this->collRegistrations = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Event::setDeleted()
     * @see Event::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
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
                EventTableMap::addInstanceToPool($this);
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

            if ($this->aLocation !== null) {
                if ($this->aLocation->isModified() || $this->aLocation->isNew()) {
                    $affectedRows += $this->aLocation->save($con);
                }
                $this->setLocation($this->aLocation);
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

            if ($this->earlyDiscountsScheduledForDeletion !== null) {
                if (!$this->earlyDiscountsScheduledForDeletion->isEmpty()) {
                    \EarlyDiscountQuery::create()
                        ->filterByPrimaryKeys($this->earlyDiscountsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->earlyDiscountsScheduledForDeletion = null;
                }
            }

            if ($this->collEarlyDiscounts !== null) {
                foreach ($this->collEarlyDiscounts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->itemsScheduledForDeletion !== null) {
                if (!$this->itemsScheduledForDeletion->isEmpty()) {
                    \ItemQuery::create()
                        ->filterByPrimaryKeys($this->itemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->itemsScheduledForDeletion = null;
                }
            }

            if ($this->collItems !== null) {
                foreach ($this->collItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->questionsScheduledForDeletion !== null) {
                if (!$this->questionsScheduledForDeletion->isEmpty()) {
                    \QuestionQuery::create()
                        ->filterByPrimaryKeys($this->questionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->questionsScheduledForDeletion = null;
                }
            }

            if ($this->collQuestions !== null) {
                foreach ($this->collQuestions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->registrationsScheduledForDeletion !== null) {
                if (!$this->registrationsScheduledForDeletion->isEmpty()) {
                    \RegistrationQuery::create()
                        ->filterByPrimaryKeys($this->registrationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->registrationsScheduledForDeletion = null;
                }
            }

            if ($this->collRegistrations !== null) {
                foreach ($this->collRegistrations as $referrerFK) {
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

        $this->modifiedColumns[EventTableMap::COL_EVENT_ID] = true;
        if (null !== $this->event_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . EventTableMap::COL_EVENT_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventTableMap::COL_EVENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'event_id';
        }
        if ($this->isColumnModified(EventTableMap::COL_LOCATION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'location_id';
        }
        if ($this->isColumnModified(EventTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(EventTableMap::COL_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'start_date';
        }
        if ($this->isColumnModified(EventTableMap::COL_END_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'end_date';
        }
        if ($this->isColumnModified(EventTableMap::COL_INCLUDE_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'include_time';
        }
        if ($this->isColumnModified(EventTableMap::COL_START_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'start_time';
        }
        if ($this->isColumnModified(EventTableMap::COL_END_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'end_time';
        }
        if ($this->isColumnModified(EventTableMap::COL_INFO)) {
            $modifiedColumns[':p' . $index++]  = 'info';
        }
        if ($this->isColumnModified(EventTableMap::COL_REG_START)) {
            $modifiedColumns[':p' . $index++]  = 'reg_start';
        }
        if ($this->isColumnModified(EventTableMap::COL_REG_END)) {
            $modifiedColumns[':p' . $index++]  = 'reg_end';
        }
        if ($this->isColumnModified(EventTableMap::COL_REG_COST)) {
            $modifiedColumns[':p' . $index++]  = 'reg_cost';
        }

        $sql = sprintf(
            'INSERT INTO event (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'event_id':
                        $stmt->bindValue($identifier, $this->event_id, PDO::PARAM_INT);
                        break;
                    case 'location_id':
                        $stmt->bindValue($identifier, $this->location_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'start_date':
                        $stmt->bindValue($identifier, $this->start_date ? $this->start_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'end_date':
                        $stmt->bindValue($identifier, $this->end_date ? $this->end_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'include_time':
                        $stmt->bindValue($identifier, $this->include_time, PDO::PARAM_STR);
                        break;
                    case 'start_time':
                        $stmt->bindValue($identifier, $this->start_time ? $this->start_time->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'end_time':
                        $stmt->bindValue($identifier, $this->end_time ? $this->end_time->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'info':
                        $stmt->bindValue($identifier, $this->info, PDO::PARAM_STR);
                        break;
                    case 'reg_start':
                        $stmt->bindValue($identifier, $this->reg_start ? $this->reg_start->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'reg_end':
                        $stmt->bindValue($identifier, $this->reg_end ? $this->reg_end->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'reg_cost':
                        $stmt->bindValue($identifier, $this->reg_cost, PDO::PARAM_STR);
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
        $this->setEventId($pk);

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
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getEventId();
                break;
            case 1:
                return $this->getLocationId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getStartDate();
                break;
            case 4:
                return $this->getEndDate();
                break;
            case 5:
                return $this->getIncludeTime();
                break;
            case 6:
                return $this->getStartTime();
                break;
            case 7:
                return $this->getEndTime();
                break;
            case 8:
                return $this->getInfo();
                break;
            case 9:
                return $this->getRegStart();
                break;
            case 10:
                return $this->getRegEnd();
                break;
            case 11:
                return $this->getRegCost();
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

        if (isset($alreadyDumpedObjects['Event'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Event'][$this->hashCode()] = true;
        $keys = EventTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getEventId(),
            $keys[1] => $this->getLocationId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getStartDate(),
            $keys[4] => $this->getEndDate(),
            $keys[5] => $this->getIncludeTime(),
            $keys[6] => $this->getStartTime(),
            $keys[7] => $this->getEndTime(),
            $keys[8] => $this->getInfo(),
            $keys[9] => $this->getRegStart(),
            $keys[10] => $this->getRegEnd(),
            $keys[11] => $this->getRegCost(),
        );
        if ($result[$keys[3]] instanceof \DateTimeInterface) {
            $result[$keys[3]] = $result[$keys[3]]->format('c');
        }

        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('c');
        }

        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }

        if ($result[$keys[10]] instanceof \DateTimeInterface) {
            $result[$keys[10]] = $result[$keys[10]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aLocation) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'location';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'location';
                        break;
                    default:
                        $key = 'Location';
                }

                $result[$key] = $this->aLocation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collEarlyDiscounts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'earlyDiscounts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'early_discounts';
                        break;
                    default:
                        $key = 'EarlyDiscounts';
                }

                $result[$key] = $this->collEarlyDiscounts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'items';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'items';
                        break;
                    default:
                        $key = 'Items';
                }

                $result[$key] = $this->collItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuestions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'questions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'questions';
                        break;
                    default:
                        $key = 'Questions';
                }

                $result[$key] = $this->collQuestions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRegistrations) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'registrations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'registrations';
                        break;
                    default:
                        $key = 'Registrations';
                }

                $result[$key] = $this->collRegistrations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Event
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Event
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setEventId($value);
                break;
            case 1:
                $this->setLocationId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setStartDate($value);
                break;
            case 4:
                $this->setEndDate($value);
                break;
            case 5:
                $this->setIncludeTime($value);
                break;
            case 6:
                $this->setStartTime($value);
                break;
            case 7:
                $this->setEndTime($value);
                break;
            case 8:
                $this->setInfo($value);
                break;
            case 9:
                $this->setRegStart($value);
                break;
            case 10:
                $this->setRegEnd($value);
                break;
            case 11:
                $this->setRegCost($value);
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
        $keys = EventTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setEventId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLocationId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setStartDate($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEndDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setIncludeTime($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setStartTime($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setEndTime($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setInfo($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setRegStart($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setRegEnd($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setRegCost($arr[$keys[11]]);
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
     * @return $this|\Event The current object, for fluid interface
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
        $criteria = new Criteria(EventTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventTableMap::COL_EVENT_ID)) {
            $criteria->add(EventTableMap::COL_EVENT_ID, $this->event_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_LOCATION_ID)) {
            $criteria->add(EventTableMap::COL_LOCATION_ID, $this->location_id);
        }
        if ($this->isColumnModified(EventTableMap::COL_NAME)) {
            $criteria->add(EventTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(EventTableMap::COL_START_DATE)) {
            $criteria->add(EventTableMap::COL_START_DATE, $this->start_date);
        }
        if ($this->isColumnModified(EventTableMap::COL_END_DATE)) {
            $criteria->add(EventTableMap::COL_END_DATE, $this->end_date);
        }
        if ($this->isColumnModified(EventTableMap::COL_INCLUDE_TIME)) {
            $criteria->add(EventTableMap::COL_INCLUDE_TIME, $this->include_time);
        }
        if ($this->isColumnModified(EventTableMap::COL_START_TIME)) {
            $criteria->add(EventTableMap::COL_START_TIME, $this->start_time);
        }
        if ($this->isColumnModified(EventTableMap::COL_END_TIME)) {
            $criteria->add(EventTableMap::COL_END_TIME, $this->end_time);
        }
        if ($this->isColumnModified(EventTableMap::COL_INFO)) {
            $criteria->add(EventTableMap::COL_INFO, $this->info);
        }
        if ($this->isColumnModified(EventTableMap::COL_REG_START)) {
            $criteria->add(EventTableMap::COL_REG_START, $this->reg_start);
        }
        if ($this->isColumnModified(EventTableMap::COL_REG_END)) {
            $criteria->add(EventTableMap::COL_REG_END, $this->reg_end);
        }
        if ($this->isColumnModified(EventTableMap::COL_REG_COST)) {
            $criteria->add(EventTableMap::COL_REG_COST, $this->reg_cost);
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
        $criteria = ChildEventQuery::create();
        $criteria->add(EventTableMap::COL_EVENT_ID, $this->event_id);

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
        $validPk = null !== $this->getEventId();

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
        return $this->getEventId();
    }

    /**
     * Generic method to set the primary key (event_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setEventId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getEventId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Event (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLocationId($this->getLocationId());
        $copyObj->setName($this->getName());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setEndDate($this->getEndDate());
        $copyObj->setIncludeTime($this->getIncludeTime());
        $copyObj->setStartTime($this->getStartTime());
        $copyObj->setEndTime($this->getEndTime());
        $copyObj->setInfo($this->getInfo());
        $copyObj->setRegStart($this->getRegStart());
        $copyObj->setRegEnd($this->getRegEnd());
        $copyObj->setRegCost($this->getRegCost());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getEarlyDiscounts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEarlyDiscount($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addItem($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuestions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuestion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRegistrations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRegistration($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setEventId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Event Clone of current object.
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
     * Declares an association between this object and a ChildLocation object.
     *
     * @param  ChildLocation $v
     * @return $this|\Event The current object (for fluent API support)
     * @throws PropelException
     */
    public function setLocation(ChildLocation $v = null)
    {
        if ($v === null) {
            $this->setLocationId(NULL);
        } else {
            $this->setLocationId($v->getLocationId());
        }

        $this->aLocation = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildLocation object, it will not be re-added.
        if ($v !== null) {
            $v->addEvent($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildLocation object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildLocation The associated ChildLocation object.
     * @throws PropelException
     */
    public function getLocation(ConnectionInterface $con = null)
    {
        if ($this->aLocation === null && ($this->location_id != 0)) {
            $this->aLocation = ChildLocationQuery::create()->findPk($this->location_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aLocation->addEvents($this);
             */
        }

        return $this->aLocation;
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
        if ('EarlyDiscount' == $relationName) {
            $this->initEarlyDiscounts();
            return;
        }
        if ('Item' == $relationName) {
            $this->initItems();
            return;
        }
        if ('Question' == $relationName) {
            $this->initQuestions();
            return;
        }
        if ('Registration' == $relationName) {
            $this->initRegistrations();
            return;
        }
    }

    /**
     * Clears out the collEarlyDiscounts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEarlyDiscounts()
     */
    public function clearEarlyDiscounts()
    {
        $this->collEarlyDiscounts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEarlyDiscounts collection loaded partially.
     */
    public function resetPartialEarlyDiscounts($v = true)
    {
        $this->collEarlyDiscountsPartial = $v;
    }

    /**
     * Initializes the collEarlyDiscounts collection.
     *
     * By default this just sets the collEarlyDiscounts collection to an empty array (like clearcollEarlyDiscounts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEarlyDiscounts($overrideExisting = true)
    {
        if (null !== $this->collEarlyDiscounts && !$overrideExisting) {
            return;
        }

        $collectionClassName = EarlyDiscountTableMap::getTableMap()->getCollectionClassName();

        $this->collEarlyDiscounts = new $collectionClassName;
        $this->collEarlyDiscounts->setModel('\EarlyDiscount');
    }

    /**
     * Gets an array of ChildEarlyDiscount objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvent is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEarlyDiscount[] List of ChildEarlyDiscount objects
     * @throws PropelException
     */
    public function getEarlyDiscounts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEarlyDiscountsPartial && !$this->isNew();
        if (null === $this->collEarlyDiscounts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEarlyDiscounts) {
                // return empty collection
                $this->initEarlyDiscounts();
            } else {
                $collEarlyDiscounts = ChildEarlyDiscountQuery::create(null, $criteria)
                    ->filterByEvent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEarlyDiscountsPartial && count($collEarlyDiscounts)) {
                        $this->initEarlyDiscounts(false);

                        foreach ($collEarlyDiscounts as $obj) {
                            if (false == $this->collEarlyDiscounts->contains($obj)) {
                                $this->collEarlyDiscounts->append($obj);
                            }
                        }

                        $this->collEarlyDiscountsPartial = true;
                    }

                    return $collEarlyDiscounts;
                }

                if ($partial && $this->collEarlyDiscounts) {
                    foreach ($this->collEarlyDiscounts as $obj) {
                        if ($obj->isNew()) {
                            $collEarlyDiscounts[] = $obj;
                        }
                    }
                }

                $this->collEarlyDiscounts = $collEarlyDiscounts;
                $this->collEarlyDiscountsPartial = false;
            }
        }

        return $this->collEarlyDiscounts;
    }

    /**
     * Sets a collection of ChildEarlyDiscount objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $earlyDiscounts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function setEarlyDiscounts(Collection $earlyDiscounts, ConnectionInterface $con = null)
    {
        /** @var ChildEarlyDiscount[] $earlyDiscountsToDelete */
        $earlyDiscountsToDelete = $this->getEarlyDiscounts(new Criteria(), $con)->diff($earlyDiscounts);


        $this->earlyDiscountsScheduledForDeletion = $earlyDiscountsToDelete;

        foreach ($earlyDiscountsToDelete as $earlyDiscountRemoved) {
            $earlyDiscountRemoved->setEvent(null);
        }

        $this->collEarlyDiscounts = null;
        foreach ($earlyDiscounts as $earlyDiscount) {
            $this->addEarlyDiscount($earlyDiscount);
        }

        $this->collEarlyDiscounts = $earlyDiscounts;
        $this->collEarlyDiscountsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related EarlyDiscount objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related EarlyDiscount objects.
     * @throws PropelException
     */
    public function countEarlyDiscounts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEarlyDiscountsPartial && !$this->isNew();
        if (null === $this->collEarlyDiscounts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEarlyDiscounts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEarlyDiscounts());
            }

            $query = ChildEarlyDiscountQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collEarlyDiscounts);
    }

    /**
     * Method called to associate a ChildEarlyDiscount object to this object
     * through the ChildEarlyDiscount foreign key attribute.
     *
     * @param  ChildEarlyDiscount $l ChildEarlyDiscount
     * @return $this|\Event The current object (for fluent API support)
     */
    public function addEarlyDiscount(ChildEarlyDiscount $l)
    {
        if ($this->collEarlyDiscounts === null) {
            $this->initEarlyDiscounts();
            $this->collEarlyDiscountsPartial = true;
        }

        if (!$this->collEarlyDiscounts->contains($l)) {
            $this->doAddEarlyDiscount($l);

            if ($this->earlyDiscountsScheduledForDeletion and $this->earlyDiscountsScheduledForDeletion->contains($l)) {
                $this->earlyDiscountsScheduledForDeletion->remove($this->earlyDiscountsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEarlyDiscount $earlyDiscount The ChildEarlyDiscount object to add.
     */
    protected function doAddEarlyDiscount(ChildEarlyDiscount $earlyDiscount)
    {
        $this->collEarlyDiscounts[]= $earlyDiscount;
        $earlyDiscount->setEvent($this);
    }

    /**
     * @param  ChildEarlyDiscount $earlyDiscount The ChildEarlyDiscount object to remove.
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function removeEarlyDiscount(ChildEarlyDiscount $earlyDiscount)
    {
        if ($this->getEarlyDiscounts()->contains($earlyDiscount)) {
            $pos = $this->collEarlyDiscounts->search($earlyDiscount);
            $this->collEarlyDiscounts->remove($pos);
            if (null === $this->earlyDiscountsScheduledForDeletion) {
                $this->earlyDiscountsScheduledForDeletion = clone $this->collEarlyDiscounts;
                $this->earlyDiscountsScheduledForDeletion->clear();
            }
            $this->earlyDiscountsScheduledForDeletion[]= clone $earlyDiscount;
            $earlyDiscount->setEvent(null);
        }

        return $this;
    }

    /**
     * Clears out the collItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addItems()
     */
    public function clearItems()
    {
        $this->collItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collItems collection loaded partially.
     */
    public function resetPartialItems($v = true)
    {
        $this->collItemsPartial = $v;
    }

    /**
     * Initializes the collItems collection.
     *
     * By default this just sets the collItems collection to an empty array (like clearcollItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initItems($overrideExisting = true)
    {
        if (null !== $this->collItems && !$overrideExisting) {
            return;
        }

        $collectionClassName = ItemTableMap::getTableMap()->getCollectionClassName();

        $this->collItems = new $collectionClassName;
        $this->collItems->setModel('\Item');
    }

    /**
     * Gets an array of ChildItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvent is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildItem[] List of ChildItem objects
     * @throws PropelException
     */
    public function getItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                // return empty collection
                $this->initItems();
            } else {
                $collItems = ChildItemQuery::create(null, $criteria)
                    ->filterByEvent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collItemsPartial && count($collItems)) {
                        $this->initItems(false);

                        foreach ($collItems as $obj) {
                            if (false == $this->collItems->contains($obj)) {
                                $this->collItems->append($obj);
                            }
                        }

                        $this->collItemsPartial = true;
                    }

                    return $collItems;
                }

                if ($partial && $this->collItems) {
                    foreach ($this->collItems as $obj) {
                        if ($obj->isNew()) {
                            $collItems[] = $obj;
                        }
                    }
                }

                $this->collItems = $collItems;
                $this->collItemsPartial = false;
            }
        }

        return $this->collItems;
    }

    /**
     * Sets a collection of ChildItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $items A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function setItems(Collection $items, ConnectionInterface $con = null)
    {
        /** @var ChildItem[] $itemsToDelete */
        $itemsToDelete = $this->getItems(new Criteria(), $con)->diff($items);


        $this->itemsScheduledForDeletion = $itemsToDelete;

        foreach ($itemsToDelete as $itemRemoved) {
            $itemRemoved->setEvent(null);
        }

        $this->collItems = null;
        foreach ($items as $item) {
            $this->addItem($item);
        }

        $this->collItems = $items;
        $this->collItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Item objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Item objects.
     * @throws PropelException
     */
    public function countItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collItemsPartial && !$this->isNew();
        if (null === $this->collItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getItems());
            }

            $query = ChildItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collItems);
    }

    /**
     * Method called to associate a ChildItem object to this object
     * through the ChildItem foreign key attribute.
     *
     * @param  ChildItem $l ChildItem
     * @return $this|\Event The current object (for fluent API support)
     */
    public function addItem(ChildItem $l)
    {
        if ($this->collItems === null) {
            $this->initItems();
            $this->collItemsPartial = true;
        }

        if (!$this->collItems->contains($l)) {
            $this->doAddItem($l);

            if ($this->itemsScheduledForDeletion and $this->itemsScheduledForDeletion->contains($l)) {
                $this->itemsScheduledForDeletion->remove($this->itemsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildItem $item The ChildItem object to add.
     */
    protected function doAddItem(ChildItem $item)
    {
        $this->collItems[]= $item;
        $item->setEvent($this);
    }

    /**
     * @param  ChildItem $item The ChildItem object to remove.
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function removeItem(ChildItem $item)
    {
        if ($this->getItems()->contains($item)) {
            $pos = $this->collItems->search($item);
            $this->collItems->remove($pos);
            if (null === $this->itemsScheduledForDeletion) {
                $this->itemsScheduledForDeletion = clone $this->collItems;
                $this->itemsScheduledForDeletion->clear();
            }
            $this->itemsScheduledForDeletion[]= clone $item;
            $item->setEvent(null);
        }

        return $this;
    }

    /**
     * Clears out the collQuestions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuestions()
     */
    public function clearQuestions()
    {
        $this->collQuestions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collQuestions collection loaded partially.
     */
    public function resetPartialQuestions($v = true)
    {
        $this->collQuestionsPartial = $v;
    }

    /**
     * Initializes the collQuestions collection.
     *
     * By default this just sets the collQuestions collection to an empty array (like clearcollQuestions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuestions($overrideExisting = true)
    {
        if (null !== $this->collQuestions && !$overrideExisting) {
            return;
        }

        $collectionClassName = QuestionTableMap::getTableMap()->getCollectionClassName();

        $this->collQuestions = new $collectionClassName;
        $this->collQuestions->setModel('\Question');
    }

    /**
     * Gets an array of ChildQuestion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvent is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildQuestion[] List of ChildQuestion objects
     * @throws PropelException
     */
    public function getQuestions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionsPartial && !$this->isNew();
        if (null === $this->collQuestions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuestions) {
                // return empty collection
                $this->initQuestions();
            } else {
                $collQuestions = ChildQuestionQuery::create(null, $criteria)
                    ->filterByEvent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collQuestionsPartial && count($collQuestions)) {
                        $this->initQuestions(false);

                        foreach ($collQuestions as $obj) {
                            if (false == $this->collQuestions->contains($obj)) {
                                $this->collQuestions->append($obj);
                            }
                        }

                        $this->collQuestionsPartial = true;
                    }

                    return $collQuestions;
                }

                if ($partial && $this->collQuestions) {
                    foreach ($this->collQuestions as $obj) {
                        if ($obj->isNew()) {
                            $collQuestions[] = $obj;
                        }
                    }
                }

                $this->collQuestions = $collQuestions;
                $this->collQuestionsPartial = false;
            }
        }

        return $this->collQuestions;
    }

    /**
     * Sets a collection of ChildQuestion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $questions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function setQuestions(Collection $questions, ConnectionInterface $con = null)
    {
        /** @var ChildQuestion[] $questionsToDelete */
        $questionsToDelete = $this->getQuestions(new Criteria(), $con)->diff($questions);


        $this->questionsScheduledForDeletion = $questionsToDelete;

        foreach ($questionsToDelete as $questionRemoved) {
            $questionRemoved->setEvent(null);
        }

        $this->collQuestions = null;
        foreach ($questions as $question) {
            $this->addQuestion($question);
        }

        $this->collQuestions = $questions;
        $this->collQuestionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Question objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Question objects.
     * @throws PropelException
     */
    public function countQuestions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionsPartial && !$this->isNew();
        if (null === $this->collQuestions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuestions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getQuestions());
            }

            $query = ChildQuestionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collQuestions);
    }

    /**
     * Method called to associate a ChildQuestion object to this object
     * through the ChildQuestion foreign key attribute.
     *
     * @param  ChildQuestion $l ChildQuestion
     * @return $this|\Event The current object (for fluent API support)
     */
    public function addQuestion(ChildQuestion $l)
    {
        if ($this->collQuestions === null) {
            $this->initQuestions();
            $this->collQuestionsPartial = true;
        }

        if (!$this->collQuestions->contains($l)) {
            $this->doAddQuestion($l);

            if ($this->questionsScheduledForDeletion and $this->questionsScheduledForDeletion->contains($l)) {
                $this->questionsScheduledForDeletion->remove($this->questionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildQuestion $question The ChildQuestion object to add.
     */
    protected function doAddQuestion(ChildQuestion $question)
    {
        $this->collQuestions[]= $question;
        $question->setEvent($this);
    }

    /**
     * @param  ChildQuestion $question The ChildQuestion object to remove.
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function removeQuestion(ChildQuestion $question)
    {
        if ($this->getQuestions()->contains($question)) {
            $pos = $this->collQuestions->search($question);
            $this->collQuestions->remove($pos);
            if (null === $this->questionsScheduledForDeletion) {
                $this->questionsScheduledForDeletion = clone $this->collQuestions;
                $this->questionsScheduledForDeletion->clear();
            }
            $this->questionsScheduledForDeletion[]= clone $question;
            $question->setEvent(null);
        }

        return $this;
    }

    /**
     * Clears out the collRegistrations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRegistrations()
     */
    public function clearRegistrations()
    {
        $this->collRegistrations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRegistrations collection loaded partially.
     */
    public function resetPartialRegistrations($v = true)
    {
        $this->collRegistrationsPartial = $v;
    }

    /**
     * Initializes the collRegistrations collection.
     *
     * By default this just sets the collRegistrations collection to an empty array (like clearcollRegistrations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRegistrations($overrideExisting = true)
    {
        if (null !== $this->collRegistrations && !$overrideExisting) {
            return;
        }

        $collectionClassName = RegistrationTableMap::getTableMap()->getCollectionClassName();

        $this->collRegistrations = new $collectionClassName;
        $this->collRegistrations->setModel('\Registration');
    }

    /**
     * Gets an array of ChildRegistration objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvent is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRegistration[] List of ChildRegistration objects
     * @throws PropelException
     */
    public function getRegistrations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRegistrationsPartial && !$this->isNew();
        if (null === $this->collRegistrations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRegistrations) {
                // return empty collection
                $this->initRegistrations();
            } else {
                $collRegistrations = ChildRegistrationQuery::create(null, $criteria)
                    ->filterByEvent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRegistrationsPartial && count($collRegistrations)) {
                        $this->initRegistrations(false);

                        foreach ($collRegistrations as $obj) {
                            if (false == $this->collRegistrations->contains($obj)) {
                                $this->collRegistrations->append($obj);
                            }
                        }

                        $this->collRegistrationsPartial = true;
                    }

                    return $collRegistrations;
                }

                if ($partial && $this->collRegistrations) {
                    foreach ($this->collRegistrations as $obj) {
                        if ($obj->isNew()) {
                            $collRegistrations[] = $obj;
                        }
                    }
                }

                $this->collRegistrations = $collRegistrations;
                $this->collRegistrationsPartial = false;
            }
        }

        return $this->collRegistrations;
    }

    /**
     * Sets a collection of ChildRegistration objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $registrations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function setRegistrations(Collection $registrations, ConnectionInterface $con = null)
    {
        /** @var ChildRegistration[] $registrationsToDelete */
        $registrationsToDelete = $this->getRegistrations(new Criteria(), $con)->diff($registrations);


        $this->registrationsScheduledForDeletion = $registrationsToDelete;

        foreach ($registrationsToDelete as $registrationRemoved) {
            $registrationRemoved->setEvent(null);
        }

        $this->collRegistrations = null;
        foreach ($registrations as $registration) {
            $this->addRegistration($registration);
        }

        $this->collRegistrations = $registrations;
        $this->collRegistrationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Registration objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Registration objects.
     * @throws PropelException
     */
    public function countRegistrations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRegistrationsPartial && !$this->isNew();
        if (null === $this->collRegistrations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRegistrations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRegistrations());
            }

            $query = ChildRegistrationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvent($this)
                ->count($con);
        }

        return count($this->collRegistrations);
    }

    /**
     * Method called to associate a ChildRegistration object to this object
     * through the ChildRegistration foreign key attribute.
     *
     * @param  ChildRegistration $l ChildRegistration
     * @return $this|\Event The current object (for fluent API support)
     */
    public function addRegistration(ChildRegistration $l)
    {
        if ($this->collRegistrations === null) {
            $this->initRegistrations();
            $this->collRegistrationsPartial = true;
        }

        if (!$this->collRegistrations->contains($l)) {
            $this->doAddRegistration($l);

            if ($this->registrationsScheduledForDeletion and $this->registrationsScheduledForDeletion->contains($l)) {
                $this->registrationsScheduledForDeletion->remove($this->registrationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRegistration $registration The ChildRegistration object to add.
     */
    protected function doAddRegistration(ChildRegistration $registration)
    {
        $this->collRegistrations[]= $registration;
        $registration->setEvent($this);
    }

    /**
     * @param  ChildRegistration $registration The ChildRegistration object to remove.
     * @return $this|ChildEvent The current object (for fluent API support)
     */
    public function removeRegistration(ChildRegistration $registration)
    {
        if ($this->getRegistrations()->contains($registration)) {
            $pos = $this->collRegistrations->search($registration);
            $this->collRegistrations->remove($pos);
            if (null === $this->registrationsScheduledForDeletion) {
                $this->registrationsScheduledForDeletion = clone $this->collRegistrations;
                $this->registrationsScheduledForDeletion->clear();
            }
            $this->registrationsScheduledForDeletion[]= clone $registration;
            $registration->setEvent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Event is new, it will return
     * an empty collection; or if this Event has previously
     * been saved, it will retrieve related Registrations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Event.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRegistration[] List of ChildRegistration objects
     */
    public function getRegistrationsJoinUsers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRegistrationQuery::create(null, $criteria);
        $query->joinWith('Users', $joinBehavior);

        return $this->getRegistrations($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aLocation) {
            $this->aLocation->removeEvent($this);
        }
        $this->event_id = null;
        $this->location_id = null;
        $this->name = null;
        $this->start_date = null;
        $this->end_date = null;
        $this->include_time = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->info = null;
        $this->reg_start = null;
        $this->reg_end = null;
        $this->reg_cost = null;
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
            if ($this->collEarlyDiscounts) {
                foreach ($this->collEarlyDiscounts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collItems) {
                foreach ($this->collItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuestions) {
                foreach ($this->collQuestions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRegistrations) {
                foreach ($this->collRegistrations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collEarlyDiscounts = null;
        $this->collItems = null;
        $this->collQuestions = null;
        $this->collRegistrations = null;
        $this->aLocation = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EventTableMap::DEFAULT_STRING_FORMAT);
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
