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
use crwdogs\events\RegistrationOption as ChildRegistrationOption;
use crwdogs\events\RegistrationOptionQuery as ChildRegistrationOptionQuery;
use crwdogs\events\Map\RegistrationOptionTableMap;

/**
 * Base class that represents a query for the 'registration_option' table.
 *
 *
 *
 * @method     ChildRegistrationOptionQuery orderByRegoptId($order = Criteria::ASC) Order by the regopt_id column
 * @method     ChildRegistrationOptionQuery orderByPurchaseId($order = Criteria::ASC) Order by the purchase_id column
 * @method     ChildRegistrationOptionQuery orderByValueId($order = Criteria::ASC) Order by the value_id column
 *
 * @method     ChildRegistrationOptionQuery groupByRegoptId() Group by the regopt_id column
 * @method     ChildRegistrationOptionQuery groupByPurchaseId() Group by the purchase_id column
 * @method     ChildRegistrationOptionQuery groupByValueId() Group by the value_id column
 *
 * @method     ChildRegistrationOptionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRegistrationOptionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRegistrationOptionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRegistrationOptionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRegistrationOptionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRegistrationOptionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRegistrationOptionQuery leftJoinPurchasedItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the PurchasedItem relation
 * @method     ChildRegistrationOptionQuery rightJoinPurchasedItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PurchasedItem relation
 * @method     ChildRegistrationOptionQuery innerJoinPurchasedItem($relationAlias = null) Adds a INNER JOIN clause to the query using the PurchasedItem relation
 *
 * @method     ChildRegistrationOptionQuery joinWithPurchasedItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PurchasedItem relation
 *
 * @method     ChildRegistrationOptionQuery leftJoinWithPurchasedItem() Adds a LEFT JOIN clause and with to the query using the PurchasedItem relation
 * @method     ChildRegistrationOptionQuery rightJoinWithPurchasedItem() Adds a RIGHT JOIN clause and with to the query using the PurchasedItem relation
 * @method     ChildRegistrationOptionQuery innerJoinWithPurchasedItem() Adds a INNER JOIN clause and with to the query using the PurchasedItem relation
 *
 * @method     ChildRegistrationOptionQuery leftJoinOptionValue($relationAlias = null) Adds a LEFT JOIN clause to the query using the OptionValue relation
 * @method     ChildRegistrationOptionQuery rightJoinOptionValue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OptionValue relation
 * @method     ChildRegistrationOptionQuery innerJoinOptionValue($relationAlias = null) Adds a INNER JOIN clause to the query using the OptionValue relation
 *
 * @method     ChildRegistrationOptionQuery joinWithOptionValue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OptionValue relation
 *
 * @method     ChildRegistrationOptionQuery leftJoinWithOptionValue() Adds a LEFT JOIN clause and with to the query using the OptionValue relation
 * @method     ChildRegistrationOptionQuery rightJoinWithOptionValue() Adds a RIGHT JOIN clause and with to the query using the OptionValue relation
 * @method     ChildRegistrationOptionQuery innerJoinWithOptionValue() Adds a INNER JOIN clause and with to the query using the OptionValue relation
 *
 * @method     \crwdogs\events\PurchasedItemQuery|\crwdogs\events\OptionValueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRegistrationOption findOne(ConnectionInterface $con = null) Return the first ChildRegistrationOption matching the query
 * @method     ChildRegistrationOption findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRegistrationOption matching the query, or a new ChildRegistrationOption object populated from the query conditions when no match is found
 *
 * @method     ChildRegistrationOption findOneByRegoptId(int $regopt_id) Return the first ChildRegistrationOption filtered by the regopt_id column
 * @method     ChildRegistrationOption findOneByPurchaseId(int $purchase_id) Return the first ChildRegistrationOption filtered by the purchase_id column
 * @method     ChildRegistrationOption findOneByValueId(int $value_id) Return the first ChildRegistrationOption filtered by the value_id column *

 * @method     ChildRegistrationOption requirePk($key, ConnectionInterface $con = null) Return the ChildRegistrationOption by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRegistrationOption requireOne(ConnectionInterface $con = null) Return the first ChildRegistrationOption matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRegistrationOption requireOneByRegoptId(int $regopt_id) Return the first ChildRegistrationOption filtered by the regopt_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRegistrationOption requireOneByPurchaseId(int $purchase_id) Return the first ChildRegistrationOption filtered by the purchase_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRegistrationOption requireOneByValueId(int $value_id) Return the first ChildRegistrationOption filtered by the value_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRegistrationOption[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRegistrationOption objects based on current ModelCriteria
 * @method     ChildRegistrationOption[]|ObjectCollection findByRegoptId(int $regopt_id) Return ChildRegistrationOption objects filtered by the regopt_id column
 * @method     ChildRegistrationOption[]|ObjectCollection findByPurchaseId(int $purchase_id) Return ChildRegistrationOption objects filtered by the purchase_id column
 * @method     ChildRegistrationOption[]|ObjectCollection findByValueId(int $value_id) Return ChildRegistrationOption objects filtered by the value_id column
 * @method     ChildRegistrationOption[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RegistrationOptionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \crwdogs\events\Base\RegistrationOptionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\crwdogs\\events\\RegistrationOption', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRegistrationOptionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRegistrationOptionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRegistrationOptionQuery) {
            return $criteria;
        }
        $query = new ChildRegistrationOptionQuery();
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
     * @return ChildRegistrationOption|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RegistrationOptionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RegistrationOptionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildRegistrationOption A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT regopt_id, purchase_id, value_id FROM registration_option WHERE regopt_id = :p0';
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
            /** @var ChildRegistrationOption $obj */
            $obj = new ChildRegistrationOption();
            $obj->hydrate($row);
            RegistrationOptionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildRegistrationOption|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RegistrationOptionTableMap::COL_REGOPT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RegistrationOptionTableMap::COL_REGOPT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the regopt_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRegoptId(1234); // WHERE regopt_id = 1234
     * $query->filterByRegoptId(array(12, 34)); // WHERE regopt_id IN (12, 34)
     * $query->filterByRegoptId(array('min' => 12)); // WHERE regopt_id > 12
     * </code>
     *
     * @param     mixed $regoptId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function filterByRegoptId($regoptId = null, $comparison = null)
    {
        if (is_array($regoptId)) {
            $useMinMax = false;
            if (isset($regoptId['min'])) {
                $this->addUsingAlias(RegistrationOptionTableMap::COL_REGOPT_ID, $regoptId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($regoptId['max'])) {
                $this->addUsingAlias(RegistrationOptionTableMap::COL_REGOPT_ID, $regoptId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegistrationOptionTableMap::COL_REGOPT_ID, $regoptId, $comparison);
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
     * @see       filterByPurchasedItem()
     *
     * @param     mixed $purchaseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function filterByPurchaseId($purchaseId = null, $comparison = null)
    {
        if (is_array($purchaseId)) {
            $useMinMax = false;
            if (isset($purchaseId['min'])) {
                $this->addUsingAlias(RegistrationOptionTableMap::COL_PURCHASE_ID, $purchaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($purchaseId['max'])) {
                $this->addUsingAlias(RegistrationOptionTableMap::COL_PURCHASE_ID, $purchaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegistrationOptionTableMap::COL_PURCHASE_ID, $purchaseId, $comparison);
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
     * @see       filterByOptionValue()
     *
     * @param     mixed $valueId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function filterByValueId($valueId = null, $comparison = null)
    {
        if (is_array($valueId)) {
            $useMinMax = false;
            if (isset($valueId['min'])) {
                $this->addUsingAlias(RegistrationOptionTableMap::COL_VALUE_ID, $valueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valueId['max'])) {
                $this->addUsingAlias(RegistrationOptionTableMap::COL_VALUE_ID, $valueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegistrationOptionTableMap::COL_VALUE_ID, $valueId, $comparison);
    }

    /**
     * Filter the query by a related \crwdogs\events\PurchasedItem object
     *
     * @param \crwdogs\events\PurchasedItem|ObjectCollection $purchasedItem The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function filterByPurchasedItem($purchasedItem, $comparison = null)
    {
        if ($purchasedItem instanceof \crwdogs\events\PurchasedItem) {
            return $this
                ->addUsingAlias(RegistrationOptionTableMap::COL_PURCHASE_ID, $purchasedItem->getPurchaseId(), $comparison);
        } elseif ($purchasedItem instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RegistrationOptionTableMap::COL_PURCHASE_ID, $purchasedItem->toKeyValue('PrimaryKey', 'PurchaseId'), $comparison);
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
     * @return $this|ChildRegistrationOptionQuery The current query, for fluid interface
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
     * Filter the query by a related \crwdogs\events\OptionValue object
     *
     * @param \crwdogs\events\OptionValue|ObjectCollection $optionValue The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function filterByOptionValue($optionValue, $comparison = null)
    {
        if ($optionValue instanceof \crwdogs\events\OptionValue) {
            return $this
                ->addUsingAlias(RegistrationOptionTableMap::COL_VALUE_ID, $optionValue->getValueId(), $comparison);
        } elseif ($optionValue instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RegistrationOptionTableMap::COL_VALUE_ID, $optionValue->toKeyValue('PrimaryKey', 'ValueId'), $comparison);
        } else {
            throw new PropelException('filterByOptionValue() only accepts arguments of type \crwdogs\events\OptionValue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OptionValue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function joinOptionValue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OptionValue');

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
            $this->addJoinObject($join, 'OptionValue');
        }

        return $this;
    }

    /**
     * Use the OptionValue relation OptionValue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \crwdogs\events\OptionValueQuery A secondary query class using the current class as primary query
     */
    public function useOptionValueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOptionValue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OptionValue', '\crwdogs\events\OptionValueQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRegistrationOption $registrationOption Object to remove from the list of results
     *
     * @return $this|ChildRegistrationOptionQuery The current query, for fluid interface
     */
    public function prune($registrationOption = null)
    {
        if ($registrationOption) {
            $this->addUsingAlias(RegistrationOptionTableMap::COL_REGOPT_ID, $registrationOption->getRegoptId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the registration_option table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RegistrationOptionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RegistrationOptionTableMap::clearInstancePool();
            RegistrationOptionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RegistrationOptionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RegistrationOptionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RegistrationOptionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RegistrationOptionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RegistrationOptionQuery
