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
use crwdogs\events\AuthGroup;
use crwdogs\events\AuthGroupQuery;


/**
 * This class defines the structure of the 'auth_group' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AuthGroupTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'crwdogs.events.Map.AuthGroupTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'auth_group';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\crwdogs\\events\\AuthGroup';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'crwdogs.events.AuthGroup';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the group_id field
     */
    const COL_GROUP_ID = 'auth_group.group_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'auth_group.name';

    /**
     * the column name for the label field
     */
    const COL_LABEL = 'auth_group.label';

    /**
     * the column name for the comment field
     */
    const COL_COMMENT = 'auth_group.comment';

    /**
     * the column name for the default_group field
     */
    const COL_DEFAULT_GROUP = 'auth_group.default_group';

    /**
     * the column name for the anonymous field
     */
    const COL_ANONYMOUS = 'auth_group.anonymous';

    /**
     * the column name for the root field
     */
    const COL_ROOT = 'auth_group.root';

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
        self::TYPE_PHPNAME       => array('GroupId', 'Name', 'Label', 'Comment', 'DefaultGroup', 'Anonymous', 'Root', ),
        self::TYPE_CAMELNAME     => array('groupId', 'name', 'label', 'comment', 'defaultGroup', 'anonymous', 'root', ),
        self::TYPE_COLNAME       => array(AuthGroupTableMap::COL_GROUP_ID, AuthGroupTableMap::COL_NAME, AuthGroupTableMap::COL_LABEL, AuthGroupTableMap::COL_COMMENT, AuthGroupTableMap::COL_DEFAULT_GROUP, AuthGroupTableMap::COL_ANONYMOUS, AuthGroupTableMap::COL_ROOT, ),
        self::TYPE_FIELDNAME     => array('group_id', 'name', 'label', 'comment', 'default_group', 'anonymous', 'root', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('GroupId' => 0, 'Name' => 1, 'Label' => 2, 'Comment' => 3, 'DefaultGroup' => 4, 'Anonymous' => 5, 'Root' => 6, ),
        self::TYPE_CAMELNAME     => array('groupId' => 0, 'name' => 1, 'label' => 2, 'comment' => 3, 'defaultGroup' => 4, 'anonymous' => 5, 'root' => 6, ),
        self::TYPE_COLNAME       => array(AuthGroupTableMap::COL_GROUP_ID => 0, AuthGroupTableMap::COL_NAME => 1, AuthGroupTableMap::COL_LABEL => 2, AuthGroupTableMap::COL_COMMENT => 3, AuthGroupTableMap::COL_DEFAULT_GROUP => 4, AuthGroupTableMap::COL_ANONYMOUS => 5, AuthGroupTableMap::COL_ROOT => 6, ),
        self::TYPE_FIELDNAME     => array('group_id' => 0, 'name' => 1, 'label' => 2, 'comment' => 3, 'default_group' => 4, 'anonymous' => 5, 'root' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('auth_group');
        $this->setPhpName('AuthGroup');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\crwdogs\\events\\AuthGroup');
        $this->setPackage('crwdogs.events');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('group_id', 'GroupId', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 40, null);
        $this->addColumn('label', 'Label', 'VARCHAR', true, 255, null);
        $this->addColumn('comment', 'Comment', 'LONGVARCHAR', true, null, null);
        $this->addColumn('default_group', 'DefaultGroup', 'VARCHAR', true, 1, null);
        $this->addColumn('anonymous', 'Anonymous', 'VARCHAR', true, 1, null);
        $this->addColumn('root', 'Root', 'VARCHAR', true, 1, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Event', '\\crwdogs\\events\\Event', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':owning_group',
    1 => ':group_id',
  ),
), null, null, 'Events', false);
        $this->addRelation('UserGroup', '\\crwdogs\\events\\UserGroup', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':group_id',
    1 => ':group_id',
  ),
), null, null, 'UserGroups', false);
        $this->addRelation('User', '\\crwdogs\\events\\User', RelationMap::MANY_TO_MANY, array(), null, null, 'Users');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('GroupId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AuthGroupTableMap::CLASS_DEFAULT : AuthGroupTableMap::OM_CLASS;
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
     * @return array           (AuthGroup object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AuthGroupTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AuthGroupTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AuthGroupTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AuthGroupTableMap::OM_CLASS;
            /** @var AuthGroup $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AuthGroupTableMap::addInstanceToPool($obj, $key);
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
            $key = AuthGroupTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AuthGroupTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AuthGroup $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AuthGroupTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AuthGroupTableMap::COL_GROUP_ID);
            $criteria->addSelectColumn(AuthGroupTableMap::COL_NAME);
            $criteria->addSelectColumn(AuthGroupTableMap::COL_LABEL);
            $criteria->addSelectColumn(AuthGroupTableMap::COL_COMMENT);
            $criteria->addSelectColumn(AuthGroupTableMap::COL_DEFAULT_GROUP);
            $criteria->addSelectColumn(AuthGroupTableMap::COL_ANONYMOUS);
            $criteria->addSelectColumn(AuthGroupTableMap::COL_ROOT);
        } else {
            $criteria->addSelectColumn($alias . '.group_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.label');
            $criteria->addSelectColumn($alias . '.comment');
            $criteria->addSelectColumn($alias . '.default_group');
            $criteria->addSelectColumn($alias . '.anonymous');
            $criteria->addSelectColumn($alias . '.root');
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
        return Propel::getServiceContainer()->getDatabaseMap(AuthGroupTableMap::DATABASE_NAME)->getTable(AuthGroupTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AuthGroupTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AuthGroupTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AuthGroupTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a AuthGroup or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AuthGroup object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AuthGroupTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \crwdogs\events\AuthGroup) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AuthGroupTableMap::DATABASE_NAME);
            $criteria->add(AuthGroupTableMap::COL_GROUP_ID, (array) $values, Criteria::IN);
        }

        $query = AuthGroupQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AuthGroupTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AuthGroupTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the auth_group table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AuthGroupQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AuthGroup or Criteria object.
     *
     * @param mixed               $criteria Criteria or AuthGroup object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuthGroupTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AuthGroup object
        }

        if ($criteria->containsKey(AuthGroupTableMap::COL_GROUP_ID) && $criteria->keyContainsValue(AuthGroupTableMap::COL_GROUP_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AuthGroupTableMap::COL_GROUP_ID.')');
        }


        // Set the correct dbName
        $query = AuthGroupQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AuthGroupTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AuthGroupTableMap::buildTableMap();
