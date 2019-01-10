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
use crwdogs\events\Response as ChildResponse;
use crwdogs\events\ResponseQuery as ChildResponseQuery;
use crwdogs\events\Map\ResponseTableMap;

/**
 * Base class that represents a query for the 'response' table.
 *
 *
 *
 * @method     ChildResponseQuery orderByResponseId($order = Criteria::ASC) Order by the response_id column
 * @method     ChildResponseQuery orderByQuestionId($order = Criteria::ASC) Order by the question_id column
 * @method     ChildResponseQuery orderByRegistrationId($order = Criteria::ASC) Order by the registration_id column
 * @method     ChildResponseQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method     ChildResponseQuery groupByResponseId() Group by the response_id column
 * @method     ChildResponseQuery groupByQuestionId() Group by the question_id column
 * @method     ChildResponseQuery groupByRegistrationId() Group by the registration_id column
 * @method     ChildResponseQuery groupByValue() Group by the value column
 *
 * @method     ChildResponseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildResponseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildResponseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildResponseQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildResponseQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildResponseQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildResponseQuery leftJoinQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Question relation
 * @method     ChildResponseQuery rightJoinQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Question relation
 * @method     ChildResponseQuery innerJoinQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the Question relation
 *
 * @method     ChildResponseQuery joinWithQuestion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Question relation
 *
 * @method     ChildResponseQuery leftJoinWithQuestion() Adds a LEFT JOIN clause and with to the query using the Question relation
 * @method     ChildResponseQuery rightJoinWithQuestion() Adds a RIGHT JOIN clause and with to the query using the Question relation
 * @method     ChildResponseQuery innerJoinWithQuestion() Adds a INNER JOIN clause and with to the query using the Question relation
 *
 * @method     ChildResponseQuery leftJoinRegistration($relationAlias = null) Adds a LEFT JOIN clause to the query using the Registration relation
 * @method     ChildResponseQuery rightJoinRegistration($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Registration relation
 * @method     ChildResponseQuery innerJoinRegistration($relationAlias = null) Adds a INNER JOIN clause to the query using the Registration relation
 *
 * @method     ChildResponseQuery joinWithRegistration($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Registration relation
 *
 * @method     ChildResponseQuery leftJoinWithRegistration() Adds a LEFT JOIN clause and with to the query using the Registration relation
 * @method     ChildResponseQuery rightJoinWithRegistration() Adds a RIGHT JOIN clause and with to the query using the Registration relation
 * @method     ChildResponseQuery innerJoinWithRegistration() Adds a INNER JOIN clause and with to the query using the Registration relation
 *
 * @method     \crwdogs\events\QuestionQuery|\crwdogs\events\RegistrationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildResponse findOne(ConnectionInterface $con = null) Return the first ChildResponse matching the query
 * @method     ChildResponse findOneOrCreate(ConnectionInterface $con = null) Return the first ChildResponse matching the query, or a new ChildResponse object populated from the query conditions when no match is found
 *
 * @method     ChildResponse findOneByResponseId(int $response_id) Return the first ChildResponse filtered by the response_id column
 * @method     ChildResponse findOneByQuestionId(int $question_id) Return the first ChildResponse filtered by the question_id column
 * @method     ChildResponse findOneByRegistrationId(int $registration_id) Return the first ChildResponse filtered by the registration_id column
 * @method     ChildResponse findOneByValue(string $value) Return the first ChildResponse filtered by the value column *

 * @method     ChildResponse requirePk($key, ConnectionInterface $con = null) Return the ChildResponse by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResponse requireOne(ConnectionInterface $con = null) Return the first ChildResponse matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildResponse requireOneByResponseId(int $response_id) Return the first ChildResponse filtered by the response_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResponse requireOneByQuestionId(int $question_id) Return the first ChildResponse filtered by the question_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResponse requireOneByRegistrationId(int $registration_id) Return the first ChildResponse filtered by the registration_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResponse requireOneByValue(string $value) Return the first ChildResponse filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildResponse[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildResponse objects based on current ModelCriteria
 * @method     ChildResponse[]|ObjectCollection findByResponseId(int $response_id) Return ChildResponse objects filtered by the response_id column
 * @method     ChildResponse[]|ObjectCollection findByQuestionId(int $question_id) Return ChildResponse objects filtered by the question_id column
 * @method     ChildResponse[]|ObjectCollection findByRegistrationId(int $registration_id) Return ChildResponse objects filtered by the registration_id column
 * @method     ChildResponse[]|ObjectCollection findByValue(string $value) Return ChildResponse objects filtered by the value column
 * @method     ChildResponse[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ResponseQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \crwdogs\events\Base\ResponseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\crwdogs\\events\\Response', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildResponseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildResponseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildResponseQuery) {
            return $criteria;
        }
        $query = new ChildResponseQuery();
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
     * @return ChildResponse|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ResponseTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ResponseTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildResponse A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT response_id, question_id, registration_id, value FROM response WHERE response_id = :p0';
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
            /** @var ChildResponse $obj */
            $obj = new ChildResponse();
            $obj->hydrate($row);
            ResponseTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildResponse|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildResponseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ResponseTableMap::COL_RESPONSE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildResponseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ResponseTableMap::COL_RESPONSE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the response_id column
     *
     * Example usage:
     * <code>
     * $query->filterByResponseId(1234); // WHERE response_id = 1234
     * $query->filterByResponseId(array(12, 34)); // WHERE response_id IN (12, 34)
     * $query->filterByResponseId(array('min' => 12)); // WHERE response_id > 12
     * </code>
     *
     * @param     mixed $responseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildResponseQuery The current query, for fluid interface
     */
    public function filterByResponseId($responseId = null, $comparison = null)
    {
        if (is_array($responseId)) {
            $useMinMax = false;
            if (isset($responseId['min'])) {
                $this->addUsingAlias(ResponseTableMap::COL_RESPONSE_ID, $responseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($responseId['max'])) {
                $this->addUsingAlias(ResponseTableMap::COL_RESPONSE_ID, $responseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponseTableMap::COL_RESPONSE_ID, $responseId, $comparison);
    }

    /**
     * Filter the query on the question_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuestionId(1234); // WHERE question_id = 1234
     * $query->filterByQuestionId(array(12, 34)); // WHERE question_id IN (12, 34)
     * $query->filterByQuestionId(array('min' => 12)); // WHERE question_id > 12
     * </code>
     *
     * @see       filterByQuestion()
     *
     * @param     mixed $questionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildResponseQuery The current query, for fluid interface
     */
    public function filterByQuestionId($questionId = null, $comparison = null)
    {
        if (is_array($questionId)) {
            $useMinMax = false;
            if (isset($questionId['min'])) {
                $this->addUsingAlias(ResponseTableMap::COL_QUESTION_ID, $questionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($questionId['max'])) {
                $this->addUsingAlias(ResponseTableMap::COL_QUESTION_ID, $questionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponseTableMap::COL_QUESTION_ID, $questionId, $comparison);
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
     * @return $this|ChildResponseQuery The current query, for fluid interface
     */
    public function filterByRegistrationId($registrationId = null, $comparison = null)
    {
        if (is_array($registrationId)) {
            $useMinMax = false;
            if (isset($registrationId['min'])) {
                $this->addUsingAlias(ResponseTableMap::COL_REGISTRATION_ID, $registrationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registrationId['max'])) {
                $this->addUsingAlias(ResponseTableMap::COL_REGISTRATION_ID, $registrationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponseTableMap::COL_REGISTRATION_ID, $registrationId, $comparison);
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
     * @return $this|ChildResponseQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResponseTableMap::COL_VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related \crwdogs\events\Question object
     *
     * @param \crwdogs\events\Question|ObjectCollection $question The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildResponseQuery The current query, for fluid interface
     */
    public function filterByQuestion($question, $comparison = null)
    {
        if ($question instanceof \crwdogs\events\Question) {
            return $this
                ->addUsingAlias(ResponseTableMap::COL_QUESTION_ID, $question->getQuestionId(), $comparison);
        } elseif ($question instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ResponseTableMap::COL_QUESTION_ID, $question->toKeyValue('PrimaryKey', 'QuestionId'), $comparison);
        } else {
            throw new PropelException('filterByQuestion() only accepts arguments of type \crwdogs\events\Question or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Question relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildResponseQuery The current query, for fluid interface
     */
    public function joinQuestion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Question');

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
            $this->addJoinObject($join, 'Question');
        }

        return $this;
    }

    /**
     * Use the Question relation Question object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \crwdogs\events\QuestionQuery A secondary query class using the current class as primary query
     */
    public function useQuestionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuestion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Question', '\crwdogs\events\QuestionQuery');
    }

    /**
     * Filter the query by a related \crwdogs\events\Registration object
     *
     * @param \crwdogs\events\Registration|ObjectCollection $registration The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildResponseQuery The current query, for fluid interface
     */
    public function filterByRegistration($registration, $comparison = null)
    {
        if ($registration instanceof \crwdogs\events\Registration) {
            return $this
                ->addUsingAlias(ResponseTableMap::COL_REGISTRATION_ID, $registration->getRegistrationId(), $comparison);
        } elseif ($registration instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ResponseTableMap::COL_REGISTRATION_ID, $registration->toKeyValue('PrimaryKey', 'RegistrationId'), $comparison);
        } else {
            throw new PropelException('filterByRegistration() only accepts arguments of type \crwdogs\events\Registration or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Registration relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildResponseQuery The current query, for fluid interface
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
     * @return \crwdogs\events\RegistrationQuery A secondary query class using the current class as primary query
     */
    public function useRegistrationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRegistration($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Registration', '\crwdogs\events\RegistrationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildResponse $response Object to remove from the list of results
     *
     * @return $this|ChildResponseQuery The current query, for fluid interface
     */
    public function prune($response = null)
    {
        if ($response) {
            $this->addUsingAlias(ResponseTableMap::COL_RESPONSE_ID, $response->getResponseId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the response table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ResponseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ResponseTableMap::clearInstancePool();
            ResponseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ResponseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ResponseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ResponseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ResponseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ResponseQuery
