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
use crwdogs\events\Item;
use crwdogs\events\ItemQuery;


/**
 * This class defines the structure of the 'item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'crwdogs.events.Map.ItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\crwdogs\\events\\Item';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'crwdogs.events.Item';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'item.item_id';

    /**
     * the column name for the event_id field
     */
    const COL_EVENT_ID = 'item.event_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'item.name';

    /**
     * the column name for the qty_type field
     */
    const COL_QTY_TYPE = 'item.qty_type';

    /**
     * the column name for the min_qty field
     */
    const COL_MIN_QTY = 'item.min_qty';

    /**
     * the column name for the max_qty field
     */
    const COL_MAX_QTY = 'item.max_qty';

    /**
     * the column name for the event_qty field
     */
    const COL_EVENT_QTY = 'item.event_qty';

    /**
     * the column name for the image field
     */
    const COL_IMAGE = 'item.image';

    /**
     * the column name for the label field
     */
    const COL_LABEL = 'item.label';

    /**
     * the column name for the base_cost field
     */
    const COL_BASE_COST = 'item.base_cost';

    /**
     * the column name for the multiple_variations field
     */
    const COL_MULTIPLE_VARIATIONS = 'item.multiple_variations';

    /**
     * the column name for the qty_label field
     */
    const COL_QTY_LABEL = 'item.qty_label';

    /**
     * the column name for the cost_label field
     */
    const COL_COST_LABEL = 'item.cost_label';

    /**
     * the column name for the sort field
     */
    const COL_SORT = 'item.sort';

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
        self::TYPE_PHPNAME       => array('ItemId', 'EventId', 'Name', 'QtyType', 'MinQty', 'MaxQty', 'EventQty', 'Image', 'Label', 'BaseCost', 'MultipleVariations', 'QtyLabel', 'CostLabel', 'Sort', ),
        self::TYPE_CAMELNAME     => array('itemId', 'eventId', 'name', 'qtyType', 'minQty', 'maxQty', 'eventQty', 'image', 'label', 'baseCost', 'multipleVariations', 'qtyLabel', 'costLabel', 'sort', ),
        self::TYPE_COLNAME       => array(ItemTableMap::COL_ITEM_ID, ItemTableMap::COL_EVENT_ID, ItemTableMap::COL_NAME, ItemTableMap::COL_QTY_TYPE, ItemTableMap::COL_MIN_QTY, ItemTableMap::COL_MAX_QTY, ItemTableMap::COL_EVENT_QTY, ItemTableMap::COL_IMAGE, ItemTableMap::COL_LABEL, ItemTableMap::COL_BASE_COST, ItemTableMap::COL_MULTIPLE_VARIATIONS, ItemTableMap::COL_QTY_LABEL, ItemTableMap::COL_COST_LABEL, ItemTableMap::COL_SORT, ),
        self::TYPE_FIELDNAME     => array('item_id', 'event_id', 'name', 'qty_type', 'min_qty', 'max_qty', 'event_qty', 'image', 'label', 'base_cost', 'multiple_variations', 'qty_label', 'cost_label', 'sort', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ItemId' => 0, 'EventId' => 1, 'Name' => 2, 'QtyType' => 3, 'MinQty' => 4, 'MaxQty' => 5, 'EventQty' => 6, 'Image' => 7, 'Label' => 8, 'BaseCost' => 9, 'MultipleVariations' => 10, 'QtyLabel' => 11, 'CostLabel' => 12, 'Sort' => 13, ),
        self::TYPE_CAMELNAME     => array('itemId' => 0, 'eventId' => 1, 'name' => 2, 'qtyType' => 3, 'minQty' => 4, 'maxQty' => 5, 'eventQty' => 6, 'image' => 7, 'label' => 8, 'baseCost' => 9, 'multipleVariations' => 10, 'qtyLabel' => 11, 'costLabel' => 12, 'sort' => 13, ),
        self::TYPE_COLNAME       => array(ItemTableMap::COL_ITEM_ID => 0, ItemTableMap::COL_EVENT_ID => 1, ItemTableMap::COL_NAME => 2, ItemTableMap::COL_QTY_TYPE => 3, ItemTableMap::COL_MIN_QTY => 4, ItemTableMap::COL_MAX_QTY => 5, ItemTableMap::COL_EVENT_QTY => 6, ItemTableMap::COL_IMAGE => 7, ItemTableMap::COL_LABEL => 8, ItemTableMap::COL_BASE_COST => 9, ItemTableMap::COL_MULTIPLE_VARIATIONS => 10, ItemTableMap::COL_QTY_LABEL => 11, ItemTableMap::COL_COST_LABEL => 12, ItemTableMap::COL_SORT => 13, ),
        self::TYPE_FIELDNAME     => array('item_id' => 0, 'event_id' => 1, 'name' => 2, 'qty_type' => 3, 'min_qty' => 4, 'max_qty' => 5, 'event_qty' => 6, 'image' => 7, 'label' => 8, 'base_cost' => 9, 'multiple_variations' => 10, 'qty_label' => 11, 'cost_label' => 12, 'sort' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
        $this->setName('item');
        $this->setPhpName('Item');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\crwdogs\\events\\Item');
        $this->setPackage('crwdogs.events');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('item_id', 'ItemId', 'INTEGER', true, null, null);
        $this->addForeignKey('event_id', 'EventId', 'INTEGER', 'event', 'event_id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 45, null);
        $this->addColumn('qty_type', 'QtyType', 'VARCHAR', true, 45, null);
        $this->addColumn('min_qty', 'MinQty', 'INTEGER', true, null, null);
        $this->addColumn('max_qty', 'MaxQty', 'INTEGER', true, null, null);
        $this->addColumn('event_qty', 'EventQty', 'INTEGER', true, null, 0);
        $this->addColumn('image', 'Image', 'VARCHAR', true, 255, null);
        $this->addColumn('label', 'Label', 'VARCHAR', true, 45, null);
        $this->addColumn('base_cost', 'BaseCost', 'DECIMAL', true, 6, 0);
        $this->addColumn('multiple_variations', 'MultipleVariations', 'VARCHAR', true, 1, null);
        $this->addColumn('qty_label', 'QtyLabel', 'VARCHAR', true, 20, null);
        $this->addColumn('cost_label', 'CostLabel', 'VARCHAR', true, 20, null);
        $this->addColumn('sort', 'Sort', 'INTEGER', true, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Event', '\\crwdogs\\events\\Event', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':event_id',
    1 => ':event_id',
  ),
), null, null, null, false);
        $this->addRelation('ItemOption', '\\crwdogs\\events\\ItemOption', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':item_id',
    1 => ':item_id',
  ),
), null, null, 'ItemOptions', false);
        $this->addRelation('PurchasedItem', '\\crwdogs\\events\\PurchasedItem', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':item_id',
    1 => ':item_id',
  ),
), null, null, 'PurchasedItems', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ItemTableMap::CLASS_DEFAULT : ItemTableMap::OM_CLASS;
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
     * @return array           (Item object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ItemTableMap::OM_CLASS;
            /** @var Item $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ItemTableMap::addInstanceToPool($obj, $key);
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
            $key = ItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Item $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ItemTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(ItemTableMap::COL_EVENT_ID);
            $criteria->addSelectColumn(ItemTableMap::COL_NAME);
            $criteria->addSelectColumn(ItemTableMap::COL_QTY_TYPE);
            $criteria->addSelectColumn(ItemTableMap::COL_MIN_QTY);
            $criteria->addSelectColumn(ItemTableMap::COL_MAX_QTY);
            $criteria->addSelectColumn(ItemTableMap::COL_EVENT_QTY);
            $criteria->addSelectColumn(ItemTableMap::COL_IMAGE);
            $criteria->addSelectColumn(ItemTableMap::COL_LABEL);
            $criteria->addSelectColumn(ItemTableMap::COL_BASE_COST);
            $criteria->addSelectColumn(ItemTableMap::COL_MULTIPLE_VARIATIONS);
            $criteria->addSelectColumn(ItemTableMap::COL_QTY_LABEL);
            $criteria->addSelectColumn(ItemTableMap::COL_COST_LABEL);
            $criteria->addSelectColumn(ItemTableMap::COL_SORT);
        } else {
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.event_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.qty_type');
            $criteria->addSelectColumn($alias . '.min_qty');
            $criteria->addSelectColumn($alias . '.max_qty');
            $criteria->addSelectColumn($alias . '.event_qty');
            $criteria->addSelectColumn($alias . '.image');
            $criteria->addSelectColumn($alias . '.label');
            $criteria->addSelectColumn($alias . '.base_cost');
            $criteria->addSelectColumn($alias . '.multiple_variations');
            $criteria->addSelectColumn($alias . '.qty_label');
            $criteria->addSelectColumn($alias . '.cost_label');
            $criteria->addSelectColumn($alias . '.sort');
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
        return Propel::getServiceContainer()->getDatabaseMap(ItemTableMap::DATABASE_NAME)->getTable(ItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ItemTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ItemTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Item or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Item object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \crwdogs\events\Item) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ItemTableMap::DATABASE_NAME);
            $criteria->add(ItemTableMap::COL_ITEM_ID, (array) $values, Criteria::IN);
        }

        $query = ItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Item or Criteria object.
     *
     * @param mixed               $criteria Criteria or Item object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Item object
        }

        if ($criteria->containsKey(ItemTableMap::COL_ITEM_ID) && $criteria->keyContainsValue(ItemTableMap::COL_ITEM_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ItemTableMap::COL_ITEM_ID.')');
        }


        // Set the correct dbName
        $query = ItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ItemTableMap::buildTableMap();
