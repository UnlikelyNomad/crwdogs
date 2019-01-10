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
use crwdogs\events\EarlyDiscount as ChildEarlyDiscount;
use crwdogs\events\EarlyDiscountQuery as ChildEarlyDiscountQuery;
use crwdogs\events\Map\EarlyDiscountTableMap;

/**
 * Base class that represents a query for the 'early_discount' table.
 *
 *
 *
 * @method     ChildEarlyDiscountQuery orderByEarlyDiscountId($order = Criteria::ASC) Order by the early_discount_id column
 * @method     ChildEarlyDiscountQuery orderByEventId($order = Criteria::ASC) Order by the event_id column
 * @method     ChildEarlyDiscountQuery orderByEndDate($order = Criteria::ASC) Order by the end_date column
 * @method     ChildEarlyDiscountQuery orderByDiscount($order = Criteria::ASC) Order by the discount column
 *
 * @method     ChildEarlyDiscountQuery groupByEarlyDiscountId() Group by the early_discount_id column
 * @method     ChildEarlyDiscountQuery groupByEventId() Group by the event_id column
 * @method     ChildEarlyDiscountQuery groupByEndDate() Group by the end_date column
 * @method     ChildEarlyDiscountQuery groupByDiscount() Group by the discount column
 *
 * @method     ChildEarlyDiscountQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEarlyDiscountQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEarlyDiscountQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEarlyDiscountQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEarlyDiscountQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEarlyDiscountQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEarlyDiscountQuery leftJoinEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Event relation
 * @method     ChildEarlyDiscountQuery rightJoinEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Event relation
 * @method     ChildEarlyDiscountQuery innerJoinEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the Event relation
 *
 * @method     ChildEarlyDiscountQuery joinWithEvent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Event relation
 *
 * @method     ChildEarlyDiscountQuery leftJoinWithEvent() Adds a LEFT JOIN clause and with to the query using the Event relation
 * @method     ChildEarlyDiscountQuery rightJoinWithEvent() Adds a RIGHT JOIN clause and with to the query using the Event relation
 * @method     ChildEarlyDiscountQuery innerJoinWithEvent() Adds a INNER JOIN clause and with to the query using the Event relation
 *
 * @method     \crwdogs\events\EventQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEarlyDiscount findOne(ConnectionInterface $con = null) Return the first ChildEarlyDiscount matching the query
 * @method     ChildEarlyDiscount findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEarlyDiscount matching the query, or a new ChildEarlyDiscount object populated from the query conditions when no match is found
 *
 * @method     ChildEarlyDiscount findOneByEarlyDiscountId(int $early_discount_id) Return the first ChildEarlyDiscount filtered by the early_discount_id column
 * @method     ChildEarlyDiscount findOneByEventId(int $event_id) Return the first ChildEarlyDiscount filtered by the event_id column
 * @method     ChildEarlyDiscount findOneByEndDate(string $end_date) Return the first ChildEarlyDiscount filtered by the end_date column
 * @method     ChildEarlyDiscount findOneByDiscount(string $discount) Return the first ChildEarlyDiscount filtered by the discount column *

 * @method     ChildEarlyDiscount requirePk($key, ConnectionInterface $con = null) Return the ChildEarlyDiscount by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEarlyDiscount requireOne(ConnectionInterface $con = null) Return the first ChildEarlyDiscount matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEarlyDiscount requireOneByEarlyDiscountId(int $early_discount_id) Return the first ChildEarlyDiscount filtered by the early_discount_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEarlyDiscount requireOneByEventId(int $event_id) Return the first ChildEarlyDiscount filtered by the event_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEarlyDiscount requireOneByEndDate(string $end_date) Return the first ChildEarlyDiscount filtered by the end_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEarlyDiscount requireOneByDiscount(string $discount) Return the first ChildEarlyDiscount filtered by the discount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEarlyDiscount[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEarlyDiscount objects based on current ModelCriteria
 * @method     ChildEarlyDiscount[]|ObjectCollection findByEarlyDiscountId(int $early_discount_id) Return ChildEarlyDiscount objects filtered by the early_discount_id column
 * @method     ChildEarlyDiscount[]|ObjectCollection findByEventId(int $event_id) Return ChildEarlyDiscount objects filtered by the event_id column
 * @method     ChildEarlyDiscount[]|ObjectCollection findByEndDate(string $end_date) Return ChildEarlyDiscount objects filtered by the end_date column
 * @method     ChildEarlyDiscount[]|ObjectCollection findByDiscount(string $discount) Return ChildEarlyDiscount objects filtered by the discount column
 * @method     ChildEarlyDiscount[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EarlyDiscountQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \crwdogs\events\Base\EarlyDiscountQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\crwdogs\\events\\EarlyDiscount', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEarlyDiscountQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEarlyDiscountQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEarlyDiscountQuery) {
            return $criteria;
        }
        $query = new ChildEarlyDiscountQuery();
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
     * @return ChildEarlyDiscount|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EarlyDiscountTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EarlyDiscountTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildEarlyDiscount A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT early_discount_id, event_id, end_date, discount FROM early_discount WHERE early_discount_id = :p0';
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
            /** @var ChildEarlyDiscount $obj */
            $obj = new ChildEarlyDiscount();
            $obj->hydrate($row);
            EarlyDiscountTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEarlyDiscount|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildEarlyDiscountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EarlyDiscountTableMap::COL_EARLY_DISCOUNT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEarlyDiscountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EarlyDiscountTableMap::COL_EARLY_DISCOUNT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the early_discount_id column
     *
     * Example usage:
     * <code>
     * $query->filterByEarlyDiscountId(1234); // WHERE early_discount_id = 1234
     * $query->filterByEarlyDiscountId(array(12, 34)); // WHERE early_discount_id IN (12, 34)
     * $query->filterByEarlyDiscountId(array('min' => 12)); // WHERE early_discount_id > 12
     * </code>
     *
     * @param     mixed $earlyDiscountId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEarlyDiscountQuery The current query, for fluid interface
     */
    public function filterByEarlyDiscountId($earlyDiscountId = null, $comparison = null)
    {
        if (is_array($earlyDiscountId)) {
            $useMinMax = false;
            if (isset($earlyDiscountId['min'])) {
                $this->addUsingAlias(EarlyDiscountTableMap::COL_EARLY_DISCOUNT_ID, $earlyDiscountId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($earlyDiscountId['max'])) {
                $this->addUsingAlias(EarlyDiscountTableMap::COL_EARLY_DISCOUNT_ID, $earlyDiscountId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EarlyDiscountTableMap::COL_EARLY_DISCOUNT_ID, $earlyDiscountId, $comparison);
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
     * @return $this|ChildEarlyDiscountQuery The current query, for fluid interface
     */
    public function filterByEventId($eventId = null, $comparison = null)
    {
        if (is_array($eventId)) {
            $useMinMax = false;
            if (isset($eventId['min'])) {
                $this->addUsingAlias(EarlyDiscountTableMap::COL_EVENT_ID, $eventId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventId['max'])) {
                $this->addUsingAlias(EarlyDiscountTableMap::COL_EVENT_ID, $eventId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EarlyDiscountTableMap::COL_EVENT_ID, $eventId, $comparison);
    }

    /**
     * Filter the query on the end_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEndDate('2011-03-14'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate('now'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate(array('max' => 'yesterday')); // WHERE end_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $endDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEarlyDiscountQuery The current query, for fluid interface
     */
    public function filterByEndDate($endDate = null, $comparison = null)
    {
        if (is_array($endDate)) {
            $useMinMax = false;
            if (isset($endDate['min'])) {
                $this->addUsingAlias(EarlyDiscountTableMap::COL_END_DATE, $endDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endDate['max'])) {
                $this->addUsingAlias(EarlyDiscountTableMap::COL_END_DATE, $endDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EarlyDiscountTableMap::COL_END_DATE, $endDate, $comparison);
    }

    /**
     * Filter the query on the discount column
     *
     * Example usage:
     * <code>
     * $query->filterByDiscount(1234); // WHERE discount = 1234
     * $query->filterByDiscount(array(12, 34)); // WHERE discount IN (12, 34)
     * $query->filterByDiscount(array('min' => 12)); // WHERE discount > 12
     * </code>
     *
     * @param     mixed $discount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEarlyDiscountQuery The current query, for fluid interface
     */
    public function filterByDiscount($discount = null, $comparison = null)
    {
        if (is_array($discount)) {
            $useMinMax = false;
            if (isset($discount['min'])) {
                $this->addUsingAlias(EarlyDiscountTableMap::COL_DISCOUNT, $discount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($discount['max'])) {
                $this->addUsingAlias(EarlyDiscountTableMap::COL_DISCOUNT, $discount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EarlyDiscountTableMap::COL_DISCOUNT, $discount, $comparison);
    }

    /**
     * Filter the query by a related \crwdogs\events\Event object
     *
     * @param \crwdogs\events\Event|ObjectCollection $event The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEarlyDiscountQuery The current query, for fluid interface
     */
    public function filterByEvent($event, $comparison = null)
    {
        if ($event instanceof \crwdogs\events\Event) {
            return $this
                ->addUsingAlias(EarlyDiscountTableMap::COL_EVENT_ID, $event->getEventId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EarlyDiscountTableMap::COL_EVENT_ID, $event->toKeyValue('PrimaryKey', 'EventId'), $comparison);
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
     * @return $this|ChildEarlyDiscountQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildEarlyDiscount $earlyDiscount Object to remove from the list of results
     *
     * @return $this|ChildEarlyDiscountQuery The current query, for fluid interface
     */
    public function prune($earlyDiscount = null)
    {
        if ($earlyDiscount) {
            $this->addUsingAlias(EarlyDiscountTableMap::COL_EARLY_DISCOUNT_ID, $earlyDiscount->getEarlyDiscountId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the early_discount table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EarlyDiscountTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EarlyDiscountTableMap::clearInstancePool();
            EarlyDiscountTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EarlyDiscountTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EarlyDiscountTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EarlyDiscountTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EarlyDiscountTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EarlyDiscountQuery
