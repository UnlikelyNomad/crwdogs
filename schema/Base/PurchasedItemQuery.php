<?php

namespace Base;

use \PurchasedItem as ChildPurchasedItem;
use \PurchasedItemQuery as ChildPurchasedItemQuery;
use \Exception;
use \PDO;
use Map\PurchasedItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'purchased_item' table.
 *
 *
 *
 * @method     ChildPurchasedItemQuery orderByPurchaseId($order = Criteria::ASC) Order by the purchase_id column
 * @method     ChildPurchasedItemQuery orderByRegistrationId($order = Criteria::ASC) Order by the registration_id column
 * @method     ChildPurchasedItemQuery orderByQty($order = Criteria::ASC) Order by the qty column
 * @method     ChildPurchasedItemQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildPurchasedItemQuery orderByUnitCost($order = Criteria::ASC) Order by the unit_cost column
 *
 * @method     ChildPurchasedItemQuery groupByPurchaseId() Group by the purchase_id column
 * @method     ChildPurchasedItemQuery groupByRegistrationId() Group by the registration_id column
 * @method     ChildPurchasedItemQuery groupByQty() Group by the qty column
 * @method     ChildPurchasedItemQuery groupByItemId() Group by the item_id column
 * @method     ChildPurchasedItemQuery groupByUnitCost() Group by the unit_cost column
 *
 * @method     ChildPurchasedItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPurchasedItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPurchasedItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPurchasedItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPurchasedItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPurchasedItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPurchasedItemQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildPurchasedItemQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildPurchasedItemQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildPurchasedItemQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildPurchasedItemQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildPurchasedItemQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildPurchasedItemQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     ChildPurchasedItemQuery leftJoinRegistration($relationAlias = null) Adds a LEFT JOIN clause to the query using the Registration relation
 * @method     ChildPurchasedItemQuery rightJoinRegistration($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Registration relation
 * @method     ChildPurchasedItemQuery innerJoinRegistration($relationAlias = null) Adds a INNER JOIN clause to the query using the Registration relation
 *
 * @method     ChildPurchasedItemQuery joinWithRegistration($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Registration relation
 *
 * @method     ChildPurchasedItemQuery leftJoinWithRegistration() Adds a LEFT JOIN clause and with to the query using the Registration relation
 * @method     ChildPurchasedItemQuery rightJoinWithRegistration() Adds a RIGHT JOIN clause and with to the query using the Registration relation
 * @method     ChildPurchasedItemQuery innerJoinWithRegistration() Adds a INNER JOIN clause and with to the query using the Registration relation
 *
 * @method     ChildPurchasedItemQuery leftJoinRegistrationOption($relationAlias = null) Adds a LEFT JOIN clause to the query using the RegistrationOption relation
 * @method     ChildPurchasedItemQuery rightJoinRegistrationOption($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RegistrationOption relation
 * @method     ChildPurchasedItemQuery innerJoinRegistrationOption($relationAlias = null) Adds a INNER JOIN clause to the query using the RegistrationOption relation
 *
 * @method     ChildPurchasedItemQuery joinWithRegistrationOption($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RegistrationOption relation
 *
 * @method     ChildPurchasedItemQuery leftJoinWithRegistrationOption() Adds a LEFT JOIN clause and with to the query using the RegistrationOption relation
 * @method     ChildPurchasedItemQuery rightJoinWithRegistrationOption() Adds a RIGHT JOIN clause and with to the query using the RegistrationOption relation
 * @method     ChildPurchasedItemQuery innerJoinWithRegistrationOption() Adds a INNER JOIN clause and with to the query using the RegistrationOption relation
 *
 * @method     \ItemQuery|\RegistrationQuery|\RegistrationOptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPurchasedItem findOne(ConnectionInterface $con = null) Return the first ChildPurchasedItem matching the query
 * @method     ChildPurchasedItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPurchasedItem matching the query, or a new ChildPurchasedItem object populated from the query conditions when no match is found
 *
 * @method     ChildPurchasedItem findOneByPurchaseId(int $purchase_id) Return the first ChildPurchasedItem filtered by the purchase_id column
 * @method     ChildPurchasedItem findOneByRegistrationId(int $registration_id) Return the first ChildPurchasedItem filtered by the registration_id column
 * @method     ChildPurchasedItem findOneByQty(int $qty) Return the first ChildPurchasedItem filtered by the qty column
 * @method     ChildPurchasedItem findOneByItemId(int $item_id) Return the first ChildPurchasedItem filtered by the item_id column
 * @method     ChildPurchasedItem findOneByUnitCost(string $unit_cost) Return the first ChildPurchasedItem filtered by the unit_cost column *

 * @method     ChildPurchasedItem requirePk($key, ConnectionInterface $con = null) Return the ChildPurchasedItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPurchasedItem requireOne(ConnectionInterface $con = null) Return the first ChildPurchasedItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPurchasedItem requireOneByPurchaseId(int $purchase_id) Return the first ChildPurchasedItem filtered by the purchase_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPurchasedItem requireOneByRegistrationId(int $registration_id) Return the first ChildPurchasedItem filtered by the registration_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPurchasedItem requireOneByQty(int $qty) Return the first ChildPurchasedItem filtered by the qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPurchasedItem requireOneByItemId(int $item_id) Return the first ChildPurchasedItem filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPurchasedItem requireOneByUnitCost(string $unit_cost) Return the first ChildPurchasedItem filtered by the unit_cost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPurchasedItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPurchasedItem objects based on current ModelCriteria
 * @method     ChildPurchasedItem[]|ObjectCollection findByPurchaseId(int $purchase_id) Return ChildPurchasedItem objects filtered by the purchase_id column
 * @method     ChildPurchasedItem[]|ObjectCollection findByRegistrationId(int $registration_id) Return ChildPurchasedItem objects filtered by the registration_id column
 * @method     ChildPurchasedItem[]|ObjectCollection findByQty(int $qty) Return ChildPurchasedItem objects filtered by the qty column
 * @method     ChildPurchasedItem[]|ObjectCollection findByItemId(int $item_id) Return ChildPurchasedItem objects filtered by the item_id column
 * @method     ChildPurchasedItem[]|ObjectCollection findByUnitCost(string $unit_cost) Return ChildPurchasedItem objects filtered by the unit_cost column
 * @method     ChildPurchasedItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PurchasedItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PurchasedItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\PurchasedItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPurchasedItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPurchasedItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPurchasedItemQuery) {
            return $criteria;
        }
        $query = new ChildPurchasedItemQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPurchasedItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PurchasedItemTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PurchasedItemTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPurchasedItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT purchase_id, registration_id, qty, item_id, unit_cost FROM purchased_item WHERE purchase_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPurchasedItem $obj */
            $obj = new ChildPurchasedItem();
            $obj->hydrate($row);
            PurchasedItemTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildPurchasedItem|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PurchasedItemTableMap::COL_PURCHASE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PurchasedItemTableMap::COL_PURCHASE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the purchase_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPurchaseId(1234); // WHERE purchase_id = 1234
     * $query->filterByPurchaseId(array(12, 34)); // WHERE purchase_id IN (12, 34)
     * $query->filterByPurchaseId(array('min' => 12)); // WHERE purchase_id > 12
     * </code>
     *
     * @param     mixed $purchaseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByPurchaseId($purchaseId = null, $comparison = null)
    {
        if (is_array($purchaseId)) {
            $useMinMax = false;
            if (isset($purchaseId['min'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_PURCHASE_ID, $purchaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchaseId['max'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_PURCHASE_ID, $purchaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchasedItemTableMap::COL_PURCHASE_ID, $purchaseId, $comparison);
    }

    /**
     * Filter the query on the registration_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationId(1234); // WHERE registration_id = 1234
     * $query->filterByRegistrationId(array(12, 34)); // WHERE registration_id IN (12, 34)
     * $query->filterByRegistrationId(array('min' => 12)); // WHERE registration_id > 12
     * </code>
     *
     * @see       filterByRegistration()
     *
     * @param     mixed $registrationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByRegistrationId($registrationId = null, $comparison = null)
    {
        if (is_array($registrationId)) {
            $useMinMax = false;
            if (isset($registrationId['min'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_REGISTRATION_ID, $registrationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registrationId['max'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_REGISTRATION_ID, $registrationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchasedItemTableMap::COL_REGISTRATION_ID, $registrationId, $comparison);
    }

    /**
     * Filter the query on the qty column
     *
     * Example usage:
     * <code>
     * $query->filterByQty(1234); // WHERE qty = 1234
     * $query->filterByQty(array(12, 34)); // WHERE qty IN (12, 34)
     * $query->filterByQty(array('min' => 12)); // WHERE qty > 12
     * </code>
     *
     * @param     mixed $qty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByQty($qty = null, $comparison = null)
    {
        if (is_array($qty)) {
            $useMinMax = false;
            if (isset($qty['min'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_QTY, $qty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($qty['max'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_QTY, $qty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchasedItemTableMap::COL_QTY, $qty, $comparison);
    }

    /**
     * Filter the query on the item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemId(1234); // WHERE item_id = 1234
     * $query->filterByItemId(array(12, 34)); // WHERE item_id IN (12, 34)
     * $query->filterByItemId(array('min' => 12)); // WHERE item_id > 12
     * </code>
     *
     * @see       filterByItem()
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchasedItemTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the unit_cost column
     *
     * Example usage:
     * <code>
     * $query->filterByUnitCost(1234); // WHERE unit_cost = 1234
     * $query->filterByUnitCost(array(12, 34)); // WHERE unit_cost IN (12, 34)
     * $query->filterByUnitCost(array('min' => 12)); // WHERE unit_cost > 12
     * </code>
     *
     * @param     mixed $unitCost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByUnitCost($unitCost = null, $comparison = null)
    {
        if (is_array($unitCost)) {
            $useMinMax = false;
            if (isset($unitCost['min'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_UNIT_COST, $unitCost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unitCost['max'])) {
                $this->addUsingAlias(PurchasedItemTableMap::COL_UNIT_COST, $unitCost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PurchasedItemTableMap::COL_UNIT_COST, $unitCost, $comparison);
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(PurchasedItemTableMap::COL_ITEM_ID, $item->getItemId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PurchasedItemTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'ItemId'), $comparison);
        } else {
            throw new PropelException('filterByItem() only accepts arguments of type \Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Item relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function joinItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Item');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Item');
        }

        return $this;
    }

    /**
     * Use the Item relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Item', '\ItemQuery');
    }

    /**
     * Filter the query by a related \Registration object
     *
     * @param \Registration|ObjectCollection $registration The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByRegistration($registration, $comparison = null)
    {
        if ($registration instanceof \Registration) {
            return $this
                ->addUsingAlias(PurchasedItemTableMap::COL_REGISTRATION_ID, $registration->getRegistrationId(), $comparison);
        } elseif ($registration instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PurchasedItemTableMap::COL_REGISTRATION_ID, $registration->toKeyValue('PrimaryKey', 'RegistrationId'), $comparison);
        } else {
            throw new PropelException('filterByRegistration() only accepts arguments of type \Registration or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Registration relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function joinRegistration($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Registration');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Registration');
        }

        return $this;
    }

    /**
     * Use the Registration relation Registration object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RegistrationQuery A secondary query class using the current class as primary query
     */
    public function useRegistrationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRegistration($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Registration', '\RegistrationQuery');
    }

    /**
     * Filter the query by a related \RegistrationOption object
     *
     * @param \RegistrationOption|ObjectCollection $registrationOption the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function filterByRegistrationOption($registrationOption, $comparison = null)
    {
        if ($registrationOption instanceof \RegistrationOption) {
            return $this
                ->addUsingAlias(PurchasedItemTableMap::COL_PURCHASE_ID, $registrationOption->getPurchaseId(), $comparison);
        } elseif ($registrationOption instanceof ObjectCollection) {
            return $this
                ->useRegistrationOptionQuery()
                ->filterByPrimaryKeys($registrationOption->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRegistrationOption() only accepts arguments of type \RegistrationOption or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RegistrationOption relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function joinRegistrationOption($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RegistrationOption');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RegistrationOption');
        }

        return $this;
    }

    /**
     * Use the RegistrationOption relation RegistrationOption object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RegistrationOptionQuery A secondary query class using the current class as primary query
     */
    public function useRegistrationOptionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRegistrationOption($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RegistrationOption', '\RegistrationOptionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPurchasedItem $purchasedItem Object to remove from the list of results
     *
     * @return $this|ChildPurchasedItemQuery The current query, for fluid interface
     */
    public function prune($purchasedItem = null)
    {
        if ($purchasedItem) {
            $this->addUsingAlias(PurchasedItemTableMap::COL_PURCHASE_ID, $purchasedItem->getPurchaseId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the purchased_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchasedItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PurchasedItemTableMap::clearInstancePool();
            PurchasedItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PurchasedItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PurchasedItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PurchasedItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PurchasedItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PurchasedItemQuery
