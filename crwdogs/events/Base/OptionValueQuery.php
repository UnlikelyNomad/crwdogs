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
use crwdogs\events\OptionValue as ChildOptionValue;
use crwdogs\events\OptionValueQuery as ChildOptionValueQuery;
use crwdogs\events\Map\OptionValueTableMap;

/**
 * Base class that represents a query for the 'option_value' table.
 *
 *
 *
 * @method     ChildOptionValueQuery orderByValueId($order = Criteria::ASC) Order by the value_id column
 * @method     ChildOptionValueQuery orderByOptionId($order = Criteria::ASC) Order by the option_id column
 * @method     ChildOptionValueQuery orderByCostAdj($order = Criteria::ASC) Order by the cost_adj column
 * @method     ChildOptionValueQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     ChildOptionValueQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     ChildOptionValueQuery groupByValueId() Group by the value_id column
 * @method     ChildOptionValueQuery groupByOptionId() Group by the option_id column
 * @method     ChildOptionValueQuery groupByCostAdj() Group by the cost_adj column
 * @method     ChildOptionValueQuery groupByLabel() Group by the label column
 * @method     ChildOptionValueQuery groupByValue() Group by the value column
 *
 * @method     ChildOptionValueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildOptionValueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildOptionValueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildOptionValueQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildOptionValueQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildOptionValueQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildOptionValueQuery leftJoinItemOption($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemOption relation
 * @method     ChildOptionValueQuery rightJoinItemOption($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemOption relation
 * @method     ChildOptionValueQuery innerJoinItemOption($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemOption relation
 *
 * @method     ChildOptionValueQuery joinWithItemOption($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ItemOption relation
 *
 * @method     ChildOptionValueQuery leftJoinWithItemOption() Adds a LEFT JOIN clause and with to the query using the ItemOption relation
 * @method     ChildOptionValueQuery rightJoinWithItemOption() Adds a RIGHT JOIN clause and with to the query using the ItemOption relation
 * @method     ChildOptionValueQuery innerJoinWithItemOption() Adds a INNER JOIN clause and with to the query using the ItemOption relation
 *
 * @method     ChildOptionValueQuery leftJoinRegistrationOption($relationAlias = null) Adds a LEFT JOIN clause to the query using the RegistrationOption relation
 * @method     ChildOptionValueQuery rightJoinRegistrationOption($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RegistrationOption relation
 * @method     ChildOptionValueQuery innerJoinRegistrationOption($relationAlias = null) Adds a INNER JOIN clause to the query using the RegistrationOption relation
 *
 * @method     ChildOptionValueQuery joinWithRegistrationOption($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RegistrationOption relation
 *
 * @method     ChildOptionValueQuery leftJoinWithRegistrationOption() Adds a LEFT JOIN clause and with to the query using the RegistrationOption relation
 * @method     ChildOptionValueQuery rightJoinWithRegistrationOption() Adds a RIGHT JOIN clause and with to the query using the RegistrationOption relation
 * @method     ChildOptionValueQuery innerJoinWithRegistrationOption() Adds a INNER JOIN clause and with to the query using the RegistrationOption relation
 *
 * @method     \crwdogs\events\ItemOptionQuery|\crwdogs\events\RegistrationOptionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildOptionValue findOne(ConnectionInterface $con = null) Return the first ChildOptionValue matching the query
 * @method     ChildOptionValue findOneOrCreate(ConnectionInterface $con = null) Return the first ChildOptionValue matching the query, or a new ChildOptionValue object populated from the query conditions when no match is found
 *
 * @method     ChildOptionValue findOneByValueId(int $value_id) Return the first ChildOptionValue filtered by the value_id column
 * @method     ChildOptionValue findOneByOptionId(int $option_id) Return the first ChildOptionValue filtered by the option_id column
 * @method     ChildOptionValue findOneByCostAdj(string $cost_adj) Return the first ChildOptionValue filtered by the cost_adj column
 * @method     ChildOptionValue findOneByLabel(string $label) Return the first ChildOptionValue filtered by the label column
 * @method     ChildOptionValue findOneByValue(string $value) Return the first ChildOptionValue filtered by the value column *

 * @method     ChildOptionValue requirePk($key, ConnectionInterface $con = null) Return the ChildOptionValue by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptionValue requireOne(ConnectionInterface $con = null) Return the first ChildOptionValue matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOptionValue requireOneByValueId(int $value_id) Return the first ChildOptionValue filtered by the value_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptionValue requireOneByOptionId(int $option_id) Return the first ChildOptionValue filtered by the option_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptionValue requireOneByCostAdj(string $cost_adj) Return the first ChildOptionValue filtered by the cost_adj column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptionValue requireOneByLabel(string $label) Return the first ChildOptionValue filtered by the label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildOptionValue requireOneByValue(string $value) Return the first ChildOptionValue filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildOptionValue[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildOptionValue objects based on current ModelCriteria
 * @method     ChildOptionValue[]|ObjectCollection findByValueId(int $value_id) Return ChildOptionValue objects filtered by the value_id column
 * @method     ChildOptionValue[]|ObjectCollection findByOptionId(int $option_id) Return ChildOptionValue objects filtered by the option_id column
 * @method     ChildOptionValue[]|ObjectCollection findByCostAdj(string $cost_adj) Return ChildOptionValue objects filtered by the cost_adj column
 * @method     ChildOptionValue[]|ObjectCollection findByLabel(string $label) Return ChildOptionValue objects filtered by the label column
 * @method     ChildOptionValue[]|ObjectCollection findByValue(string $value) Return ChildOptionValue objects filtered by the value column
 * @method     ChildOptionValue[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class OptionValueQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \crwdogs\events\Base\OptionValueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\crwdogs\\events\\OptionValue', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildOptionValueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildOptionValueQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildOptionValueQuery) {
            return $criteria;
        }
        $query = new ChildOptionValueQuery();
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
     * @return ChildOptionValue|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(OptionValueTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = OptionValueTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildOptionValue A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT value_id, option_id, cost_adj, label, value FROM option_value WHERE value_id = :p0';
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
            /** @var ChildOptionValue $obj */
            $obj = new ChildOptionValue();
            $obj->hydrate($row);
            OptionValueTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildOptionValue|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OptionValueTableMap::COL_VALUE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OptionValueTableMap::COL_VALUE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the value_id column
     *
     * Example usage:
     * <code>
     * $query->filterByValueId(1234); // WHERE value_id = 1234
     * $query->filterByValueId(array(12, 34)); // WHERE value_id IN (12, 34)
     * $query->filterByValueId(array('min' => 12)); // WHERE value_id > 12
     * </code>
     *
     * @param     mixed $valueId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByValueId($valueId = null, $comparison = null)
    {
        if (is_array($valueId)) {
            $useMinMax = false;
            if (isset($valueId['min'])) {
                $this->addUsingAlias(OptionValueTableMap::COL_VALUE_ID, $valueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valueId['max'])) {
                $this->addUsingAlias(OptionValueTableMap::COL_VALUE_ID, $valueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptionValueTableMap::COL_VALUE_ID, $valueId, $comparison);
    }

    /**
     * Filter the query on the option_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOptionId(1234); // WHERE option_id = 1234
     * $query->filterByOptionId(array(12, 34)); // WHERE option_id IN (12, 34)
     * $query->filterByOptionId(array('min' => 12)); // WHERE option_id > 12
     * </code>
     *
     * @see       filterByItemOption()
     *
     * @param     mixed $optionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByOptionId($optionId = null, $comparison = null)
    {
        if (is_array($optionId)) {
            $useMinMax = false;
            if (isset($optionId['min'])) {
                $this->addUsingAlias(OptionValueTableMap::COL_OPTION_ID, $optionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($optionId['max'])) {
                $this->addUsingAlias(OptionValueTableMap::COL_OPTION_ID, $optionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptionValueTableMap::COL_OPTION_ID, $optionId, $comparison);
    }

    /**
     * Filter the query on the cost_adj column
     *
     * Example usage:
     * <code>
     * $query->filterByCostAdj(1234); // WHERE cost_adj = 1234
     * $query->filterByCostAdj(array(12, 34)); // WHERE cost_adj IN (12, 34)
     * $query->filterByCostAdj(array('min' => 12)); // WHERE cost_adj > 12
     * </code>
     *
     * @param     mixed $costAdj The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByCostAdj($costAdj = null, $comparison = null)
    {
        if (is_array($costAdj)) {
            $useMinMax = false;
            if (isset($costAdj['min'])) {
                $this->addUsingAlias(OptionValueTableMap::COL_COST_ADJ, $costAdj['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($costAdj['max'])) {
                $this->addUsingAlias(OptionValueTableMap::COL_COST_ADJ, $costAdj['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptionValueTableMap::COL_COST_ADJ, $costAdj, $comparison);
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
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptionValueTableMap::COL_LABEL, $label, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%', Criteria::LIKE); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OptionValueTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related \crwdogs\events\ItemOption object
     *
     * @param \crwdogs\events\ItemOption|ObjectCollection $itemOption The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByItemOption($itemOption, $comparison = null)
    {
        if ($itemOption instanceof \crwdogs\events\ItemOption) {
            return $this
                ->addUsingAlias(OptionValueTableMap::COL_OPTION_ID, $itemOption->getOptionId(), $comparison);
        } elseif ($itemOption instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OptionValueTableMap::COL_OPTION_ID, $itemOption->toKeyValue('PrimaryKey', 'OptionId'), $comparison);
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
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
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
     * Filter the query by a related \crwdogs\events\RegistrationOption object
     *
     * @param \crwdogs\events\RegistrationOption|ObjectCollection $registrationOption the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildOptionValueQuery The current query, for fluid interface
     */
    public function filterByRegistrationOption($registrationOption, $comparison = null)
    {
        if ($registrationOption instanceof \crwdogs\events\RegistrationOption) {
            return $this
                ->addUsingAlias(OptionValueTableMap::COL_VALUE_ID, $registrationOption->getValueId(), $comparison);
        } elseif ($registrationOption instanceof ObjectCollection) {
            return $this
                ->useRegistrationOptionQuery()
                ->filterByPrimaryKeys($registrationOption->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRegistrationOption() only accepts arguments of type \crwdogs\events\RegistrationOption or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RegistrationOption relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
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
     * @return \crwdogs\events\RegistrationOptionQuery A secondary query class using the current class as primary query
     */
    public function useRegistrationOptionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRegistrationOption($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RegistrationOption', '\crwdogs\events\RegistrationOptionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildOptionValue $optionValue Object to remove from the list of results
     *
     * @return $this|ChildOptionValueQuery The current query, for fluid interface
     */
    public function prune($optionValue = null)
    {
        if ($optionValue) {
            $this->addUsingAlias(OptionValueTableMap::COL_VALUE_ID, $optionValue->getValueId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the option_value table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(OptionValueTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            OptionValueTableMap::clearInstancePool();
            OptionValueTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(OptionValueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(OptionValueTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            OptionValueTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            OptionValueTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // OptionValueQuery
