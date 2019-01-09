<?php

namespace Base;

use \Location as ChildLocation;
use \LocationQuery as ChildLocationQuery;
use \Exception;
use \PDO;
use Map\LocationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'location' table.
 *
 *
 *
 * @method     ChildLocationQuery orderByLocationId($order = Criteria::ASC) Order by the location_id column
 * @method     ChildLocationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildLocationQuery orderByStreet($order = Criteria::ASC) Order by the street column
 * @method     ChildLocationQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildLocationQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildLocationQuery orderByZip($order = Criteria::ASC) Order by the zip column
 * @method     ChildLocationQuery orderByGoogleLink($order = Criteria::ASC) Order by the google_link column
 * @method     ChildLocationQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildLocationQuery orderByAmenities($order = Criteria::ASC) Order by the amenities column
 *
 * @method     ChildLocationQuery groupByLocationId() Group by the location_id column
 * @method     ChildLocationQuery groupByName() Group by the name column
 * @method     ChildLocationQuery groupByStreet() Group by the street column
 * @method     ChildLocationQuery groupByCity() Group by the city column
 * @method     ChildLocationQuery groupByState() Group by the state column
 * @method     ChildLocationQuery groupByZip() Group by the zip column
 * @method     ChildLocationQuery groupByGoogleLink() Group by the google_link column
 * @method     ChildLocationQuery groupByPhone() Group by the phone column
 * @method     ChildLocationQuery groupByAmenities() Group by the amenities column
 *
 * @method     ChildLocationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLocationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLocationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLocationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLocationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLocationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLocationQuery leftJoinEvent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Event relation
 * @method     ChildLocationQuery rightJoinEvent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Event relation
 * @method     ChildLocationQuery innerJoinEvent($relationAlias = null) Adds a INNER JOIN clause to the query using the Event relation
 *
 * @method     ChildLocationQuery joinWithEvent($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Event relation
 *
 * @method     ChildLocationQuery leftJoinWithEvent() Adds a LEFT JOIN clause and with to the query using the Event relation
 * @method     ChildLocationQuery rightJoinWithEvent() Adds a RIGHT JOIN clause and with to the query using the Event relation
 * @method     ChildLocationQuery innerJoinWithEvent() Adds a INNER JOIN clause and with to the query using the Event relation
 *
 * @method     \EventQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildLocation findOne(ConnectionInterface $con = null) Return the first ChildLocation matching the query
 * @method     ChildLocation findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLocation matching the query, or a new ChildLocation object populated from the query conditions when no match is found
 *
 * @method     ChildLocation findOneByLocationId(int $location_id) Return the first ChildLocation filtered by the location_id column
 * @method     ChildLocation findOneByName(string $name) Return the first ChildLocation filtered by the name column
 * @method     ChildLocation findOneByStreet(string $street) Return the first ChildLocation filtered by the street column
 * @method     ChildLocation findOneByCity(string $city) Return the first ChildLocation filtered by the city column
 * @method     ChildLocation findOneByState(string $state) Return the first ChildLocation filtered by the state column
 * @method     ChildLocation findOneByZip(int $zip) Return the first ChildLocation filtered by the zip column
 * @method     ChildLocation findOneByGoogleLink(string $google_link) Return the first ChildLocation filtered by the google_link column
 * @method     ChildLocation findOneByPhone(string $phone) Return the first ChildLocation filtered by the phone column
 * @method     ChildLocation findOneByAmenities(string $amenities) Return the first ChildLocation filtered by the amenities column *

 * @method     ChildLocation requirePk($key, ConnectionInterface $con = null) Return the ChildLocation by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOne(ConnectionInterface $con = null) Return the first ChildLocation matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLocation requireOneByLocationId(int $location_id) Return the first ChildLocation filtered by the location_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByName(string $name) Return the first ChildLocation filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByStreet(string $street) Return the first ChildLocation filtered by the street column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByCity(string $city) Return the first ChildLocation filtered by the city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByState(string $state) Return the first ChildLocation filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByZip(int $zip) Return the first ChildLocation filtered by the zip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByGoogleLink(string $google_link) Return the first ChildLocation filtered by the google_link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByPhone(string $phone) Return the first ChildLocation filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLocation requireOneByAmenities(string $amenities) Return the first ChildLocation filtered by the amenities column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLocation[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLocation objects based on current ModelCriteria
 * @method     ChildLocation[]|ObjectCollection findByLocationId(int $location_id) Return ChildLocation objects filtered by the location_id column
 * @method     ChildLocation[]|ObjectCollection findByName(string $name) Return ChildLocation objects filtered by the name column
 * @method     ChildLocation[]|ObjectCollection findByStreet(string $street) Return ChildLocation objects filtered by the street column
 * @method     ChildLocation[]|ObjectCollection findByCity(string $city) Return ChildLocation objects filtered by the city column
 * @method     ChildLocation[]|ObjectCollection findByState(string $state) Return ChildLocation objects filtered by the state column
 * @method     ChildLocation[]|ObjectCollection findByZip(int $zip) Return ChildLocation objects filtered by the zip column
 * @method     ChildLocation[]|ObjectCollection findByGoogleLink(string $google_link) Return ChildLocation objects filtered by the google_link column
 * @method     ChildLocation[]|ObjectCollection findByPhone(string $phone) Return ChildLocation objects filtered by the phone column
 * @method     ChildLocation[]|ObjectCollection findByAmenities(string $amenities) Return ChildLocation objects filtered by the amenities column
 * @method     ChildLocation[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LocationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\LocationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Location', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLocationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLocationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLocationQuery) {
            return $criteria;
        }
        $query = new ChildLocationQuery();
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
     * @return ChildLocation|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LocationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = LocationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildLocation A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT location_id, name, street, city, state, zip, google_link, phone, amenities FROM location WHERE location_id = :p0';
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
            /** @var ChildLocation $obj */
            $obj = new ChildLocation();
            $obj->hydrate($row);
            LocationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildLocation|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LocationTableMap::COL_LOCATION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LocationTableMap::COL_LOCATION_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the location_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLocationId(1234); // WHERE location_id = 1234
     * $query->filterByLocationId(array(12, 34)); // WHERE location_id IN (12, 34)
     * $query->filterByLocationId(array('min' => 12)); // WHERE location_id > 12
     * </code>
     *
     * @param     mixed $locationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByLocationId($locationId = null, $comparison = null)
    {
        if (is_array($locationId)) {
            $useMinMax = false;
            if (isset($locationId['min'])) {
                $this->addUsingAlias(LocationTableMap::COL_LOCATION_ID, $locationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locationId['max'])) {
                $this->addUsingAlias(LocationTableMap::COL_LOCATION_ID, $locationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_LOCATION_ID, $locationId, $comparison);
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
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the street column
     *
     * Example usage:
     * <code>
     * $query->filterByStreet('fooValue');   // WHERE street = 'fooValue'
     * $query->filterByStreet('%fooValue%', Criteria::LIKE); // WHERE street LIKE '%fooValue%'
     * </code>
     *
     * @param     string $street The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByStreet($street = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($street)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_STREET, $street, $comparison);
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%', Criteria::LIKE); // WHERE city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $city The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByCity($city = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_CITY, $city, $comparison);
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%', Criteria::LIKE); // WHERE state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $state The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_STATE, $state, $comparison);
    }

    /**
     * Filter the query on the zip column
     *
     * Example usage:
     * <code>
     * $query->filterByZip(1234); // WHERE zip = 1234
     * $query->filterByZip(array(12, 34)); // WHERE zip IN (12, 34)
     * $query->filterByZip(array('min' => 12)); // WHERE zip > 12
     * </code>
     *
     * @param     mixed $zip The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByZip($zip = null, $comparison = null)
    {
        if (is_array($zip)) {
            $useMinMax = false;
            if (isset($zip['min'])) {
                $this->addUsingAlias(LocationTableMap::COL_ZIP, $zip['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($zip['max'])) {
                $this->addUsingAlias(LocationTableMap::COL_ZIP, $zip['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_ZIP, $zip, $comparison);
    }

    /**
     * Filter the query on the google_link column
     *
     * Example usage:
     * <code>
     * $query->filterByGoogleLink('fooValue');   // WHERE google_link = 'fooValue'
     * $query->filterByGoogleLink('%fooValue%', Criteria::LIKE); // WHERE google_link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $googleLink The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByGoogleLink($googleLink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($googleLink)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_GOOGLE_LINK, $googleLink, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%', Criteria::LIKE); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the amenities column
     *
     * Example usage:
     * <code>
     * $query->filterByAmenities('fooValue');   // WHERE amenities = 'fooValue'
     * $query->filterByAmenities('%fooValue%', Criteria::LIKE); // WHERE amenities LIKE '%fooValue%'
     * </code>
     *
     * @param     string $amenities The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function filterByAmenities($amenities = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($amenities)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LocationTableMap::COL_AMENITIES, $amenities, $comparison);
    }

    /**
     * Filter the query by a related \Event object
     *
     * @param \Event|ObjectCollection $event the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildLocationQuery The current query, for fluid interface
     */
    public function filterByEvent($event, $comparison = null)
    {
        if ($event instanceof \Event) {
            return $this
                ->addUsingAlias(LocationTableMap::COL_LOCATION_ID, $event->getLocationId(), $comparison);
        } elseif ($event instanceof ObjectCollection) {
            return $this
                ->useEventQuery()
                ->filterByPrimaryKeys($event->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildLocationQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildLocation $location Object to remove from the list of results
     *
     * @return $this|ChildLocationQuery The current query, for fluid interface
     */
    public function prune($location = null)
    {
        if ($location) {
            $this->addUsingAlias(LocationTableMap::COL_LOCATION_ID, $location->getLocationId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the location table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LocationTableMap::clearInstancePool();
            LocationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LocationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LocationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LocationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LocationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LocationQuery
