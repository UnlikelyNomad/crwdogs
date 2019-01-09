<?php

namespace Map;

use \ItemOption;
use \ItemOptionQuery;
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
 * This class defines the structure of the 'item_option' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ItemOptionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ItemOptionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'item_option';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ItemOption';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ItemOption';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the option_id field
     */
    const COL_OPTION_ID = 'item_option.option_id';

    /**
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'item_option.item_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'item_option.name';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'item_option.type';

    /**
     * the column name for the label field
     */
    const COL_LABEL = 'item_option.label';

    /**
     * the column name for the sort field
     */
    const COL_SORT = 'item_option.sort';

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
        self::TYPE_PHPNAME       => array('OptionId', 'ItemId', 'Name', 'Type', 'Label', 'Sort', ),
        self::TYPE_CAMELNAME     => array('optionId', 'itemId', 'name', 'type', 'label', 'sort', ),
        self::TYPE_COLNAME       => array(ItemOptionTableMap::COL_OPTION_ID, ItemOptionTableMap::COL_ITEM_ID, ItemOptionTableMap::COL_NAME, ItemOptionTableMap::COL_TYPE, ItemOptionTableMap::COL_LABEL, ItemOptionTableMap::COL_SORT, ),
        self::TYPE_FIELDNAME     => array('option_id', 'item_id', 'name', 'type', 'label', 'sort', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('OptionId' => 0, 'ItemId' => 1, 'Name' => 2, 'Type' => 3, 'Label' => 4, 'Sort' => 5, ),
        self::TYPE_CAMELNAME     => array('optionId' => 0, 'itemId' => 1, 'name' => 2, 'type' => 3, 'label' => 4, 'sort' => 5, ),
        self::TYPE_COLNAME       => array(ItemOptionTableMap::COL_OPTION_ID => 0, ItemOptionTableMap::COL_ITEM_ID => 1, ItemOptionTableMap::COL_NAME => 2, ItemOptionTableMap::COL_TYPE => 3, ItemOptionTableMap::COL_LABEL => 4, ItemOptionTableMap::COL_SORT => 5, ),
        self::TYPE_FIELDNAME     => array('option_id' => 0, 'item_id' => 1, 'name' => 2, 'type' => 3, 'label' => 4, 'sort' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('item_option');
        $this->setPhpName('ItemOption');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ItemOption');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('option_id', 'OptionId', 'INTEGER', true, null, null);
        $this->addForeignKey('item_id', 'ItemId', 'INTEGER', 'item', 'item_id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 45, null);
        $this->addColumn('type', 'Type', 'VARCHAR', true, 45, null);
        $this->addColumn('label', 'Label', 'VARCHAR', true, 45, null);
        $this->addColumn('sort', 'Sort', 'INTEGER', true, null, null);
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
        $this->addRelation('OptionValue', '\\OptionValue', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':option_id',
    1 => ':option_id',
  ),
), null, null, 'OptionValues', false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('OptionId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ItemOptionTableMap::CLASS_DEFAULT : ItemOptionTableMap::OM_CLASS;
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
     * @return array           (ItemOption object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ItemOptionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ItemOptionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ItemOptionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ItemOptionTableMap::OM_CLASS;
            /** @var ItemOption $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ItemOptionTableMap::addInstanceToPool($obj, $key);
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
            $key = ItemOptionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ItemOptionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ItemOption $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ItemOptionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ItemOptionTableMap::COL_OPTION_ID);
            $criteria->addSelectColumn(ItemOptionTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(ItemOptionTableMap::COL_NAME);
            $criteria->addSelectColumn(ItemOptionTableMap::COL_TYPE);
            $criteria->addSelectColumn(ItemOptionTableMap::COL_LABEL);
            $criteria->addSelectColumn(ItemOptionTableMap::COL_SORT);
        } else {
            $criteria->addSelectColumn($alias . '.option_id');
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.label');
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
        return Propel::getServiceContainer()->getDatabaseMap(ItemOptionTableMap::DATABASE_NAME)->getTable(ItemOptionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemOptionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ItemOptionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ItemOptionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ItemOption or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ItemOption object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemOptionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ItemOption) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ItemOptionTableMap::DATABASE_NAME);
            $criteria->add(ItemOptionTableMap::COL_OPTION_ID, (array) $values, Criteria::IN);
        }

        $query = ItemOptionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ItemOptionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ItemOptionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the item_option table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ItemOptionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ItemOption or Criteria object.
     *
     * @param mixed               $criteria Criteria or ItemOption object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemOptionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ItemOption object
        }

        if ($criteria->containsKey(ItemOptionTableMap::COL_OPTION_ID) && $criteria->keyContainsValue(ItemOptionTableMap::COL_OPTION_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ItemOptionTableMap::COL_OPTION_ID.')');
        }


        // Set the correct dbName
        $query = ItemOptionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ItemOptionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ItemOptionTableMap::buildTableMap();
