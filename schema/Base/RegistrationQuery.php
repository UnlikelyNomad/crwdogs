<?php

namespace Base;

use \Registration as ChildRegistration;
use \RegistrationQuery as ChildRegistrationQuery;
use \Exception;
use \PDO;
use Map\RegistrationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'registration' table.
 *
 *
 *
 * @method     ChildRegistrationQuery orderByRegistrationId($order = Criteria::ASC) Order by the registration_id column
 * @method     ChildRegistrationQuery orderByEventId($order = Criteria::ASC) Order by the event_id column
 * @method     ChildRegistrationQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildRegistrationQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildRegistrationQuery groupByRegistrationId() Group by the registration_id column
 * @method     ChildRegistrationQuery groupByEventId() Group by the event_id column
 * @method     ChildRegistrationQuery groupByUserId() Group by the user_id column
 * @method     ChildRegistrationQuery groupByStatus() Group by the status column
 *
 * @method     ChildRegistrationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRegistrationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRegistrationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRegistrationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRegistrationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRegistrationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRegistrationQuery leftJoinEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Event relation
 * @method     ChildRegistrationQuery rightJoinEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Event relation
 * @method     ChildRegistrationQuery innerJoinEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the Event relation
 *
 * @method     ChildRegistrationQuery joinWithEvent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Event relation
 *
 * @method     ChildRegistrationQuery leftJoinWithEvent() Adds a LEFT JOIN clause and with to the query using the Event relation
 * @method     ChildRegistrationQuery rightJoinWithEvent() Adds a RIGHT JOIN clause and with to the query using the Event relation
 * @method     ChildRegistrationQuery innerJoinWithEvent() Adds a INNER JOIN clause and with to the query using the Event relation
 *
 * @method     ChildRegistrationQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildRegistrationQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildRegistrationQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildRegistrationQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildRegistrationQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildRegistrationQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildRegistrationQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     ChildRegistrationQuery leftJoinPayment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Payment relation
 * @method     ChildRegistrationQuery rightJoinPayment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Payment relation
 * @method     ChildRegistrationQuery innerJoinPayment($relationAlias = null) Adds a INNER JOIN clause to the query using the Payment relation
 *
 * @method     ChildRegistrationQuery joinWithPayment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Payment relation
 *
 * @method     ChildRegistrationQuery leftJoinWithPayment() Adds a LEFT JOIN clause and with to the query using the Payment relation
 * @method     ChildRegistrationQuery rightJoinWithPayment() Adds a RIGHT JOIN clause and with to the query using the Payment relation
 * @method     ChildRegistrationQuery innerJoinWithPayment() Adds a INNER JOIN clause and with to the query using the Payment relation
 *
 * @method     ChildRegistrationQuery leftJoinPurchasedItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the PurchasedItem relation
 * @method     ChildRegistrationQuery rightJoinPurchasedItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PurchasedItem relation
 * @method     ChildRegistrationQuery innerJoinPurchasedItem($relationAlias = null) Adds a INNER JOIN clause to the query using the PurchasedItem relation
 *
 * @method     ChildRegistrationQuery joinWithPurchasedItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PurchasedItem relation
 *
 * @method     ChildRegistrationQuery leftJoinWithPurchasedItem() Adds a LEFT JOIN clause and with to the query using the PurchasedItem relation
 * @method     ChildRegistrationQuery rightJoinWithPurchasedItem() Adds a RIGHT JOIN clause and with to the query using the PurchasedItem relation
 * @method     ChildRegistrationQuery innerJoinWithPurchasedItem() Adds a INNER JOIN clause and with to the query using the PurchasedItem relation
 *
 * @method     ChildRegistrationQuery leftJoinResponse($relationAlias = null) Adds a LEFT JOIN clause to the query using the Response relation
 * @method     ChildRegistrationQuery rightJoinResponse($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Response relation
 * @method     ChildRegistrationQuery innerJoinResponse($relationAlias = null) Adds a INNER JOIN clause to the query using the Response relation
 *
 * @method     ChildRegistrationQuery joinWithResponse($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Response relation
 *
 * @method     ChildRegistrationQuery leftJoinWithResponse() Adds a LEFT JOIN clause and with to the query using the Response relation
 * @method     ChildRegistrationQuery rightJoinWithResponse() Adds a RIGHT JOIN clause and with to the query using the Response relation
 * @method     ChildRegistrationQuery innerJoinWithResponse() Adds a INNER JOIN clause and with to the query using the Response relation
 *
 * @method     \EventQuery|\UsersQuery|\PaymentQuery|\PurchasedItemQuery|\ResponseQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRegistration findOne(ConnectionInterface $con = null) Return the first ChildRegistration matching the query
 * @method     ChildRegistration findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRegistration matching the query, or a new ChildRegistration object populated from the query conditions when no match is found
 *
 * @method     ChildRegistration findOneByRegistrationId(int $registration_id) Return the first ChildRegistration filtered by the registration_id column
 * @method     ChildRegistration findOneByEventId(int $event_id) Return the first ChildRegistration filtered by the event_id column
 * @method     ChildRegistration findOneByUserId(int $user_id) Return the first ChildRegistration filtered by the user_id column
 * @method     ChildRegistration findOneByStatus(string $status) Return the first ChildRegistration filtered by the status column *

 * @method     ChildRegistration requirePk($key, ConnectionInterface $con = null) Return the ChildRegistration by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRegistration requireOne(ConnectionInterface $con = null) Return the first ChildRegistration matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRegistration requireOneByRegistrationId(int $registration_id) Return the first ChildRegistration filtered by the registration_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRegistration requireOneByEventId(int $event_id) Return the first ChildRegistration filtered by the event_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRegistration requireOneByUserId(int $user_id) Return the first ChildRegistration filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRegistration requireOneByStatus(string $status) Return the first ChildRegistration filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRegistration[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRegistration objects based on current ModelCriteria
 * @method     ChildRegistration[]|ObjectCollection findByRegistrationId(int $registration_id) Return ChildRegistration objects filtered by the registration_id column
 * @method     ChildRegistration[]|ObjectCollection findByEventId(int $event_id) Return ChildRegistration objects filtered by the event_id column
 * @method     ChildRegistration[]|ObjectCollection findByUserId(int $user_id) Return ChildRegistration objects filtered by the user_id column
 * @method     ChildRegistration[]|ObjectCollection findByStatus(string $status) Return ChildRegistration objects filtered by the status column
 * @method     ChildRegistration[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RegistrationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RegistrationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Registration', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRegistrationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRegistrationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRegistrationQuery) {
            return $criteria;
        }
        $query = new ChildRegistrationQuery();
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
     * @return ChildRegistration|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RegistrationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RegistrationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildRegistration A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT registration_id, event_id, user_id, status FROM registration WHERE registration_id = :p0';
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
            /** @var ChildRegistration $obj */
            $obj = new ChildRegistration();
            $obj->hydrate($row);
            RegistrationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildRegistration|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $keys, Criteria::IN);
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
     * @param     mixed $registrationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByRegistrationId($registrationId = null, $comparison = null)
    {
        if (is_array($registrationId)) {
            $useMinMax = false;
            if (isset($registrationId['min'])) {
                $this->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $registrationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registrationId['max'])) {
                $this->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $registrationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $registrationId, $comparison);
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
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByEventId($eventId = null, $comparison = null)
    {
        if (is_array($eventId)) {
            $useMinMax = false;
            if (isset($eventId['min'])) {
                $this->addUsingAlias(RegistrationTableMap::COL_EVENT_ID, $eventId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventId['max'])) {
                $this->addUsingAlias(RegistrationTableMap::COL_EVENT_ID, $eventId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegistrationTableMap::COL_EVENT_ID, $eventId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUsers()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(RegistrationTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(RegistrationTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegistrationTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegistrationTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \Event object
     *
     * @param \Event|ObjectCollection $event The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByEvent($event, $comparison = null)
    {
        if ($event instanceof \Event) {
            return $this
                ->addUsingAlias(RegistrationTableMap::COL_EVENT_ID, $event->getEventId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RegistrationTableMap::COL_EVENT_ID, $event->toKeyValue('PrimaryKey', 'EventId'), $comparison);
        } else {
            throw new PropelException('filterByEvent() only accepts arguments of type \Event or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Event relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
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
     * @return \EventQuery A secondary query class using the current class as primary query
     */
    public function useEventQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Event', '\EventQuery');
    }

    /**
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(RegistrationTableMap::COL_USER_ID, $users->getUserId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RegistrationTableMap::COL_USER_ID, $users->toKeyValue('PrimaryKey', 'UserId'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\UsersQuery');
    }

    /**
     * Filter the query by a related \Payment object
     *
     * @param \Payment|ObjectCollection $payment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByPayment($payment, $comparison = null)
    {
        if ($payment instanceof \Payment) {
            return $this
                ->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $payment->getRegistrationId(), $comparison);
        } elseif ($payment instanceof ObjectCollection) {
            return $this
                ->usePaymentQuery()
                ->filterByPrimaryKeys($payment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPayment() only accepts arguments of type \Payment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Payment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function joinPayment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Payment');

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
            $this->addJoinObject($join, 'Payment');
        }

        return $this;
    }

    /**
     * Use the Payment relation Payment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PaymentQuery A secondary query class using the current class as primary query
     */
    public function usePaymentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPayment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Payment', '\PaymentQuery');
    }

    /**
     * Filter the query by a related \PurchasedItem object
     *
     * @param \PurchasedItem|ObjectCollection $purchasedItem the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByPurchasedItem($purchasedItem, $comparison = null)
    {
        if ($purchasedItem instanceof \PurchasedItem) {
            return $this
                ->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $purchasedItem->getRegistrationId(), $comparison);
        } elseif ($purchasedItem instanceof ObjectCollection) {
            return $this
                ->usePurchasedItemQuery()
                ->filterByPrimaryKeys($purchasedItem->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPurchasedItem() only accepts arguments of type \PurchasedItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PurchasedItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
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
     * @return \PurchasedItemQuery A secondary query class using the current class as primary query
     */
    public function usePurchasedItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPurchasedItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PurchasedItem', '\PurchasedItemQuery');
    }

    /**
     * Filter the query by a related \Response object
     *
     * @param \Response|ObjectCollection $response the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRegistrationQuery The current query, for fluid interface
     */
    public function filterByResponse($response, $comparison = null)
    {
        if ($response instanceof \Response) {
            return $this
                ->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $response->getRegistrationId(), $comparison);
        } elseif ($response instanceof ObjectCollection) {
            return $this
                ->useResponseQuery()
                ->filterByPrimaryKeys($response->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByResponse() only accepts arguments of type \Response or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Response relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function joinResponse($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Response');

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
            $this->addJoinObject($join, 'Response');
        }

        return $this;
    }

    /**
     * Use the Response relation Response object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ResponseQuery A secondary query class using the current class as primary query
     */
    public function useResponseQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinResponse($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Response', '\ResponseQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRegistration $registration Object to remove from the list of results
     *
     * @return $this|ChildRegistrationQuery The current query, for fluid interface
     */
    public function prune($registration = null)
    {
        if ($registration) {
            $this->addUsingAlias(RegistrationTableMap::COL_REGISTRATION_ID, $registration->getRegistrationId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the registration table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RegistrationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RegistrationTableMap::clearInstancePool();
            RegistrationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RegistrationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RegistrationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RegistrationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RegistrationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RegistrationQuery
