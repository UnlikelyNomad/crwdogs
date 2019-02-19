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
use crwdogs\events\Payment as ChildPayment;
use crwdogs\events\PaymentQuery as ChildPaymentQuery;
use crwdogs\events\PurchasedItem as ChildPurchasedItem;
use crwdogs\events\PurchasedItemQuery as ChildPurchasedItemQuery;
use crwdogs\events\Registration as ChildRegistration;
use crwdogs\events\RegistrationQuery as ChildRegistrationQuery;
use crwdogs\events\Response as ChildResponse;
use crwdogs\events\ResponseQuery as ChildResponseQuery;
use crwdogs\events\User as ChildUser;
use crwdogs\events\UserQuery as ChildUserQuery;
use crwdogs\events\Map\PaymentTableMap;
use crwdogs\events\Map\PurchasedItemTableMap;
use crwdogs\events\Map\RegistrationTableMap;
use crwdogs\events\Map\ResponseTableMap;

/**
 * Base class that represents a row from the 'registration' table.
 *
 *
 *
 * @package    propel.generator.crwdogs.events.Base
 */
abstract class Registration implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\crwdogs\\events\\Map\\RegistrationTableMap';


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
     * The value for the registration_id field.
     *
     * @var        int
     */
    protected $registration_id;

    /**
     * The value for the event_id field.
     *
     * @var        int
     */
    protected $event_id;

    /**
     * The value for the user_id field.
     *
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the status field.
     *
     * @var        string
     */
    protected $status;

    /**
     * The value for the total field.
     *
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $total;

    /**
     * @var        ChildEvent
     */
    protected $aEvent;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ObjectCollection|ChildPayment[] Collection to store aggregation of ChildPayment objects.
     */
    protected $collPayments;
    protected $collPaymentsPartial;

    /**
     * @var        ObjectCollection|ChildPurchasedItem[] Collection to store aggregation of ChildPurchasedItem objects.
     */
    protected $collPurchasedItems;
    protected $collPurchasedItemsPartial;

    /**
     * @var        ObjectCollection|ChildResponse[] Collection to store aggregation of ChildResponse objects.
     */
    protected $collResponses;
    protected $collResponsesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPayment[]
     */
    protected $paymentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPurchasedItem[]
     */
    protected $purchasedItemsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildResponse[]
     */
    protected $responsesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->total = '0';
    }

    /**
     * Initializes internal state of crwdogs\events\Base\Registration object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Registration</code> instance.  If
     * <code>obj</code> is an instance of <code>Registration</code>, delegates to
     * <code>equals(Registration)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Registration The current object, for fluid interface
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
     * Get the [registration_id] column value.
     *
     * @return int
     */
    public function getRegistrationId()
    {
        return $this->registration_id;
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
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [total] column value.
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set the value of [registration_id] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
     */
    public function setRegistrationId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->registration_id !== $v) {
            $this->registration_id = $v;
            $this->modifiedColumns[RegistrationTableMap::COL_REGISTRATION_ID] = true;
        }

        return $this;
    } // setRegistrationId()

    /**
     * Set the value of [event_id] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
     */
    public function setEventId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_id !== $v) {
            $this->event_id = $v;
            $this->modifiedColumns[RegistrationTableMap::COL_EVENT_ID] = true;
        }

        if ($this->aEvent !== null && $this->aEvent->getEventId() !== $v) {
            $this->aEvent = null;
        }

        return $this;
    } // setEventId()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[RegistrationTableMap::COL_USER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getUserId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [status] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[RegistrationTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [total] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
     */
    public function setTotal($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->total !== $v) {
            $this->total = $v;
            $this->modifiedColumns[RegistrationTableMap::COL_TOTAL] = true;
        }

        return $this;
    } // setTotal()

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
            if ($this->total !== '0') {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RegistrationTableMap::translateFieldName('RegistrationId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->registration_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RegistrationTableMap::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RegistrationTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RegistrationTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RegistrationTableMap::translateFieldName('Total', TableMap::TYPE_PHPNAME, $indexType)];
            $this->total = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = RegistrationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\crwdogs\\events\\Registration'), 0, $e);
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
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getUserId()) {
            $this->aUser = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(RegistrationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRegistrationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEvent = null;
            $this->aUser = null;
            $this->collPayments = null;

            $this->collPurchasedItems = null;

            $this->collResponses = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Registration::setDeleted()
     * @see Registration::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RegistrationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRegistrationQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RegistrationTableMap::DATABASE_NAME);
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
                RegistrationTableMap::addInstanceToPool($this);
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

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
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

            if ($this->paymentsScheduledForDeletion !== null) {
                if (!$this->paymentsScheduledForDeletion->isEmpty()) {
                    \crwdogs\events\PaymentQuery::create()
                        ->filterByPrimaryKeys($this->paymentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->paymentsScheduledForDeletion = null;
                }
            }

            if ($this->collPayments !== null) {
                foreach ($this->collPayments as $referrerFK) {
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

            if ($this->responsesScheduledForDeletion !== null) {
                if (!$this->responsesScheduledForDeletion->isEmpty()) {
                    \crwdogs\events\ResponseQuery::create()
                        ->filterByPrimaryKeys($this->responsesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->responsesScheduledForDeletion = null;
                }
            }

            if ($this->collResponses !== null) {
                foreach ($this->collResponses as $referrerFK) {
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

        $this->modifiedColumns[RegistrationTableMap::COL_REGISTRATION_ID] = true;
        if (null !== $this->registration_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RegistrationTableMap::COL_REGISTRATION_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RegistrationTableMap::COL_REGISTRATION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'registration_id';
        }
        if ($this->isColumnModified(RegistrationTableMap::COL_EVENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'event_id';
        }
        if ($this->isColumnModified(RegistrationTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(RegistrationTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(RegistrationTableMap::COL_TOTAL)) {
            $modifiedColumns[':p' . $index++]  = 'total';
        }

        $sql = sprintf(
            'INSERT INTO registration (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'registration_id':
                        $stmt->bindValue($identifier, $this->registration_id, PDO::PARAM_INT);
                        break;
                    case 'event_id':
                        $stmt->bindValue($identifier, $this->event_id, PDO::PARAM_INT);
                        break;
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case 'total':
                        $stmt->bindValue($identifier, $this->total, PDO::PARAM_STR);
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
        $this->setRegistrationId($pk);

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
        $pos = RegistrationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getRegistrationId();
                break;
            case 1:
                return $this->getEventId();
                break;
            case 2:
                return $this->getUserId();
                break;
            case 3:
                return $this->getStatus();
                break;
            case 4:
                return $this->getTotal();
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

        if (isset($alreadyDumpedObjects['Registration'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Registration'][$this->hashCode()] = true;
        $keys = RegistrationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getRegistrationId(),
            $keys[1] => $this->getEventId(),
            $keys[2] => $this->getUserId(),
            $keys[3] => $this->getStatus(),
            $keys[4] => $this->getTotal(),
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
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPayments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'payments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'payments';
                        break;
                    default:
                        $key = 'Payments';
                }

                $result[$key] = $this->collPayments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collResponses) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'responses';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'responses';
                        break;
                    default:
                        $key = 'Responses';
                }

                $result[$key] = $this->collResponses->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\crwdogs\events\Registration
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RegistrationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\crwdogs\events\Registration
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setRegistrationId($value);
                break;
            case 1:
                $this->setEventId($value);
                break;
            case 2:
                $this->setUserId($value);
                break;
            case 3:
                $this->setStatus($value);
                break;
            case 4:
                $this->setTotal($value);
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
        $keys = RegistrationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setRegistrationId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEventId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setStatus($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setTotal($arr[$keys[4]]);
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
     * @return $this|\crwdogs\events\Registration The current object, for fluid interface
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
        $criteria = new Criteria(RegistrationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RegistrationTableMap::COL_REGISTRATION_ID)) {
            $criteria->add(RegistrationTableMap::COL_REGISTRATION_ID, $this->registration_id);
        }
        if ($this->isColumnModified(RegistrationTableMap::COL_EVENT_ID)) {
            $criteria->add(RegistrationTableMap::COL_EVENT_ID, $this->event_id);
        }
        if ($this->isColumnModified(RegistrationTableMap::COL_USER_ID)) {
            $criteria->add(RegistrationTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(RegistrationTableMap::COL_STATUS)) {
            $criteria->add(RegistrationTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(RegistrationTableMap::COL_TOTAL)) {
            $criteria->add(RegistrationTableMap::COL_TOTAL, $this->total);
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
        $criteria = ChildRegistrationQuery::create();
        $criteria->add(RegistrationTableMap::COL_REGISTRATION_ID, $this->registration_id);

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
        $validPk = null !== $this->getRegistrationId();

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
        return $this->getRegistrationId();
    }

    /**
     * Generic method to set the primary key (registration_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setRegistrationId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getRegistrationId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \crwdogs\events\Registration (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEventId($this->getEventId());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setTotal($this->getTotal());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPayments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPayment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPurchasedItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPurchasedItem($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getResponses() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addResponse($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setRegistrationId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \crwdogs\events\Registration Clone of current object.
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
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
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
            $v->addRegistration($this);
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
                $this->aEvent->addRegistrations($this);
             */
        }

        return $this->aEvent;
    }

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getUserId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addRegistration($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->user_id != 0)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addRegistrations($this);
             */
        }

        return $this->aUser;
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
        if ('Payment' == $relationName) {
            $this->initPayments();
            return;
        }
        if ('PurchasedItem' == $relationName) {
            $this->initPurchasedItems();
            return;
        }
        if ('Response' == $relationName) {
            $this->initResponses();
            return;
        }
    }

    /**
     * Clears out the collPayments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPayments()
     */
    public function clearPayments()
    {
        $this->collPayments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPayments collection loaded partially.
     */
    public function resetPartialPayments($v = true)
    {
        $this->collPaymentsPartial = $v;
    }

    /**
     * Initializes the collPayments collection.
     *
     * By default this just sets the collPayments collection to an empty array (like clearcollPayments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPayments($overrideExisting = true)
    {
        if (null !== $this->collPayments && !$overrideExisting) {
            return;
        }

        $collectionClassName = PaymentTableMap::getTableMap()->getCollectionClassName();

        $this->collPayments = new $collectionClassName;
        $this->collPayments->setModel('\crwdogs\events\Payment');
    }

    /**
     * Gets an array of ChildPayment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRegistration is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPayment[] List of ChildPayment objects
     * @throws PropelException
     */
    public function getPayments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPaymentsPartial && !$this->isNew();
        if (null === $this->collPayments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPayments) {
                // return empty collection
                $this->initPayments();
            } else {
                $collPayments = ChildPaymentQuery::create(null, $criteria)
                    ->filterByRegistration($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPaymentsPartial && count($collPayments)) {
                        $this->initPayments(false);

                        foreach ($collPayments as $obj) {
                            if (false == $this->collPayments->contains($obj)) {
                                $this->collPayments->append($obj);
                            }
                        }

                        $this->collPaymentsPartial = true;
                    }

                    return $collPayments;
                }

                if ($partial && $this->collPayments) {
                    foreach ($this->collPayments as $obj) {
                        if ($obj->isNew()) {
                            $collPayments[] = $obj;
                        }
                    }
                }

                $this->collPayments = $collPayments;
                $this->collPaymentsPartial = false;
            }
        }

        return $this->collPayments;
    }

    /**
     * Sets a collection of ChildPayment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $payments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRegistration The current object (for fluent API support)
     */
    public function setPayments(Collection $payments, ConnectionInterface $con = null)
    {
        /** @var ChildPayment[] $paymentsToDelete */
        $paymentsToDelete = $this->getPayments(new Criteria(), $con)->diff($payments);


        $this->paymentsScheduledForDeletion = $paymentsToDelete;

        foreach ($paymentsToDelete as $paymentRemoved) {
            $paymentRemoved->setRegistration(null);
        }

        $this->collPayments = null;
        foreach ($payments as $payment) {
            $this->addPayment($payment);
        }

        $this->collPayments = $payments;
        $this->collPaymentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Payment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Payment objects.
     * @throws PropelException
     */
    public function countPayments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPaymentsPartial && !$this->isNew();
        if (null === $this->collPayments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPayments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPayments());
            }

            $query = ChildPaymentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRegistration($this)
                ->count($con);
        }

        return count($this->collPayments);
    }

    /**
     * Method called to associate a ChildPayment object to this object
     * through the ChildPayment foreign key attribute.
     *
     * @param  ChildPayment $l ChildPayment
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
     */
    public function addPayment(ChildPayment $l)
    {
        if ($this->collPayments === null) {
            $this->initPayments();
            $this->collPaymentsPartial = true;
        }

        if (!$this->collPayments->contains($l)) {
            $this->doAddPayment($l);

            if ($this->paymentsScheduledForDeletion and $this->paymentsScheduledForDeletion->contains($l)) {
                $this->paymentsScheduledForDeletion->remove($this->paymentsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPayment $payment The ChildPayment object to add.
     */
    protected function doAddPayment(ChildPayment $payment)
    {
        $this->collPayments[]= $payment;
        $payment->setRegistration($this);
    }

    /**
     * @param  ChildPayment $payment The ChildPayment object to remove.
     * @return $this|ChildRegistration The current object (for fluent API support)
     */
    public function removePayment(ChildPayment $payment)
    {
        if ($this->getPayments()->contains($payment)) {
            $pos = $this->collPayments->search($payment);
            $this->collPayments->remove($pos);
            if (null === $this->paymentsScheduledForDeletion) {
                $this->paymentsScheduledForDeletion = clone $this->collPayments;
                $this->paymentsScheduledForDeletion->clear();
            }
            $this->paymentsScheduledForDeletion[]= clone $payment;
            $payment->setRegistration(null);
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
     * If this ChildRegistration is new, it will return
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
                    ->filterByRegistration($this)
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
     * @return $this|ChildRegistration The current object (for fluent API support)
     */
    public function setPurchasedItems(Collection $purchasedItems, ConnectionInterface $con = null)
    {
        /** @var ChildPurchasedItem[] $purchasedItemsToDelete */
        $purchasedItemsToDelete = $this->getPurchasedItems(new Criteria(), $con)->diff($purchasedItems);


        $this->purchasedItemsScheduledForDeletion = $purchasedItemsToDelete;

        foreach ($purchasedItemsToDelete as $purchasedItemRemoved) {
            $purchasedItemRemoved->setRegistration(null);
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
                ->filterByRegistration($this)
                ->count($con);
        }

        return count($this->collPurchasedItems);
    }

    /**
     * Method called to associate a ChildPurchasedItem object to this object
     * through the ChildPurchasedItem foreign key attribute.
     *
     * @param  ChildPurchasedItem $l ChildPurchasedItem
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
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
        $purchasedItem->setRegistration($this);
    }

    /**
     * @param  ChildPurchasedItem $purchasedItem The ChildPurchasedItem object to remove.
     * @return $this|ChildRegistration The current object (for fluent API support)
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
            $purchasedItem->setRegistration(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Registration is new, it will return
     * an empty collection; or if this Registration has previously
     * been saved, it will retrieve related PurchasedItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Registration.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPurchasedItem[] List of ChildPurchasedItem objects
     */
    public function getPurchasedItemsJoinItem(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPurchasedItemQuery::create(null, $criteria);
        $query->joinWith('Item', $joinBehavior);

        return $this->getPurchasedItems($query, $con);
    }

    /**
     * Clears out the collResponses collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addResponses()
     */
    public function clearResponses()
    {
        $this->collResponses = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collResponses collection loaded partially.
     */
    public function resetPartialResponses($v = true)
    {
        $this->collResponsesPartial = $v;
    }

    /**
     * Initializes the collResponses collection.
     *
     * By default this just sets the collResponses collection to an empty array (like clearcollResponses());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initResponses($overrideExisting = true)
    {
        if (null !== $this->collResponses && !$overrideExisting) {
            return;
        }

        $collectionClassName = ResponseTableMap::getTableMap()->getCollectionClassName();

        $this->collResponses = new $collectionClassName;
        $this->collResponses->setModel('\crwdogs\events\Response');
    }

    /**
     * Gets an array of ChildResponse objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRegistration is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildResponse[] List of ChildResponse objects
     * @throws PropelException
     */
    public function getResponses(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collResponsesPartial && !$this->isNew();
        if (null === $this->collResponses || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collResponses) {
                // return empty collection
                $this->initResponses();
            } else {
                $collResponses = ChildResponseQuery::create(null, $criteria)
                    ->filterByRegistration($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collResponsesPartial && count($collResponses)) {
                        $this->initResponses(false);

                        foreach ($collResponses as $obj) {
                            if (false == $this->collResponses->contains($obj)) {
                                $this->collResponses->append($obj);
                            }
                        }

                        $this->collResponsesPartial = true;
                    }

                    return $collResponses;
                }

                if ($partial && $this->collResponses) {
                    foreach ($this->collResponses as $obj) {
                        if ($obj->isNew()) {
                            $collResponses[] = $obj;
                        }
                    }
                }

                $this->collResponses = $collResponses;
                $this->collResponsesPartial = false;
            }
        }

        return $this->collResponses;
    }

    /**
     * Sets a collection of ChildResponse objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $responses A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRegistration The current object (for fluent API support)
     */
    public function setResponses(Collection $responses, ConnectionInterface $con = null)
    {
        /** @var ChildResponse[] $responsesToDelete */
        $responsesToDelete = $this->getResponses(new Criteria(), $con)->diff($responses);


        $this->responsesScheduledForDeletion = $responsesToDelete;

        foreach ($responsesToDelete as $responseRemoved) {
            $responseRemoved->setRegistration(null);
        }

        $this->collResponses = null;
        foreach ($responses as $response) {
            $this->addResponse($response);
        }

        $this->collResponses = $responses;
        $this->collResponsesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Response objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Response objects.
     * @throws PropelException
     */
    public function countResponses(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collResponsesPartial && !$this->isNew();
        if (null === $this->collResponses || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collResponses) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getResponses());
            }

            $query = ChildResponseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRegistration($this)
                ->count($con);
        }

        return count($this->collResponses);
    }

    /**
     * Method called to associate a ChildResponse object to this object
     * through the ChildResponse foreign key attribute.
     *
     * @param  ChildResponse $l ChildResponse
     * @return $this|\crwdogs\events\Registration The current object (for fluent API support)
     */
    public function addResponse(ChildResponse $l)
    {
        if ($this->collResponses === null) {
            $this->initResponses();
            $this->collResponsesPartial = true;
        }

        if (!$this->collResponses->contains($l)) {
            $this->doAddResponse($l);

            if ($this->responsesScheduledForDeletion and $this->responsesScheduledForDeletion->contains($l)) {
                $this->responsesScheduledForDeletion->remove($this->responsesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildResponse $response The ChildResponse object to add.
     */
    protected function doAddResponse(ChildResponse $response)
    {
        $this->collResponses[]= $response;
        $response->setRegistration($this);
    }

    /**
     * @param  ChildResponse $response The ChildResponse object to remove.
     * @return $this|ChildRegistration The current object (for fluent API support)
     */
    public function removeResponse(ChildResponse $response)
    {
        if ($this->getResponses()->contains($response)) {
            $pos = $this->collResponses->search($response);
            $this->collResponses->remove($pos);
            if (null === $this->responsesScheduledForDeletion) {
                $this->responsesScheduledForDeletion = clone $this->collResponses;
                $this->responsesScheduledForDeletion->clear();
            }
            $this->responsesScheduledForDeletion[]= clone $response;
            $response->setRegistration(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Registration is new, it will return
     * an empty collection; or if this Registration has previously
     * been saved, it will retrieve related Responses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Registration.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildResponse[] List of ChildResponse objects
     */
    public function getResponsesJoinQuestion(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildResponseQuery::create(null, $criteria);
        $query->joinWith('Question', $joinBehavior);

        return $this->getResponses($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aEvent) {
            $this->aEvent->removeRegistration($this);
        }
        if (null !== $this->aUser) {
            $this->aUser->removeRegistration($this);
        }
        $this->registration_id = null;
        $this->event_id = null;
        $this->user_id = null;
        $this->status = null;
        $this->total = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collPayments) {
                foreach ($this->collPayments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPurchasedItems) {
                foreach ($this->collPurchasedItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collResponses) {
                foreach ($this->collResponses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPayments = null;
        $this->collPurchasedItems = null;
        $this->collResponses = null;
        $this->aEvent = null;
        $this->aUser = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RegistrationTableMap::DEFAULT_STRING_FORMAT);
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
