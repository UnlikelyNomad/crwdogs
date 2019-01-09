<?php

namespace Base;

use \Event as ChildEvent;
use \EventQuery as ChildEventQuery;
use \Question as ChildQuestion;
use \QuestionOption as ChildQuestionOption;
use \QuestionOptionQuery as ChildQuestionOptionQuery;
use \QuestionQuery as ChildQuestionQuery;
use \Response as ChildResponse;
use \ResponseQuery as ChildResponseQuery;
use \Exception;
use \PDO;
use Map\QuestionOptionTableMap;
use Map\QuestionTableMap;
use Map\ResponseTableMap;
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

/**
 * Base class that represents a row from the 'question' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Question implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\QuestionTableMap';


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
     * The value for the question_id field.
     *
     * @var        int
     */
    protected $question_id;

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
     * The value for the label field.
     *
     * @var        string
     */
    protected $label;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * The value for the sort field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $sort;

    /**
     * @var        ChildEvent
     */
    protected $aEvent;

    /**
     * @var        ObjectCollection|ChildQuestionOption[] Collection to store aggregation of ChildQuestionOption objects.
     */
    protected $collQuestionOptions;
    protected $collQuestionOptionsPartial;

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
     * @var ObjectCollection|ChildQuestionOption[]
     */
    protected $questionOptionsScheduledForDeletion = null;

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
        $this->sort = 0;
    }

    /**
     * Initializes internal state of Base\Question object.
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
     * Compares this with another <code>Question</code> instance.  If
     * <code>obj</code> is an instance of <code>Question</code>, delegates to
     * <code>equals(Question)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Question The current object, for fluid interface
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
     * Get the [question_id] column value.
     *
     * @return int
     */
    public function getQuestionId()
    {
        return $this->question_id;
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
     * Get the [label] column value.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Set the value of [question_id] column.
     *
     * @param int $v new value
     * @return $this|\Question The current object (for fluent API support)
     */
    public function setQuestionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->question_id !== $v) {
            $this->question_id = $v;
            $this->modifiedColumns[QuestionTableMap::COL_QUESTION_ID] = true;
        }

        return $this;
    } // setQuestionId()

    /**
     * Set the value of [event_id] column.
     *
     * @param int $v new value
     * @return $this|\Question The current object (for fluent API support)
     */
    public function setEventId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->event_id !== $v) {
            $this->event_id = $v;
            $this->modifiedColumns[QuestionTableMap::COL_EVENT_ID] = true;
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
     * @return $this|\Question The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[QuestionTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [label] column.
     *
     * @param string $v new value
     * @return $this|\Question The current object (for fluent API support)
     */
    public function setLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label !== $v) {
            $this->label = $v;
            $this->modifiedColumns[QuestionTableMap::COL_LABEL] = true;
        }

        return $this;
    } // setLabel()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Question The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[QuestionTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [sort] column.
     *
     * @param int $v new value
     * @return $this|\Question The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sort !== $v) {
            $this->sort = $v;
            $this->modifiedColumns[QuestionTableMap::COL_SORT] = true;
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
            if ($this->sort !== 0) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : QuestionTableMap::translateFieldName('QuestionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->question_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : QuestionTableMap::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : QuestionTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : QuestionTableMap::translateFieldName('Label', TableMap::TYPE_PHPNAME, $indexType)];
            $this->label = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : QuestionTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : QuestionTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sort = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = QuestionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Question'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(QuestionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildQuestionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aEvent = null;
            $this->collQuestionOptions = null;

            $this->collResponses = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Question::setDeleted()
     * @see Question::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildQuestionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionTableMap::DATABASE_NAME);
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
                QuestionTableMap::addInstanceToPool($this);
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

            if ($this->questionOptionsScheduledForDeletion !== null) {
                if (!$this->questionOptionsScheduledForDeletion->isEmpty()) {
                    \QuestionOptionQuery::create()
                        ->filterByPrimaryKeys($this->questionOptionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->questionOptionsScheduledForDeletion = null;
                }
            }

            if ($this->collQuestionOptions !== null) {
                foreach ($this->collQuestionOptions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->responsesScheduledForDeletion !== null) {
                if (!$this->responsesScheduledForDeletion->isEmpty()) {
                    \ResponseQuery::create()
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

        $this->modifiedColumns[QuestionTableMap::COL_QUESTION_ID] = true;
        if (null !== $this->question_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . QuestionTableMap::COL_QUESTION_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(QuestionTableMap::COL_QUESTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'question_id';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_EVENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'event_id';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_LABEL)) {
            $modifiedColumns[':p' . $index++]  = 'label';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'type';
        }
        if ($this->isColumnModified(QuestionTableMap::COL_SORT)) {
            $modifiedColumns[':p' . $index++]  = 'sort';
        }

        $sql = sprintf(
            'INSERT INTO question (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'question_id':
                        $stmt->bindValue($identifier, $this->question_id, PDO::PARAM_INT);
                        break;
                    case 'event_id':
                        $stmt->bindValue($identifier, $this->event_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'label':
                        $stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
                        break;
                    case 'type':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
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
        $this->setQuestionId($pk);

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
        $pos = QuestionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getQuestionId();
                break;
            case 1:
                return $this->getEventId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getLabel();
                break;
            case 4:
                return $this->getType();
                break;
            case 5:
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

        if (isset($alreadyDumpedObjects['Question'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Question'][$this->hashCode()] = true;
        $keys = QuestionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getQuestionId(),
            $keys[1] => $this->getEventId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getLabel(),
            $keys[4] => $this->getType(),
            $keys[5] => $this->getSort(),
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
            if (null !== $this->collQuestionOptions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'questionOptions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'question_options';
                        break;
                    default:
                        $key = 'QuestionOptions';
                }

                $result[$key] = $this->collQuestionOptions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Question
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = QuestionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Question
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setQuestionId($value);
                break;
            case 1:
                $this->setEventId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setLabel($value);
                break;
            case 4:
                $this->setType($value);
                break;
            case 5:
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
        $keys = QuestionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setQuestionId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setEventId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLabel($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setType($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSort($arr[$keys[5]]);
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
     * @return $this|\Question The current object, for fluid interface
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
        $criteria = new Criteria(QuestionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(QuestionTableMap::COL_QUESTION_ID)) {
            $criteria->add(QuestionTableMap::COL_QUESTION_ID, $this->question_id);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_EVENT_ID)) {
            $criteria->add(QuestionTableMap::COL_EVENT_ID, $this->event_id);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_NAME)) {
            $criteria->add(QuestionTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_LABEL)) {
            $criteria->add(QuestionTableMap::COL_LABEL, $this->label);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_TYPE)) {
            $criteria->add(QuestionTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(QuestionTableMap::COL_SORT)) {
            $criteria->add(QuestionTableMap::COL_SORT, $this->sort);
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
        $criteria = ChildQuestionQuery::create();
        $criteria->add(QuestionTableMap::COL_QUESTION_ID, $this->question_id);

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
        $validPk = null !== $this->getQuestionId();

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
        return $this->getQuestionId();
    }

    /**
     * Generic method to set the primary key (question_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setQuestionId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getQuestionId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Question (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setEventId($this->getEventId());
        $copyObj->setName($this->getName());
        $copyObj->setLabel($this->getLabel());
        $copyObj->setType($this->getType());
        $copyObj->setSort($this->getSort());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getQuestionOptions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuestionOption($relObj->copy($deepCopy));
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
            $copyObj->setQuestionId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Question Clone of current object.
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
     * @return $this|\Question The current object (for fluent API support)
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
            $v->addQuestion($this);
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
                $this->aEvent->addQuestions($this);
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
        if ('QuestionOption' == $relationName) {
            $this->initQuestionOptions();
            return;
        }
        if ('Response' == $relationName) {
            $this->initResponses();
            return;
        }
    }

    /**
     * Clears out the collQuestionOptions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuestionOptions()
     */
    public function clearQuestionOptions()
    {
        $this->collQuestionOptions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collQuestionOptions collection loaded partially.
     */
    public function resetPartialQuestionOptions($v = true)
    {
        $this->collQuestionOptionsPartial = $v;
    }

    /**
     * Initializes the collQuestionOptions collection.
     *
     * By default this just sets the collQuestionOptions collection to an empty array (like clearcollQuestionOptions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuestionOptions($overrideExisting = true)
    {
        if (null !== $this->collQuestionOptions && !$overrideExisting) {
            return;
        }

        $collectionClassName = QuestionOptionTableMap::getTableMap()->getCollectionClassName();

        $this->collQuestionOptions = new $collectionClassName;
        $this->collQuestionOptions->setModel('\QuestionOption');
    }

    /**
     * Gets an array of ChildQuestionOption objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildQuestion is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildQuestionOption[] List of ChildQuestionOption objects
     * @throws PropelException
     */
    public function getQuestionOptions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionOptionsPartial && !$this->isNew();
        if (null === $this->collQuestionOptions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuestionOptions) {
                // return empty collection
                $this->initQuestionOptions();
            } else {
                $collQuestionOptions = ChildQuestionOptionQuery::create(null, $criteria)
                    ->filterByQuestion($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collQuestionOptionsPartial && count($collQuestionOptions)) {
                        $this->initQuestionOptions(false);

                        foreach ($collQuestionOptions as $obj) {
                            if (false == $this->collQuestionOptions->contains($obj)) {
                                $this->collQuestionOptions->append($obj);
                            }
                        }

                        $this->collQuestionOptionsPartial = true;
                    }

                    return $collQuestionOptions;
                }

                if ($partial && $this->collQuestionOptions) {
                    foreach ($this->collQuestionOptions as $obj) {
                        if ($obj->isNew()) {
                            $collQuestionOptions[] = $obj;
                        }
                    }
                }

                $this->collQuestionOptions = $collQuestionOptions;
                $this->collQuestionOptionsPartial = false;
            }
        }

        return $this->collQuestionOptions;
    }

    /**
     * Sets a collection of ChildQuestionOption objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $questionOptions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function setQuestionOptions(Collection $questionOptions, ConnectionInterface $con = null)
    {
        /** @var ChildQuestionOption[] $questionOptionsToDelete */
        $questionOptionsToDelete = $this->getQuestionOptions(new Criteria(), $con)->diff($questionOptions);


        $this->questionOptionsScheduledForDeletion = $questionOptionsToDelete;

        foreach ($questionOptionsToDelete as $questionOptionRemoved) {
            $questionOptionRemoved->setQuestion(null);
        }

        $this->collQuestionOptions = null;
        foreach ($questionOptions as $questionOption) {
            $this->addQuestionOption($questionOption);
        }

        $this->collQuestionOptions = $questionOptions;
        $this->collQuestionOptionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related QuestionOption objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related QuestionOption objects.
     * @throws PropelException
     */
    public function countQuestionOptions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionOptionsPartial && !$this->isNew();
        if (null === $this->collQuestionOptions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuestionOptions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getQuestionOptions());
            }

            $query = ChildQuestionOptionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByQuestion($this)
                ->count($con);
        }

        return count($this->collQuestionOptions);
    }

    /**
     * Method called to associate a ChildQuestionOption object to this object
     * through the ChildQuestionOption foreign key attribute.
     *
     * @param  ChildQuestionOption $l ChildQuestionOption
     * @return $this|\Question The current object (for fluent API support)
     */
    public function addQuestionOption(ChildQuestionOption $l)
    {
        if ($this->collQuestionOptions === null) {
            $this->initQuestionOptions();
            $this->collQuestionOptionsPartial = true;
        }

        if (!$this->collQuestionOptions->contains($l)) {
            $this->doAddQuestionOption($l);

            if ($this->questionOptionsScheduledForDeletion and $this->questionOptionsScheduledForDeletion->contains($l)) {
                $this->questionOptionsScheduledForDeletion->remove($this->questionOptionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildQuestionOption $questionOption The ChildQuestionOption object to add.
     */
    protected function doAddQuestionOption(ChildQuestionOption $questionOption)
    {
        $this->collQuestionOptions[]= $questionOption;
        $questionOption->setQuestion($this);
    }

    /**
     * @param  ChildQuestionOption $questionOption The ChildQuestionOption object to remove.
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function removeQuestionOption(ChildQuestionOption $questionOption)
    {
        if ($this->getQuestionOptions()->contains($questionOption)) {
            $pos = $this->collQuestionOptions->search($questionOption);
            $this->collQuestionOptions->remove($pos);
            if (null === $this->questionOptionsScheduledForDeletion) {
                $this->questionOptionsScheduledForDeletion = clone $this->collQuestionOptions;
                $this->questionOptionsScheduledForDeletion->clear();
            }
            $this->questionOptionsScheduledForDeletion[]= clone $questionOption;
            $questionOption->setQuestion(null);
        }

        return $this;
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
        $this->collResponses->setModel('\Response');
    }

    /**
     * Gets an array of ChildResponse objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildQuestion is new, it will return
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
                    ->filterByQuestion($this)
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
     * @return $this|ChildQuestion The current object (for fluent API support)
     */
    public function setResponses(Collection $responses, ConnectionInterface $con = null)
    {
        /** @var ChildResponse[] $responsesToDelete */
        $responsesToDelete = $this->getResponses(new Criteria(), $con)->diff($responses);


        $this->responsesScheduledForDeletion = $responsesToDelete;

        foreach ($responsesToDelete as $responseRemoved) {
            $responseRemoved->setQuestion(null);
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
                ->filterByQuestion($this)
                ->count($con);
        }

        return count($this->collResponses);
    }

    /**
     * Method called to associate a ChildResponse object to this object
     * through the ChildResponse foreign key attribute.
     *
     * @param  ChildResponse $l ChildResponse
     * @return $this|\Question The current object (for fluent API support)
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
        $response->setQuestion($this);
    }

    /**
     * @param  ChildResponse $response The ChildResponse object to remove.
     * @return $this|ChildQuestion The current object (for fluent API support)
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
            $response->setQuestion(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Question is new, it will return
     * an empty collection; or if this Question has previously
     * been saved, it will retrieve related Responses from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Question.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildResponse[] List of ChildResponse objects
     */
    public function getResponsesJoinRegistration(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildResponseQuery::create(null, $criteria);
        $query->joinWith('Registration', $joinBehavior);

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
            $this->aEvent->removeQuestion($this);
        }
        $this->question_id = null;
        $this->event_id = null;
        $this->name = null;
        $this->label = null;
        $this->type = null;
        $this->sort = null;
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
            if ($this->collQuestionOptions) {
                foreach ($this->collQuestionOptions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collResponses) {
                foreach ($this->collResponses as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collQuestionOptions = null;
        $this->collResponses = null;
        $this->aEvent = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(QuestionTableMap::DEFAULT_STRING_FORMAT);
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
