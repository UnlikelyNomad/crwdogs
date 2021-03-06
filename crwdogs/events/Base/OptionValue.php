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
use crwdogs\events\ItemOption as ChildItemOption;
use crwdogs\events\ItemOptionQuery as ChildItemOptionQuery;
use crwdogs\events\OptionValue as ChildOptionValue;
use crwdogs\events\OptionValueQuery as ChildOptionValueQuery;
use crwdogs\events\RegistrationOption as ChildRegistrationOption;
use crwdogs\events\RegistrationOptionQuery as ChildRegistrationOptionQuery;
use crwdogs\events\Map\OptionValueTableMap;
use crwdogs\events\Map\RegistrationOptionTableMap;

/**
 * Base class that represents a row from the 'option_value' table.
 *
 *
 *
 * @package    propel.generator.crwdogs.events.Base
 */
abstract class OptionValue implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\crwdogs\\events\\Map\\OptionValueTableMap';


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
     * The value for the value_id field.
     *
     * @var        int
     */
    protected $value_id;

    /**
     * The value for the option_id field.
     *
     * @var        int
     */
    protected $option_id;

    /**
     * The value for the cost_adj field.
     *
     * @var        string
     */
    protected $cost_adj;

    /**
     * The value for the label field.
     *
     * @var        string
     */
    protected $label;

    /**
     * The value for the value field.
     *
     * @var        string
     */
    protected $value;

    /**
     * @var        ChildItemOption
     */
    protected $aItemOption;

    /**
     * @var        ObjectCollection|ChildRegistrationOption[] Collection to store aggregation of ChildRegistrationOption objects.
     */
    protected $collRegistrationOptions;
    protected $collRegistrationOptionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRegistrationOption[]
     */
    protected $registrationOptionsScheduledForDeletion = null;

    /**
     * Initializes internal state of crwdogs\events\Base\OptionValue object.
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
     * Compares this with another <code>OptionValue</code> instance.  If
     * <code>obj</code> is an instance of <code>OptionValue</code>, delegates to
     * <code>equals(OptionValue)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|OptionValue The current object, for fluid interface
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
     * Get the [value_id] column value.
     *
     * @return int
     */
    public function getValueId()
    {
        return $this->value_id;
    }

    /**
     * Get the [option_id] column value.
     *
     * @return int
     */
    public function getOptionId()
    {
        return $this->option_id;
    }

    /**
     * Get the [cost_adj] column value.
     *
     * @return string
     */
    public function getCostAdj()
    {
        return $this->cost_adj;
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
     * Get the [value] column value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of [value_id] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\OptionValue The current object (for fluent API support)
     */
    public function setValueId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->value_id !== $v) {
            $this->value_id = $v;
            $this->modifiedColumns[OptionValueTableMap::COL_VALUE_ID] = true;
        }

        return $this;
    } // setValueId()

    /**
     * Set the value of [option_id] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\OptionValue The current object (for fluent API support)
     */
    public function setOptionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->option_id !== $v) {
            $this->option_id = $v;
            $this->modifiedColumns[OptionValueTableMap::COL_OPTION_ID] = true;
        }

        if ($this->aItemOption !== null && $this->aItemOption->getOptionId() !== $v) {
            $this->aItemOption = null;
        }

        return $this;
    } // setOptionId()

    /**
     * Set the value of [cost_adj] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\OptionValue The current object (for fluent API support)
     */
    public function setCostAdj($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cost_adj !== $v) {
            $this->cost_adj = $v;
            $this->modifiedColumns[OptionValueTableMap::COL_COST_ADJ] = true;
        }

        return $this;
    } // setCostAdj()

    /**
     * Set the value of [label] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\OptionValue The current object (for fluent API support)
     */
    public function setLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label !== $v) {
            $this->label = $v;
            $this->modifiedColumns[OptionValueTableMap::COL_LABEL] = true;
        }

        return $this;
    } // setLabel()

    /**
     * Set the value of [value] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\OptionValue The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[OptionValueTableMap::COL_VALUE] = true;
        }

        return $this;
    } // setValue()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : OptionValueTableMap::translateFieldName('ValueId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->value_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : OptionValueTableMap::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->option_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : OptionValueTableMap::translateFieldName('CostAdj', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cost_adj = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : OptionValueTableMap::translateFieldName('Label', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : OptionValueTableMap::translateFieldName('Value', TableMap::TYPE_PHPNAME, $indexType)];
            $this->value = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = OptionValueTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\crwdogs\\events\\OptionValue'), 0, $e);
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
        if ($this->aItemOption !== null && $this->option_id !== $this->aItemOption->getOptionId()) {
            $this->aItemOption = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(OptionValueTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildOptionValueQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aItemOption = null;
            $this->collRegistrationOptions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see OptionValue::setDeleted()
     * @see OptionValue::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(OptionValueTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildOptionValueQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(OptionValueTableMap::DATABASE_NAME);
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
                OptionValueTableMap::addInstanceToPool($this);
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

            if ($this->aItemOption !== null) {
                if ($this->aItemOption->isModified() || $this->aItemOption->isNew()) {
                    $affectedRows += $this->aItemOption->save($con);
                }
                $this->setItemOption($this->aItemOption);
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

            if ($this->registrationOptionsScheduledForDeletion !== null) {
                if (!$this->registrationOptionsScheduledForDeletion->isEmpty()) {
                    \crwdogs\events\RegistrationOptionQuery::create()
                        ->filterByPrimaryKeys($this->registrationOptionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->registrationOptionsScheduledForDeletion = null;
                }
            }

            if ($this->collRegistrationOptions !== null) {
                foreach ($this->collRegistrationOptions as $referrerFK) {
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

        $this->modifiedColumns[OptionValueTableMap::COL_VALUE_ID] = true;
        if (null !== $this->value_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OptionValueTableMap::COL_VALUE_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OptionValueTableMap::COL_VALUE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'value_id';
        }
        if ($this->isColumnModified(OptionValueTableMap::COL_OPTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'option_id';
        }
        if ($this->isColumnModified(OptionValueTableMap::COL_COST_ADJ)) {
            $modifiedColumns[':p' . $index++]  = 'cost_adj';
        }
        if ($this->isColumnModified(OptionValueTableMap::COL_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'label';
        }
        if ($this->isColumnModified(OptionValueTableMap::COL_VALUE)) {
            $modifiedColumns[':p' . $index++]  = 'value';
        }

        $sql = sprintf(
            'INSERT INTO option_value (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'value_id':
                        $stmt->bindValue($identifier, $this->value_id, PDO::PARAM_INT);
                        break;
                    case 'option_id':
                        $stmt->bindValue($identifier, $this->option_id, PDO::PARAM_INT);
                        break;
                    case 'cost_adj':
                        $stmt->bindValue($identifier, $this->cost_adj, PDO::PARAM_STR);
                        break;
                    case 'label':
                        $stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
                        break;
                    case 'value':
                        $stmt->bindValue($identifier, $this->value, PDO::PARAM_STR);
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
        $this->setValueId($pk);

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
        $pos = OptionValueTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getValueId();
                break;
            case 1:
                return $this->getOptionId();
                break;
            case 2:
                return $this->getCostAdj();
                break;
            case 3:
                return $this->getLabel();
                break;
            case 4:
                return $this->getValue();
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

        if (isset($alreadyDumpedObjects['OptionValue'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['OptionValue'][$this->hashCode()] = true;
        $keys = OptionValueTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getValueId(),
            $keys[1] => $this->getOptionId(),
            $keys[2] => $this->getCostAdj(),
            $keys[3] => $this->getLabel(),
            $keys[4] => $this->getValue(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aItemOption) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'itemOption';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'item_option';
                        break;
                    default:
                        $key = 'ItemOption';
                }

                $result[$key] = $this->aItemOption->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRegistrationOptions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'registrationOptions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'registration_options';
                        break;
                    default:
                        $key = 'RegistrationOptions';
                }

                $result[$key] = $this->collRegistrationOptions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\crwdogs\events\OptionValue
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = OptionValueTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\crwdogs\events\OptionValue
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setValueId($value);
                break;
            case 1:
                $this->setOptionId($value);
                break;
            case 2:
                $this->setCostAdj($value);
                break;
            case 3:
                $this->setLabel($value);
                break;
            case 4:
                $this->setValue($value);
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
        $keys = OptionValueTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setValueId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setOptionId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCostAdj($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLabel($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setValue($arr[$keys[4]]);
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
     * @return $this|\crwdogs\events\OptionValue The current object, for fluid interface
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
        $criteria = new Criteria(OptionValueTableMap::DATABASE_NAME);

        if ($this->isColumnModified(OptionValueTableMap::COL_VALUE_ID)) {
            $criteria->add(OptionValueTableMap::COL_VALUE_ID, $this->value_id);
        }
        if ($this->isColumnModified(OptionValueTableMap::COL_OPTION_ID)) {
            $criteria->add(OptionValueTableMap::COL_OPTION_ID, $this->option_id);
        }
        if ($this->isColumnModified(OptionValueTableMap::COL_COST_ADJ)) {
            $criteria->add(OptionValueTableMap::COL_COST_ADJ, $this->cost_adj);
        }
        if ($this->isColumnModified(OptionValueTableMap::COL_LABEL)) {
            $criteria->add(OptionValueTableMap::COL_LABEL, $this->label);
        }
        if ($this->isColumnModified(OptionValueTableMap::COL_VALUE)) {
            $criteria->add(OptionValueTableMap::COL_VALUE, $this->value);
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
        $criteria = ChildOptionValueQuery::create();
        $criteria->add(OptionValueTableMap::COL_VALUE_ID, $this->value_id);

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
        $validPk = null !== $this->getValueId();

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
        return $this->getValueId();
    }

    /**
     * Generic method to set the primary key (value_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setValueId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getValueId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \crwdogs\events\OptionValue (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setOptionId($this->getOptionId());
        $copyObj->setCostAdj($this->getCostAdj());
        $copyObj->setLabel($this->getLabel());
        $copyObj->setValue($this->getValue());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRegistrationOptions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRegistrationOption($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setValueId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \crwdogs\events\OptionValue Clone of current object.
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
     * Declares an association between this object and a ChildItemOption object.
     *
     * @param  ChildItemOption $v
     * @return $this|\crwdogs\events\OptionValue The current object (for fluent API support)
     * @throws PropelException
     */
    public function setItemOption(ChildItemOption $v = null)
    {
        if ($v === null) {
            $this->setOptionId(NULL);
        } else {
            $this->setOptionId($v->getOptionId());
        }

        $this->aItemOption = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildItemOption object, it will not be re-added.
        if ($v !== null) {
            $v->addOptionValue($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildItemOption object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildItemOption The associated ChildItemOption object.
     * @throws PropelException
     */
    public function getItemOption(ConnectionInterface $con = null)
    {
        if ($this->aItemOption === null && ($this->option_id != 0)) {
            $this->aItemOption = ChildItemOptionQuery::create()->findPk($this->option_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aItemOption->addOptionValues($this);
             */
        }

        return $this->aItemOption;
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
        if ('RegistrationOption' == $relationName) {
            $this->initRegistrationOptions();
            return;
        }
    }

    /**
     * Clears out the collRegistrationOptions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRegistrationOptions()
     */
    public function clearRegistrationOptions()
    {
        $this->collRegistrationOptions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRegistrationOptions collection loaded partially.
     */
    public function resetPartialRegistrationOptions($v = true)
    {
        $this->collRegistrationOptionsPartial = $v;
    }

    /**
     * Initializes the collRegistrationOptions collection.
     *
     * By default this just sets the collRegistrationOptions collection to an empty array (like clearcollRegistrationOptions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRegistrationOptions($overrideExisting = true)
    {
        if (null !== $this->collRegistrationOptions && !$overrideExisting) {
            return;
        }

        $collectionClassName = RegistrationOptionTableMap::getTableMap()->getCollectionClassName();

        $this->collRegistrationOptions = new $collectionClassName;
        $this->collRegistrationOptions->setModel('\crwdogs\events\RegistrationOption');
    }

    /**
     * Gets an array of ChildRegistrationOption objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildOptionValue is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRegistrationOption[] List of ChildRegistrationOption objects
     * @throws PropelException
     */
    public function getRegistrationOptions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRegistrationOptionsPartial && !$this->isNew();
        if (null === $this->collRegistrationOptions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRegistrationOptions) {
                // return empty collection
                $this->initRegistrationOptions();
            } else {
                $collRegistrationOptions = ChildRegistrationOptionQuery::create(null, $criteria)
                    ->filterByOptionValue($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRegistrationOptionsPartial && count($collRegistrationOptions)) {
                        $this->initRegistrationOptions(false);

                        foreach ($collRegistrationOptions as $obj) {
                            if (false == $this->collRegistrationOptions->contains($obj)) {
                                $this->collRegistrationOptions->append($obj);
                            }
                        }

                        $this->collRegistrationOptionsPartial = true;
                    }

                    return $collRegistrationOptions;
                }

                if ($partial && $this->collRegistrationOptions) {
                    foreach ($this->collRegistrationOptions as $obj) {
                        if ($obj->isNew()) {
                            $collRegistrationOptions[] = $obj;
                        }
                    }
                }

                $this->collRegistrationOptions = $collRegistrationOptions;
                $this->collRegistrationOptionsPartial = false;
            }
        }

        return $this->collRegistrationOptions;
    }

    /**
     * Sets a collection of ChildRegistrationOption objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $registrationOptions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildOptionValue The current object (for fluent API support)
     */
    public function setRegistrationOptions(Collection $registrationOptions, ConnectionInterface $con = null)
    {
        /** @var ChildRegistrationOption[] $registrationOptionsToDelete */
        $registrationOptionsToDelete = $this->getRegistrationOptions(new Criteria(), $con)->diff($registrationOptions);


        $this->registrationOptionsScheduledForDeletion = $registrationOptionsToDelete;

        foreach ($registrationOptionsToDelete as $registrationOptionRemoved) {
            $registrationOptionRemoved->setOptionValue(null);
        }

        $this->collRegistrationOptions = null;
        foreach ($registrationOptions as $registrationOption) {
            $this->addRegistrationOption($registrationOption);
        }

        $this->collRegistrationOptions = $registrationOptions;
        $this->collRegistrationOptionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RegistrationOption objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RegistrationOption objects.
     * @throws PropelException
     */
    public function countRegistrationOptions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRegistrationOptionsPartial && !$this->isNew();
        if (null === $this->collRegistrationOptions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRegistrationOptions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRegistrationOptions());
            }

            $query = ChildRegistrationOptionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOptionValue($this)
                ->count($con);
        }

        return count($this->collRegistrationOptions);
    }

    /**
     * Method called to associate a ChildRegistrationOption object to this object
     * through the ChildRegistrationOption foreign key attribute.
     *
     * @param  ChildRegistrationOption $l ChildRegistrationOption
     * @return $this|\crwdogs\events\OptionValue The current object (for fluent API support)
     */
    public function addRegistrationOption(ChildRegistrationOption $l)
    {
        if ($this->collRegistrationOptions === null) {
            $this->initRegistrationOptions();
            $this->collRegistrationOptionsPartial = true;
        }

        if (!$this->collRegistrationOptions->contains($l)) {
            $this->doAddRegistrationOption($l);

            if ($this->registrationOptionsScheduledForDeletion and $this->registrationOptionsScheduledForDeletion->contains($l)) {
                $this->registrationOptionsScheduledForDeletion->remove($this->registrationOptionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRegistrationOption $registrationOption The ChildRegistrationOption object to add.
     */
    protected function doAddRegistrationOption(ChildRegistrationOption $registrationOption)
    {
        $this->collRegistrationOptions[]= $registrationOption;
        $registrationOption->setOptionValue($this);
    }

    /**
     * @param  ChildRegistrationOption $registrationOption The ChildRegistrationOption object to remove.
     * @return $this|ChildOptionValue The current object (for fluent API support)
     */
    public function removeRegistrationOption(ChildRegistrationOption $registrationOption)
    {
        if ($this->getRegistrationOptions()->contains($registrationOption)) {
            $pos = $this->collRegistrationOptions->search($registrationOption);
            $this->collRegistrationOptions->remove($pos);
            if (null === $this->registrationOptionsScheduledForDeletion) {
                $this->registrationOptionsScheduledForDeletion = clone $this->collRegistrationOptions;
                $this->registrationOptionsScheduledForDeletion->clear();
            }
            $this->registrationOptionsScheduledForDeletion[]= clone $registrationOption;
            $registrationOption->setOptionValue(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this OptionValue is new, it will return
     * an empty collection; or if this OptionValue has previously
     * been saved, it will retrieve related RegistrationOptions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in OptionValue.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRegistrationOption[] List of ChildRegistrationOption objects
     */
    public function getRegistrationOptionsJoinPurchasedItem(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRegistrationOptionQuery::create(null, $criteria);
        $query->joinWith('PurchasedItem', $joinBehavior);

        return $this->getRegistrationOptions($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aItemOption) {
            $this->aItemOption->removeOptionValue($this);
        }
        $this->value_id = null;
        $this->option_id = null;
        $this->cost_adj = null;
        $this->label = null;
        $this->value = null;
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
            if ($this->collRegistrationOptions) {
                foreach ($this->collRegistrationOptions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRegistrationOptions = null;
        $this->aItemOption = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OptionValueTableMap::DEFAULT_STRING_FORMAT);
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
