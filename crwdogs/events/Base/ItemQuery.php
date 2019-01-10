<?php

namespace crwdogs\events\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use crwdogs\events\Item as ChildItem;
use crwdogs\events\ItemQuery as ChildItemQuery;
use crwdogs\events\Map\ItemTableMap;

/**
 * Base class that represents a query for the 'item' table.
 *
 *
 *
 * @method     ChildItemQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildItemQuery orderByEventId($order = Criteria::ASC) Order by the event_id column
 * @method     ChildItemQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildItemQuery orderByQtyType($order = Criteria::ASC) Order by the qty_type column
 * @method     ChildItemQuery orderByMinQty($order = Criteria::ASC) Order by the min_qty column
 * @method     ChildItemQuery orderByMaxQty($order = Criteria::ASC) Order by the max_qty column
 * @method     ChildItemQuery orderByEventQty($order = Criteria::ASC) Order by the event_qty column
 * @method     ChildItemQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method     ChildItemQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     ChildItemQuery orderByBaseCost($order = Criteria::ASC) Order by the base_cost column
 * @method     ChildItemQuery orderByMultipleVariations($order = Criteria::ASC) Order by the multiple_variations column
 * @method     ChildItemQuery orderByQtyLabel($order = Criteria::ASC) Order by the qty_label column
 * @method     ChildItemQuery orderByCostLabel($order = Criteria::ASC) Order by the cost_label column
 * @method     ChildItemQuery orderBySort($order = Criteria::ASC) Order by the sort column
 *
 * @method     ChildItemQuery groupByItemId() Group by the item_id column
 * @method     ChildItemQuery groupByEventId() Group by the event_id column
 * @method     ChildItemQuery groupByName() Group by the name column
 * @method     ChildItemQuery groupByQtyType() Group by the qty_type column
 * @method     ChildItemQuery groupByMinQty() Group by the min_qty column
 * @method     ChildItemQuery groupByMaxQty() Group by the max_qty column
 * @method     ChildItemQuery groupByEventQty() Group by the event_qty column
 * @method     ChildItemQuery groupByImage() Group by the image column
 * @method     ChildItemQuery groupByLabel() Group by the label column
 * @method     ChildItemQuery groupByBaseCost() Group by the base_cost column
 * @method     ChildItemQuery groupByMultipleVariations() Group by the multiple_variations column
 * @method     ChildItemQuery groupByQtyLabel() Group by the qty_label column
 * @method     ChildItemQuery groupByCostLabel() Group by the cost_label column
 * @method     ChildItemQuery groupBySort() Group by the sort column
 *
 * @method     ChildItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildItemQuery leftJoinEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Event relation
 * @method     ChildItemQuery rightJoinEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Event relation
 * @method     ChildItemQuery innerJoinEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the Event relation
 *
 * @method     ChildItemQuery joinWithEvent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Event relation
 *
 * @method     ChildItemQuery leftJoinWithEvent() Adds a LEFT JOIN clause and with to the query using the Event relation
 * @method     ChildItemQuery rightJoinWithEvent() Adds a RIGHT JOIN clause and with to the query using the Event relation
 * @method     ChildItemQuery innerJoinWithEvent() Adds a INNER JOIN clause and with to the query using the Event relation
 *
 * @method     ChildItemQuery leftJoinItemOption($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemOption relation
 * @method     ChildItemQuery rightJoinItemOption($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemOption relation
 * @method     ChildItemQuery innerJoinItemOption($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemOption relation
 *
 * @method     ChildItemQuery joinWithItemOption($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ItemOption relation
 *
 * @method     ChildItemQuery leftJoinWithItemOption() Adds a LEFT JOIN clause and with to the query using the ItemOption relation
 * @method     ChildItemQuery rightJoinWithItemOption() Adds a RIGHT JOIN clause and with to the query using the ItemOption relation
 * @method     ChildItemQuery innerJoinWithItemOption() Adds a INNER JOIN clause and with to the query using the ItemOption relation
 *
 * @method     ChildItemQuery leftJoinPurchasedItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the PurchasedItem relation
 * @method     ChildItemQuery rightJoinPurchasedItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PurchasedItem relation
 * @method     ChildItemQuery innerJoinPurchasedItem($relationAlias = null) Adds a INNER JOIN clause to the query using the PurchasedItem relation
 *
 * @method     ChildItemQuery joinWithPurchasedItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PurchasedItem relation
 *
 * @method     ChildItemQuery leftJoinWithPurchasedItem() Adds a LEFT JOIN clause and with to the query using the PurchasedItem relation
 * @method     ChildItemQuery rightJoinWithPurchasedItem() Adds a RIGHT JOIN clause and with to the query using the PurchasedItem relation
 * @method     ChildItemQuery innerJoinWithPurchasedItem() Adds a INNER JOIN clause and with to the query using the PurchasedItem relation
 *
 * @method     \crwdogs\events\EventQuery|\crwdogs\events\ItemOptionQuery|\crwdogs\events\PurchasedItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItem findOne(ConnectionInterface $con = null) Return the first ChildItem matching the query
 * @method     ChildItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItem matching the query, or a new ChildItem object populated from the query conditions when no match is found
 *
 * @method     ChildItem findOneByItemId(int $item_id) Return the first ChildItem filtered by the item_id column
 * @method     ChildItem findOneByEventId(int $event_id) Return the first ChildItem filtered by the event_id column
 * @method     ChildItem findOneByName(string $name) Return the first ChildItem filtered by the name column
 * @method     ChildItem findOneByQtyType(string $qty_type) Return the first ChildItem filtered by the qty_type column
 * @method     ChildItem findOneByMinQty(int $min_qty) Return the first ChildItem filtered by the min_qty column
 * @method     ChildItem findOneByMaxQty(int $max_qty) Return the first ChildItem filtered by the max_qty column
 * @method     ChildItem findOneByEventQty(int $event_qty) Return the first ChildItem filtered by the event_qty column
 * @method     ChildItem findOneByImage(string $image) Return the first ChildItem filtered by the image column
 * @method     ChildItem findOneByLabel(string $label) Return the first ChildItem filtered by the label column
 * @method     ChildItem findOneByBaseCost(string $base_cost) Return the first ChildItem filtered by the base_cost column
 * @method     ChildItem findOneByMultipleVariations(string $multiple_variations) Return the first ChildItem filtered by the multiple_variations column
 * @method     ChildItem findOneByQtyLabel(string $qty_label) Return the first ChildItem filtered by the qty_label column
 * @method     ChildItem findOneByCostLabel(string $cost_label) Return the first ChildItem filtered by the cost_label column
 * @method     ChildItem findOneBySort(int $sort) Return the first ChildItem filtered by the sort column *

 * @method     ChildItem requirePk($key, ConnectionInterface $con = null) Return the ChildItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOne(ConnectionInterface $con = null) Return the first ChildItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem requireOneByItemId(int $item_id) Return the first ChildItem filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByEventId(int $event_id) Return the first ChildItem filtered by the event_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByName(string $name) Return the first ChildItem filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByQtyType(string $qty_type) Return the first ChildItem filtered by the qty_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByMinQty(int $min_qty) Return the first ChildItem filtered by the min_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByMaxQty(int $max_qty) Return the first ChildItem filtered by the max_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByEventQty(int $event_qty) Return the first ChildItem filtered by the event_qty column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByImage(string $image) Return the first ChildItem filtered by the image column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByLabel(string $label) Return the first ChildItem filtered by the label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByBaseCost(string $base_cost) Return the first ChildItem filtered by the base_cost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByMultipleVariations(string $multiple_variations) Return the first ChildItem filtered by the multiple_variations column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByQtyLabel(string $qty_label) Return the first ChildItem filtered by the qty_label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByCostLabel(string $cost_label) Return the first ChildItem filtered by the cost_label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneBySort(int $sort) Return the first ChildItem filtered by the sort column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItem objects based on current ModelCriteria
 * @method     ChildItem[]|ObjectCollection findByItemId(int $item_id) Return ChildItem objects filtered by the item_id column
 * @method     ChildItem[]|ObjectCollection findByEventId(int $event_id) Return ChildItem objects filtered by the event_id column
 * @method     ChildItem[]|ObjectCollection findByName(string $name) Return ChildItem objects filtered by the name column
 * @method     ChildItem[]|ObjectCollection findByQtyType(string $qty_type) Return ChildItem objects filtered by the qty_type column
 * @method     ChildItem[]|ObjectCollection findByMinQty(int $min_qty) Return ChildItem objects filtered by the min_qty column
 * @method     ChildItem[]|ObjectCollection findByMaxQty(int $max_qty) Return ChildItem objects filtered by the max_qty column
 * @method     ChildItem[]|ObjectCollection findByEventQty(int $event_qty) Return ChildItem objects filtered by the event_qty column
 * @method     ChildItem[]|ObjectCollection findByImage(string $image) Return ChildItem objects filtered by the image column
 * @method     ChildItem[]|ObjectCollection findByLabel(string $label) Return ChildItem objects filtered by the label column
 * @method     ChildItem[]|ObjectCollection findByBaseCost(string $base_cost) Return ChildItem objects filtered by the base_cost column
 * @method     ChildItem[]|ObjectCollection findByMultipleVariations(string $multiple_variations) Return ChildItem objects filtered by the multiple_variations column
 * @method     ChildItem[]|ObjectCollection findByQtyLabel(string $qty_label) Return ChildItem objects filtered by the qty_label column
 * @method     ChildItem[]|ObjectCollection findByCostLabel(string $cost_label) Return ChildItem objects filtered by the cost_label column
 * @method     ChildItem[]|ObjectCollection findBySort(int $sort) Return ChildItem objects filtered by the sort column
 * @method     ChildItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \crwdogs\events\Base\ItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\crwdogs\\events\\Item', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemQuery) {
            return $criteria;
        }
        $query = new ChildItemQuery();
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ItemTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, event_id, name, qty_type, min_qty, max_qty, event_qty, image, label, base_cost, multiple_variations, qty_label, cost_label, sort FROM item WHERE item_id = :p0';
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
            /** @var ChildItem $obj */
            $obj = new ChildItem();
            $obj->hydrate($row);
            ItemTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $keys, Criteria::IN);
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
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the event_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEventId(1234); // WHERE event_id = 1234
     * $query->filterByEventId(array(12, 34)); // WHERE event_id IN (12, 34)
     * $query->filterByEventId(array('min' => 12)); // WHERE event_id > 12
     * </code>
     *
     * @see       filterByEvent()
     *
     * @param     mixed $eventId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByEventId($eventId = null, $comparison = null)
    {
        if (is_array($eventId)) {
            $useMinMax = false;
            if (isset($eventId['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_EVENT_ID, $eventId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventId['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_EVENT_ID, $eventId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_EVENT_ID, $eventId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the qty_type column
     *
     * Example usage:
     * <code>
     * $query->filterByQtyType('fooValue');   // WHERE qty_type = 'fooValue'
     * $query->filterByQtyType('%fooValue%', Criteria::LIKE); // WHERE qty_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $qtyType The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByQtyType($qtyType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($qtyType)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_QTY_TYPE, $qtyType, $comparison);
    }

    /**
     * Filter the query on the min_qty column
     *
     * Example usage:
     * <code>
     * $query->filterByMinQty(1234); // WHERE min_qty = 1234
     * $query->filterByMinQty(array(12, 34)); // WHERE min_qty IN (12, 34)
     * $query->filterByMinQty(array('min' => 12)); // WHERE min_qty > 12
     * </code>
     *
     * @param     mixed $minQty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByMinQty($minQty = null, $comparison = null)
    {
        if (is_array($minQty)) {
            $useMinMax = false;
            if (isset($minQty['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_MIN_QTY, $minQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($minQty['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_MIN_QTY, $minQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_MIN_QTY, $minQty, $comparison);
    }

    /**
     * Filter the query on the max_qty column
     *
     * Example usage:
     * <code>
     * $query->filterByMaxQty(1234); // WHERE max_qty = 1234
     * $query->filterByMaxQty(array(12, 34)); // WHERE max_qty IN (12, 34)
     * $query->filterByMaxQty(array('min' => 12)); // WHERE max_qty > 12
     * </code>
     *
     * @param     mixed $maxQty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByMaxQty($maxQty = null, $comparison = null)
    {
        if (is_array($maxQty)) {
            $useMinMax = false;
            if (isset($maxQty['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_MAX_QTY, $maxQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($maxQty['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_MAX_QTY, $maxQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_MAX_QTY, $maxQty, $comparison);
    }

    /**
     * Filter the query on the event_qty column
     *
     * Example usage:
     * <code>
     * $query->filterByEventQty(1234); // WHERE event_qty = 1234
     * $query->filterByEventQty(array(12, 34)); // WHERE event_qty IN (12, 34)
     * $query->filterByEventQty(array('min' => 12)); // WHERE event_qty > 12
     * </code>
     *
     * @param     mixed $eventQty The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByEventQty($eventQty = null, $comparison = null)
    {
        if (is_array($eventQty)) {
            $useMinMax = false;
            if (isset($eventQty['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_EVENT_QTY, $eventQty['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventQty['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_EVENT_QTY, $eventQty['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_EVENT_QTY, $eventQty, $comparison);
    }

    /**
     * Filter the query on the image column
     *
     * Example usage:
     * <code>
     * $query->filterByImage('fooValue');   // WHERE image = 'fooValue'
     * $query->filterByImage('%fooValue%', Criteria::LIKE); // WHERE image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $image The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($image)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_IMAGE, $image, $comparison);
    }

    /**
     * Filter the query on the label column
     *
     * Example usage:
     * <code>
     * $query->filterByLabel('fooValue');   // WHERE label = 'fooValue'
     * $query->filterByLabel('%fooValue%', Criteria::LIKE); // WHERE label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $label The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_LABEL, $label, $comparison);
    }

    /**
     * Filter the query on the base_cost column
     *
     * Example usage:
     * <code>
     * $query->filterByBaseCost(1234); // WHERE base_cost = 1234
     * $query->filterByBaseCost(array(12, 34)); // WHERE base_cost IN (12, 34)
     * $query->filterByBaseCost(array('min' => 12)); // WHERE base_cost > 12
     * </code>
     *
     * @param     mixed $baseCost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByBaseCost($baseCost = null, $comparison = null)
    {
        if (is_array($baseCost)) {
            $useMinMax = false;
            if (isset($baseCost['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_BASE_COST, $baseCost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($baseCost['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_BASE_COST, $baseCost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_BASE_COST, $baseCost, $comparison);
    }

    /**
     * Filter the query on the multiple_variations column
     *
     * Example usage:
     * <code>
     * $query->filterByMultipleVariations('fooValue');   // WHERE multiple_variations = 'fooValue'
     * $query->filterByMultipleVariations('%fooValue%', Criteria::LIKE); // WHERE multiple_variations LIKE '%fooValue%'
     * </code>
     *
     * @param     string $multipleVariations The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByMultipleVariations($multipleVariations = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($multipleVariations)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_MULTIPLE_VARIATIONS, $multipleVariations, $comparison);
    }

    /**
     * Filter the query on the qty_label column
     *
     * Example usage:
     * <code>
     * $query->filterByQtyLabel('fooValue');   // WHERE qty_label = 'fooValue'
     * $query->filterByQtyLabel('%fooValue%', Criteria::LIKE); // WHERE qty_label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $qtyLabel The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByQtyLabel($qtyLabel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($qtyLabel)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_QTY_LABEL, $qtyLabel, $comparison);
    }

    /**
     * Filter the query on the cost_label column
     *
     * Example usage:
     * <code>
     * $query->filterByCostLabel('fooValue');   // WHERE cost_label = 'fooValue'
     * $query->filterByCostLabel('%fooValue%', Criteria::LIKE); // WHERE cost_label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $costLabel The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByCostLabel($costLabel = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($costLabel)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_COST_LABEL, $costLabel, $comparison);
    }

    /**
     * Filter the query on the sort column
     *
     * Example usage:
     * <code>
     * $query->filterBySort(1234); // WHERE sort = 1234
     * $query->filterBySort(array(12, 34)); // WHERE sort IN (12, 34)
     * $query->filterBySort(array('min' => 12)); // WHERE sort > 12
     * </code>
     *
     * @param     mixed $sort The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_SORT, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_SORT, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_SORT, $sort, $comparison);
    }

    /**
     * Filter the query by a related \crwdogs\events\Event object
     *
     * @param \crwdogs\events\Event|ObjectCollection $event The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByEvent($event, $comparison = null)
    {
        if ($event instanceof \crwdogs\events\Event) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_EVENT_ID, $event->getEventId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_EVENT_ID, $event->toKeyValue('PrimaryKey', 'EventId'), $comparison);
        } else {
            throw new PropelException('filterByEvent() only accepts arguments of type \crwdogs\events\Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Event relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinEvent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Event');

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
            $this->addJoinObject($join, 'Event');
        }

        return $this;
    }

    /**
     * Use the Event relation Event object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \crwdogs\events\EventQuery A secondary query class using the current class as primary query
     */
    public function useEventQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Event', '\crwdogs\events\EventQuery');
    }

    /**
     * Filter the query by a related \crwdogs\events\ItemOption object
     *
     * @param \crwdogs\events\ItemOption|ObjectCollection $itemOption the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemOption($itemOption, $comparison = null)
    {
        if ($itemOption instanceof \crwdogs\events\ItemOption) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemOption->getItemId(), $comparison);
        } elseif ($itemOption instanceof ObjectCollection) {
            return $this
                ->useItemOptionQuery()
                ->filterByPrimaryKeys($itemOption->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByItemOption() only accepts arguments of type \crwdogs\events\ItemOption or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemOption relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinItemOption($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemOption');

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
            $this->addJoinObject($join, 'ItemOption');
        }

        return $this;
    }

    /**
     * Use the ItemOption relation ItemOption object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \crwdogs\events\ItemOptionQuery A secondary query class using the current class as primary query
     */
    public function useItemOptionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItemOption($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemOption', '\crwdogs\events\ItemOptionQuery');
    }

    /**
     * Filter the query by a related \crwdogs\events\PurchasedItem object
     *
     * @param \crwdogs\events\PurchasedItem|ObjectCollection $purchasedItem the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByPurchasedItem($purchasedItem, $comparison = null)
    {
        if ($purchasedItem instanceof \crwdogs\events\PurchasedItem) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ITEM_ID, $purchasedItem->getItemId(), $comparison);
        } elseif ($purchasedItem instanceof ObjectCollection) {
            return $this
                ->usePurchasedItemQuery()
                ->filterByPrimaryKeys($purchasedItem->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPurchasedItem() only accepts arguments of type \crwdogs\events\PurchasedItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PurchasedItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinPurchasedItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PurchasedItem');

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
            $this->addJoinObject($join, 'PurchasedItem');
        }

        return $this;
    }

    /**
     * Use the PurchasedItem relation PurchasedItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \crwdogs\events\PurchasedItemQuery A secondary query class using the current class as primary query
     */
    public function usePurchasedItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPurchasedItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PurchasedItem', '\crwdogs\events\PurchasedItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItem $item Object to remove from the list of results
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function prune($item = null)
    {
        if ($item) {
            $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $item->getItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemTableMap::clearInstancePool();
            ItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemQuery
