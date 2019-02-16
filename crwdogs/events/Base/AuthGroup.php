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
use crwdogs\events\AuthGroup as ChildAuthGroup;
use crwdogs\events\AuthGroupQuery as ChildAuthGroupQuery;
use crwdogs\events\Event as ChildEvent;
use crwdogs\events\EventQuery as ChildEventQuery;
use crwdogs\events\User as ChildUser;
use crwdogs\events\UserGroup as ChildUserGroup;
use crwdogs\events\UserGroupQuery as ChildUserGroupQuery;
use crwdogs\events\UserQuery as ChildUserQuery;
use crwdogs\events\Map\AuthGroupTableMap;
use crwdogs\events\Map\EventTableMap;
use crwdogs\events\Map\UserGroupTableMap;

/**
 * Base class that represents a row from the 'auth_group' table.
 *
 *
 *
 * @package    propel.generator.crwdogs.events.Base
 */
abstract class AuthGroup implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\crwdogs\\events\\Map\\AuthGroupTableMap';


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
     * The value for the group_id field.
     *
     * @var        int
     */
    protected $group_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the label field.
     *
     * @var        string
     */
    protected $label;

    /**
     * The value for the comment field.
     *
     * @var        string
     */
    protected $comment;

    /**
     * The value for the default_group field.
     *
     * @var        string
     */
    protected $default_group;

    /**
     * The value for the anonymous field.
     *
     * @var        string
     */
    protected $anonymous;

    /**
     * The value for the root field.
     *
     * @var        string
     */
    protected $root;

    /**
     * @var        ObjectCollection|ChildEvent[] Collection to store aggregation of ChildEvent objects.
     */
    protected $collEvents;
    protected $collEventsPartial;

    /**
     * @var        ObjectCollection|ChildUserGroup[] Collection to store aggregation of ChildUserGroup objects.
     */
    protected $collUserGroups;
    protected $collUserGroupsPartial;

    /**
     * @var        ObjectCollection|ChildUser[] Cross Collection to store aggregation of ChildUser objects.
     */
    protected $collUsers;

    /**
     * @var bool
     */
    protected $collUsersPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUser[]
     */
    protected $usersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEvent[]
     */
    protected $eventsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUserGroup[]
     */
    protected $userGroupsScheduledForDeletion = null;

    /**
     * Initializes internal state of crwdogs\events\Base\AuthGroup object.
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
     * Compares this with another <code>AuthGroup</code> instance.  If
     * <code>obj</code> is an instance of <code>AuthGroup</code>, delegates to
     * <code>equals(AuthGroup)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|AuthGroup The current object, for fluid interface
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
     * Get the [group_id] column value.
     *
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
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
     * Get the [label] column value.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the [comment] column value.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Get the [default_group] column value.
     *
     * @return string
     */
    public function getDefaultGroup()
    {
        return $this->default_group;
    }

    /**
     * Get the [anonymous] column value.
     *
     * @return string
     */
    public function getAnonymous()
    {
        return $this->anonymous;
    }

    /**
     * Get the [root] column value.
     *
     * @return string
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set the value of [group_id] column.
     *
     * @param int $v new value
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function setGroupId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->group_id !== $v) {
            $this->group_id = $v;
            $this->modifiedColumns[AuthGroupTableMap::COL_GROUP_ID] = true;
        }

        return $this;
    } // setGroupId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[AuthGroupTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [label] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function setLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label !== $v) {
            $this->label = $v;
            $this->modifiedColumns[AuthGroupTableMap::COL_LABEL] = true;
        }

        return $this;
    } // setLabel()

    /**
     * Set the value of [comment] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function setComment($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->comment !== $v) {
            $this->comment = $v;
            $this->modifiedColumns[AuthGroupTableMap::COL_COMMENT] = true;
        }

        return $this;
    } // setComment()

    /**
     * Set the value of [default_group] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function setDefaultGroup($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->default_group !== $v) {
            $this->default_group = $v;
            $this->modifiedColumns[AuthGroupTableMap::COL_DEFAULT_GROUP] = true;
        }

        return $this;
    } // setDefaultGroup()

    /**
     * Set the value of [anonymous] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function setAnonymous($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->anonymous !== $v) {
            $this->anonymous = $v;
            $this->modifiedColumns[AuthGroupTableMap::COL_ANONYMOUS] = true;
        }

        return $this;
    } // setAnonymous()

    /**
     * Set the value of [root] column.
     *
     * @param string $v new value
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function setRoot($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->root !== $v) {
            $this->root = $v;
            $this->modifiedColumns[AuthGroupTableMap::COL_ROOT] = true;
        }

        return $this;
    } // setRoot()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AuthGroupTableMap::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->group_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AuthGroupTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AuthGroupTableMap::translateFieldName('Label', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AuthGroupTableMap::translateFieldName('Comment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->comment = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AuthGroupTableMap::translateFieldName('DefaultGroup', TableMap::TYPE_PHPNAME, $indexType)];
            $this->default_group = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AuthGroupTableMap::translateFieldName('Anonymous', TableMap::TYPE_PHPNAME, $indexType)];
            $this->anonymous = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AuthGroupTableMap::translateFieldName('Root', TableMap::TYPE_PHPNAME, $indexType)];
            $this->root = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = AuthGroupTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\crwdogs\\events\\AuthGroup'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AuthGroupTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAuthGroupQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collEvents = null;

            $this->collUserGroups = null;

            $this->collUsers = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AuthGroup::setDeleted()
     * @see AuthGroup::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuthGroupTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAuthGroupQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AuthGroupTableMap::DATABASE_NAME);
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
                AuthGroupTableMap::addInstanceToPool($this);
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

            if ($this->usersScheduledForDeletion !== null) {
                if (!$this->usersScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->usersScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getGroupId();
                        $entryPk[0] = $entry->getUserId();
                        $pks[] = $entryPk;
                    }

                    \crwdogs\events\UserGroupQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->usersScheduledForDeletion = null;
                }

            }

            if ($this->collUsers) {
                foreach ($this->collUsers as $user) {
                    if (!$user->isDeleted() && ($user->isNew() || $user->isModified())) {
                        $user->save($con);
                    }
                }
            }


            if ($this->eventsScheduledForDeletion !== null) {
                if (!$this->eventsScheduledForDeletion->isEmpty()) {
                    \crwdogs\events\EventQuery::create()
                        ->filterByPrimaryKeys($this->eventsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->eventsScheduledForDeletion = null;
                }
            }

            if ($this->collEvents !== null) {
                foreach ($this->collEvents as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userGroupsScheduledForDeletion !== null) {
                if (!$this->userGroupsScheduledForDeletion->isEmpty()) {
                    \crwdogs\events\UserGroupQuery::create()
                        ->filterByPrimaryKeys($this->userGroupsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userGroupsScheduledForDeletion = null;
                }
            }

            if ($this->collUserGroups !== null) {
                foreach ($this->collUserGroups as $referrerFK) {
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

        $this->modifiedColumns[AuthGroupTableMap::COL_GROUP_ID] = true;
        if (null !== $this->group_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AuthGroupTableMap::COL_GROUP_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AuthGroupTableMap::COL_GROUP_ID)) {
            $modifiedColumns[':p' . $index++]  = 'group_id';
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'label';
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_COMMENT)) {
            $modifiedColumns[':p' . $index++]  = 'comment';
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_DEFAULT_GROUP)) {
            $modifiedColumns[':p' . $index++]  = 'default_group';
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_ANONYMOUS)) {
            $modifiedColumns[':p' . $index++]  = 'anonymous';
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_ROOT)) {
            $modifiedColumns[':p' . $index++]  = 'root';
        }

        $sql = sprintf(
            'INSERT INTO auth_group (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'group_id':
                        $stmt->bindValue($identifier, $this->group_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'label':
                        $stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
                        break;
                    case 'comment':
                        $stmt->bindValue($identifier, $this->comment, PDO::PARAM_STR);
                        break;
                    case 'default_group':
                        $stmt->bindValue($identifier, $this->default_group, PDO::PARAM_STR);
                        break;
                    case 'anonymous':
                        $stmt->bindValue($identifier, $this->anonymous, PDO::PARAM_STR);
                        break;
                    case 'root':
                        $stmt->bindValue($identifier, $this->root, PDO::PARAM_STR);
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
        $this->setGroupId($pk);

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
        $pos = AuthGroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getGroupId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getLabel();
                break;
            case 3:
                return $this->getComment();
                break;
            case 4:
                return $this->getDefaultGroup();
                break;
            case 5:
                return $this->getAnonymous();
                break;
            case 6:
                return $this->getRoot();
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

        if (isset($alreadyDumpedObjects['AuthGroup'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AuthGroup'][$this->hashCode()] = true;
        $keys = AuthGroupTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getGroupId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getLabel(),
            $keys[3] => $this->getComment(),
            $keys[4] => $this->getDefaultGroup(),
            $keys[5] => $this->getAnonymous(),
            $keys[6] => $this->getRoot(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collEvents) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'events';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'events';
                        break;
                    default:
                        $key = 'Events';
                }

                $result[$key] = $this->collEvents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserGroups) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userGroups';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_groups';
                        break;
                    default:
                        $key = 'UserGroups';
                }

                $result[$key] = $this->collUserGroups->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\crwdogs\events\AuthGroup
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AuthGroupTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\crwdogs\events\AuthGroup
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setGroupId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setLabel($value);
                break;
            case 3:
                $this->setComment($value);
                break;
            case 4:
                $this->setDefaultGroup($value);
                break;
            case 5:
                $this->setAnonymous($value);
                break;
            case 6:
                $this->setRoot($value);
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
        $keys = AuthGroupTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setGroupId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLabel($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setComment($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDefaultGroup($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAnonymous($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setRoot($arr[$keys[6]]);
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
     * @return $this|\crwdogs\events\AuthGroup The current object, for fluid interface
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
        $criteria = new Criteria(AuthGroupTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AuthGroupTableMap::COL_GROUP_ID)) {
            $criteria->add(AuthGroupTableMap::COL_GROUP_ID, $this->group_id);
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_NAME)) {
            $criteria->add(AuthGroupTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_LABEL)) {
            $criteria->add(AuthGroupTableMap::COL_LABEL, $this->label);
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_COMMENT)) {
            $criteria->add(AuthGroupTableMap::COL_COMMENT, $this->comment);
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_DEFAULT_GROUP)) {
            $criteria->add(AuthGroupTableMap::COL_DEFAULT_GROUP, $this->default_group);
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_ANONYMOUS)) {
            $criteria->add(AuthGroupTableMap::COL_ANONYMOUS, $this->anonymous);
        }
        if ($this->isColumnModified(AuthGroupTableMap::COL_ROOT)) {
            $criteria->add(AuthGroupTableMap::COL_ROOT, $this->root);
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
        $criteria = ChildAuthGroupQuery::create();
        $criteria->add(AuthGroupTableMap::COL_GROUP_ID, $this->group_id);

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
        $validPk = null !== $this->getGroupId();

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
        return $this->getGroupId();
    }

    /**
     * Generic method to set the primary key (group_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setGroupId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getGroupId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \crwdogs\events\AuthGroup (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setLabel($this->getLabel());
        $copyObj->setComment($this->getComment());
        $copyObj->setDefaultGroup($this->getDefaultGroup());
        $copyObj->setAnonymous($this->getAnonymous());
        $copyObj->setRoot($this->getRoot());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getEvents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEvent($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserGroups() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserGroup($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setGroupId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \crwdogs\events\AuthGroup Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Event' == $relationName) {
            $this->initEvents();
            return;
        }
        if ('UserGroup' == $relationName) {
            $this->initUserGroups();
            return;
        }
    }

    /**
     * Clears out the collEvents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEvents()
     */
    public function clearEvents()
    {
        $this->collEvents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEvents collection loaded partially.
     */
    public function resetPartialEvents($v = true)
    {
        $this->collEventsPartial = $v;
    }

    /**
     * Initializes the collEvents collection.
     *
     * By default this just sets the collEvents collection to an empty array (like clearcollEvents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEvents($overrideExisting = true)
    {
        if (null !== $this->collEvents && !$overrideExisting) {
            return;
        }

        $collectionClassName = EventTableMap::getTableMap()->getCollectionClassName();

        $this->collEvents = new $collectionClassName;
        $this->collEvents->setModel('\crwdogs\events\Event');
    }

    /**
     * Gets an array of ChildEvent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAuthGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEvent[] List of ChildEvent objects
     * @throws PropelException
     */
    public function getEvents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsPartial && !$this->isNew();
        if (null === $this->collEvents || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEvents) {
                // return empty collection
                $this->initEvents();
            } else {
                $collEvents = ChildEventQuery::create(null, $criteria)
                    ->filterByAuthGroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventsPartial && count($collEvents)) {
                        $this->initEvents(false);

                        foreach ($collEvents as $obj) {
                            if (false == $this->collEvents->contains($obj)) {
                                $this->collEvents->append($obj);
                            }
                        }

                        $this->collEventsPartial = true;
                    }

                    return $collEvents;
                }

                if ($partial && $this->collEvents) {
                    foreach ($this->collEvents as $obj) {
                        if ($obj->isNew()) {
                            $collEvents[] = $obj;
                        }
                    }
                }

                $this->collEvents = $collEvents;
                $this->collEventsPartial = false;
            }
        }

        return $this->collEvents;
    }

    /**
     * Sets a collection of ChildEvent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $events A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAuthGroup The current object (for fluent API support)
     */
    public function setEvents(Collection $events, ConnectionInterface $con = null)
    {
        /** @var ChildEvent[] $eventsToDelete */
        $eventsToDelete = $this->getEvents(new Criteria(), $con)->diff($events);


        $this->eventsScheduledForDeletion = $eventsToDelete;

        foreach ($eventsToDelete as $eventRemoved) {
            $eventRemoved->setAuthGroup(null);
        }

        $this->collEvents = null;
        foreach ($events as $event) {
            $this->addEvent($event);
        }

        $this->collEvents = $events;
        $this->collEventsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Event objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Event objects.
     * @throws PropelException
     */
    public function countEvents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventsPartial && !$this->isNew();
        if (null === $this->collEvents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEvents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEvents());
            }

            $query = ChildEventQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthGroup($this)
                ->count($con);
        }

        return count($this->collEvents);
    }

    /**
     * Method called to associate a ChildEvent object to this object
     * through the ChildEvent foreign key attribute.
     *
     * @param  ChildEvent $l ChildEvent
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function addEvent(ChildEvent $l)
    {
        if ($this->collEvents === null) {
            $this->initEvents();
            $this->collEventsPartial = true;
        }

        if (!$this->collEvents->contains($l)) {
            $this->doAddEvent($l);

            if ($this->eventsScheduledForDeletion and $this->eventsScheduledForDeletion->contains($l)) {
                $this->eventsScheduledForDeletion->remove($this->eventsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEvent $event The ChildEvent object to add.
     */
    protected function doAddEvent(ChildEvent $event)
    {
        $this->collEvents[]= $event;
        $event->setAuthGroup($this);
    }

    /**
     * @param  ChildEvent $event The ChildEvent object to remove.
     * @return $this|ChildAuthGroup The current object (for fluent API support)
     */
    public function removeEvent(ChildEvent $event)
    {
        if ($this->getEvents()->contains($event)) {
            $pos = $this->collEvents->search($event);
            $this->collEvents->remove($pos);
            if (null === $this->eventsScheduledForDeletion) {
                $this->eventsScheduledForDeletion = clone $this->collEvents;
                $this->eventsScheduledForDeletion->clear();
            }
            $this->eventsScheduledForDeletion[]= clone $event;
            $event->setAuthGroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AuthGroup is new, it will return
     * an empty collection; or if this AuthGroup has previously
     * been saved, it will retrieve related Events from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AuthGroup.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEvent[] List of ChildEvent objects
     */
    public function getEventsJoinLocation(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEventQuery::create(null, $criteria);
        $query->joinWith('Location', $joinBehavior);

        return $this->getEvents($query, $con);
    }

    /**
     * Clears out the collUserGroups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserGroups()
     */
    public function clearUserGroups()
    {
        $this->collUserGroups = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUserGroups collection loaded partially.
     */
    public function resetPartialUserGroups($v = true)
    {
        $this->collUserGroupsPartial = $v;
    }

    /**
     * Initializes the collUserGroups collection.
     *
     * By default this just sets the collUserGroups collection to an empty array (like clearcollUserGroups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserGroups($overrideExisting = true)
    {
        if (null !== $this->collUserGroups && !$overrideExisting) {
            return;
        }

        $collectionClassName = UserGroupTableMap::getTableMap()->getCollectionClassName();

        $this->collUserGroups = new $collectionClassName;
        $this->collUserGroups->setModel('\crwdogs\events\UserGroup');
    }

    /**
     * Gets an array of ChildUserGroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAuthGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUserGroup[] List of ChildUserGroup objects
     * @throws PropelException
     */
    public function getUserGroups(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserGroupsPartial && !$this->isNew();
        if (null === $this->collUserGroups || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserGroups) {
                // return empty collection
                $this->initUserGroups();
            } else {
                $collUserGroups = ChildUserGroupQuery::create(null, $criteria)
                    ->filterByAuthGroup($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUserGroupsPartial && count($collUserGroups)) {
                        $this->initUserGroups(false);

                        foreach ($collUserGroups as $obj) {
                            if (false == $this->collUserGroups->contains($obj)) {
                                $this->collUserGroups->append($obj);
                            }
                        }

                        $this->collUserGroupsPartial = true;
                    }

                    return $collUserGroups;
                }

                if ($partial && $this->collUserGroups) {
                    foreach ($this->collUserGroups as $obj) {
                        if ($obj->isNew()) {
                            $collUserGroups[] = $obj;
                        }
                    }
                }

                $this->collUserGroups = $collUserGroups;
                $this->collUserGroupsPartial = false;
            }
        }

        return $this->collUserGroups;
    }

    /**
     * Sets a collection of ChildUserGroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $userGroups A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAuthGroup The current object (for fluent API support)
     */
    public function setUserGroups(Collection $userGroups, ConnectionInterface $con = null)
    {
        /** @var ChildUserGroup[] $userGroupsToDelete */
        $userGroupsToDelete = $this->getUserGroups(new Criteria(), $con)->diff($userGroups);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->userGroupsScheduledForDeletion = clone $userGroupsToDelete;

        foreach ($userGroupsToDelete as $userGroupRemoved) {
            $userGroupRemoved->setAuthGroup(null);
        }

        $this->collUserGroups = null;
        foreach ($userGroups as $userGroup) {
            $this->addUserGroup($userGroup);
        }

        $this->collUserGroups = $userGroups;
        $this->collUserGroupsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserGroup objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UserGroup objects.
     * @throws PropelException
     */
    public function countUserGroups(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserGroupsPartial && !$this->isNew();
        if (null === $this->collUserGroups || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserGroups) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserGroups());
            }

            $query = ChildUserGroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAuthGroup($this)
                ->count($con);
        }

        return count($this->collUserGroups);
    }

    /**
     * Method called to associate a ChildUserGroup object to this object
     * through the ChildUserGroup foreign key attribute.
     *
     * @param  ChildUserGroup $l ChildUserGroup
     * @return $this|\crwdogs\events\AuthGroup The current object (for fluent API support)
     */
    public function addUserGroup(ChildUserGroup $l)
    {
        if ($this->collUserGroups === null) {
            $this->initUserGroups();
            $this->collUserGroupsPartial = true;
        }

        if (!$this->collUserGroups->contains($l)) {
            $this->doAddUserGroup($l);

            if ($this->userGroupsScheduledForDeletion and $this->userGroupsScheduledForDeletion->contains($l)) {
                $this->userGroupsScheduledForDeletion->remove($this->userGroupsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUserGroup $userGroup The ChildUserGroup object to add.
     */
    protected function doAddUserGroup(ChildUserGroup $userGroup)
    {
        $this->collUserGroups[]= $userGroup;
        $userGroup->setAuthGroup($this);
    }

    /**
     * @param  ChildUserGroup $userGroup The ChildUserGroup object to remove.
     * @return $this|ChildAuthGroup The current object (for fluent API support)
     */
    public function removeUserGroup(ChildUserGroup $userGroup)
    {
        if ($this->getUserGroups()->contains($userGroup)) {
            $pos = $this->collUserGroups->search($userGroup);
            $this->collUserGroups->remove($pos);
            if (null === $this->userGroupsScheduledForDeletion) {
                $this->userGroupsScheduledForDeletion = clone $this->collUserGroups;
                $this->userGroupsScheduledForDeletion->clear();
            }
            $this->userGroupsScheduledForDeletion[]= clone $userGroup;
            $userGroup->setAuthGroup(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AuthGroup is new, it will return
     * an empty collection; or if this AuthGroup has previously
     * been saved, it will retrieve related UserGroups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AuthGroup.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUserGroup[] List of ChildUserGroup objects
     */
    public function getUserGroupsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUserGroupQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getUserGroups($query, $con);
    }

    /**
     * Clears out the collUsers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsers()
     */
    public function clearUsers()
    {
        $this->collUsers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collUsers crossRef collection.
     *
     * By default this just sets the collUsers collection to an empty collection (like clearUsers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initUsers()
    {
        $collectionClassName = UserGroupTableMap::getTableMap()->getCollectionClassName();

        $this->collUsers = new $collectionClassName;
        $this->collUsersPartial = true;
        $this->collUsers->setModel('\crwdogs\events\User');
    }

    /**
     * Checks if the collUsers collection is loaded.
     *
     * @return bool
     */
    public function isUsersLoaded()
    {
        return null !== $this->collUsers;
    }

    /**
     * Gets a collection of ChildUser objects related by a many-to-many relationship
     * to the current object by way of the user_group cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAuthGroup is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildUser[] List of ChildUser objects
     */
    public function getUsers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUsersPartial && !$this->isNew();
        if (null === $this->collUsers || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collUsers) {
                    $this->initUsers();
                }
            } else {

                $query = ChildUserQuery::create(null, $criteria)
                    ->filterByAuthGroup($this);
                $collUsers = $query->find($con);
                if (null !== $criteria) {
                    return $collUsers;
                }

                if ($partial && $this->collUsers) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collUsers as $obj) {
                        if (!$collUsers->contains($obj)) {
                            $collUsers[] = $obj;
                        }
                    }
                }

                $this->collUsers = $collUsers;
                $this->collUsersPartial = false;
            }
        }

        return $this->collUsers;
    }

    /**
     * Sets a collection of User objects related by a many-to-many relationship
     * to the current object by way of the user_group cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $users A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildAuthGroup The current object (for fluent API support)
     */
    public function setUsers(Collection $users, ConnectionInterface $con = null)
    {
        $this->clearUsers();
        $currentUsers = $this->getUsers();

        $usersScheduledForDeletion = $currentUsers->diff($users);

        foreach ($usersScheduledForDeletion as $toDelete) {
            $this->removeUser($toDelete);
        }

        foreach ($users as $user) {
            if (!$currentUsers->contains($user)) {
                $this->doAddUser($user);
            }
        }

        $this->collUsersPartial = false;
        $this->collUsers = $users;

        return $this;
    }

    /**
     * Gets the number of User objects related by a many-to-many relationship
     * to the current object by way of the user_group cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related User objects
     */
    public function countUsers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUsersPartial && !$this->isNew();
        if (null === $this->collUsers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsers) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getUsers());
                }

                $query = ChildUserQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByAuthGroup($this)
                    ->count($con);
            }
        } else {
            return count($this->collUsers);
        }
    }

    /**
     * Associate a ChildUser to this object
     * through the user_group cross reference table.
     *
     * @param ChildUser $user
     * @return ChildAuthGroup The current object (for fluent API support)
     */
    public function addUser(ChildUser $user)
    {
        if ($this->collUsers === null) {
            $this->initUsers();
        }

        if (!$this->getUsers()->contains($user)) {
            // only add it if the **same** object is not already associated
            $this->collUsers->push($user);
            $this->doAddUser($user);
        }

        return $this;
    }

    /**
     *
     * @param ChildUser $user
     */
    protected function doAddUser(ChildUser $user)
    {
        $userGroup = new ChildUserGroup();

        $userGroup->setUser($user);

        $userGroup->setAuthGroup($this);

        $this->addUserGroup($userGroup);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$user->isAuthGroupsLoaded()) {
            $user->initAuthGroups();
            $user->getAuthGroups()->push($this);
        } elseif (!$user->getAuthGroups()->contains($this)) {
            $user->getAuthGroups()->push($this);
        }

    }

    /**
     * Remove user of this object
     * through the user_group cross reference table.
     *
     * @param ChildUser $user
     * @return ChildAuthGroup The current object (for fluent API support)
     */
    public function removeUser(ChildUser $user)
    {
        if ($this->getUsers()->contains($user)) {
            $userGroup = new ChildUserGroup();
            $userGroup->setUser($user);
            if ($user->isAuthGroupsLoaded()) {
                //remove the back reference if available
                $user->getAuthGroups()->removeObject($this);
            }

            $userGroup->setAuthGroup($this);
            $this->removeUserGroup(clone $userGroup);
            $userGroup->clear();

            $this->collUsers->remove($this->collUsers->search($user));

            if (null === $this->usersScheduledForDeletion) {
                $this->usersScheduledForDeletion = clone $this->collUsers;
                $this->usersScheduledForDeletion->clear();
            }

            $this->usersScheduledForDeletion->push($user);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->group_id = null;
        $this->name = null;
        $this->label = null;
        $this->comment = null;
        $this->default_group = null;
        $this->anonymous = null;
        $this->root = null;
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
            if ($this->collEvents) {
                foreach ($this->collEvents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserGroups) {
                foreach ($this->collUserGroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsers) {
                foreach ($this->collUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collEvents = null;
        $this->collUserGroups = null;
        $this->collUsers = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AuthGroupTableMap::DEFAULT_STRING_FORMAT);
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
