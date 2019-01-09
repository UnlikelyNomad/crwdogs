<?php

namespace Base;

use \Payment as ChildPayment;
use \PaymentQuery as ChildPaymentQuery;
use \Exception;
use \PDO;
use Map\PaymentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'payment' table.
 *
 *
 *
 * @method     ChildPaymentQuery orderByPaymentId($order = Criteria::ASC) Order by the payment_id column
 * @method     ChildPaymentQuery orderByRegistrationId($order = Criteria::ASC) Order by the registration_id column
 * @method     ChildPaymentQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildPaymentQuery orderByTxnId($order = Criteria::ASC) Order by the txn_id column
 * @method     ChildPaymentQuery orderByTxnType($order = Criteria::ASC) Order by the txn_type column
 * @method     ChildPaymentQuery orderByRecipient($order = Criteria::ASC) Order by the recipient column
 * @method     ChildPaymentQuery orderByParentTxn($order = Criteria::ASC) Order by the parent_txn column
 * @method     ChildPaymentQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildPaymentQuery orderByFull($order = Criteria::ASC) Order by the full column
 * @method     ChildPaymentQuery orderByReceived($order = Criteria::ASC) Order by the received column
 *
 * @method     ChildPaymentQuery groupByPaymentId() Group by the payment_id column
 * @method     ChildPaymentQuery groupByRegistrationId() Group by the registration_id column
 * @method     ChildPaymentQuery groupByStatus() Group by the status column
 * @method     ChildPaymentQuery groupByTxnId() Group by the txn_id column
 * @method     ChildPaymentQuery groupByTxnType() Group by the txn_type column
 * @method     ChildPaymentQuery groupByRecipient() Group by the recipient column
 * @method     ChildPaymentQuery groupByParentTxn() Group by the parent_txn column
 * @method     ChildPaymentQuery groupByEmail() Group by the email column
 * @method     ChildPaymentQuery groupByFull() Group by the full column
 * @method     ChildPaymentQuery groupByReceived() Group by the received column
 *
 * @method     ChildPaymentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPaymentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPaymentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPaymentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPaymentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPaymentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPaymentQuery leftJoinRegistration($relationAlias = null) Adds a LEFT JOIN clause to the query using the Registration relation
 * @method     ChildPaymentQuery rightJoinRegistration($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Registration relation
 * @method     ChildPaymentQuery innerJoinRegistration($relationAlias = null) Adds a INNER JOIN clause to the query using the Registration relation
 *
 * @method     ChildPaymentQuery joinWithRegistration($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Registration relation
 *
 * @method     ChildPaymentQuery leftJoinWithRegistration() Adds a LEFT JOIN clause and with to the query using the Registration relation
 * @method     ChildPaymentQuery rightJoinWithRegistration() Adds a RIGHT JOIN clause and with to the query using the Registration relation
 * @method     ChildPaymentQuery innerJoinWithRegistration() Adds a INNER JOIN clause and with to the query using the Registration relation
 *
 * @method     \RegistrationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPayment findOne(ConnectionInterface $con = null) Return the first ChildPayment matching the query
 * @method     ChildPayment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPayment matching the query, or a new ChildPayment object populated from the query conditions when no match is found
 *
 * @method     ChildPayment findOneByPaymentId(int $payment_id) Return the first ChildPayment filtered by the payment_id column
 * @method     ChildPayment findOneByRegistrationId(int $registration_id) Return the first ChildPayment filtered by the registration_id column
 * @method     ChildPayment findOneByStatus(string $status) Return the first ChildPayment filtered by the status column
 * @method     ChildPayment findOneByTxnId(string $txn_id) Return the first ChildPayment filtered by the txn_id column
 * @method     ChildPayment findOneByTxnType(string $txn_type) Return the first ChildPayment filtered by the txn_type column
 * @method     ChildPayment findOneByRecipient(string $recipient) Return the first ChildPayment filtered by the recipient column
 * @method     ChildPayment findOneByParentTxn(string $parent_txn) Return the first ChildPayment filtered by the parent_txn column
 * @method     ChildPayment findOneByEmail(string $email) Return the first ChildPayment filtered by the email column
 * @method     ChildPayment findOneByFull(string $full) Return the first ChildPayment filtered by the full column
 * @method     ChildPayment findOneByReceived(string $received) Return the first ChildPayment filtered by the received column *

 * @method     ChildPayment requirePk($key, ConnectionInterface $con = null) Return the ChildPayment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOne(ConnectionInterface $con = null) Return the first ChildPayment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPayment requireOneByPaymentId(int $payment_id) Return the first ChildPayment filtered by the payment_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByRegistrationId(int $registration_id) Return the first ChildPayment filtered by the registration_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByStatus(string $status) Return the first ChildPayment filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByTxnId(string $txn_id) Return the first ChildPayment filtered by the txn_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByTxnType(string $txn_type) Return the first ChildPayment filtered by the txn_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByRecipient(string $recipient) Return the first ChildPayment filtered by the recipient column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByParentTxn(string $parent_txn) Return the first ChildPayment filtered by the parent_txn column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByEmail(string $email) Return the first ChildPayment filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByFull(string $full) Return the first ChildPayment filtered by the full column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPayment requireOneByReceived(string $received) Return the first ChildPayment filtered by the received column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPayment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPayment objects based on current ModelCriteria
 * @method     ChildPayment[]|ObjectCollection findByPaymentId(int $payment_id) Return ChildPayment objects filtered by the payment_id column
 * @method     ChildPayment[]|ObjectCollection findByRegistrationId(int $registration_id) Return ChildPayment objects filtered by the registration_id column
 * @method     ChildPayment[]|ObjectCollection findByStatus(string $status) Return ChildPayment objects filtered by the status column
 * @method     ChildPayment[]|ObjectCollection findByTxnId(string $txn_id) Return ChildPayment objects filtered by the txn_id column
 * @method     ChildPayment[]|ObjectCollection findByTxnType(string $txn_type) Return ChildPayment objects filtered by the txn_type column
 * @method     ChildPayment[]|ObjectCollection findByRecipient(string $recipient) Return ChildPayment objects filtered by the recipient column
 * @method     ChildPayment[]|ObjectCollection findByParentTxn(string $parent_txn) Return ChildPayment objects filtered by the parent_txn column
 * @method     ChildPayment[]|ObjectCollection findByEmail(string $email) Return ChildPayment objects filtered by the email column
 * @method     ChildPayment[]|ObjectCollection findByFull(string $full) Return ChildPayment objects filtered by the full column
 * @method     ChildPayment[]|ObjectCollection findByReceived(string $received) Return ChildPayment objects filtered by the received column
 * @method     ChildPayment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PaymentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PaymentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Payment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPaymentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPaymentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPaymentQuery) {
            return $criteria;
        }
        $query = new ChildPaymentQuery();
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
     * @return ChildPayment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PaymentTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PaymentTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPayment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT payment_id, registration_id, status, txn_id, txn_type, recipient, parent_txn, email, full, received FROM payment WHERE payment_id = :p0';
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
            /** @var ChildPayment $obj */
            $obj = new ChildPayment();
            $obj->hydrate($row);
            PaymentTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPayment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PaymentTableMap::COL_PAYMENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PaymentTableMap::COL_PAYMENT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the payment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentId(1234); // WHERE payment_id = 1234
     * $query->filterByPaymentId(array(12, 34)); // WHERE payment_id IN (12, 34)
     * $query->filterByPaymentId(array('min' => 12)); // WHERE payment_id > 12
     * </code>
     *
     * @param     mixed $paymentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByPaymentId($paymentId = null, $comparison = null)
    {
        if (is_array($paymentId)) {
            $useMinMax = false;
            if (isset($paymentId['min'])) {
                $this->addUsingAlias(PaymentTableMap::COL_PAYMENT_ID, $paymentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentId['max'])) {
                $this->addUsingAlias(PaymentTableMap::COL_PAYMENT_ID, $paymentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_PAYMENT_ID, $paymentId, $comparison);
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
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByRegistrationId($registrationId = null, $comparison = null)
    {
        if (is_array($registrationId)) {
            $useMinMax = false;
            if (isset($registrationId['min'])) {
                $this->addUsingAlias(PaymentTableMap::COL_REGISTRATION_ID, $registrationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($registrationId['max'])) {
                $this->addUsingAlias(PaymentTableMap::COL_REGISTRATION_ID, $registrationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_REGISTRATION_ID, $registrationId, $comparison);
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
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the txn_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTxnId('fooValue');   // WHERE txn_id = 'fooValue'
     * $query->filterByTxnId('%fooValue%', Criteria::LIKE); // WHERE txn_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $txnId The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByTxnId($txnId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($txnId)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_TXN_ID, $txnId, $comparison);
    }

    /**
     * Filter the query on the txn_type column
     *
     * Example usage:
     * <code>
     * $query->filterByTxnType('fooValue');   // WHERE txn_type = 'fooValue'
     * $query->filterByTxnType('%fooValue%', Criteria::LIKE); // WHERE txn_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $txnType The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByTxnType($txnType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($txnType)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_TXN_TYPE, $txnType, $comparison);
    }

    /**
     * Filter the query on the recipient column
     *
     * Example usage:
     * <code>
     * $query->filterByRecipient('fooValue');   // WHERE recipient = 'fooValue'
     * $query->filterByRecipient('%fooValue%', Criteria::LIKE); // WHERE recipient LIKE '%fooValue%'
     * </code>
     *
     * @param     string $recipient The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByRecipient($recipient = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($recipient)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_RECIPIENT, $recipient, $comparison);
    }

    /**
     * Filter the query on the parent_txn column
     *
     * Example usage:
     * <code>
     * $query->filterByParentTxn('fooValue');   // WHERE parent_txn = 'fooValue'
     * $query->filterByParentTxn('%fooValue%', Criteria::LIKE); // WHERE parent_txn LIKE '%fooValue%'
     * </code>
     *
     * @param     string $parentTxn The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByParentTxn($parentTxn = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($parentTxn)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_PARENT_TXN, $parentTxn, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the full column
     *
     * Example usage:
     * <code>
     * $query->filterByFull('fooValue');   // WHERE full = 'fooValue'
     * $query->filterByFull('%fooValue%', Criteria::LIKE); // WHERE full LIKE '%fooValue%'
     * </code>
     *
     * @param     string $full The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByFull($full = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($full)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_FULL, $full, $comparison);
    }

    /**
     * Filter the query on the received column
     *
     * Example usage:
     * <code>
     * $query->filterByReceived('2011-03-14'); // WHERE received = '2011-03-14'
     * $query->filterByReceived('now'); // WHERE received = '2011-03-14'
     * $query->filterByReceived(array('max' => 'yesterday')); // WHERE received > '2011-03-13'
     * </code>
     *
     * @param     mixed $received The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByReceived($received = null, $comparison = null)
    {
        if (is_array($received)) {
            $useMinMax = false;
            if (isset($received['min'])) {
                $this->addUsingAlias(PaymentTableMap::COL_RECEIVED, $received['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($received['max'])) {
                $this->addUsingAlias(PaymentTableMap::COL_RECEIVED, $received['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PaymentTableMap::COL_RECEIVED, $received, $comparison);
    }

    /**
     * Filter the query by a related \Registration object
     *
     * @param \Registration|ObjectCollection $registration The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPaymentQuery The current query, for fluid interface
     */
    public function filterByRegistration($registration, $comparison = null)
    {
        if ($registration instanceof \Registration) {
            return $this
                ->addUsingAlias(PaymentTableMap::COL_REGISTRATION_ID, $registration->getRegistrationId(), $comparison);
        } elseif ($registration instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PaymentTableMap::COL_REGISTRATION_ID, $registration->toKeyValue('PrimaryKey', 'RegistrationId'), $comparison);
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
     * @return $this|ChildPaymentQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildPayment $payment Object to remove from the list of results
     *
     * @return $this|ChildPaymentQuery The current query, for fluid interface
     */
    public function prune($payment = null)
    {
        if ($payment) {
            $this->addUsingAlias(PaymentTableMap::COL_PAYMENT_ID, $payment->getPaymentId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the payment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PaymentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PaymentTableMap::clearInstancePool();
            PaymentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PaymentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PaymentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PaymentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PaymentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PaymentQuery
