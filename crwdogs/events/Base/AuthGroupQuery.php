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
use crwdogs\events\AuthGroup as ChildAuthGroup;
use crwdogs\events\AuthGroupQuery as ChildAuthGroupQuery;
use crwdogs\events\Map\AuthGroupTableMap;

/**
 * Base class that represents a query for the 'auth_group' table.
 *
 *
 *
 * @method     ChildAuthGroupQuery orderByGroupId($order = Criteria::ASC) Order by the group_id column
 * @method     ChildAuthGroupQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildAuthGroupQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     ChildAuthGroupQuery orderByComment($order = Criteria::ASC) Order by the comment column
 * @method     ChildAuthGroupQuery orderByDefaultGroup($order = Criteria::ASC) Order by the default_group column
 * @method     ChildAuthGroupQuery orderByAnonymous($order = Criteria::ASC) Order by the anonymous column
 * @method     ChildAuthGroupQuery orderByRoot($order = Criteria::ASC) Order by the root column
 *
 * @method     ChildAuthGroupQuery groupByGroupId() Group by the group_id column
 * @method     ChildAuthGroupQuery groupByName() Group by the name column
 * @method     ChildAuthGroupQuery groupByLabel() Group by the label column
 * @method     ChildAuthGroupQuery groupByComment() Group by the comment column
 * @method     ChildAuthGroupQuery groupByDefaultGroup() Group by the default_group column
 * @method     ChildAuthGroupQuery groupByAnonymous() Group by the anonymous column
 * @method     ChildAuthGroupQuery groupByRoot() Group by the root column
 *
 * @method     ChildAuthGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAuthGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAuthGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAuthGroupQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAuthGroupQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAuthGroupQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAuthGroupQuery leftJoinEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Event relation
 * @method     ChildAuthGroupQuery rightJoinEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Event relation
 * @method     ChildAuthGroupQuery innerJoinEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the Event relation
 *
 * @method     ChildAuthGroupQuery joinWithEvent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Event relation
 *
 * @method     ChildAuthGroupQuery leftJoinWithEvent() Adds a LEFT JOIN clause and with to the query using the Event relation
 * @method     ChildAuthGroupQuery rightJoinWithEvent() Adds a RIGHT JOIN clause and with to the query using the Event relation
 * @method     ChildAuthGroupQuery innerJoinWithEvent() Adds a INNER JOIN clause and with to the query using the Event relation
 *
 * @method     ChildAuthGroupQuery leftJoinUserGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroup relation
 * @method     ChildAuthGroupQuery rightJoinUserGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroup relation
 * @method     ChildAuthGroupQuery innerJoinUserGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroup relation
 *
 * @method     ChildAuthGroupQuery joinWithUserGroup($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserGroup relation
 *
 * @method     ChildAuthGroupQuery leftJoinWithUserGroup() Adds a LEFT JOIN clause and with to the query using the UserGroup relation
 * @method     ChildAuthGroupQuery rightJoinWithUserGroup() Adds a RIGHT JOIN clause and with to the query using the UserGroup relation
 * @method     ChildAuthGroupQuery innerJoinWithUserGroup() Adds a INNER JOIN clause and with to the query using the UserGroup relation
 *
 * @method     \crwdogs\events\EventQuery|\crwdogs\events\UserGroupQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAuthGroup findOne(ConnectionInterface $con = null) Return the first ChildAuthGroup matching the query
 * @method     ChildAuthGroup findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAuthGroup matching the query, or a new ChildAuthGroup object populated from the query conditions when no match is found
 *
 * @method     ChildAuthGroup findOneByGroupId(int $group_id) Return the first ChildAuthGroup filtered by the group_id column
 * @method     ChildAuthGroup findOneByName(string $name) Return the first ChildAuthGroup filtered by the name column
 * @method     ChildAuthGroup findOneByLabel(string $label) Return the first ChildAuthGroup filtered by the label column
 * @method     ChildAuthGroup findOneByComment(string $comment) Return the first ChildAuthGroup filtered by the comment column
 * @method     ChildAuthGroup findOneByDefaultGroup(string $default_group) Return the first ChildAuthGroup filtered by the default_group column
 * @method     ChildAuthGroup findOneByAnonymous(string $anonymous) Return the first ChildAuthGroup filtered by the anonymous column
 * @method     ChildAuthGroup findOneByRoot(string $root) Return the first ChildAuthGroup filtered by the root column *

 * @method     ChildAuthGroup requirePk($key, ConnectionInterface $con = null) Return the ChildAuthGroup by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthGroup requireOne(ConnectionInterface $con = null) Return the first ChildAuthGroup matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuthGroup requireOneByGroupId(int $group_id) Return the first ChildAuthGroup filtered by the group_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthGroup requireOneByName(string $name) Return the first ChildAuthGroup filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthGroup requireOneByLabel(string $label) Return the first ChildAuthGroup filtered by the label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthGroup requireOneByComment(string $comment) Return the first ChildAuthGroup filtered by the comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthGroup requireOneByDefaultGroup(string $default_group) Return the first ChildAuthGroup filtered by the default_group column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthGroup requireOneByAnonymous(string $anonymous) Return the first ChildAuthGroup filtered by the anonymous column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAuthGroup requireOneByRoot(string $root) Return the first ChildAuthGroup filtered by the root column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAuthGroup[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAuthGroup objects based on current ModelCriteria
 * @method     ChildAuthGroup[]|ObjectCollection findByGroupId(int $group_id) Return ChildAuthGroup objects filtered by the group_id column
 * @method     ChildAuthGroup[]|ObjectCollection findByName(string $name) Return ChildAuthGroup objects filtered by the name column
 * @method     ChildAuthGroup[]|ObjectCollection findByLabel(string $label) Return ChildAuthGroup objects filtered by the label column
 * @method     ChildAuthGroup[]|ObjectCollection findByComment(string $comment) Return ChildAuthGroup objects filtered by the comment column
 * @method     ChildAuthGroup[]|ObjectCollection findByDefaultGroup(string $default_group) Return ChildAuthGroup objects filtered by the default_group column
 * @method     ChildAuthGroup[]|ObjectCollection findByAnonymous(string $anonymous) Return ChildAuthGroup objects filtered by the anonymous column
 * @method     ChildAuthGroup[]|ObjectCollection findByRoot(string $root) Return ChildAuthGroup objects filtered by the root column
 * @method     ChildAuthGroup[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AuthGroupQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \crwdogs\events\Base\AuthGroupQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\crwdogs\\events\\AuthGroup', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAuthGroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAuthGroupQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAuthGroupQuery) {
            return $criteria;
        }
        $query = new ChildAuthGroupQuery();
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
     * @return ChildAuthGroup|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AuthGroupTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AuthGroupTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAuthGroup A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT group_id, name, label, comment, default_group, anonymous, root FROM auth_group WHERE group_id = :p0';
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
            /** @var ChildAuthGroup $obj */
            $obj = new ChildAuthGroup();
            $obj->hydrate($row);
            AuthGroupTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAuthGroup|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AuthGroupTableMap::COL_GROUP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AuthGroupTableMap::COL_GROUP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByGroupId(1234); // WHERE group_id = 1234
     * $query->filterByGroupId(array(12, 34)); // WHERE group_id IN (12, 34)
     * $query->filterByGroupId(array('min' => 12)); // WHERE group_id > 12
     * </code>
     *
     * @param     mixed $groupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByGroupId($groupId = null, $comparison = null)
    {
        if (is_array($groupId)) {
            $useMinMax = false;
            if (isset($groupId['min'])) {
                $this->addUsingAlias(AuthGroupTableMap::COL_GROUP_ID, $groupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($groupId['max'])) {
                $this->addUsingAlias(AuthGroupTableMap::COL_GROUP_ID, $groupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthGroupTableMap::COL_GROUP_ID, $groupId, $comparison);
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
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthGroupTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthGroupTableMap::COL_LABEL, $label, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByComment('%fooValue%', Criteria::LIKE); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthGroupTableMap::COL_COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query on the default_group column
     *
     * Example usage:
     * <code>
     * $query->filterByDefaultGroup('fooValue');   // WHERE default_group = 'fooValue'
     * $query->filterByDefaultGroup('%fooValue%', Criteria::LIKE); // WHERE default_group LIKE '%fooValue%'
     * </code>
     *
     * @param     string $defaultGroup The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByDefaultGroup($defaultGroup = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($defaultGroup)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthGroupTableMap::COL_DEFAULT_GROUP, $defaultGroup, $comparison);
    }

    /**
     * Filter the query on the anonymous column
     *
     * Example usage:
     * <code>
     * $query->filterByAnonymous('fooValue');   // WHERE anonymous = 'fooValue'
     * $query->filterByAnonymous('%fooValue%', Criteria::LIKE); // WHERE anonymous LIKE '%fooValue%'
     * </code>
     *
     * @param     string $anonymous The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByAnonymous($anonymous = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($anonymous)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthGroupTableMap::COL_ANONYMOUS, $anonymous, $comparison);
    }

    /**
     * Filter the query on the root column
     *
     * Example usage:
     * <code>
     * $query->filterByRoot('fooValue');   // WHERE root = 'fooValue'
     * $query->filterByRoot('%fooValue%', Criteria::LIKE); // WHERE root LIKE '%fooValue%'
     * </code>
     *
     * @param     string $root The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByRoot($root = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($root)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AuthGroupTableMap::COL_ROOT, $root, $comparison);
    }

    /**
     * Filter the query by a related \crwdogs\events\Event object
     *
     * @param \crwdogs\events\Event|ObjectCollection $event the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByEvent($event, $comparison = null)
    {
        if ($event instanceof \crwdogs\events\Event) {
            return $this
                ->addUsingAlias(AuthGroupTableMap::COL_GROUP_ID, $event->getOwningGroup(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            return $this
                ->useEventQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
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
     * Filter the query by a related \crwdogs\events\UserGroup object
     *
     * @param \crwdogs\events\UserGroup|ObjectCollection $userGroup the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByUserGroup($userGroup, $comparison = null)
    {
        if ($userGroup instanceof \crwdogs\events\UserGroup) {
            return $this
                ->addUsingAlias(AuthGroupTableMap::COL_GROUP_ID, $userGroup->getGroupId(), $comparison);
        } elseif ($userGroup instanceof ObjectCollection) {
            return $this
                ->useUserGroupQuery()
                ->filterByPrimaryKeys($userGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserGroup() only accepts arguments of type \crwdogs\events\UserGroup or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function joinUserGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserGroup');

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
            $this->addJoinObject($join, 'UserGroup');
        }

        return $this;
    }

    /**
     * Use the UserGroup relation UserGroup object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \crwdogs\events\UserGroupQuery A secondary query class using the current class as primary query
     */
    public function useUserGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroup', '\crwdogs\events\UserGroupQuery');
    }

    /**
     * Filter the query by a related User object
     * using the user_group table as cross reference
     *
     * @param User $user the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAuthGroupQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useUserGroupQuery()
            ->filterByUser($user, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAuthGroup $authGroup Object to remove from the list of results
     *
     * @return $this|ChildAuthGroupQuery The current query, for fluid interface
     */
    public function prune($authGroup = null)
    {
        if ($authGroup) {
            $this->addUsingAlias(AuthGroupTableMap::COL_GROUP_ID, $authGroup->getGroupId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the auth_group table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AuthGroupTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AuthGroupTableMap::clearInstancePool();
            AuthGroupTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AuthGroupTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AuthGroupTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AuthGroupTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AuthGroupTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AuthGroupQuery
