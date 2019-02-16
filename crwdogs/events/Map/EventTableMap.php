<?php

namespace crwdogs\events\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use crwdogs\events\Event;
use crwdogs\events\EventQuery;


/**
 * This class defines the structure of the 'event' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class EventTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'crwdogs.events.Map.EventTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'event';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\crwdogs\\events\\Event';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'crwdogs.events.Event';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the event_id field
     */
    const COL_EVENT_ID = 'event.event_id';

    /**
     * the column name for the location_id field
     */
    const COL_LOCATION_ID = 'event.location_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'event.name';

    /**
     * the column name for the start_date field
     */
    const COL_START_DATE = 'event.start_date';

    /**
     * the column name for the end_date field
     */
    const COL_END_DATE = 'event.end_date';

    /**
     * the column name for the include_time field
     */
    const COL_INCLUDE_TIME = 'event.include_time';

    /**
     * the column name for the start_time field
     */
    const COL_START_TIME = 'event.start_time';

    /**
     * the column name for the end_time field
     */
    const COL_END_TIME = 'event.end_time';

    /**
     * the column name for the info field
     */
    const COL_INFO = 'event.info';

    /**
     * the column name for the reg_start field
     */
    const COL_REG_START = 'event.reg_start';

    /**
     * the column name for the reg_end field
     */
    const COL_REG_END = 'event.reg_end';

    /**
     * the column name for the reg_cost field
     */
    const COL_REG_COST = 'event.reg_cost';

    /**
     * the column name for the paypal_email field
     */
    const COL_PAYPAL_EMAIL = 'event.paypal_email';

    /**
     * the column name for the notify_email field
     */
    const COL_NOTIFY_EMAIL = 'event.notify_email';

    /**
     * the column name for the owning_group field
     */
    const COL_OWNING_GROUP = 'event.owning_group';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('EventId', 'LocationId', 'Name', 'StartDate', 'EndDate', 'IncludeTime', 'StartTime', 'EndTime', 'Info', 'RegStart', 'RegEnd', 'RegCost', 'PaypalEmail', 'NotifyEmail', 'OwningGroup', ),
        self::TYPE_CAMELNAME     => array('eventId', 'locationId', 'name', 'startDate', 'endDate', 'includeTime', 'startTime', 'endTime', 'info', 'regStart', 'regEnd', 'regCost', 'paypalEmail', 'notifyEmail', 'owningGroup', ),
        self::TYPE_COLNAME       => array(EventTableMap::COL_EVENT_ID, EventTableMap::COL_LOCATION_ID, EventTableMap::COL_NAME, EventTableMap::COL_START_DATE, EventTableMap::COL_END_DATE, EventTableMap::COL_INCLUDE_TIME, EventTableMap::COL_START_TIME, EventTableMap::COL_END_TIME, EventTableMap::COL_INFO, EventTableMap::COL_REG_START, EventTableMap::COL_REG_END, EventTableMap::COL_REG_COST, EventTableMap::COL_PAYPAL_EMAIL, EventTableMap::COL_NOTIFY_EMAIL, EventTableMap::COL_OWNING_GROUP, ),
        self::TYPE_FIELDNAME     => array('event_id', 'location_id', 'name', 'start_date', 'end_date', 'include_time', 'start_time', 'end_time', 'info', 'reg_start', 'reg_end', 'reg_cost', 'paypal_email', 'notify_email', 'owning_group', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('EventId' => 0, 'LocationId' => 1, 'Name' => 2, 'StartDate' => 3, 'EndDate' => 4, 'IncludeTime' => 5, 'StartTime' => 6, 'EndTime' => 7, 'Info' => 8, 'RegStart' => 9, 'RegEnd' => 10, 'RegCost' => 11, 'PaypalEmail' => 12, 'NotifyEmail' => 13, 'OwningGroup' => 14, ),
        self::TYPE_CAMELNAME     => array('eventId' => 0, 'locationId' => 1, 'name' => 2, 'startDate' => 3, 'endDate' => 4, 'includeTime' => 5, 'startTime' => 6, 'endTime' => 7, 'info' => 8, 'regStart' => 9, 'regEnd' => 10, 'regCost' => 11, 'paypalEmail' => 12, 'notifyEmail' => 13, 'owningGroup' => 14, ),
        self::TYPE_COLNAME       => array(EventTableMap::COL_EVENT_ID => 0, EventTableMap::COL_LOCATION_ID => 1, EventTableMap::COL_NAME => 2, EventTableMap::COL_START_DATE => 3, EventTableMap::COL_END_DATE => 4, EventTableMap::COL_INCLUDE_TIME => 5, EventTableMap::COL_START_TIME => 6, EventTableMap::COL_END_TIME => 7, EventTableMap::COL_INFO => 8, EventTableMap::COL_REG_START => 9, EventTableMap::COL_REG_END => 10, EventTableMap::COL_REG_COST => 11, EventTableMap::COL_PAYPAL_EMAIL => 12, EventTableMap::COL_NOTIFY_EMAIL => 13, EventTableMap::COL_OWNING_GROUP => 14, ),
        self::TYPE_FIELDNAME     => array('event_id' => 0, 'location_id' => 1, 'name' => 2, 'start_date' => 3, 'end_date' => 4, 'include_time' => 5, 'start_time' => 6, 'end_time' => 7, 'info' => 8, 'reg_start' => 9, 'reg_end' => 10, 'reg_cost' => 11, 'paypal_email' => 12, 'notify_email' => 13, 'owning_group' => 14, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('event');
        $this->setPhpName('Event');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\crwdogs\\events\\Event');
        $this->setPackage('crwdogs.events');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('event_id', 'EventId', 'INTEGER', true, null, null);
        $this->addForeignKey('location_id', 'LocationId', 'INTEGER', 'location', 'location_id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('start_date', 'StartDate', 'DATE', true, null, null);
        $this->addColumn('end_date', 'EndDate', 'DATE', true, null, null);
        $this->addColumn('include_time', 'IncludeTime', 'VARCHAR', true, 1, null);
        $this->addColumn('start_time', 'StartTime', 'TIME', true, null, null);
        $this->addColumn('end_time', 'EndTime', 'TIME', true, null, null);
        $this->addColumn('info', 'Info', 'LONGVARCHAR', true, null, null);
        $this->addColumn('reg_start', 'RegStart', 'DATE', true, null, null);
        $this->addColumn('reg_end', 'RegEnd', 'DATE', true, null, null);
        $this->addColumn('reg_cost', 'RegCost', 'DECIMAL', true, 6, null);
        $this->addColumn('paypal_email', 'PaypalEmail', 'VARCHAR', true, 255, null);
        $this->addColumn('notify_email', 'NotifyEmail', 'VARCHAR', true, 255, null);
        $this->addForeignKey('owning_group', 'OwningGroup', 'INTEGER', 'auth_group', 'group_id', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Location', '\\crwdogs\\events\\Location', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':location_id',
    1 => ':location_id',
  ),
), null, null, null, false);
        $this->addRelation('AuthGroup', '\\crwdogs\\events\\AuthGroup', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':owning_group',
    1 => ':group_id',
  ),
), null, null, null, false);
        $this->addRelation('EarlyDiscount', '\\crwdogs\\events\\EarlyDiscount', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':event_id',
    1 => ':event_id',
  ),
), null, null, 'EarlyDiscounts', false);
        $this->addRelation('Item', '\\crwdogs\\events\\Item', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':event_id',
    1 => ':event_id',
  ),
), null, null, 'Items', false);
        $this->addRelation('Question', '\\crwdogs\\events\\Question', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':event_id',
    1 => ':event_id',
  ),
), null, null, 'Questions', false);
        $this->addRelation('Registration', '\\crwdogs\\events\\Registration', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':event_id',
    1 => ':event_id',
  ),
), null, null, 'Registrations', false);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('EventId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? EventTableMap::CLASS_DEFAULT : EventTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Event object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EventTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EventTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EventTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EventTableMap::OM_CLASS;
            /** @var Event $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EventTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = EventTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EventTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Event $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EventTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(EventTableMap::COL_EVENT_ID);
            $criteria->addSelectColumn(EventTableMap::COL_LOCATION_ID);
            $criteria->addSelectColumn(EventTableMap::COL_NAME);
            $criteria->addSelectColumn(EventTableMap::COL_START_DATE);
            $criteria->addSelectColumn(EventTableMap::COL_END_DATE);
            $criteria->addSelectColumn(EventTableMap::COL_INCLUDE_TIME);
            $criteria->addSelectColumn(EventTableMap::COL_START_TIME);
            $criteria->addSelectColumn(EventTableMap::COL_END_TIME);
            $criteria->addSelectColumn(EventTableMap::COL_INFO);
            $criteria->addSelectColumn(EventTableMap::COL_REG_START);
            $criteria->addSelectColumn(EventTableMap::COL_REG_END);
            $criteria->addSelectColumn(EventTableMap::COL_REG_COST);
            $criteria->addSelectColumn(EventTableMap::COL_PAYPAL_EMAIL);
            $criteria->addSelectColumn(EventTableMap::COL_NOTIFY_EMAIL);
            $criteria->addSelectColumn(EventTableMap::COL_OWNING_GROUP);
        } else {
            $criteria->addSelectColumn($alias . '.event_id');
            $criteria->addSelectColumn($alias . '.location_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.start_date');
            $criteria->addSelectColumn($alias . '.end_date');
            $criteria->addSelectColumn($alias . '.include_time');
            $criteria->addSelectColumn($alias . '.start_time');
            $criteria->addSelectColumn($alias . '.end_time');
            $criteria->addSelectColumn($alias . '.info');
            $criteria->addSelectColumn($alias . '.reg_start');
            $criteria->addSelectColumn($alias . '.reg_end');
            $criteria->addSelectColumn($alias . '.reg_cost');
            $criteria->addSelectColumn($alias . '.paypal_email');
            $criteria->addSelectColumn($alias . '.notify_email');
            $criteria->addSelectColumn($alias . '.owning_group');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(EventTableMap::DATABASE_NAME)->getTable(EventTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EventTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EventTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EventTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Event or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Event object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \crwdogs\events\Event) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EventTableMap::DATABASE_NAME);
            $criteria->add(EventTableMap::COL_EVENT_ID, (array) $values, Criteria::IN);
        }

        $query = EventQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EventTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EventTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the event table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EventQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Event or Criteria object.
     *
     * @param mixed               $criteria Criteria or Event object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Event object
        }

        if ($criteria->containsKey(EventTableMap::COL_EVENT_ID) && $criteria->keyContainsValue(EventTableMap::COL_EVENT_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.EventTableMap::COL_EVENT_ID.')');
        }


        // Set the correct dbName
        $query = EventQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EventTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EventTableMap::buildTableMap();
