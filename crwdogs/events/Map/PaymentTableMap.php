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
use crwdogs\events\Payment;
use crwdogs\events\PaymentQuery;


/**
 * This class defines the structure of the 'payment' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PaymentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'crwdogs.events.Map.PaymentTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'payment';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\crwdogs\\events\\Payment';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'crwdogs.events.Payment';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the payment_id field
     */
    const COL_PAYMENT_ID = 'payment.payment_id';

    /**
     * the column name for the registration_id field
     */
    const COL_REGISTRATION_ID = 'payment.registration_id';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'payment.status';

    /**
     * the column name for the txn_id field
     */
    const COL_TXN_ID = 'payment.txn_id';

    /**
     * the column name for the txn_type field
     */
    const COL_TXN_TYPE = 'payment.txn_type';

    /**
     * the column name for the recipient field
     */
    const COL_RECIPIENT = 'payment.recipient';

    /**
     * the column name for the parent_txn field
     */
    const COL_PARENT_TXN = 'payment.parent_txn';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'payment.email';

    /**
     * the column name for the full field
     */
    const COL_FULL = 'payment.full';

    /**
     * the column name for the received field
     */
    const COL_RECEIVED = 'payment.received';

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
        self::TYPE_PHPNAME       => array('PaymentId', 'RegistrationId', 'Status', 'TxnId', 'TxnType', 'Recipient', 'ParentTxn', 'Email', 'Full', 'Received', ),
        self::TYPE_CAMELNAME     => array('paymentId', 'registrationId', 'status', 'txnId', 'txnType', 'recipient', 'parentTxn', 'email', 'full', 'received', ),
        self::TYPE_COLNAME       => array(PaymentTableMap::COL_PAYMENT_ID, PaymentTableMap::COL_REGISTRATION_ID, PaymentTableMap::COL_STATUS, PaymentTableMap::COL_TXN_ID, PaymentTableMap::COL_TXN_TYPE, PaymentTableMap::COL_RECIPIENT, PaymentTableMap::COL_PARENT_TXN, PaymentTableMap::COL_EMAIL, PaymentTableMap::COL_FULL, PaymentTableMap::COL_RECEIVED, ),
        self::TYPE_FIELDNAME     => array('payment_id', 'registration_id', 'status', 'txn_id', 'txn_type', 'recipient', 'parent_txn', 'email', 'full', 'received', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PaymentId' => 0, 'RegistrationId' => 1, 'Status' => 2, 'TxnId' => 3, 'TxnType' => 4, 'Recipient' => 5, 'ParentTxn' => 6, 'Email' => 7, 'Full' => 8, 'Received' => 9, ),
        self::TYPE_CAMELNAME     => array('paymentId' => 0, 'registrationId' => 1, 'status' => 2, 'txnId' => 3, 'txnType' => 4, 'recipient' => 5, 'parentTxn' => 6, 'email' => 7, 'full' => 8, 'received' => 9, ),
        self::TYPE_COLNAME       => array(PaymentTableMap::COL_PAYMENT_ID => 0, PaymentTableMap::COL_REGISTRATION_ID => 1, PaymentTableMap::COL_STATUS => 2, PaymentTableMap::COL_TXN_ID => 3, PaymentTableMap::COL_TXN_TYPE => 4, PaymentTableMap::COL_RECIPIENT => 5, PaymentTableMap::COL_PARENT_TXN => 6, PaymentTableMap::COL_EMAIL => 7, PaymentTableMap::COL_FULL => 8, PaymentTableMap::COL_RECEIVED => 9, ),
        self::TYPE_FIELDNAME     => array('payment_id' => 0, 'registration_id' => 1, 'status' => 2, 'txn_id' => 3, 'txn_type' => 4, 'recipient' => 5, 'parent_txn' => 6, 'email' => 7, 'full' => 8, 'received' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('payment');
        $this->setPhpName('Payment');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\crwdogs\\events\\Payment');
        $this->setPackage('crwdogs.events');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('payment_id', 'PaymentId', 'INTEGER', true, null, null);
        $this->addForeignKey('registration_id', 'RegistrationId', 'INTEGER', 'registration', 'registration_id', true, null, null);
        $this->addColumn('status', 'Status', 'VARCHAR', true, 45, null);
        $this->addColumn('txn_id', 'TxnId', 'VARCHAR', true, 45, null);
        $this->addColumn('txn_type', 'TxnType', 'VARCHAR', true, 45, null);
        $this->addColumn('recipient', 'Recipient', 'VARCHAR', true, 255, null);
        $this->addColumn('parent_txn', 'ParentTxn', 'VARCHAR', true, 45, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 255, null);
        $this->addColumn('full', 'Full', 'LONGVARCHAR', true, null, null);
        $this->addColumn('received', 'Received', 'TIMESTAMP', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Registration', '\\crwdogs\\events\\Registration', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':registration_id',
    1 => ':registration_id',
  ),
), null, null, null, false);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PaymentId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PaymentId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PaymentId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PaymentId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PaymentId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PaymentId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PaymentId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PaymentTableMap::CLASS_DEFAULT : PaymentTableMap::OM_CLASS;
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
     * @return array           (Payment object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PaymentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PaymentTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PaymentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PaymentTableMap::OM_CLASS;
            /** @var Payment $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PaymentTableMap::addInstanceToPool($obj, $key);
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
            $key = PaymentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PaymentTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Payment $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PaymentTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PaymentTableMap::COL_PAYMENT_ID);
            $criteria->addSelectColumn(PaymentTableMap::COL_REGISTRATION_ID);
            $criteria->addSelectColumn(PaymentTableMap::COL_STATUS);
            $criteria->addSelectColumn(PaymentTableMap::COL_TXN_ID);
            $criteria->addSelectColumn(PaymentTableMap::COL_TXN_TYPE);
            $criteria->addSelectColumn(PaymentTableMap::COL_RECIPIENT);
            $criteria->addSelectColumn(PaymentTableMap::COL_PARENT_TXN);
            $criteria->addSelectColumn(PaymentTableMap::COL_EMAIL);
            $criteria->addSelectColumn(PaymentTableMap::COL_FULL);
            $criteria->addSelectColumn(PaymentTableMap::COL_RECEIVED);
        } else {
            $criteria->addSelectColumn($alias . '.payment_id');
            $criteria->addSelectColumn($alias . '.registration_id');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.txn_id');
            $criteria->addSelectColumn($alias . '.txn_type');
            $criteria->addSelectColumn($alias . '.recipient');
            $criteria->addSelectColumn($alias . '.parent_txn');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.full');
            $criteria->addSelectColumn($alias . '.received');
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
        return Propel::getServiceContainer()->getDatabaseMap(PaymentTableMap::DATABASE_NAME)->getTable(PaymentTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PaymentTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PaymentTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PaymentTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Payment or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Payment object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PaymentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \crwdogs\events\Payment) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PaymentTableMap::DATABASE_NAME);
            $criteria->add(PaymentTableMap::COL_PAYMENT_ID, (array) $values, Criteria::IN);
        }

        $query = PaymentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PaymentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PaymentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the payment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PaymentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Payment or Criteria object.
     *
     * @param mixed               $criteria Criteria or Payment object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PaymentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Payment object
        }

        if ($criteria->containsKey(PaymentTableMap::COL_PAYMENT_ID) && $criteria->keyContainsValue(PaymentTableMap::COL_PAYMENT_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PaymentTableMap::COL_PAYMENT_ID.')');
        }


        // Set the correct dbName
        $query = PaymentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PaymentTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PaymentTableMap::buildTableMap();
