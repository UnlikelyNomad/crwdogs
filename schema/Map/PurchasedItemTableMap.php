<?php

namespace Map;

use \PurchasedItem;
use \PurchasedItemQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'purchased_item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PurchasedItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PurchasedItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'purchased_item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PurchasedItem';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PurchasedItem';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the purchase_id field
     */
    const COL_PURCHASE_ID = 'purchased_item.purchase_id';

    /**
     * the column name for the registration_id field
     */
    const COL_REGISTRATION_ID = 'purchased_item.registration_id';

    /**
     * the column name for the qty field
     */
    const COL_QTY = 'purchased_item.qty';

    /**
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'purchased_item.item_id';

    /**
     * the column name for the unit_cost field
     */
    const COL_UNIT_COST = 'purchased_item.unit_cost';

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
        self::TYPE_PHPNAME       => array('PurchaseId', 'RegistrationId', 'Qty', 'ItemId', 'UnitCost', ),
        self::TYPE_CAMELNAME     => array('purchaseId', 'registrationId', 'qty', 'itemId', 'unitCost', ),
        self::TYPE_COLNAME       => array(PurchasedItemTableMap::COL_PURCHASE_ID, PurchasedItemTableMap::COL_REGISTRATION_ID, PurchasedItemTableMap::COL_QTY, PurchasedItemTableMap::COL_ITEM_ID, PurchasedItemTableMap::COL_UNIT_COST, ),
        self::TYPE_FIELDNAME     => array('purchase_id', 'registration_id', 'qty', 'item_id', 'unit_cost', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PurchaseId' => 0, 'RegistrationId' => 1, 'Qty' => 2, 'ItemId' => 3, 'UnitCost' => 4, ),
        self::TYPE_CAMELNAME     => array('purchaseId' => 0, 'registrationId' => 1, 'qty' => 2, 'itemId' => 3, 'unitCost' => 4, ),
        self::TYPE_COLNAME       => array(PurchasedItemTableMap::COL_PURCHASE_ID => 0, PurchasedItemTableMap::COL_REGISTRATION_ID => 1, PurchasedItemTableMap::COL_QTY => 2, PurchasedItemTableMap::COL_ITEM_ID => 3, PurchasedItemTableMap::COL_UNIT_COST => 4, ),
        self::TYPE_FIELDNAME     => array('purchase_id' => 0, 'registration_id' => 1, 'qty' => 2, 'item_id' => 3, 'unit_cost' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('purchased_item');
        $this->setPhpName('PurchasedItem');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PurchasedItem');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('purchase_id', 'PurchaseId', 'INTEGER', true, null, null);
        $this->addForeignKey('registration_id', 'RegistrationId', 'INTEGER', 'registration', 'registration_id', true, null, null);
        $this->addColumn('qty', 'Qty', 'INTEGER', true, null, null);
        $this->addForeignKey('item_id', 'ItemId', 'INTEGER', 'item', 'item_id', true, null, null);
        $this->addColumn('unit_cost', 'UnitCost', 'DECIMAL', true, 6, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Item', '\\Item', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':item_id',
    1 => ':item_id',
  ),
), null, null, null, false);
        $this->addRelation('Registration', '\\Registration', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':registration_id',
    1 => ':registration_id',
  ),
), null, null, null, false);
        $this->addRelation('RegistrationOption', '\\RegistrationOption', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':purchase_id',
    1 => ':purchase_id',
  ),
), null, null, 'RegistrationOptions', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PurchaseId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PurchaseId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PurchaseId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PurchaseId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PurchaseId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PurchaseId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PurchaseId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PurchasedItemTableMap::CLASS_DEFAULT : PurchasedItemTableMap::OM_CLASS;
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
     * @return array           (PurchasedItem object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PurchasedItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PurchasedItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PurchasedItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PurchasedItemTableMap::OM_CLASS;
            /** @var PurchasedItem $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PurchasedItemTableMap::addInstanceToPool($obj, $key);
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
            $key = PurchasedItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PurchasedItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PurchasedItem $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PurchasedItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PurchasedItemTableMap::COL_PURCHASE_ID);
            $criteria->addSelectColumn(PurchasedItemTableMap::COL_REGISTRATION_ID);
            $criteria->addSelectColumn(PurchasedItemTableMap::COL_QTY);
            $criteria->addSelectColumn(PurchasedItemTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(PurchasedItemTableMap::COL_UNIT_COST);
        } else {
            $criteria->addSelectColumn($alias . '.purchase_id');
            $criteria->addSelectColumn($alias . '.registration_id');
            $criteria->addSelectColumn($alias . '.qty');
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.unit_cost');
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
        return Propel::getServiceContainer()->getDatabaseMap(PurchasedItemTableMap::DATABASE_NAME)->getTable(PurchasedItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PurchasedItemTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PurchasedItemTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PurchasedItemTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PurchasedItem or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PurchasedItem object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PurchasedItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PurchasedItem) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PurchasedItemTableMap::DATABASE_NAME);
            $criteria->add(PurchasedItemTableMap::COL_PURCHASE_ID, (array) $values, Criteria::IN);
        }

        $query = PurchasedItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PurchasedItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PurchasedItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the purchased_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PurchasedItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PurchasedItem or Criteria object.
     *
     * @param mixed               $criteria Criteria or PurchasedItem object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchasedItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PurchasedItem object
        }

        if ($criteria->containsKey(PurchasedItemTableMap::COL_PURCHASE_ID) && $criteria->keyContainsValue(PurchasedItemTableMap::COL_PURCHASE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PurchasedItemTableMap::COL_PURCHASE_ID.')');
        }


        // Set the correct dbName
        $query = PurchasedItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PurchasedItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PurchasedItemTableMap::buildTableMap();
