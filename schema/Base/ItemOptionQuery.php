<?php

namespace Base;

use \ItemOption as ChildItemOption;
use \ItemOptionQuery as ChildItemOptionQuery;
use \Exception;
use \PDO;
use Map\ItemOptionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'item_option' table.
 *
 *
 *
 * @method     ChildItemOptionQuery orderByOptionId($order = Criteria::ASC) Order by the option_id column
 * @method     ChildItemOptionQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildItemOptionQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildItemOptionQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildItemOptionQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method     ChildItemOptionQuery orderBySort($order = Criteria::ASC) Order by the sort column
 *
 * @method     ChildItemOptionQuery groupByOptionId() Group by the option_id column
 * @method     ChildItemOptionQuery groupByItemId() Group by the item_id column
 * @method     ChildItemOptionQuery groupByName() Group by the name column
 * @method     ChildItemOptionQuery groupByType() Group by the type column
 * @method     ChildItemOptionQuery groupByLabel() Group by the label column
 * @method     ChildItemOptionQuery groupBySort() Group by the sort column
 *
 * @method     ChildItemOptionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemOptionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemOptionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemOptionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildItemOptionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildItemOptionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildItemOptionQuery leftJoinItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the Item relation
 * @method     ChildItemOptionQuery rightJoinItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Item relation
 * @method     ChildItemOptionQuery innerJoinItem($relationAlias = null) Adds a INNER JOIN clause to the query using the Item relation
 *
 * @method     ChildItemOptionQuery joinWithItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Item relation
 *
 * @method     ChildItemOptionQuery leftJoinWithItem() Adds a LEFT JOIN clause and with to the query using the Item relation
 * @method     ChildItemOptionQuery rightJoinWithItem() Adds a RIGHT JOIN clause and with to the query using the Item relation
 * @method     ChildItemOptionQuery innerJoinWithItem() Adds a INNER JOIN clause and with to the query using the Item relation
 *
 * @method     ChildItemOptionQuery leftJoinOptionValue($relationAlias = null) Adds a LEFT JOIN clause to the query using the OptionValue relation
 * @method     ChildItemOptionQuery rightJoinOptionValue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OptionValue relation
 * @method     ChildItemOptionQuery innerJoinOptionValue($relationAlias = null) Adds a INNER JOIN clause to the query using the OptionValue relation
 *
 * @method     ChildItemOptionQuery joinWithOptionValue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the OptionValue relation
 *
 * @method     ChildItemOptionQuery leftJoinWithOptionValue() Adds a LEFT JOIN clause and with to the query using the OptionValue relation
 * @method     ChildItemOptionQuery rightJoinWithOptionValue() Adds a RIGHT JOIN clause and with to the query using the OptionValue relation
 * @method     ChildItemOptionQuery innerJoinWithOptionValue() Adds a INNER JOIN clause and with to the query using the OptionValue relation
 *
 * @method     \ItemQuery|\OptionValueQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItemOption findOne(ConnectionInterface $con = null) Return the first ChildItemOption matching the query
 * @method     ChildItemOption findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemOption matching the query, or a new ChildItemOption object populated from the query conditions when no match is found
 *
 * @method     ChildItemOption findOneByOptionId(int $option_id) Return the first ChildItemOption filtered by the option_id column
 * @method     ChildItemOption findOneByItemId(int $item_id) Return the first ChildItemOption filtered by the item_id column
 * @method     ChildItemOption findOneByName(string $name) Return the first ChildItemOption filtered by the name column
 * @method     ChildItemOption findOneByType(string $type) Return the first ChildItemOption filtered by the type column
 * @method     ChildItemOption findOneByLabel(string $label) Return the first ChildItemOption filtered by the label column
 * @method     ChildItemOption findOneBySort(int $sort) Return the first ChildItemOption filtered by the sort column *

 * @method     ChildItemOption requirePk($key, ConnectionInterface $con = null) Return the ChildItemOption by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemOption requireOne(ConnectionInterface $con = null) Return the first ChildItemOption matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemOption requireOneByOptionId(int $option_id) Return the first ChildItemOption filtered by the option_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemOption requireOneByItemId(int $item_id) Return the first ChildItemOption filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemOption requireOneByName(string $name) Return the first ChildItemOption filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemOption requireOneByType(string $type) Return the first ChildItemOption filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemOption requireOneByLabel(string $label) Return the first ChildItemOption filtered by the label column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemOption requireOneBySort(int $sort) Return the first ChildItemOption filtered by the sort column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemOption[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemOption objects based on current ModelCriteria
 * @method     ChildItemOption[]|ObjectCollection findByOptionId(int $option_id) Return ChildItemOption objects filtered by the option_id column
 * @method     ChildItemOption[]|ObjectCollection findByItemId(int $item_id) Return ChildItemOption objects filtered by the item_id column
 * @method     ChildItemOption[]|ObjectCollection findByName(string $name) Return ChildItemOption objects filtered by the name column
 * @method     ChildItemOption[]|ObjectCollection findByType(string $type) Return ChildItemOption objects filtered by the type column
 * @method     ChildItemOption[]|ObjectCollection findByLabel(string $label) Return ChildItemOption objects filtered by the label column
 * @method     ChildItemOption[]|ObjectCollection findBySort(int $sort) Return ChildItemOption objects filtered by the sort column
 * @method     ChildItemOption[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemOptionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ItemOptionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ItemOption', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemOptionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemOptionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemOptionQuery) {
            return $criteria;
        }
        $query = new ChildItemOptionQuery();
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
     * @return ChildItemOption|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemOptionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ItemOptionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildItemOption A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT option_id, item_id, name, type, label, sort FROM item_option WHERE option_id = :p0';
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
            /** @var ChildItemOption $obj */
            $obj = new ChildItemOption();
            $obj->hydrate($row);
            ItemOptionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildItemOption|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemOptionTableMap::COL_OPTION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemOptionTableMap::COL_OPTION_ID, $keys, Criteria::IN);
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
     * @param     mixed $optionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByOptionId($optionId = null, $comparison = null)
    {
        if (is_array($optionId)) {
            $useMinMax = false;
            if (isset($optionId['min'])) {
                $this->addUsingAlias(ItemOptionTableMap::COL_OPTION_ID, $optionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($optionId['max'])) {
                $this->addUsingAlias(ItemOptionTableMap::COL_OPTION_ID, $optionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemOptionTableMap::COL_OPTION_ID, $optionId, $comparison);
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
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ItemOptionTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ItemOptionTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemOptionTableMap::COL_ITEM_ID, $itemId, $comparison);
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
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemOptionTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemOptionTableMap::COL_TYPE, $type, $comparison);
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
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemOptionTableMap::COL_LABEL, $label, $comparison);
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
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(ItemOptionTableMap::COL_SORT, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(ItemOptionTableMap::COL_SORT, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemOptionTableMap::COL_SORT, $sort, $comparison);
    }

    /**
     * Filter the query by a related \Item object
     *
     * @param \Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByItem($item, $comparison = null)
    {
        if ($item instanceof \Item) {
            return $this
                ->addUsingAlias(ItemOptionTableMap::COL_ITEM_ID, $item->getItemId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemOptionTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'ItemId'), $comparison);
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
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
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
     * Filter the query by a related \OptionValue object
     *
     * @param \OptionValue|ObjectCollection $optionValue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemOptionQuery The current query, for fluid interface
     */
    public function filterByOptionValue($optionValue, $comparison = null)
    {
        if ($optionValue instanceof \OptionValue) {
            return $this
                ->addUsingAlias(ItemOptionTableMap::COL_OPTION_ID, $optionValue->getOptionId(), $comparison);
        } elseif ($optionValue instanceof ObjectCollection) {
            return $this
                ->useOptionValueQuery()
                ->filterByPrimaryKeys($optionValue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOptionValue() only accepts arguments of type \OptionValue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OptionValue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
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
     * @return \OptionValueQuery A secondary query class using the current class as primary query
     */
    public function useOptionValueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOptionValue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OptionValue', '\OptionValueQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItemOption $itemOption Object to remove from the list of results
     *
     * @return $this|ChildItemOptionQuery The current query, for fluid interface
     */
    public function prune($itemOption = null)
    {
        if ($itemOption) {
            $this->addUsingAlias(ItemOptionTableMap::COL_OPTION_ID, $itemOption->getOptionId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item_option table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemOptionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemOptionTableMap::clearInstancePool();
            ItemOptionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemOptionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemOptionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemOptionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemOptionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemOptionQuery
